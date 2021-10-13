# Currency converter bot for Telegram


## General info

This is small exchange rate telegram bot that allows to convert from one currency to another



## Tech stack

*Programming language*: PHP 7

*Framework*: Laravel 7



## Installation

1.Run Composer install command:
```bash
  composer install
```
2.Run migrations: 
```bash
  php artisan migrate
```
3.Add a single cron configuration entry to your server that runs the schedule:run command every minute.
```bash
  * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

4.Set up the Telegram webhook
```bash
curl -F "url=https://<YOURDOMAIN.EXAMPLE>/api/telegram/webhook/{app_auth_token}" https://api.telegram.org/bot<YOURTOKEN>/setWebhook
```
5.Send the bot commands to telegram:
```bash
php artisan bot-commands-to-telegram:send
```
6.Customize and setup your app by adding following variables to .env:
```bash
TELEGRAM_API_KEY=<YOUR_TELEGRAM_API_KEY>
EXCHANGE_RATES_API_KEY=<YOUR_EXCHANGE_RATES_API_KEY>
APP_AUTH_TOKEN=<YOUR_APP_AUTH_TOKEN>
CURRENCY_RATE_DECIMALS=2
BASE_CURRENCY=EUR 
```

## Commands
The telegram bot supports following commands:
```bash
'/start' - starts entry
'/list', 'lst' - get the list of currency rates
'/exchange' - '/exchange 300 UAH to RUB' 
'/history' - return an image graph chart which shows the exchange rate graph/chart of the selected currency for the last 7 days.
```             


## Jobs
To update currency rates, a job is used that runs every 10 minutes.
You can start the job manually at any time using this command:
```bash
  php artisan job:dispatchNow UpdateCurrencyRatesJob
```


## Contacts

Repo & Tech Product owner: Sergey Antonyuk

**Email:** antonuk.sergey@gmail.com

Sergey Antonyuk
