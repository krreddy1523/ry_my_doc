echo "API-SERVER-1"
ssh mobile-api-server-1-ind  'bash -s' << EOF
 cd /u/apps/railyatri_mobile_api_1/current/
 touch tmp/restart.txt
EOF
sleep 120
ssh mobile-api-server-1-ind  'bash -s' << EOF
 sudo passenger-status
EOF
sleep 60

echo "API-SERVER-2"
ssh mobile-api-server-2-ind  'bash -s' << EOF
 cd /u/apps/railyatri_mobile_api_2/current/
 touch tmp/restart.txt
EOF
sleep 120
ssh mobile-api-server-2-ind  'bash -s' << EOF
 sudo passenger-status
EOF
sleep 60

echo "API-SERVER-3"
ssh mobile-api-server-3-ind  'bash -s' << EOF
 cd /u/apps/railyatri_mobile_api_1/current/
 touch tmp/restart.txt
EOF
sleep 120
ssh mobile-api-server-3-ind  'bash -s' << EOF
 sudo passenger-status
EOF
sleep 60

echo "API-SERVER-4"
ssh mobile-api-server-4-ind  'bash -s' << EOF
 cd /u/apps/railyatri_mobile_api_4/current/
 touch tmp/restart.txt
EOF
sleep 120
ssh mobile-api-server-4-ind  'bash -s' << EOF
 sudo passenger-status
EOF
sleep 60

echo "API-SERVER-5"
ssh mobile-api-server-5-ind  'bash -s' << EOF
 cd /u/apps/railyatri_mobile_api_1/current/
 touch tmp/restart.txt
EOF
sleep 120
ssh mobile-api-server-5-ind  'bash -s' << EOF
 sudo passenger-status
EOF
sleep 60

echo "API-SERVER-6"
ssh mobile-api-server-6-ind  'bash -s' << EOF
 cd /u/apps/railyatri_mobile_api_2/current/
 touch tmp/restart.txt
EOF
sleep 120
ssh mobile-api-server-6-ind  'bash -s' << EOF
 sudo passenger-status
EOF

echo "BUS-SERVER-1"
ssh bus-api-server-1-ind  'bash -s' << EOF
 cd /u/apps/railyatri_bus_api_1/current/
 touch tmp/restart.txt
EOF
sleep 120

ssh bus-api-server-1-ind  'bash -s' << EOF
 sudo passenger-status
EOF
sleep 60

echo "BUS-SERVER-2"
ssh bus-api-server-2-ind  'bash -s' << EOF
 cd /u/apps/railyatri_bus_api_2/current/
 touch tmp/restart.txt
EOF
sleep 120
ssh bus-api-server-2-ind  'bash -s' << EOF
 sudo passenger-status
EOF

echo "BUS-SERVER-3"
ssh bus-api-server-3-ind  'bash -s' << EOF
 cd /u/apps/railyatri_bus_api_3/current/
 touch tmp/restart.txt
EOF
sleep 120
ssh bus-api-server-3-ind  'bash -s' << EOF
 sudo passenger-status
EOF
