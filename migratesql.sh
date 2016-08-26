bold=$(tput bold)
normal=$(tput sgr0)
RED='\033[0;31m'
GREEN='\033[0;32m'
NC='\033[0m' # No Color



printf "${RED}========================================================= \n"
printf "Bash Execute SQL Files \n"
printf "Author: Ef \n"
printf "Ver=0.1 \n"
printf "=========================================================${NC} \n"

FILES=dist/sql/*

function execute {
      printf "=========================================================\n"
      printf "${GREEN}${bold}Processing $3 file...${NC} \n"
      printf "                                                          \n"
      if mysql -u$1 -p$2 $4 < $3
      then
            printf "${GREEN}DONE!${NC} \n"
      fi
      printf "========================================================= \n"
      # take action on each file. $f store current file name
}

function loopfiles {
  FILES=dist/sql/*
    for f in $FILES
        do

         if [ "$f" != "dist/sql/init.sql" ]
         then
           execute $1 $2 $f $3
         fi
        done
}

case "$3" in

migrate-sql)
  execute $1 $2 dist/sql/init.sql $4
  loopfiles $1 $2 $4
    ;;
init-only)
    execute $1 $2 dist/sql/init.sql $4
    ;;
sql-commands-only)
  loopfiles $1 $2 $4
    ;;
*) printf "No Sqlcommand \n"
   ;;
esac



