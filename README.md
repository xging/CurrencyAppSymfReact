
# Project Documentation

## Table of Contents
1. [Introduction](#introduction)
2. [Installation](#installation)
3. [Usage with Symfony PHP](#usage-with-symfony-php)
4. [Usage with React JS](#usage-with-react-js)


---

## Introduction
An Exchange Rate App powered by the anyapi.io API. 
The project is built with Docker and consists of two parts: a Symfony PHP backend and a ReactJS frontend. For enhanced performance, RabbitMQ and Redis are used for backend optimization.

By default, sample data for currency pairs such as EUR -> GBP, EUR -> USD, EUR -> AUD, and their reverse pairs are preloaded.  
Additional currency pairs can be added directly from the symfony-php-container. Please refer to the instructions below for guidance.

Project structure:
- backend (Symfony PHP)
- frontend (React)
  - docker (react)
- docker (mysql, nginx, php-fpm)
- 
---

## Installation
Follow these steps to install the project:
- Necessary to Install Docker and Composer
1. Clone the repository:
   ```bash
   git clone https://github.com/xging/CurrencyAppSymfReact.git

2. Change API Key to yours if you want
   ```bash
    File to change, in root folder: .env.dev:
    Line to change: CURRENCY_API_KEY=
   
3. Build and start containers with Docker Compose
   ```bash
   docker-compose up --build

## Usage with Symfony PHP
### * In order to run the async process, you need to run the consumer (no need to run the consumer for sync messages)
### * Execute commands in Docker PHP container
    docker exec -it symfony-php-container bash
    
0. Run RabbitMQ сonsumer
   ```bash
   php bin/console messenger:consume -vv
1. Add Currency pairs (Async)
   ```bash
   php bin/console app:add-pair "GBP EUR"
2. Remove Currency pairs (Async)
   ```bash
   php bin/console app:remove-pair "GBP EUR"
3. Show Currency rate pair (Sync)
   ```bash
   php bin/console app:show-pair "GBP EUR" 
4. Run&Watch Currency rate pairs (Sync)
   ```bash
   php bin/console app:watch-pair

## HTTP Request
### * Redis is used to cache request output.
0. Check Redis Keys:
   ```bash
   docker exec -it symfony-redis-container redis-cli
     KEYS *
   
1. Find current exchange rate by selected currencies:
   ```bash
   http://localhost:8080/get-currency-rate/GBP/EUR

2. Find history records by selected currencies:
   ```bash
   http://localhost:8080/get-currency-hist/GBP/EUR/

3. Find history records by selected currencies and date (YYYY-MM-DD):
   ```bash
   http://localhost:8080/get-currency-hist/GBP/EUR/2025-01-17/

4. Find history records by selected currencies, date (YYYY-MM-DD), and time (HH:MM:SS):
   ```bash
   http://localhost:8080/get-currency-hist/GBP/EUR/2025-01-17/10:35:05

## Usage with React JS
  ```bash
  http://localhost:3000/

