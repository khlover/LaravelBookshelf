# Bookshelf

## Hosted
Hosted version is currently unavailable. 
![image](https://user-images.githubusercontent.com/17068353/126904681-4bb20a3c-b33a-41df-89da-912da71c5045.png)

# Setup
## Requirements
- [Docker](https://docs.docker.com/install)
- [Docker Compose](https://docs.docker.com/compose/install)

## Setup
1. Clone the repository.
3. Start the containers by running `docker-compose up -d` in the project root.
4. Install the composer packages by running `docker-compose exec laravel composer install`.
5. Rename .env.example to .env and change contents as needed.
   -Run **php artisan key:generate** to generate a laravel application key to your env file.
7. Perform a database migration with php artisan migrate.
If you encounter an access denied error, run 

   > ALTER USER 'laravel'@'localhost' IDENTIFIED WITH mysql_native_password BY 'YOURPASSWORD'; 
   >
   >  FLUSH PRIVILEGES;
1. Access the Laravel instance on `http://localhost` (If there is a "Permission denied" error, run `docker-compose exec laravel chown -R www-data storage`).
* If you still are getting table access errors run the following in mysql.
  
  > CREATE TABLE books (
  > bookid int NOT NULL AUTO_INCREMENT,
  > title varchar(255) NOT NULL,
  > author varchar(255),
  >  PRIMARY KEY (bookid)
);

## Persistent database
If you want to make sure that the data in the database persists even if the database container is deleted, add a file named `docker-compose.override.yml` in the project root with the following contents.
```
version: "3.7"

services:
  mysql:
    volumes:
    - mysql:/var/lib/mysql

volumes:
  mysql:
```
Then run the following.
```
docker-compose stop \
  && docker-compose rm -f mysql \
  && docker-compose up -d
``` 
