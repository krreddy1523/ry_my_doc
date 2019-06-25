#!/bin/bash

echo "---------------------------------------------------------"
echo "Started At : $(date)"
echo "---------------------------------------------------------"

mysql -h daxmark.railyatri.in -u dbmaster -prailyatri_prodb@123 << EOF

use railyatri_production;

insert into flush_pnr_numbers_all (select * from flush_pnr_numbers where date(created_at) < (CURDATE()));

delete from flush_pnr_numbers where date(created_at) < (CURDATE());

EOF

echo "---------------------------------------------------------"
echo "               TASK COMPLETED AT : $(date)"
echo "---------------------------------------------------------"
