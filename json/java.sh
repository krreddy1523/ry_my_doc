#!/bin/bash

ADMIN="rajasekhar.reddy@railyatri.in"
#ADMIN1="quais.husain@railyatri.in"
#ADMIN2="aparajita.m@stellingtech.com"
#ADMIN3="kalpesh.vaghani@stellingtech.com"
#ADMIN4="rakesh.yadav@stellingtech.com "
ADMIN5="uday.pandey@railyatri.in"
#ADMIN6="akhilesh.yadav@railyatri.in"
#ADMIN7="rohit.garg@railyatri.in"
echo "-----------------------------------------------------------"
echo "Started At : $(date)          CREATED BY : RAJASEKHAR REDDY"
echo "-----------------------------------------------------------"

number=1
num=1

count=$(cat /home/ubuntu/javahost | wc -l)

while [ $number -le $count ]
do
date
ip=$(head -n $number /home/ubuntu/javahost | tail -n 1 | awk 'NR==1{printf $1}')

ipaddress=$(head -n $number /home/ubuntu/javahost | tail -n 1 | awk 'NR==1{printf $2}')

ip1=`head -n 2 /home/ubuntu/javahost | tail -n 1 | awk 'NR==1{printf $1}' | tr '.' '\n' | awk 'NR==1{printf $1}'`
ip2=`head -n 2 /home/ubuntu/javahost | tail -n 1 | awk 'NR==1{printf $1}' | tr '.' '\n' | awk 'NR==2{printf $1}'`
ip3=`head -n 2 /home/ubuntu/javahost | tail -n 1 | awk 'NR==1{printf $1}' | tr '.' '\n' | awk 'NR==3{printf $1}'`
ip4=`head -n 2 /home/ubuntu/javahost | tail -n 1 | awk 'NR==1{printf $1}' | tr '.' '\n' | awk 'NR==4{printf $1}'`

 host=$ip
 
 ipa=$ipaddress

 echo "$ip"

ping -c 3 $ip > /dev/null 2>&1
#ping -c 3 52.172.192.60 > /dev/null 2>&1
 
if [ $? -eq 0 ]
then
 
 echo ok

sed -i 's/'demo/$ip'/g' /home/ubuntu/ETA_Requestss.json

sed -i 's/'one/$ip1'/g' /home/ubuntu/ETA_Requestss.json
sed -i 's/'two/$ip2'/g' /home/ubuntu/ETA_Requestss.json
sed -i 's/'three/$ip3'/g' /home/ubuntu/ETA_Requestss.json
sed -i 's/'four/$ip4'/g' /home/ubuntu/ETA_Requestss.json

#js=`newman run /home/rajasekharreddy/Downloads/json/ETA_Requestss.json | awk 'NR==7{printf $5}'`

 two=`newman run ETA_Requestss.json | grep "POST"`
 one=`newman run ETA_Requestss.json | awk 'NR==7{printf $5}'| cut -d'=' -f2`
 echo "$one"
  echo "$two"
 if [ $one -eq 200 ]
 then

 #echo "RAM SPACE $ram% used on $host Server as on $(date)" | mail -s " Alert:$host RAM SPACE LOW " $ADMIN $ADMIN1 $ADMIN2 $ADMIN3 $ADMIN4 $ADMIN5
  echo "Working Fine"

sed -i 's/'$ip1/one'/g' /home/ubuntu/ETA_Requestss.json
sed -i 's/'$ip2/two'/g'  /home/ubuntu/ETA_Requestss.json
sed -i 's/'$ip3/three'/g' /home/ubuntu/ETA_Requestss.json
sed -i 's/'$ip4/four'/g' /home/ubuntu/ETA_Requestss.json

#sed -i 's/'52.172.192.60/demo'/g' /home/rajasekharreddy/Downloads/json/ETA_Requestss.json
 else
   
    echo "Not Working"
   echo "$ipa Server is down $(date)" | mail -s " Alert:$ipa server is down " $ADMIN $ADMIN1 $ADMIN2 $ADMIN3 $ADMIN4 $ADMIN5 $ADMIN6 $ADMIN7

#  sed -i 's/'52.172.192.60/demo'/g' /home/rajasekharreddy/Downloads/json/ETA_Requestss.json

  fi


echo "---------------------------------------------------------"
echo "          $ipa TASK COMPLETED AT : $(date)" 
echo "---------------------------------------------------------"

#number=$(expr "$number" + "$num")

#exit

 else
 
   echo “fail”
    echo "$ipa server is not runnig $(date)" | mail -s " Alart: $ipa server is not running " $ADMIN $ADMIN1 $ADMIN2 $ADMIN3 $ADMIN4 $ADMIN5 $ADMIN6 $ADMIN7

echo "---------------------------------------------------------"
echo "          $host SERVER NOT WORKING AT : $(date)" 
echo "---------------------------------------------------------"

fi

number=$(expr "$number" + "$num")

done
