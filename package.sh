#!/bin/sh
mkdir build -p
tar czvf build/doctrine2-workshop.tar.gz . --exclude build --exclude .git --exclude cache --exclude logs --exclude *.swp --exclude workshop.db
