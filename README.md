## Requirements

- [PHP V 8.1](https://www.apachefriends.org/download.html)
- [Composer](https://getcomposer.org/download/)
- [Node JS](https://nodejs.org/en/download/current)

## Instalasi Project

Extract Project and Go to the project directory

```bash
cd chips-store
```
Setup Environments

```bash
cp .env.example .env
```
Install dependencies

```bash
composer install
```
```bash
npm install
```
Generate Keys

```bash
php artisan key:generate
```
Migrate database

```bash
php artisan migrate --seed
```
Start the server

```bash
php artisan serve
```
```bash
npm run dev
```
```bash
php artisan queue:work
```