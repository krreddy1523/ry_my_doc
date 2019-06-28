#!/bin/sh


# echo $host host $ip
#  servername="ss_live_status"

# echo $servername

#  host="Host $servername"

#  echo $host


# DATE="`date +"%d%m%G%H%m"`"

#dig +short myip.opendns.com @resolver1.opendns.com

# .................. Find host name .......................

# demo = " wget -qO - icanhazip.com "
# echo $demo

 ip=` wget -qO - icanhazip.com | cut -d'=' -f2 | cut -d "'" -f2`

# ip1=`hostname  | cut -d'=' -f2 | cut -d "'" -f2`


 echo $ipaddress

 Host=ss_live_status
 filename="${Host}"
 num=0
 while [ -f $filename ]; do
    num=$(( $num + 1 ))
    filename="${Host}_${num}"
 done

#  cp /home/ubuntu/host/servers /home/ubuntu/host/$filename

# echo $ip

# echo $hostname

# echo $ip1

 ssh  deployer-azure  "sed -i  '1i Host $filename '   /home/ubuntu/.ssh/config "
 ssh  deployer-azure  "sed -i  '2i Hostname $ip'   /home/ubuntu/.ssh/config"
 ssh  deployer-azure  "sed -i  '3i User ubuntu'   /home/ubuntu/.ssh/config"
 ssh  deployer-azure  "sed -i  '4i  ForwardAgent yes'   /home/ubuntu/.ssh/config"
 ssh  deployer-azure  "sed -i  '5i  IdentityFile /home/ubuntu/.ssh/azure.pem'   /home/ubuntu/.ssh/config"
# ssh  deployer-azure  "sed -i  '6i  << '   /home/ubuntu/.ssh/config"

 cp /home/ubuntu/host/servers /home/ubuntu/host/$filename

#  echo -e "\n"

 # ssh ubuntu@$ipaddress <<'SSH_EOF'

   ssh deployer-azure  <<'SSH_EOF'

# DATE="`date +"%d%m%G%H%m"`"

 #file="$DATE+production_1_as.rb"

   host=`awk 'NR==1 {print $2}' /home/ubuntu/.ssh/config`

   ip=`awk 'NR==2 {print $2}' /home/ubuntu/.ssh/config`


   server=`awk 'NR==13 {print $2}' /u/apps/railyatri.live_status_5/config/deploy/production_1_as.rb`


   scp /home/ubuntu/config/*.yml $host:/u/apps/live_status/shared/config

#  cd /u/apps/railyatri.live_status_5

#  cd /u/apps/railyatri.live_status_5/config/deploy

#   Host=ss_live_status
# file="${Host}"
# num=0
# while [ -f $filename ]; do
#    num=$(( $num + 1 ))
#    file="${Host}-${num}"
# done


#  cp /u/apps/railyatri.live_status_5/config/deploy/demo.rb /u/apps/railyatri.live_status_5/config/deploy/$file

  cd /u/apps/railyatri.live_status_5

 # cp -r /u/apps/railyatri.live_status_5/config/deploy/production_1.rb  /u/apps/railyatri.live_status_5/config/$filename

  #namechanger=`awk 'NR==1 {print $2}' /home/ubuntu/.ssh/config`

  sed -i "s/$server/'$host'/g" /u/apps/railyatri.live_status_5/config/deploy/production_1_as.rb &&

#exit 1

   eval $(ssh-agent) && ssh-add &&

  cap production_1_as deploy

  sleep 10

#  echo $ip

  curl $ip/api/home.json?[1-10]

#  curl 104.211.91.28/api/home.json?[1-10]
#   exit

 SSH_EOF

#ssh ss_live_status  <<'SSH_EOF'

#  ip=` wget -qO - icanhazip.com | cut -d'=' -f2 | cut -d "'" -f2`

#   echo $ip

#  curl $ip/api/home.json?[1-10]

#SSH_EOF

