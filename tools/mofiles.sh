#!/bin/bash

cd ../includes;
for i in $(find . -type f -name "*.php"); 
do 
    OFS=$IFS
    IFS=$'\n'
    # cat $i|grep  "public function " |grep -v "__construct"|grep -v "__construct"|cut -f1 -d'('|cut -c21-;
    for j in $(cat $i|grep -Ei "(public)? function " |grep -v "__construct"|grep -v "__destruct");
    do 
        k=$(echo $j|cut -f1 -d'('|cut -c21-);
        # echo sed -Ea "s/$k/$(echo $k| perl -pne 's/_([a-z0-9])/\U$1/g')/g" $i;
        echo $k"|"$(echo $k| perl -pne 's/_([a-z0-9])/\U$1/g');
        # echo $k;
    done;
    IFS=$OFS
done |sort -u > replacements.txt