<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use RuntimeException;
use Symfony\Component\Process\Process;
use Throwable;

class InstallController extends Controller
{
    private const INSTALLED_LOCK_FILE = 'app/install.completed';

    public function __invoke(): JsonResponse
    {
        @set_time_limit(0);
        @ini_set('max_execution_time', '0');

        if ($this->isAlreadyInstalled()) {
            return response()->json([
                'status' => 'already_installed',
                'message' => 'Installation has already been completed.',
            ]);
        }

        $steps = [];

        try {
            $this->runProcessStep(
                'Install Composer dependencies',
                'composer install --no-interaction --prefer-dist --optimize-autoloader',
                $steps
            );

            $this->runProcessStep(
                'Install NPM dependencies',
                'npm install',
                $steps
            );

            $this->runProcessStep(
                'Build frontend assets',
                'npm run build',
                $steps
            );

            $this->runArtisanStep('Ensure sqlite database file exists (if sqlite is used)', function (): void {
                if (config('database.default') !== 'sqlite') {
                    return;
                }

                $databasePath = config('database.connections.sqlite.database');

                if (blank($databasePath)) {
                    return;
                }

                $databaseFile = str_starts_with($databasePath, DIRECTORY_SEPARATOR)
                    || preg_match('/^[A-Za-z]:\\\\/', $databasePath)
                    ? $databasePath
                    : base_path($databasePath);

                $directory = dirname($databaseFile);

                if (! is_dir($directory)) {
                    File::makeDirectory($directory, 0755, true);
                }

                if (! File::exists($databaseFile)) {
                    File::put($databaseFile, '');
                }
            }, $steps);

            $this->runArtisanStep('Generate APP_KEY if missing', function (): void {
                if (blank(config('app.key'))) {
                    Artisan::call('key:generate', ['--force' => true]);
                }
            }, $steps);

            $this->runArtisanStep('Run database migrations', function (): void {
                Artisan::call('migrate', ['--force' => true]);
            }, $steps);

            $this->runArtisanStep('Create storage symlink', function (): void {
                if (! file_exists(public_path('storage'))) {
                    Artisan::call('storage:link');
                }
            }, $steps);

            $this->runArtisanStep('Clear optimization caches', function (): void {
                Artisan::call('optimize:clear');
            }, $steps);

            $this->markInstalled();

            return response()->json([
                'status' => 'installed',
                'message' => 'Installation completed successfully.',
                'steps' => $steps,
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Installation failed.',
                'error' => $exception->getMessage(),
                'steps' => $steps,
            ], 500);
        }
    }

    private function runProcessStep(string $label, string $command, array &$steps): void
    {
        $process = Process::fromShellCommandline(
            $command,
            base_path(),
            null,
            null,
            3600
        );

        $process->run();

        $output = trim($process->getOutput()."\n".$process->getErrorOutput());

        $steps[] = [
            'step' => $label,
            'command' => $command,
            'exit_code' => $process->getExitCode(),
            'output' => $this->truncate($output),
        ];

        if (! $process->isSuccessful()) {
            throw new RuntimeException($label.' failed.');
        }
    }

    private function runArtisanStep(string $label, callable $callback, array &$steps): void
    {
        $callback();

        $steps[] = [
            'step' => $label,
            'status' => 'ok',
        ];
    }

    private function isAlreadyInstalled(): bool
    {
        return File::exists(storage_path(self::INSTALLED_LOCK_FILE));
    }

    private function markInstalled(): void
    {
        File::put(storage_path(self::INSTALLED_LOCK_FILE), now()->toDateTimeString());
    }

    private function truncate(string $value, int $maxLength = 8000): string
    {
        if (mb_strlen($value) <= $maxLength) {
            return $value;
        }

        return mb_substr($value, 0, $maxLength).'... [truncated]';
    }
}
