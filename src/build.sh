docker run --rm -ti -v $PWD:/app composer install
echo $?
docker container exec priorityqueue_php_1 php /src/artisan migrate
echo "whathe fack"
