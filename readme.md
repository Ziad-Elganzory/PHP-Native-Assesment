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

## Hosts:
API host: http://api.cc.localhost

DB host: http://db.cc.localhost

Front host: http://cc.localhost

Traefik dashboard: http://127.0.0.1:8080/dashboard/#/


DB credentials - look at the docker-compose.yml and use it in .env

Api docs are in swagger.yml



## How to run project:

```
docker-compose up --build
```


