#!/bin/bash
parser=$(cat /home/ubuntu/himanshu/parvalue)
count=0
num=1
for i in {1..100}
do 
output=$(curl -I --speed-time 1 --speed-limit 200000 -m 1 --connect-timeout 1 --limit-rate 200K --no-keepalive 'https://enquiry.indianrail.gov.in/ntes/' | awk 'NR==1{print $2}')
if [ $output == '200' ]; then
count=$(expr "$count" + "$num")
fi 
done
echo "========================================================================="
echo "======================================================================"
echo "Total No of 200OK at $(date) ====>>>>> $count"
echo "======================================================================"
echo "========================================================================="
echo "Parser value $parser"
if [[ count -gt 25 ]] && [[ $parser == '0' ]]; then
curl 'http://adminwisdom.railyatri.in//set-parser.json?parser_type=LIVE&live_status_parser=NTES'
#echo "Parser Set To NTES" >> /home/ubuntu/himanshu/parser.txt
echo '1' > /home/ubuntu/himanshu/parvalue
elif [[ count -lt 20 ]] && [[ $parser == '1' ]]; then
curl 'http://adminwisdom.railyatri.in//set-parser.json?parser_type=LIVE&live_status_parser=NONE'
echo "Parser Set To NONE $(date)" >> /home/ubuntu/himanshu/parser.txt
echo '0' > /home/ubuntu/himanshu/parvalue
fi
