#!/bin/bash

count=0
num=1
for i in {1..50}
do 
output=$(curl -I --speed-time 1 --speed-limit 100000 -m 1 --connect-timeout 1 --limit-rate 25 'http://www.indianrail.gov.in/enquiry/SEAT/SeatAvailability.html?locale=en' | awk 'NR==1{print $2}')
if [ $output == '200' ]; then
count=$(expr "$count" + "$num")
fi 
done
echo "===================================================================================="
echo "  ==============================================================================="
echo "    ==========================================================================="
echo "       ====================================================================="
echo "         Total No of 200OK at $(date) ====>>>>> $count"
echo "       ====================================================================="
echo "    ==========================================================================="
echo "  ==============================================================================="
echo "===================================================================================="
if [ $count -gt 40 ]; then
curl 'http://adminwisdom.railyatri.in//set-parser.json?parser_type=SEAT&seat_parser=IR'
elif
output1=$(torify curl -I --speed-time 5 --speed-limit 100000 -m 5 --limit-rate 25 'http://www.indianrail.gov.in/enquiry/SEAT/SeatAvailability.html?locale=en' | awk 'NR==1{print $2}') | [ $output1 == '200' ]; then
curl 'http://adminwisdom.railyatri.in//set-parser.json?parser_type=SEAT&seat_parser=PROXY'
else
curl 'http://adminwisdom.railyatri.in//set-parser.json?parser_type=SEAT&seat_parser=NONE'
fi
