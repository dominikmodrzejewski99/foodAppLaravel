#!/bin/bash

# Create directory for generated code
mkdir -p angular-client

# Download OpenAPI Generator CLI if not already present
if [ ! -f openapi-generator-cli.jar ]; then
    wget https://repo1.maven.org/maven2/org/openapitools/openapi-generator-cli/6.6.0/openapi-generator-cli-6.6.0.jar -O openapi-generator-cli.jar
fi

# Generate Angular client
java -jar openapi-generator-cli.jar generate \
    -i http://localhost:8000/docs/api-docs.json \
    -g typescript-angular \
    -o angular-client \
    --additional-properties=npmName=food-app-api,npmVersion=1.0.0,ngVersion=16.0.0

echo "Angular client generated successfully in the 'angular-client' directory"
