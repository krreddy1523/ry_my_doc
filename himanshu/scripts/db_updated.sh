echo "------------------------------------------"
echo "     Created By:m45t3r                    "
echo "------------------------------------------"

echo "---------------------------------------------------------"
echo "    Script Started At $(date)       "
echo "---------------------------------------------------------"

while read LINE; do
echo "$LINE"
MYSQL_PWD=railyatri_prodb@123 mysql -h daxmarktest.cualuo6jrltb.ap-south-1.rds.amazonaws.com -udbmaster railyatri_production -e "select date(updated_at) from $LINE order by date(updated_at) desc limit 1;"
done < /opt/table_names.txt

echo "---------------------------------------------------------"
echo "    Script Ended At $(date)       "
echo "---------------------------------------------------------"

