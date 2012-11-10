#!/bin/sh
mkdir build -p
tar czvf . build/doctrine2-workshop.tar.gz --exclude build --exclude .git
