## Hi, Its bus booking system!

### Steps to run the web app : 

- cp .env.example .env 
  - change USER_PORT value in .env file to the number you want -> it would be the docker container port for your server (optional)
- docker-compose up -d --build (linux), docker compose up -d --build (mac)
- docker-compose exec app bash (linux), docker compose exec app bash (mac)
- composer install 
- composer dump-autoload 
- php artisan key:generate
- php artisan migrate --seed
- php artisan config:clear
- php artisan test (for testing)

<hr>

#### Use postman collection apis for test system -- https://github.com/Nagwa138/bus_booking_postman_collection 

<hr>

#### You can find a copy of our database structure in /database/schema folder

<hr>

### To test app using postman -- https://github.com/Nagwa138/bus_booking_video

<i> By Nagwa Ali <3 </i>
