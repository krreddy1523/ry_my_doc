#!/bin/bash
SERVERIP=scaleset_ls_4
NOTIFYEMAIL=rajasekhar.reddy@railyatri.in

ping -c 3 $SERVERIP > /dev/null 2>&1
if [ $? -ne 0 ]
then
   # Use your favorite mailer here:
   mailx -s "Server $SERVERIP is down" -t "$NOTIFYEMAIL" < /dev/null 
fi
