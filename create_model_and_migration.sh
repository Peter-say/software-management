#!/bin/bash

MODEL_NAME=$1
MIGRATION_PATH=$2

# Function to convert camel case to snake case
camel_to_snake() {
    local camel_case=$1
    echo "${camel_case}" | sed -r 's/([a-z])([A-Z])/\1_\2/g' | tr '[:upper:]' '[:lower:]'
}

# Function to pluralize table names
pluralize() {
    local singular=$1
    # Basic pluralization rules
    case $singular in
        *s|*x|*z|*ch|*sh) echo "${singular}es" ;;
        *y) echo "${singular%y}ies" ;;
        *) echo "${singular}s" ;;
    esac
}

# Ensure the directories exist
MODEL_DIRECTORY="app/Models/$MODEL_NAME"
MIGRATION_DIRECTORY="database/migrations/$MIGRATION_PATH"
mkdir -p "$MODEL_DIRECTORY"
mkdir -p "$MIGRATION_DIRECTORY"

# Create the model in the default location
php artisan make:model "$MODEL_NAME"

# Check if the model file exists and move it
if [ -f "app/Models/${MODEL_NAME}.php" ]; then
    mv "app/Models/${MODEL_NAME}.php" "$MODEL_DIRECTORY/"
else
    echo "Model file not found."
    exit 1
fi

# Adjust the namespace in the model file
NEW_NAMESPACE="App\\Models\\$MODEL_NAME"
if [ -f "$MODEL_DIRECTORY/${MODEL_NAME}.php" ]; then
    sed -i "s/namespace App\\\\Models;/namespace $NEW_NAMESPACE;/g" "$MODEL_DIRECTORY/${MODEL_NAME}.php"
else
    echo "Model file not found in the new directory."
    exit 1
fi

# Convert model name from CamelCase to snake_case and pluralize
TABLE_NAME=$(camel_to_snake ${MODEL_NAME})
PLURAL_TABLE_NAME=$(pluralize ${TABLE_NAME})

# Create the migration
MIGRATION_NAME="create_${PLURAL_TABLE_NAME}_table"
php artisan make:migration $MIGRATION_NAME --path="database/migrations/$MIGRATION_PATH"

# Find the latest migration file
MIGRATION_FILE=$(ls -t database/migrations/$MIGRATION_PATH | head -n 1)

# Adjust the migration file to use the pluralized table name
if [ -f "database/migrations/$MIGRATION_PATH/$MIGRATION_FILE" ]; then
    sed -i "s/'${TABLE_NAME}'/'${PLURAL_TABLE_NAME}'/g" "database/migrations/$MIGRATION_PATH/$MIGRATION_FILE"
else
    echo "Migration file not found."
    exit 1
fi
