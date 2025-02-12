# ip21_akademija_projekt2_with Vue

Application for accessing cryptocurrency price data, built with Laravel and Vue.
This app was created as part of the mentoring program of Inštitut za priložnosti 21. stoletja (IP21).

Users can compare different currency prices and, if logged in, mark tokens as favourites.

## Prerequisites

-   Docker
-   Docker Compose
-   Ports 80, 443 and 8080 should be free

## Project Setup

1. Clone the project

Run `git clone <project_url>`

2. Navigate to project directory

Run `cd <project_directory_name>`

3. Build

Run `docker compose up`

4. Log in to the environment

Run `docker compose exec php2_app bash`

5. Install Composer dependencies

Run `composer install`

## Access

**Application:**

[https://localhost/]

**Database:**

[https://localhost:8080/]

## Usage

**CLI:**
For instructions run: `php artisan cli 'help'`
To view the token currency list run: `php artisan cli 'list'`
To remove a token from Favourite list run: `php artisan cli 'delete'`
To view a token price run: `php artisan cli 'price' {arg1} {arg2}`
To register a new user for web: `php artisan cli 'add user'`

**WEB:**
A Guest User can view token prices.
A Registered User can view token prices and manage a personal Favourite tokens list.
