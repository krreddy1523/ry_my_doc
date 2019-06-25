#!/bin/bash

echo "---------------------------------------------------------"
echo "Started At : $(date)          CREATED BY : HIMASNHU BISHT"
echo "---------------------------------------------------------"

mysql -h rylarge.railyatri.in -u dbmaster -prailyatri_prodb@123 << EOF

use railyatri_production_large_tables;

insert into all_notification_tracks_all (select * from all_notification_tracks where id > '306301642' and date(created_at) < (CURDATE() - INTERVAL 11 DAY));

delete from all_notification_tracks where date(created_at) < (CURDATE() - INTERVAL 11 DAY);

EOF

echo "---------------------------------------------------------"
echo "               TASK COMPLETED AT : $(date)"
echo "---------------------------------------------------------"

