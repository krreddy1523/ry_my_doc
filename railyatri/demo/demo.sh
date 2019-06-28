#!/bin/bash

ip=` wget -qO - icanhazip.com | cut -d'=' -f2 | cut -d "'" -f2`

# ip1=`hostname  | cut -d'=' -f2 | cut -d "'" -f2`

#   sudo hostname demo
# echo $ipaddress

 #Host=ss_livestatus
 #filename="${Host}"
# num=0
# while [ -f $filename ]; do
#    num=$(( $num + 1 ))
#    filename="ss_livestatus_${num}"
# done

#echo $filename

#  file=` $filename | cut -d'=' -f2 | cut -d "'" -f2`

 ssh  deployer-azure  "sed -i  '1i $ip '    /home/ubuntu/rajasekhar/demo123"
# ssh  deployer-azure  "sed -i  '2i Hostname $ip'   /home/ubuntu/rajasekhar/demo123"
# ssh  deployer-azure  "sed -i  '3i User ubuntu'   /home/ubuntu/rajasekhar/demo123"
# ssh  deployer-azure  "sed -i  '4i  ForwardAgent yes'   /home/ubuntu/rajasekhar/demo123"
 #ssh  deployer-azure  "sed -i  '5i  IdentityFile /home/ubuntu/.ssh/azure.pem'   /home/ubuntu/.ssh/config"
 #ssh  deployer-azure  "sed -i  '6i  #...........scale set details..................#'   /home/ubuntu/.ssh/config"
 #ssh  deployer-azure  "sed -i  '6i  << '   /home/ubuntu/.ssh/config"

  ssh deployer-azure  <<'SSH_EOF'

# ipaddress=`awk 'NR==1 {print $1}' /home/ubuntu/rajasekhar/demo123`
 host=`awk 'NR==1 {print $2}' /home/ubuntu/rajasekhar/con/conf`
  user=`awk 'NR==3 {print $2}' /home/ubuntu/rajasekhar/con/conf`


     az_ss_count=`az vmss list-instances     --resource-group Production     --name SSLivestatus     --output table | wc -l  | cut -d'=' -f2 | cut -d "'" -f2`


# count=$az_ss_count
count=4

if [ $count -eq 3 ]
then

   server=`awk 'NR==1 {print $2}' /home/ubuntu/rajasekhar/con/con`
#     server=`awk 'NR==2 {print $2}' /home/ubuntu/rajasekhar/config`

   sed -i "s/$server/$host/g" /home/ubuntu/rajasekhar/con/con

 serverTD=`awk 'NR==2 {print $2}' /home/ubuntu/rajasekhar/con/con`

    sed -i "s/$serverTD/$user/g" /home/ubuntu/rajasekhar/con/con

elif [ $count -eq 4 ]

then

   server=`awk 'NR==9 {print $2}' /home/ubuntu/rajasekhar/con/con`
#     server=`awk 'NR==2 {print $2}' /home/ubuntu/rajasekhar/config`

   sed -i "s/$server/$ipaddress/g" /home/ubuntu/rajasekhar/con/con

 serverTD=`awk 'NR==10 {print $2}' /home/ubuntu/rajasekhar/con/con`

    sed -i "s/$serverTD/$ip/g" /home/ubuntu/rajasekhar/con/con

else
   ech "dene"

fi

SSH_EOF
