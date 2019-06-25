#!/bin/bash

echo "---------------------------------------------------------"
echo "Started At : $(date)          CREATED BY : HIMASNHU BISHT"
echo "---------------------------------------------------------"

mysql -h rylarge.railyatri.in -u dbmaster -prailyatri_prodb@123 railyatri_production -A << EOF

INSERT INTO user_vibrations (id, user_id, lat, lng, nearby_station_code, created_at, accuracy, location_access_enabled, gps_enabled, accelerometer, geomagnetic, orientation, on_track, cisr_id, action, journey_id, train_number) (select id, user_id, lat, lng, nearby_station_code, created_at, accuracy, location_access_enabled, gps_enabled, accelerometer, geomagnetic, orientation, on_track, cisr_id, action, journey_id, train_number FROM user_location_logs WHERE accelerometer is not null and on_track = 1 and journey_id is not null and action = 'Send Trip Location' and cisr_id is not null);

EOF

mysql -h daxmark.railyatri.in -udbmaster -prailyatri_prodb@123 -A railyatri_production < /home/ubuntu/himanshu/scripts/location.sql

echo "---------------------------------------------------------"
echo "               TASK COMPLETED AT : $(date)"
echo "---------------------------------------------------------"

