#!bin/bash

cd ../jekyll-cms 
jekyll build 
cp _site/. ../.. -R 
rm -rf _site