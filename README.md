# Jobs Manager System

#### How to execute
To initialize the project, run the following command on the root directory:

```
docker-compose up --build
```

Wait for all services to be up and running and visit [http://localhost](http://localhost).

<sub>PS: Also, wait for the migrations.</sub>

#### Services
1. Swagger
    - API documentation
    - http://localhost
2. Slim + PHP
    - Application
    - http://localhost:8080
3. MySql
    - Database
    - Port 3306
4. Adminer
    - Database web client
    - http://localhost:8081
    - Server: db
    - Username: mysql
    - Password: mypass
    - Database: app
5. Flyway
    - Migrations
6. Mailhog
    - Email service and client
    - http://localhost:8082
    - Port 1025 
7. RabbitMQ
    - Message Broker
    - http://localhost:8083
    - Port 5672 
    - Username: myuser
    - Password: mypassword

#### Application
The application has two endpoints:

```
GET /jobs
    - List all jobs
    - Example: curl -X 'GET' \
              'http://localhost:8080/jobs?user=regular.1%40jobsmapp.com' \
              -H 'accept: */*'
POST /jobs
    - Create a new job
    - Example: curl -X 'POST' \
              'http://localhost:8080/jobs' \
              -H 'accept: */*' \
              -H 'Content-Type: multipart/form-data' \
              -F 'user=regular.1@jobsmapp.com' \
              -F 'title=Job title' \
              -F 'description=Job description'
```

Each endpoint needs the ```user``` parameter to be passed in the request, which is the email of the user. 
This parameter simulates the user authentication.
There are three users available:
```
Regular type:
    - regular.1@jobsmapp.com
    - regular.2@jobsmapp.com
Manager type:
    - manager@jobsmapp.com
```

#### Tests
To run tests, execute the following command:
```
docker-compose exec application php composer.phar test
```