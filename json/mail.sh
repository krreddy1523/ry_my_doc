#!/bin/bash

ADMIN="rajasekhar.reddy@railyatri.in"
#ADMIN1="quais.husain@railyatri.in"
#ADMIN2="aparajita.m@stellingtech.com"
#ADMIN3="kalpesh.vaghani@stellingtech.com"
ADMIN4="rakesh.yadav@stellingtech.com "
ADMIN5="uday.pandey@railyatri.in"

echo "-----------------------------------------------------------"
echo "Started At : $(date)          CREATED BY : RAJASEKHAR REDDY"
echo "-----------------------------------------------------------"

number=1
num=1

count=$(cat /home/ubuntu/rajasekhar/mail/host | wc -l)

while [ $number -le $count ]
do
date
ip=$(head -n $number /home/ubuntu/rajasekhar/mail/host | tail -n 1 | awk 'NR==1{printf $1}')

ipaddress=$(head -n $number /home/ubuntu/rajasekhar/mail/host | tail -n 1 | awk 'NR==1{printf $2}')

 host=$ip
 
 ipa=$ipaddress

 echo "$ipa"

ping -c 3 $ipa > /dev/null 2>&1
 
if [ $? -eq 0 ]
then
 
 echo ok

# path='/home/ubuntu/script'

# ram=`ssh $host 'sh /home/ubuntu/script/ram.sh' | awk 'NR==1{printf $1}'` 

 ram=`ssh $host free -m | awk 'NR==2{printf "Memory Usage: %s/%sMB %.f\n", $3,$2,$3*100/$2 }'| awk 'NR==1{printf $4}' | awk 'NR==1{printf $1}' | awk 'NR==1{printf $1}'` 
 
# disk=`ssh $host 'sh /home/ubuntu/script/disk.sh' | awk 'NR==1{printf $1}'`
  
 disk=`ssh $host df -h | awk '$NF=="/"{printf "%d/%dGB %s\n", $3,$2,$5}'| awk 'NR==1{print $2}'| tr '%' ' ' | awk 'NR==1{printf $1}'`

 queue=` ssh $host sudo passenger-status | grep "Requests in queue" | awk '{print $4}'`

 echo "$ram"

 echo "$disk"

 echo "$queue"
  
 if [ $ram -ge 95 ]
 then

 echo "RAM SPACE $ram% used on $host Server as on $(date)" | mail -s " Alert:$host RAM SPACE LOW " $ADMIN $ADMIN1 $ADMIN2 $ADMIN3 $ADMIN4 $ADMIN5

 else
   
    echo "working fine"

  fi

  if [ $disk -ge 95 ]
 then

 echo " DISK SPACE $disk% used on $host Server as on $(date)" | mail -s " Alert:$host DISK SPACE LOW " $ADMIN $ADMIN1 $ADMIN2 $ADMIN3 $ADMIN4 $ADMIN5

 else

    echo "working fine"
fi

 if [ $queue -ge 30 ]

 then

 echo "Queue size in $host Server is $queue at $(date)" | mail -s "Queue size in $host Server is  $queue" $ADMIN $ADMIN1 $ADMIN2 $ADMIN3 $ADMIN4 $ADMIN5

 else
  
   echo "working fine"
fi



echo "---------------------------------------------------------"
echo "          $host TASK COMPLETED AT : $(date)" 
echo "---------------------------------------------------------"

#number=$(expr "$number" + "$num")

#exit

 else
 
   echo “fail”
    echo "$host server is not runnig $(date)" | mail -s " Alart: $host server is not running " $ADMIN

echo "---------------------------------------------------------"
echo "          $host SERVER NOT WORKING AT : $(date)" 
echo "---------------------------------------------------------"

fi

number=$(expr "$number" + "$num")

done
