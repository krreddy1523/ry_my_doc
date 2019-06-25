#!/bin/bash

echo "---------------------------------------------------------"
echo "Started At : $(date)"
echo "---------------------------------------------------------"

mysql -h daxmark.railyatri.in -u dbmaster -prailyatri_prodb@123 << EOF

use railyatri_production;

insert into live_train_updates_all (select * from live_train_updates where date(created_at) < (CURDATE() - INTERVAL 3 DAY));

delete from live_train_updates where date(created_at) < (CURDATE() - INTERVAL 3 DAY);

EOF

echo "---------------------------------------------------------"
echo "               TASK COMPLETED AT : $(date)"
echo "---------------------------------------------------------"
