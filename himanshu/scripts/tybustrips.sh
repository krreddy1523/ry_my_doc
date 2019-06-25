#!/bin/bash

echo "---------------------------------------------------------"
echo "Started At : $(date)"
echo "---------------------------------------------------------"

mysql -h daxmark.railyatri.in -u dbmaster -prailyatri_prodb@123 << EOF

use railyatri_production;

insert into ty_bus_trips_all (select * from ty_bus_trips where date(created_at) < (CURDATE() - INTERVAL 2 DAY));

delete from ty_bus_trips where date(created_at) < (CURDATE() - INTERVAL 2 DAY);

EOF

echo "---------------------------------------------------------"
echo "               TASK COMPLETED AT : $(date)"
echo "---------------------------------------------------------"
