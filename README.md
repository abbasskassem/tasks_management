# Demo Project by Abbass Kassem

Steps: Download the project :

- This project is based on PHP 8.2, Laravel 10.x, MySQL 8.0
- Used Flyway for migrations control
- This project is dockerized 
  - I have added PHPMyAdmin to allow you view the database structure (http:localhost:8081)
  - Default Server in phpMyAdmin is "mysql" , user: root, password: password
  - I have attached PostMan collection to view the endpoints and test them
- Steps:

  - git clone project_repo
  - docker-compose up --build  ( first time to build the image)
  - go inside the directory and run the following commands:
    - ./setup_project.sh  ( make sure  you run chmod +x to allow execute permission allowed)
    - make sure to run_flyway command ( ./run_flyway.sh) in case
