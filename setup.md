# Abuja Kings Football Academy - Fresh Localhost Setup

## 1) Clone and enter project

```powershell
git clone <your-repo-url> academy
cd academy
```

## 2) Install PHP dependencies

```powershell
composer install
```

## 3) Create `.env`

```powershell
Copy-Item .env.example .env
```

## 4) Generate app key

```powershell
php artisan key:generate
```

## 5) Create SQLite database file

```powershell
New-Item -ItemType File -Path database\database.sqlite -Force
```

## 6) Ensure `.env` uses SQLite

Use these values in `.env`:

```env
DB_CONNECTION=sqlite
# Leave DB_DATABASE commented to use the default: database/database.sqlite
# DB_DATABASE=/absolute/path/to/database.sqlite
```

## 7) Run migrations and seed demo data

```powershell
php artisan migrate --force
php artisan db:seed --force
```

## 8) Link storage for uploaded files/images

```powershell
php artisan storage:link
```

## 9) Clear cached config/routes/views (safe on fresh setup)

```powershell
php artisan optimize:clear
```

## 10) Run app locally

If using `php artisan serve`:

```powershell
php artisan serve
```

Open: `http://127.0.0.1:8000`

If using Laragon/Apache, point it to this folder (`c:\laragon\www\academy`) and open:
`http://academy.test` (or your configured local domain).

## 11) Optional quick checks

```powershell
php artisan test
php artisan route:list
```

---

## Bash/macOS/Linux equivalents

```bash
git clone <your-repo-url> academy
cd academy
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
php artisan optimize:clear
php artisan serve
```
