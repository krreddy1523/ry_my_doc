echo "------------------------------------------"
echo "	   Created By:m45t3r	       		"
echo "------------------------------------------"

echo "---------------------------------------------------------"
echo "    Script Started At $(date)       "
echo "---------------------------------------------------------"
cd /log/tables/
while read LINE; do
/usr/bin/mysqldump -h daxmark.railyatri.in -udbmaster -prailyatri_prodb@123 --no-create-info --skip-add-drop-table --order-by-primary --single-transaction --insert-ignore railyatri_production $LINE | /bin/gzip -c > "$LINE".sql.gz
done < /home/ubuntu/himanshu/scripts/tbl_name1.txt

echo "---------------------------------------------------------"
echo "    Script Ended At $(date)       "
echo "---------------------------------------------------------"
