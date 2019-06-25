#!/bin/sh
ADMIN="himanshu.bisht@railyatri.in"
# set alert level 90% is default
ALERT=9
df -Th | grep -vE '^Filesystem|tmpfs|cdrom' | awk '{ print $6 " " $1 }' | while read output;
do
  #echo $output
  usep=$(echo $output | awk '{ print $1}' | cut -d'%' -f1  )
  partition=$(echo $output | awk '{ print $2 }' )
  if [ $usep -ge $ALERT ]; then
    echo "Running out of space \"$partition ($usep%)\" on $(hostname) as on $(date)" |
     mail -s "Alert: Almost out of disk space $usep" $ADMIN
  fi
done

#sh disk.sh > disk.log
