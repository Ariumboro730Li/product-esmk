#!/usr/bin/env bash

set -e

role=${CONTAINER_ROLE:-app}

if [ "$role" = "queue" ]; then

    echo "Running the queue..."
    php /var/www/artisan queue:work

elif [ "$role" = "scheduler" ]; then

    echo "Running the scheduler..."
    while [ true ]
    do
      php /var/www/artisan schedule:run
      sleep 3
    done

fi