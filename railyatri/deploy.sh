s#!/bin/bash

#Deployment Script on Production for Zone 1a

# echo $DATE="`date +"%d%m%G%H%m"`"
#DATE="`date +"%d%m%G%H%m"`"
# echo $src='/home/rajasekharreddy/Desktop/stuf/src'
#src='/home/rajasekharreddy/Desktop/stuf/src'
# echo $dest='/home/rajasekharreddy/Desktop/stuf/dest'
#dest='/home/rajasekharreddy/Desktop/stuf/dest'
#dest='/home/userdata/scale/dest/'
# echo $backdir='/home/rajasekharreddy/Desktop/stuf/backup'
#backdir='/home/rajasekharreddy/Desktop/stuf/backup'
#backdir='/home/userdata/scale/backup'
# echo "***************Deploying on Production***************"

# sudo  mkdir   $backdir/$DATE
 
# sudo cp -r  /home/userdata/scale/dest/* /home/userdata/scale/backup/$DATE/

#cp -r  $dest/* $backup/DATE/

# cd /home/userdata/scale/dest/

# sudo rm  -rf *

# sudo git pull https://github.com/krreddy1523/scale-set.git 

#scp   /home/rajasekharreddy/Desktop/scale-set/test.sh  deployer-azure:/home/ubuntu/rajasekhar/

ssh deployer-azure  <<'SSH_EOF'

 sh /home/ubuntu/RY_scaleset/sslts.sh

SSH_EOF

