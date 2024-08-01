# Project Boilerplate

## Location
- **Migration**: Database migration files for schema definitions.
- **Seeders**: Seeder files for populating initial data.
- **SQL Dump**: SQL dump files for database structure and initial data.

## RBAC (Role-Based Access Control)
- **Spatie Permission**: Integrated for efficiently managing roles and permissions.
- **Permission Manager Command**: Custom Artisan command for managing permissions.
- **Permission & Role Seeder**: Seeders to create default roles and permissions.
  - **Default 'super-admin' role**: Seeded with all permissions.

## User Management
- **Admin User**: Pre-seeded with the 'super-admin' role.

## Commands

### Setup Commands
```sh
php artisan app:setup
```
- Sets up the application, including initial migrations and seeding.

### Refresh Commands
```sh
php artisan app:refresh
```
- Refreshes the database by running migrations and seeders.

### Permission Management Commands
```sh
php artisan app:permission:add --name="permission:name"
```
- Adds a permission to the database or file (default: database).

```sh
php artisan app:permission:list:file
```
- Lists permissions from the JSON file.

```sh
php artisan app:permission:list:db
```
- Lists permissions from the database.

```sh
php artisan app:permission:remove --name="permission:name" [--force]
```
- Removes a permission from the database or file (default: database). Use `--force` to remove permissions even if they are assigned to roles.

```sh
php artisan app:permission:compare
```
- Compares permissions between the database and the JSON file, showing discrepancies.

```sh
php artisan app:permission:sync
```
- Synchronizes permissions between the database and the JSON file, ensuring both are consistent.
