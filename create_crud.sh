#!/bin/bash

PHPFPM=php-fpm-commandes
USER=dine
GROUP=dine

function help()
{
	scriptname=$(basename "$0")
	echo "In case of script errors, just adapt variables"
	echo "How to use ${scriptname} : ${scriptname} create <entityname> [field1,field2,field3,...]"
	echo "                            ${scriptname} rm <entityname>"
}

# arg=un deux trois quatre
action=$1
shift
# arg=deux trois quatre
case $action in

 "create")
	if [ $# -lt 1 ]; then
		echo "Nombre d'argument insuffisant"
	 	help
	else
		mkdir -p app/Entities

		docker compose exec $PHPFPM php spark generate:models $@
		docker compose exec $PHPFPM php spark generate:entity "${1}Model"
		docker compose exec $PHPFPM php spark generate:controller $@
		docker compose exec $PHPFPM php spark generate:views $@
		docker compose exec $PHPFPM php spark generate:routes $@
		entity=${1^}
		sudo chmod -f 0664 app/Views/$entity/*.php  app/Entities/${entity}.php app/Models/${entity}Model.php app/Controllers/${entity}Controller.php
	fi
    ;;

  "rm")
	if [ $# -ne 1 ]; then
		echo "Nombre d'argument insuffisant"
		help
	else
		entity=${1^}
		sudo rm -riv app/Views/$entity/*.php  app/Entities/${entity}.php app/Models/${entity}Model.php app/Controllers/${entity}Controller.php
	fi
    ;;
esac

sudo chown -Rf $USER:$GROUP .
sudo chown -Rf www-data:www-data writable
