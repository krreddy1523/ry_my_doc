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

 Host=live_status
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

 ssh  azure-ip  "sed -i  '1i Host $filename '   /home/ubuntu/.ssh/config "
 ssh  azure-ip  "sed -i  '2i Hostname $ip'   /home/ubuntu/.ssh/config"
 ssh  azure-ip  "sed -i  '3i User ubuntu'   /home/ubuntu/.ssh/config"
 ssh  azure-ip  "sed -i  '4i  ForwardAgent yes'   /home/ubuntu/.ssh/config"
 ssh  azure-ip  "sed -i  '5i  IdentityFile /home/ubuntu/.ssh/azure.pem'   /home/ubuntu/.ssh/config"
# ssh  deployer-azure  "sed -i  '6i  << '   /home/ubuntu/.ssh/config"


#  echo -e "\n"

 # ssh ubuntu@$ipaddress <<'SSH_EOF'

   ssh azure-ip  <<'SSH_EOF'

 #  Script of deployment

    scp /home/ubuntu/config/*.yml $host:/u/apps/status/shared/config

#  cd /u/apps/status

#  cd /u/apps/status/config/deploy



#SSH_EOF

