#!/bin/bash

echo "*************************************"
echo "*************************************"
echo "*                                   *"
echo "*   Installation of SpyAgents GUI   *"
echo "*         by navaismo               *"
echo "*      info@digital-merge.com       *"
echo "*                                   *"
echo "*************************************"
echo "*************************************"

echo "YOU NEED MYSQL SERVER RUNNING and a DATABASE to store the TABLES"
echo
echo

echo "Name of the database:"
read database
echo ""

echo "User of the database:"
read dbuser
echo ""

echo "Password of the database:"
read dbpwd
echo ""


echo "Asterisk Manager User:"
read amiuser
echo ""

echo "Asterisk Manager Password:"
read amipwd



mkdir /var/www/html/spyagents
mysql -u$dbuser -p$dbpwd  $database < spyid.sql
mysql -u$dbuser -p$dbpwd  $database < spyidcdr.sql

cp -rf phpagi /var/lib/asterisk/agi-bin/
cp -rf * /var/www/html/spyagents

sed -i 's/pdbuser/'$dbuser'/g' /var/www/html/spyagents/loginsql.php
sed -i 's/pdbpass/'$dbpwd'/g' /var/www/html/spyagents/loginsql.php
sed -i 's/pdbname/'$database'/g' /var/www/html/spyagents/loginsql.php

sed -i 's/muser/'$amiuser'/g' /var/www/html/spyagents/*.php
sed -i 's/mpass/'$amipwd'/g' /var/www/html/spyagents/*.php
