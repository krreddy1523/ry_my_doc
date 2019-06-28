#!/bin/sh

# /u/apps/railyatri.live_status_5/config/deploy

#read -p "enter new file:" filename
#read -p "enter old file:" oldfile
#read -p "enter name:" name
#read -p "enter newname:" newname

# echo $host host $ip

#  hostname =  Hostname ss_live_status

# echo $user User ubuntu

# echo $permission  ForwardAgent yes

# echo $path  IdentityFile /home/rajasekharreddy/.ssh/azure.pem

# DATE="`date +"%d%m%G%H%m"`"

# curl ifconfig.co
#dig +short myip.opendns.com @resolver1.opendns.com

 ipaddress='52.172.222.217'

# .................. Find host name .......................

# demo = " wget -qO - icanhazip.com "
# echo $demo

 ip=` wget -qO - icanhazip.com | cut -d'=' -f2 | cut -d "'" -f2`

# ip1=`hostname  | cut -d'=' -f2 | cut -d "'" -f2`


 echo $ipaddress

 echo $ip

# echo $hostname

# echo $ip1

# ssh ubuntu@52.172.222.217

 ssh ubuntu@$ipaddress  "sed -i  '1i  Hostname ss_live_status'   /home/ubuntu/.ssh/config "
 ssh ubuntu@52.172.222.217  "sed -i  '2i Host $ip'   /home/ubuntu/.ssh/config"
 ssh ubuntu@52.172.222.217  "sed -i  '3i User ubuntu'   /home/ubuntu/.ssh/config"
 ssh ubuntu@52.172.222.217  "sed -i  '4i  ForwardAgent yes'   /home/ubuntu/.ssh/config"
 ssh ubuntu@52.172.222.217  "sed -i  '5i  IdentityFile /home/rajasekharreddy/.ssh/azure.pem'   /home/ubuntu/.ssh/config"
# ssh ubuntu@52.172.222.217  "sed -i  '6i  '   /home/ubuntu/.ssh/config"

 ssh ubuntu@52.172.222.217 <<'SSH_EOF'

   sudo rm -rf /home/ubuntu/.ssh/test

  #scp

 SSH_EOF
#read -p "enter new file:" filename
#read -p "enter old file:" oldfile
#read -p "enter name:" name
#read -p "enter newname:" newname
#cp -r /home/ginger/jenkins/$oldfile   /home/ginger/Desktop/malli/$filename

#sed -i 's/'${name}'/'${newname}'/g' /home/ginger/Desktop/malli/$filenamey

