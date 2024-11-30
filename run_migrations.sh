#!/bin/bash

MIGRATIONS_DIR="./database/migrations"  # Ensure the path is relative to your current directory
CONTAINER_NAME="db"                     # MySQL container name
DB_USER="test_user"                     # MySQL username
DB_PASS="test_password"                 # MySQL password
DB_NAME="course_catalog"                # Target database name

# Ensure migrations directory exists
if [ ! -d "$MIGRATIONS_DIR" ]; then
    echo "Error: Migrations directory '$MIGRATIONS_DIR' does not exist."
    exit 1
fi

# Iterate over all .sql files in the migrations directory
for SQL_FILE in "$MIGRATIONS_DIR"/*.sql; do
    [ -e "$SQL_FILE" ] || { echo "No migration files found in $MIGRATIONS_DIR."; exit 0; }
    echo "Running migration: $SQL_FILE"

    # Execute the migration inside the container
    docker-compose exec $CONTAINER_NAME sh -c \
        "mysql --user='$DB_USER' --password='$DB_PASS' '$DB_NAME' < /docker-entrypoint-initdb.d/$(basename "$SQL_FILE")"

    # Check the command result
    if [ $? -ne 0 ]; then
        echo "Error running migration: $SQL_FILE"
        exit 1
    fi
done

echo "All migrations executed successfully."
