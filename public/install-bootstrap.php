<?php

@set_time_limit(0);
@ini_set('max_execution_time', '0');

header('Content-Type: application/json; charset=UTF-8');

$projectRoot = realpath(__DIR__.'/..') ?: dirname(__DIR__);
$envPath = $projectRoot.'/.env';
$lockFile = $projectRoot.'/storage/app/install.completed';
$steps = [];

try {
    $configuredToken = getEnvValue('INSTALL_TOKEN', $envPath);
    $providedToken = isset($_GET['token']) ? (string) $_GET['token'] : '';

    if ($configuredToken === '' || $providedToken === '' || ! hash_equals($configuredToken, $providedToken)) {
        jsonResponse(403, [
            'status' => 'forbidden',
            'message' => 'Invalid install token.',
        ]);
    }

    if (is_file($lockFile)) {
        jsonResponse(200, [
            'status' => 'already_installed',
            'message' => 'Installation has already been completed.',
        ]);
    }

    $phpBinary = escapeshellarg(PHP_BINARY ?: 'php');
    $artisan = escapeshellarg($projectRoot.'/artisan');

    runCommandStep(
        'Install Composer dependencies',
        resolveComposerCommand($projectRoot, $phpBinary).' install --no-interaction --prefer-dist --optimize-autoloader',
        $projectRoot,
        $steps
    );

    runCommandStep(
        'Install NPM dependencies',
        'npm install',
        $projectRoot,
        $steps
    );

    runCommandStep(
        'Build frontend assets',
        'npm run build',
        $projectRoot,
        $steps
    );

    ensureSqliteFileExists($projectRoot, $envPath, $steps);

    if (getEnvValue('APP_KEY', $envPath) === '') {
        runCommandStep(
            'Generate APP_KEY',
            $phpBinary.' '.$artisan.' key:generate --force',
            $projectRoot,
            $steps
        );
    }

    runCommandStep(
        'Run database migrations',
        $phpBinary.' '.$artisan.' migrate --force',
        $projectRoot,
        $steps
    );

    if (! file_exists($projectRoot.'/public/storage')) {
        runCommandStep(
            'Create storage symlink',
            $phpBinary.' '.$artisan.' storage:link',
            $projectRoot,
            $steps
        );
    }

    runCommandStep(
        'Clear optimization caches',
        $phpBinary.' '.$artisan.' optimize:clear',
        $projectRoot,
        $steps
    );

    ensureDirectory(dirname($lockFile));
    file_put_contents($lockFile, date('c'));

    jsonResponse(200, [
        'status' => 'installed',
        'message' => 'Installation completed successfully.',
        'steps' => $steps,
    ]);
} catch (Throwable $exception) {
    jsonResponse(500, [
        'status' => 'failed',
        'message' => 'Installation failed.',
        'error' => $exception->getMessage(),
        'steps' => $steps,
    ]);
}

function runCommandStep(string $label, string $command, string $workingDirectory, array &$steps): void
{
    // if (! function_exists('exec')) {
    //     throw new RuntimeException('The exec() function is disabled on this server.');
    // }

    $outputLines = [];
    $exitCode = 0;

    $fullCommand = 'cd '.escapeshellarg($workingDirectory).' && '.$command.' 2>&1';
    exec($fullCommand, $outputLines, $exitCode);

    $output = trim(implode("\n", $outputLines));

    $steps[] = [
        'step' => $label,
        'command' => $command,
        'exit_code' => $exitCode,
        'output' => truncateOutput($output),
    ];

    if ($exitCode !== 0) {
        throw new RuntimeException($label.' failed.');
    }
}

function ensureSqliteFileExists(string $projectRoot, string $envPath, array &$steps): void
{
    $connection = getEnvValue('DB_CONNECTION', $envPath);

    if ($connection !== 'sqlite') {
        return;
    }

    $databasePath = getEnvValue('DB_DATABASE', $envPath);
    $databaseFile = $databasePath === '' ? $projectRoot.'/database/database.sqlite' : $databasePath;

    if (! isAbsolutePath($databaseFile)) {
        $databaseFile = $projectRoot.'/'.$databaseFile;
    }

    ensureDirectory(dirname($databaseFile));

    if (! file_exists($databaseFile)) {
        file_put_contents($databaseFile, '');
    }

    $steps[] = [
        'step' => 'Ensure sqlite database file exists (if sqlite is used)',
        'status' => 'ok',
    ];
}

function resolveComposerCommand(string $projectRoot, string $phpBinary): string
{
    $composerPhar = $projectRoot.'/composer.phar';

    if (is_file($composerPhar)) {
        return $phpBinary.' '.escapeshellarg($composerPhar);
    }

    return 'composer';
}

function ensureDirectory(string $path): void
{
    if (is_dir($path)) {
        return;
    }

    mkdir($path, 0755, true);
}

function getEnvValue(string $key, string $envPath): string
{
    if (! is_file($envPath)) {
        $value = getenv($key);

        return $value === false ? '' : (string) $value;
    }

    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    if ($lines === false) {
        return '';
    }

    foreach ($lines as $line) {
        $line = trim($line);

        if ($line === '' || str_starts_with($line, '#') || ! str_contains($line, '=')) {
            continue;
        }

        [$envKey, $envValue] = explode('=', $line, 2);
        $envKey = trim($envKey);

        if ($envKey !== $key) {
            continue;
        }

        $envValue = trim($envValue);

        if (
            (str_starts_with($envValue, '"') && str_ends_with($envValue, '"'))
            || (str_starts_with($envValue, '\'') && str_ends_with($envValue, '\''))
        ) {
            $envValue = substr($envValue, 1, -1);
        }

        return $envValue;
    }

    $fallback = getenv($key);

    return $fallback === false ? '' : (string) $fallback;
}

function isAbsolutePath(string $path): bool
{
    return str_starts_with($path, '/') || preg_match('/^[A-Za-z]:\\\\/', $path) === 1;
}

function truncateOutput(string $value, int $maxLength = 8000): string
{
    if (mb_strlen($value) <= $maxLength) {
        return $value;
    }

    return mb_substr($value, 0, $maxLength).'... [truncated]';
}

function jsonResponse(int $statusCode, array $payload): void
{
    http_response_code($statusCode);
    echo json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    exit;
}
