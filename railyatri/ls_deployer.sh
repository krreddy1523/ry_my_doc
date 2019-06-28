#!/bin/sh

#read -p "enter new file:" filename
#read -p "enter old file:" oldfile
#read -p "enter name:" name
#read -p "enter newname:" newname

# echo $host host $ip
  servername="ss_live_status"

 echo $servername

  host="Host $servername"

  echo $host

# echo $user User ubuntu

# echo $permission  ForwardAgent yes

# echo $path  IdentityFile /home/rajasekharreddy/.ssh/azure.pem

# DATE="`date +"%d%m%G%H%m"`"

# curl ifconfig.co
#dig +short myip.opendns.com @resolver1.opendns.com

# ipaddress='52.172.218.225'

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

 ssh  deployer-azure  "sed -i  '1i  $host'   /home/ubuntu/.ssh/config "
 ssh  deployer-azure  "sed -i  '2i Hostname $ip'   /home/ubuntu/.ssh/config"
 ssh  deployer-azure  "sed -i  '3i User ubuntu'   /home/ubuntu/.ssh/config"
 ssh  deployer-azure  "sed -i  '4i  ForwardAgent yes'   /home/ubuntu/.ssh/config"
 ssh  deployer-azure  "sed -i  '5i  IdentityFile /home/ubuntu/.ssh/azure.pem'   /home/ubuntu/.ssh/config"
 ssh  deployer-azure  "sed -i  '6i  '   /home/ubuntu/.ssh/config"
 ssh  deployer-azure  "sed -i  '7i  '   /home/ubuntu/.ssh/config"
  echo -e "\n"

 # ssh ubuntu@$ipaddress <<'SSH_EOF'

   ssh deployer-azure <<'SSH_EOF'

   #sudo rm -rf /home/ubuntu/.ssh/test

 #sudo   mkdir /home/ubuntu/.ssh/test

 #sudo  touch /home/ubuntu/.ssh/test/demofile.yml

 # scp /home/ubuntu/.ssh/test/*.yml  $host:/home/ubuntu/.ssh/

   scp /home/ubuntu/config/*.yml ss_live_status:/u/apps/live_status/shared/config

  cd /u/apps/railyatri.live_status_5

  cp -r /u/apps/railyatri.live_status_5/config/deploy/production_1.rb  /u/apps/railyatri.live_status_5/config/deploy/production_1_as.rb 

  sed -i 's/'live-status-1-ind-5/ss_live_status'/g' /u/apps/railyatri.live_status_5/config/deploy/production_1_as.rb &&

   eval $(ssh-agent) && ssh-add &&

  cap production_1_as deploy

  sleep 10

#  curl $ip/api/home.json?[1-10]

#  curl 104.211.91.28/api/home.json?[1-10]

 SSH_EOF

#read -p "enter new file:" filename
#read -p "enter old file:" oldfile
#read -p "enter name:" name
#read -p "enter newname:" newname
#cp -r /home/ginger/jenkins/$oldfile   /home/ginger/Desktop/malli/$filename

#sed -i 's/'${name}'/'${newname}'/g' /home/ginger/Desktop/malli/$filenamey

