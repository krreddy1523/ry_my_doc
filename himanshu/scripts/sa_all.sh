#For rotating sa_search_results and sa_queries everyday

#!/bin/bash

echo "---------------------------------------------------------"
echo "Started At : $(date)          CREATED BY : HIMASNHU BISHT"
echo "---------------------------------------------------------"

mysql -h rylarge.railyatri.in -u dbmaster -prailyatri_prodb@123 << EOF

use railyatri_production_large_tables;

insert into sa_queries_all (select * from sa_queries where date(for_date) < (CURDATE()));

delete from sa_queries where date(for_date) < (CURDATE());

EOF

echo "---------------------------------------------------------"
echo "               TASK COMPLETED AT : $(date)"
echo "---------------------------------------------------------"
