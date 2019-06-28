#!/bin/sh


# echo $host host $ip

#dig +short myip.opendns.com @resolver1.opendns.com

# .................. Find host name .......................

# demo = " wget -qO - icanhazip.com "
# echo $demo

#    cd /home/ubuntu/script

 ip=` wget -qO - icanhazip.com | cut -d'=' -f2 | cut -d "'" -f2`

# ip1=`hostname  | cut -d'=' -f2 | cut -d "'" -f2`


# echo $ipaddress

 #Host=ss_livestatus
 #filename="${Host}"
 num=0
 while [ -f $filename ]; do
    num=$(( $num + 1 ))
    filename="ss_livestatus_${num}"
 done

#echo $filename

#  file=` $filename | cut -d'=' -f2 | cut -d "'" -f2`

 ssh  deployer-azure  "sed -i  '1i $ip '    /home/ubuntu/rajasekhar/demo"
# ssh  deployer-azure  "sed -i  '2i Hostname $ip'   /home/ubuntu/.ssh/config"
# ssh  deployer-azure  "sed -i  '3i User ubuntu'   /home/ubuntu/.ssh/config"
# ssh  deployer-azure  "sed -i  '4i  ForwardAgent yes'   /home/ubuntu/.ssh/config"
# ssh  deployer-azure  "sed -i  '5i  IdentityFile /home/ubuntu/.ssh/azure.pem'   /home/ubuntu/.ssh/config"
# ssh  deployer-azure  "sed -i  '6i  #...........scale set details..................#'   /home/ubuntu/.ssh/config"
# ssh  deployer-azure  "sed -i  '6i  << '   /home/ubuntu/.ssh/config"

#  cp /home/ubuntu/script/ss_ls /home/ubuntu/script/$filename

#  echo -e "\n"

 # ssh ubuntu@$ipaddress <<'SSH_EOF'

#exit1

#exit

# ....................... second server details for deploying process ....................

   ssh deployer-azure  <<'SSH_EOF'

#    cd /home/ubuntu/rajasekhar
#   mv demo demo1

#    source  /home/ubuntu/rajasekha/demo.sh argument1


#    cd /home # cd ubuntu #cd rajasekhar #./demo.sh


   ipaddress=`awk 'NR==1 {print $1}' /home/ubuntu/rajasekhar/demo`

     az_ss_count=`az vmss list-instances     --resource-group Production     --name SSLivestatus     --output table | wc -l  | cut -d'=' -f2 | cut -d "'" -f2`


 count=$az_ss_count
#count=6
if [ $count -eq 3 ]
then

   server=`awk 'NR==2 {print $2}' /home/ubuntu/.ssh/config`
#     server=`awk 'NR==2 {print $2}' /home/ubuntu/rajasekhar/config`

   sed -i "s/$server/$ipaddress/g" /home/ubuntu/.ssh/config

elif [ $count -eq 4 ]
then

    server=`awk 'NR==8 {print $2}' /home/ubuntu/.ssh/config`

   sed -i "s/$server/$ipaddress/g" /home/ubuntu/.ssh/config

elif [ $count -eq 5 ]
then

      server=`awk 'NR==14 {print $2}' /home/ubuntu/.ssh/config`

   sed -i "s/$server/$ipaddress/g" /home/ubuntu/.ssh/config

elif [ $count -eq 6 ]
then

   server=`awk 'NR==20 {print $2}' /home/ubuntu/.ssh/config`

   sed -i "s/$server/$ipaddress/g" /home/ubuntu/.ssh/config

else
  echo "done"
fi

 DATE="`date +"%d%m%G%H%m"`"

 #file="$DATE+production_1_as.rb"

#   host=`awk 'NR==1 {print $2}' /home/ubuntu/.ssh/config`

 #  ip=`awk 'NR==2 {print $2}' /home/ubuntu/.ssh/config`


#   server=`awk 'NR==13 {print $2}' /u/apps/railyatri.live_status_5/config/deploy/production_1_as.rb`


#   scp /home/ubuntu/config/*.yml $host:/u/apps/live_status/shared/config

  if [ $count -eq 3 ]
then

  scp /home/ubuntu/config/*.yml testing1:/u/apps/live_status/shared/config

elif [ $count -eq 4 ]
then

scp /home/ubuntu/config/*.yml testing2:/u/apps/live_status/shared/config

elif [ $count -eq 5 ]
then

     scp /home/ubuntu/config/*.yml testing3:/u/apps/live_status/shared/config

elif [ $count -eq 6 ]
then

   scp /home/ubuntu/config/*.yml testing4:/u/apps/live_status/shared/config

else
  echo "done"
fi


#  cd /u/apps/railyatri.live_status_5

#  cd /u/apps/railyatri.live_status_5/config/deploy


#  cp /u/apps/railyatri.live_status_5/config/deploy/demo.rb /u/apps/railyatri.live_status_5/config/deploy/$file

  cd /u/apps/railyatri.live_status_5

 # cp -r /u/apps/railyatri.live_status_5/config/deploy/production_1.rb  /u/apps/railyatri.live_status_5/config/$filename

  #namechanger=`awk 'NR==1 {print $2}' /home/ubuntu/.ssh/config`

#  sed -i "s/$server/'$host',/g" /u/apps/railyatri.live_status_5/config/deploy/production_1_as.rb &&



   eval $(ssh-agent) && ssh-add

if [ $count -eq 3 ]
then

  cap production_ss deploy

elif [ $count -eq 4 ]
then

cap production_ss deploy

elif [ $count -eq 5 ]
then

     cap production_ss deploy

elif [ $count -eq 6 ]
then

   cap production_ss deploy

else
  echo "done"
fi



#  cap production_1_as deploy

  sleep 10
#  echo $ip

  curl $ipaddress/api/home.json?[1-10]

#  curl 104.211.91.28/api/home.json?[1-10]
#   exit

 SSH_EOF

#ssh ss_live_status  <<'SSH_EOF'

#  ip=` wget -qO - icanhazip.com | cut -d'=' -f2 | cut -d "'" -f2`

#   echo $ip

#  curl $ip/api/home.json?[1-10]

#SSH_EOF

