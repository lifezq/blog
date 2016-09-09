#!/bin/bash

files=`find . -type f -name "*.gif" | xargs`

for f in $files
do 

    gif2webp -q 70 $f -o ${f%.gif}.webp
    printf "cmd:gif2webp -q 70 %s -o %s\n" $f ${f%.gif}.webp
done

files=`find . -type f -name "*.png" | xargs`

for f in $files
do 

    cwebp -q 70 $f -o ${f%.png}.webp
    printf "cmd:cwebp -q 70 %s -o %s\n" $f ${f%.png}.webp
done

files=`find . -type f -name "*.jpg" | xargs`

for f in $files
do 

    cwebp -q 70 $f -o ${f%.jpg}.webp
    printf "cmd:cwebp -q 70 %s -o %s\n" $f ${f%.jpg}.webp
done

files=`find . -type f -name "*.jpeg" | xargs`

for f in $files
do 

    cwebp -q 70 $f -o ${f%.jpeg}.webp
    printf "cmd:cwebp -q 70 %s -o %s\n" $f ${f%.jpeg}.webp
done
