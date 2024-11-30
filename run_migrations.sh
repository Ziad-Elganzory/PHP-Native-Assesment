#!/bin/bash

MIGRATIONS_DIR="database/migrations"  
CONTAINER_NAME="db"                     
DB_USER="test_user"                    
DB_PASS="test_password"               
DB_NAME="course_catalog"               

for SQL_FILE in "$MIGRATIONS_DIR"/*.sql; do
    echo "Running migration: $SQL_FILE"
    docker-compose exec -it $CONTAINER_NAME mysql --user="$DB_USER" --password="$DB_PASS" "$DB_NAME" < "$SQL_FILE"
    if [ $? -ne 0 ]; then
        echo "Error running migration: $SQL_FILE"
        exit 1
    fi
done

echo "All migrations executed successfully."
