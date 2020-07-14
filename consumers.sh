if [ $# -eq 0 ]
  then
    echo "Must supply the number of consumers"
    exit 1
fi
re='^[0-9]+$'
if ! [[ $1 =~ $re ]] ; then
   echo "The argument mus be an integer" >&2; exit 1
fi

for i in {1..$1}; do docker container exec -d priorityqueue_php_1 php /src/artisan queue:consume; done
