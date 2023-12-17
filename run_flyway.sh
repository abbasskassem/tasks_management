#!/bin/bash

echo "Running Flyway migrations check .."
docker-compose run flyway
