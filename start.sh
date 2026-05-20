#!/bin/bash

# 1. Start the Docker containers
docker-compose up -d --build

# 2. Wait a couple of seconds for the Apache server to fully wake up
echo "Starting containers and opening browser..."
sleep 5

# 3. Open the URLs in your default Mac browser
open http://localhost:8080/
open http://localhost:8080/api/projects.php

# 4. To close: docker-compose down -v 