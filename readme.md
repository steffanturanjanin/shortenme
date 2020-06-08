## About Shorten.me

Shortenme is a web service for shortening urls written in Laravel PHP framework. It allows users to generate shorten urls which can be shared across the web. It is particularly useful for platforms (example Twitter) that have limited number of characters per post. By shortening urls, application saves users their valuable number of characters. It is also more pleasant to see shorter url.
 
Application generates personalized page where user can see information about generated url, total and unique number of visits. If user have provided email address, they receive an e-mail with the link to the url details page.

## How to run application

1. Clone repository to your machine
2. Create database and set proper credentials to .env file
3. Run `composer install`
4. Run `php artisan migrate`
