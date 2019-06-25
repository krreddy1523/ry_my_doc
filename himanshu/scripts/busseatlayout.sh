#!/bin/bash

echo "---------------------------------------------------------"
echo "Started At : $(date)"
echo "---------------------------------------------------------"

mysql -h daxmark.railyatri.in -u dbmaster -prailyatri_prodb@123 << EOF

use railyatri_production;

insert into bus_seat_layouts_all (select * from bus_seat_layouts where date(created_at) < (CURDATE() - INTERVAL 3 DAY));

delete from bus_seat_layouts where date(created_at) < (CURDATE() - INTERVAL 3 DAY);

EOF

echo "---------------------------------------------------------"
echo "               TASK COMPLETED AT : $(date)"
echo "---------------------------------------------------------"
