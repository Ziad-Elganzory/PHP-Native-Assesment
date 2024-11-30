# Test task - Course catalog
## To do:

1. Create a Restful API according to the specification in the swagger.yaml;
    - Requirements:
        - Pure PHP;
        - PSR-12;
        - Services should have as few sql requests as possible;
2. Create a database structure and put migrations in /database/migrations folder;
    - Example of migration is provided in the /database/migrations/1713358478_example.sql file;
    - Mock data is located in the /data folder;
4. Create SPA application with a web page to display the courses and categories;
    - Design layouts are located in the /design folder;
        - Pixel perfect is not required;
    - Requirements:
        - Any front-end framework can be used, but pure technologies are preferred;
    - Layout key features include:
        - By default, all courses should be displayed;
        - By clicking on a category, only courses from that category should be displayed;
        - On the desktop layout, titles and descriptions are truncated with ellipses;
        - If category has courses the count of courses should be displayed and value should include count of courses in child categories;
        - Each course card should display name of the main category of the course;
    - Restrictions:
        - Each course should belong to only one category;
        - Max depth of the categories tree is 4;

## How to run project:

```
docker-compose up --build
```

## Hosts:
API host: http://api.cc.localhost

DB host: http://db.cc.localhost

Front host: http://cc.localhost

Traefik dashboard: http://127.0.0.1:8080/dashboard/#/


DB credentials - look at the docker-compose.yml

Api docs are in swagger.yml

-----------------------------------------------------------------------
## Key Changes:

1. The Php Image didn't include mysqli and pdo extentions so i made a docker file and installing the needed extentions 

2. After Building the docker-compose.yml ,run``` docker-compose up -d ``` 
   then run ``` ./database/run_migrations.sh  ``` to create database tables.

3. rename .env-example to .env and run ``` php insertToDB.php --json=<json_file_path> --table=<table_name>  ``` for each table

## Backend Endpoints:

1. Get All Courses ``` http://api.cc.localhost/courses ```

2. Get Course By ID ``` http://api.cc.localhost/courses/${id} ```

3. Get All Categories ``` http://api.cc.localhost/categories ```

4. Get Category By uuid ``` http://api.cc.localhost/categories/${uuid} ```

