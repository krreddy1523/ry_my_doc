#!/bin/bash

echo "---------------------------------------------------------"
echo "Started At : $(date)          CREATED BY : HIMASNHU BISHT"
echo "---------------------------------------------------------"

mysql -h daxmark.railyatri.in -u dbmaster -prailyatri_prodb@123 << EOF

use railyatri_production;

insert into gps_ntes_train_infos_all(select * from gps_ntes_train_infos where predicate_date=subdate(current_date, 1));

delete from gps_ntes_train_infos where predicate_date=subdate(current_date, 1);

EOF

echo "---------------------------------------------------------"
echo "               TASK COMPLETED AT : $(date)"
echo "---------------------------------------------------------"

