docker run --rm -ti -v $PWD:/app composer install
docker container exec -d priorityqueue_php_1 php /src/artisan migrate