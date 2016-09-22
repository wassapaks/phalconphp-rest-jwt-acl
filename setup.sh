#!/bin/sh

bold=$(tput bold)
normal=$(tput sgr0)
RED='\033[0;31m'
GREEN='\033[0;32m'
NC='\033[0m' # No Color

config="dist/config/config.$1.php";
db=($(php -r 'include "'$config'"; echo implode(" ",$settings["database"]);')) 

clear

printf "${RED}========================================================= \n"
printf "Setting up Phalcon Rest JWT \n"
printf "Author: Ef \n"
printf "Ver=1.0 \n"
printf "=========================================================${NC} \n"

printf "${GREEN}---------- I will now check your database connection. ${NC} \n"

if [ ! -f $config ]; then
    printf "${RED} File not found! "$config"${NC}"
    exit
fi

mysql --host="${db[1]}" --user="${db[2]}" --password="${db[3]}" -e exit 2>/dev/null
dbstatus=`echo $?`
if [ $dbstatus -ne 0 ]; then
  printf "${RED} Please check your database credentials in your "$config" file. ${NC} \n\n"
  exit
else
  printf "${GREEN} Connection Success! ${NC} \n\n"
fi

printf "${GREEN}---------- I will now create your database and migrate init.sql ${NC} \n"
RESULT=`mysql -h${db[1]} -u${db[2]} -p${db[3]} --skip-column-names -e "SHOW DATABASES LIKE '${db[4]}'"`
if [ "$RESULT" == ${db[4]} ]; then
  printf "${RED} Your Database already exist, you might want to change your database name ${NC}\n\n"
  exit
else
  printf "${GREEN} Database does not exist, So i will be creating your database now.... ${NC} \n\n"
  dbcreate=`mysql -h${db[1]} -u${db[2]} -p${db[3]} --skip-column-names -e "CREATE DATABASE ${db[4]};"`
  printf "${GREEN} ${db[4]} has been created now calling migrating script... ${NC} \n\n"
  bash migratesql.sh ${db[2]} ${db[3]} init-only ${db[4]}
fi

printf "${GREEN}---------- I will now copy your config file to the designated folder ${NC} \n"

copyconfig=$(dirname $(readlink -f $0))"/dist/config/config."$1".php"
destconfig=$(dirname $(readlink -f $0))"/app/config/config."$1".php"

if [ -f $destconfig ]; then
    sudo rm $destconfig
fi

sudo cp $copyconfig $destconfig
printf "${GREEN} $copyconfig has been copied ... ${NC} \n\n"

sed -i "/define('APP_ENV'/c\    define('APP_ENV', getenv('APP_ENV') ?: '$1');" public/index.php
printf "${GREEN} APP_ENV has been changed in public/index.php ... ${NC} \n\n"


printf "${GREEN}---------- Executing Composer Install ${NC} \n"
composer install

printf "${GREEN}---------- Creating Cache Folder ${NC} \n"
sudo mkdir app/cache
sudo chmod -R 776 app/cache

printf "${GREEN}---------- Thank you for using PhalconRestJWT ${NC} \n\n"