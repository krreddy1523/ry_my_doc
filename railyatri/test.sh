#!/bin/bash
SERVERIP=34.68.118.158
#SERVERIP=scaleset_ls_4
NOTIFYEMAIL=rajasekhar.reddy@railyatri.in

ping -c1 $SERVERIP > /dev/null
if [ $? -eq 0 ]
  then 
    echo ok 
    exit 0
  else
    echo “fail”
fi
