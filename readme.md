## PHP Challenge


### Requirements
 - Docker

### How to install

run the following commands

1. copy _.env.example_ -> _.env_
2. set a password for the **DB connection**
3. Set up the MAILER config **(i used mailtrap.io)**
4. docker-compose build
5. docker-compose up -d
6. ./composer install
7. create variable APP_END={VALUE}
8. ./phinx migrate
9. ./phinx seed:run


NOTE: the password of the **mysql** docker image will be the same as the one you set up on the .env on **DB_PASSWORD**, and the port that docker expose for MYSQL is **5306**

### How to test

1. Copy the link of this [collection](https://www.getpostman.com/collections/ad4c38672c19e9e2a429)
2. Import the collection into Postman
   - click on import and then past the link
3. The collection work with an environment variable called **url_api** this should be equals to http://localhost:8080


![img.png](storage/readme/img.png)


### features

1. register users (YES)
2. login user with JWT (YES)
3. fetch stock data (YES)
   - send email with the stock data
   - fetch data in json o csv format
4. fetch user history (YES)

### optional features

1. Add unit tests for the endpoints. (NO)
2. Use RabbitMQ to send the email asynchronously. (NO)
3. Use JWT instead of basic authentication for endpoints. (YES)
4. Containerize the app. (YES)

NOTE: the default password for the user created by the seeder is **password**
