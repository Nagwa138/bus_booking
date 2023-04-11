## Hi, Its bus booking system!

### Steps to run the web app : 

- copy .env.example .env 
  - change USER_PORT value in .env file to the number you want -> it would be the docker container port for your server (optional)
- docker-compose up -d --build (linux), docker compose up -d --build (mac)
- docker-compose exec app bash (linux), docker compose exec app bash (mac)
- composer install 
- composer dump-autoload 
- php artisan key:generate
- php artisan config:clear
- php artisan test (for testing)

<hr>

#### Use postman collection apis : for test system -- github repo link :

<hr>

#### Copy of our database -- github repo link :

<hr>

### To test app using postman -- github link

<i> By Nagwa Ali <3 </i>
