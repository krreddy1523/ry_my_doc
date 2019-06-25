#!/bin/bash

ADMIN="himanshu.bisht@railyatri.in"

if curl -Is --head http://127.0.0.1:8080 | grep "200 OK" > /dev/null
then
echo "THE NTES_Up...HURRY..!!"
else
echo "THE NTES_Down..need to fix it uh!"
fi

