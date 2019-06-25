#For rotating sa_search_results everyday

#!/bin/bash

echo "---------------------------------------------------------"
echo "Started At : $(date)          CREATED BY : HIMASNHU BISHT"
echo "---------------------------------------------------------"

mysql -h rylarge.railyatri.in -u dbmaster -prailyatri_prodb@123 << EOF

use railyatri_production_large_tables;

insert into sa_search_results_all (select * from sa_search_results where date(for_date) < (CURDATE()));

delete from sa_search_results date(for_date) < (CURDATE());

EOF

echo "---------------------------------------------------------"
echo "               TASK COMPLETED AT : $(date)"
echo "---------------------------------------------------------"
