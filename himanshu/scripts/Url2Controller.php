<?php

//header("Access-Control-Allow-Origin: https://www.yatrachef.com");
class Url2Controller extends Controller {

    public function actionIndex() {
        echo 'BLOCKED';
        die;
//        $guid = help::SMSAPI(3, '9633500719', 'test');
//        print_r($guid);
        $guid = Help::SMSAPI(3, '9633500719', 'SUCCESS');
        print_r($guid);
        die;

        $app_link_url = Help::bitly('http://m.rytr.in/Food-Order/' . rand(1, 5000));
        print_r($app_link_url);
        die;
        echo 'Ok2';
        die;
    }

    public function actionRestart() {
        echo 'ok';
        $x = exec('/usr/sbin/apache2  restart');
        print_r($x);
    }

    public function actionReportManagement() { //at 11o'clock 
        $today = date('Y-m-d');
        $timestamp = strtotime($today);
        if (date('D', $timestamp) === 'Mon') { //weekly report
//            $x1 = file_get_contents("https://cc.yatrachef.com/index.php/url2/ReportToApi/catg/2"); //regular
//            print_r($x1);
//            $x2 = file_get_contents("https://cc.yatrachef.com/index.php/url2/ReportToApi/catg/1"); //premium
//            print_r($x2);
//            $x3 = file_get_contents("https://cc.yatrachef.com/index.php/url2/ReportToApi/catg/5"); //finance
//            print_r($x3);
//
//            $x10 = file_get_contents("https://cc.yatrachef.com/index.php/url2/AgentConversion"); //agent order conversion
//            print_r($x10);
//            $this->review_weekly();
//
//            $x125 = file_get_contents("https://cc.yatrachef.com/index.php/report/WeeklyComplaints/");  
//            print_r($x125);
            $x1 = file_get_contents("https://cc.yatrachef.com/index.php/url2/ReportToApi/catg/12"); //WeeklyComplaints to account manager

            $this->failure_report_weekly();
        }
//        -----------------Weekly end-----------------------------------
        $monday = date('Y-m-d', strtotime('First Monday of ' . date('F o', strtotime($today))));
        if (date('d') == '01') { //monthly report
//regular
//            $x4 = file_get_contents("https://cc.yatrachef.com/index.php/url2/ReportToApi/catg/4");
//echo 'monthly premium partner delivery report';
//            $x5 = file_get_contents("https://cc.yatrachef.com/index.php/url2/ReportToApi/catg/3");
//            print_r($x4);
//            print_r($x5);
        }
        if (date('d') == '02') {

            $this->failure_report_monthly();
        }
        if (date('d') == '03') {
            $x6 = file_get_contents("https://cc.yatrachef.com/index.php/url2/ReportToApi/catg/6"); //finance
            print_r($x6);
        }
//        -----------------Monthly end------------------------------------




        $x7 = file_get_contents("https://cc.yatrachef.com/index.php/url2/ReportToApi/catg/0"); //daily order report
        print_r($x7);

//        $x8 = file_get_contents("https://cc.yatrachef.com/index.php/url2/IncomingCallReport"); //incoming calls
//        print_r($x8);
//
//
//        $x9 = file_get_contents("https://cc.yatrachef.com/index.php/url2/DetailedIncomingCallReport"); //incoming calls
//        print_r($x9);

        $x9 = file_get_contents("https://cc.yatrachef.com/index.php/url2/ReportToApi/catg/9"); //Review Mail
        print_r($x9);

        $x10 = file_get_contents("https://cc.yatrachef.com/index.php/url2/ReportToApi/catg/11"); //canceled reson report Mail
        print_r($x10);

        file_get_contents("https://cc.yatrachef.com/index.php/url2/Nicotex");

        file_get_contents("https://cc.yatrachef.com/index.php/url2/NicotexFeedback");

        $this->actionpepsiorders();
        $this->actionaquafinaorders();
        $this->actiontrain_combo();


//        -----------------Daily end------------------------------------
    }

    public function actionDailyReport() { //at 5pm
        $x7 = file_get_contents("https://cc.yatrachef.com/index.php/url2/ReportToApi/catg/7"); //acquisition
        print_r($x7);
        $x10 = file_get_contents("https://cc.yatrachef.com/index.php/url2/ReportToApi/catg/10"); //Channel report Mail
        print_r($x10);
        $x = $this->actiondaily_used_coupons();


//        print_r($x);
    }

    public function actionIncomingCallReport() {
        $res = ReportController::actionIncomingCallReport();
        print_r($res);
    }

    public function actionDetailedIncomingCallReport() {
        $res = ReportController::actionDetailedIncomingCallReport();
        print_r($res);
    }

    public function actionAgentConversion() {
        $res = ReportController::actionAgentConversion();
        print_r($res);
    }

    public function actionWeeklyOnce_Cron_report_() {
        $today = date('Y-m-d');
        $timestamp = strtotime($today);
        if (date('D', $timestamp) === 'Mon') { //weekly report
            $x1 = file_get_contents("https://cc.yatrachef.com/index.php/url2/ReportToApi/catg/2"); //regular
            print_r($x1);
            $x2 = file_get_contents("https://cc.yatrachef.com/index.php/url2/ReportToApi/catg/1"); //premium
            print_r($x2);
            $x3 = file_get_contents("https://cc.yatrachef.com/index.php/url2/ReportToApi/catg/5"); //finance
            print_r($x3);
        }
        echo '<br>Working';
    }

    public function actionMonthlyOnce_Cron_report_() {
        $monday = date('Y-m-d', strtotime('First Monday of ' . date('F o', strtotime($today))));
        if (date('d') == '01') { //monthly report
//regular
            $x1 = file_get_contents("https://cc.yatrachef.com/index.php/url2/ReportToApi/catg/4");
//echo 'monthly premium partner delivery report';
            $x2 = file_get_contents("https://cc.yatrachef.com/index.php/url2/ReportToApi/catg/3");

            $x3 = file_get_contents("https://cc.yatrachef.com/index.php/url2/ReportToApi/catg/6"); //finance
            print_r($x1);
            print_r($x2);
            print_r($x3);
        }
        echo '<br>Working';
    }

    public function actionReportToApi($catg = 100) {
        if ($catg == 0) { // daily
            $res = ReportController::actionFoodOrderReport($date = '', $type = 0, $rt = 0, $mail = 1);
        } else if ($catg == 1) {//weekly prm
            $res = ReportController::actionFoodOrderReport($date = '', $type = 1, $rt = 0, $mail = 1);
        } else if ($catg == 2) {//weekly reg
            $res = ReportController::actionFoodOrderReport($date = '', $type = 1, $rt = 1, $mail = 1);
        } else if ($catg == 3) {//monthly reg
            $res = ReportController::actionFoodOrderReport($date = '', $type = 2, $rt = 0, $mail = 1);
        } else if ($catg == 4) {//monthly reg
            $res = ReportController::actionFoodOrderReport($date = '', $type = 2, $rt = 1, $mail = 1);
        } else if ($catg == 5) {//weekly finance
            $res = ReportController::actionFoodOrderReport($date = '', $type = 3, $rt = 1, $mail = 1);
        } else if ($catg == 6) {//monthly finance
            $res = ReportController::actionFoodOrderReport($date = '', $type = 4, $rt = 1, $mail = 1);
        } else if ($catg == 7) {//daily acusition
            $res = ReportController::actionRYfood($mydate = '', $mail = 1);
        } else if ($catg == 8) {//monthly finance
            $res = ReportController::actionRYfood($mydate = '', $mail = 0);
        } else if ($catg == 9) {//monthly finance
            $res = ReportController::actionreview_report();
        } else if ($catg == 10) {//channel report
            $res = ReportController::actionChanelPerDay();
        } else if ($catg == 11) {//failed reason report
            $res = ReportController::actionfailed_reason();
        } else if ($catg == 12) {//WeeklyComplaints report
            $res = ReportController::actionWeeklyComplaints();
        }
        print_r($res);
    }

//    public function actionRYfood($mydate = '', $mail = 0) { //echo 'sdfsdf';die;
//        $res = ReportController::actionRYfood($mydate = '', $mail);
//        print_r($res);
//    }

    public function actionCalcFoodTime() {

        $this->refund_processing();

//        $x=file_get_contents('https://cc.yatrachef.com/index.php/My_db_functions/ry_wisdon_backup');
//        print_r($x);
//        die;
        $sql = "SELECT o.res_id,o.id,o.real_day_time,o.expected_arrival,r.break_start,r.break_end,r.lunch_start,r.lunch_end,r.dinner_start,r.dinner_end
FROM tbl_order_table o
INNER JOIN tbl_restaurant r ON o.res_id=r.id
WHERE food_time IS NULL
ORDER BY `o`.`id`  ASC "; //LIMIT 0,100
        $list = help::readAll($sql);
//        echo '<pre>';
//        print_r($list);die;
        $break = $lunch = $dinner = 0;
        $food_time = 0;

        foreach ($list as $rw) {
            $STA = date('H:i', strtotime($rw['real_day_time']));
//            $STA = date('H:i', strtotime($rw['expected_arrival']));
//            if ((($rw['break_start'] != 0) && ($rw['break_end'] != 0)) || ($rw['dinner_start'] != 0) && ($rw['dinner_end'] != 0) || (($rw['lunch_start'] != 0) && ($rw['lunch_end'] != 0))) {

            if (($STA >= $rw['break_start']) && ($STA <= $rw['break_end'])) {
                $food_time = 1;
                $time_int = $rw['break_start'] . '--' . $rw['break_end'];
            } else if (($STA >= $rw['lunch_start']) && ($STA <= $rw['lunch_end'])) {
                $food_time = 2;
                $time_int = $rw['lunch_start'] . '--' . $rw['lunch_end'];
            } else if (($STA >= $rw['dinner_start']) && ($STA <= $rw['dinner_end'])) {
                $food_time = 3;
                $time_int = $rw['dinner_start'] . '--' . $rw['dinner_end'];
            } else {
                if (($STA >= '06:00') && ($STA <= '11:00')) {
                    $food_time = 1;
                    $time_int = '06:00' . '--' . '11:00';
                } else if (($STA >= '11:00') && ($STA <= '17:00')) {
                    $food_time = 2;
                    $time_int = '11:00' . '--' . '17:00';
                } else if (($STA >= '17:00') && ($STA <= '23:59')) {
                    $food_time = 3;
                    $time_int = '17:00' . '--' . '23:59';
                } else {
                    $food_time = 3;
//                    $time_int='';
                }
            }
//            if ($STA != '00:00') {
            echo $rw['id'] . '==' . $rw['res_id'] . '==>' . $STA . '---' . $food_time . '---' . $time_int . '<br>';
//            }
            $sql = "UPDATE `tbl_order_table` SET `food_time`='$food_time' WHERE `id`='$rw[id]' AND res_id='$rw[res_id]'";
            if (help::execute($sql)) {
                echo 'S<br>';
            } else {
                echo 'F<br>';
            }
//            }
        }
        $x = file_get_contents('https://cc.yatrachef.com/index.php/url2/ProblemOrders');




//        help::Mail($subject = 'CRON REPORT-Update Food timing & alert queue cron,refund details', $content = 'update food timing in order table -' . count($list), $to = 'akhil.tm@yatrachef.com', $type = 1);
    }

    public function actionall_review($rest_id = 0) {
//        $sql="SELECT `Order_id`,`Date_time`,`Review`,`Rating` FROM `tbl_user_reviews` WHERE
//        `Rel_Id`='$rest_id' and Rating<>'' and Review<>'' ORDER BY  Rating desc";

        $sql = "SELECT DATE(r1.Date_time) as Date_time,r1.Rel_Id as rest_id,r1.Order_id,r1.Review,r1.Rating,r2.rest_name,o.order_method,o.order_type
            FROM tbl_user_reviews r1
            INNER JOIN tbl_restaurant r2
            ON r1.Rel_Id = r2.id
            INNER JOIN tbl_order_table o
            ON o.id=r1.Order_id
            WHERE   r1.Rating<>'' and r1.Review<>'' and  r1.Rel_Id='$rest_id'  ORDER BY  r1.Date_time desc  ";
//           r2.ry_is_preferred_vendor=1

        $data = help::readAll($sql);
//        echo '<pre>';
//        print_r($data);
//        die;
        $this->layout = 'sss';
        $this->render('rest_all_reviews', array('data' => $data));
    }

    public function actionClearScoreDate($oid = 0, $clear = 0) {

        $sql = "SELECT o.cust_uid,o.online,o.cust_id,o.wallet_amount,c.score_updated_at from tbl_order_table o
        INNER JOIN tbl_customer c
        ON o.cust_uid=c.id
        WHERE o.id='$oid'";

        $r = help::read($sql);

        $cust_id = $r['cust_id'];
        $wallet_refund = $r['wallet_amount'];
        $online = $r['online'];

        if ($r['score_updated_at'] != '') {
            $cust_uid = $r['cust_uid'];
            $sql2 = "UPDATE `tbl_customer` SET `score_updated_at`=NULL where `id`='$cust_uid'";
            if (help::execute($sql2)) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            echo '1';
        }


        if (($clear == 0 || $clear == 2) && ($online > 0 || $wallet_refund > 0)) {

            $sql6 = "SELECT `transaction_status`,amount FROM `tbl_payment` WHERE `cust_id`='$cust_id' ORDER BY t_time DESC LIMIT 1";
            $result2 = help::read($sql6);
            $trans_status = $result2['transaction_status'];
            $paid_amount = $result2['amount'] / 100;
            if (($trans_status == 'SUCCESS') || ($wallet_refund > 0)) {



                if ($trans_status != 'SUCCESS') {
                    $online = 0;
                }

                $sql3 = "SELECT `id` FROM `tbl_refund` WHERE order_id=$oid";
                $r = help::getScalar($sql3);
                if ($r == '') {
                    $entry = 0;
                } else {
                    $entry = 1;
                }
                $ctime = date('Y-m-d H:i:s');
                if ($clear == 0) {
                    $tag = "Customer Canceled the order from RY App.Refund request raised.pg_refund:$online , wallet_refund:$wallet_refund. ";
                    $source = 0;
                } else if ($clear == 2) {
                    $tag = "Customer Canceled the order from IVR Response";
                    $source = 4;
                }


                if ($entry == 0) {
                    $sql2 = "INSERT INTO `tbl_refund`( `order_id`, `pg_refund`, `pending_pg_refund`, `wallet_refund`, `pending_wallet_refund`,
                `sc_refund`, `pending_sc_refund`, `refund_mode`, `refund_status`, `refund_time`,refund_req_source)
                values('$oid','$online','$online','$wallet_refund','$wallet_refund','0','0','1','1','$ctime','$source')";
                } else if ($entry == 1) {
                    $sql2 = "UPDATE `tbl_refund` SET `pg_refund`=$online,`pending_pg_refund`=$online,
                `wallet_refund`='$wallet_refund',`pending_wallet_refund`='$wallet_refund',`sc_refund`='0',`pending_sc_refund`='0',
                `refund_mode`='1',`refund_status`='1',`refund_time`='$ctime',refund_req_source='$source' WHERE order_id='$oid'";
                }

                $refund_sum = $online + $wallet_refund;
                $sql4 = "INSERT INTO `tbl_refund_log`( `order_id`, `refund_amount`, `event_time`, `agent_id`, `message`)
            VALUES ('$oid',$refund_sum,'$ctime','','$tag')";



                help::execute($sql4);
                help::execute($sql2);

                $url = 'http://api.railyatri.in/api/insert-refund-history.json?order_id=' . $oid . '&event_name=ticket_cancelled&ecomm_type=0';
                $output = help::api_get($url, $time_out = 8000, $json = 1);
                if ($output->success == 1) {
                    
                }
            }
        }
    }

    public function actionryClearScoreDate($oid = 0, $clear = 0) {

        $sql = "SELECT o.cust_uid,o.online,o.cust_id,o.wallet_amount,c.score_updated_at from tbl_order_table o
        INNER JOIN tbl_customer c
        ON o.cust_uid=c.id
        WHERE o.id='$oid'";

        $r = help::read($sql);

        $cust_id = $r['cust_id'];
        $wallet_refund = $r['wallet_amount'];
        $online = $r['online'];

        if ($r['score_updated_at'] != '') {
            $cust_uid = $r['cust_uid'];
            $sql2 = "UPDATE `tbl_customer` SET `score_updated_at`=NULL where `id`='$cust_uid'";
            if (help::execute($sql2)) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            echo '1';
        }


        if (($clear == 0 || $clear == 2) && ($online > 0 || $wallet_refund > 0)) {

            $sql6 = "SELECT `transaction_status`,amount FROM `tbl_payment` WHERE `cust_id`='$cust_id' ORDER BY t_time DESC LIMIT 1";
            $result2 = help::read($sql6);
            $trans_status = $result2['transaction_status'];
            $paid_amount = $result2['amount'] / 100;
            if (($trans_status == 'SUCCESS') || ($wallet_refund > 0)) {



                if ($trans_status != 'SUCCESS') {
                    $online = 0;
                }

                $sql3 = "SELECT `id` FROM `tbl_refund` WHERE order_id=$oid";
                $r = help::getScalar($sql3);
                if ($r == '') {
                    $entry = 0;
                } else {
                    $entry = 1;
                }
                $ctime = date('Y-m-d H:i:s');
                if ($clear == 0) {
                    $tag = "Customer Canceled the order from RY App.Refund request raised.pg_refund:$online , wallet_refund:$wallet_refund.(new)";
                    OrderController::createtag($msg = $tag, $id = $oid, $type = 'Order Cancellation', $cat = 36);
                    $source = 0;
                } else if ($clear == 2) {
                    $tag = "Customer Canceled the order from IVR Response";
                    $source = 4;
                }


                if ($entry == 0) {
                    $sql2 = "INSERT INTO `tbl_refund`( `order_id`, `pg_refund`, `pending_pg_refund`, `wallet_refund`, `pending_wallet_refund`,
                `sc_refund`, `pending_sc_refund`, `refund_mode`, `refund_status`, `refund_time`,refund_req_source)
                values('$oid','$online','$online','$wallet_refund','$wallet_refund','0','0','1','1','$ctime','$source')";
                } else if ($entry == 1) {
                    $sql2 = "UPDATE `tbl_refund` SET `pg_refund`=$online,`pending_pg_refund`=$online,
                `wallet_refund`='$wallet_refund',`pending_wallet_refund`='$wallet_refund',`sc_refund`='0',`pending_sc_refund`='0',
                `refund_mode`='1',`refund_status`='1',`refund_time`='$ctime',refund_req_source='$source' WHERE order_id='$oid'";
                }

                $refund_sum = $online + $wallet_refund;
                $sql4 = "INSERT INTO `tbl_refund_log`( `order_id`, `refund_amount`, `event_time`, `agent_id`, `message`)
            VALUES ('$oid',$refund_sum,'$ctime','','$tag')";



                help::execute($sql4);
                help::execute($sql2);

                $url = 'http://api.railyatri.in/api/insert-refund-history.json?order_id=' . $oid . '&event_name=ticket_cancelled&ecomm_type=0';
                $output = help::api_get($url, $time_out = 8000, $json = 1);
                if ($output->success == 1) {
                    
                }
            }
        }
    }

    public function actionClearScoreDate_22_12_2016($oid = 0) {
        $sql = "SELECT o.cust_uid,c.score_updated_at from tbl_order_table o
        INNER JOIN tbl_customer c
        ON o.cust_uid=c.id
        WHERE o.id='$oid'";
        $r = help::read($sql);

        if ($r['score_updated_at'] != '') {
            $cust_uid = $r['cust_uid'];

            $sql2 = "UPDATE `tbl_customer` SET `score_updated_at`=NULL where `id`='$cust_uid'";
            if (help::execute($sql2)) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            echo '1';
        }
    }

    public function actionUserScore_old_working() {
        $today = date('Y-m-d');
        $sql = "SELECT o.id,o.cust_uid,j.email,j.phone_no,j.phone_no2
              FROM tbl_order_table o
              INNER JOIN tbl_journey j
              ON o.cust_id=j.cust_id
              INNER JOIN tbl_customer c
              ON o.cust_uid=c.id
              WHERE  DATE(o.real_day_time)='$today'
              AND o.order_status=1 and c.score_updated_at is NULL";

        $r = help::readAll($sql);

        foreach ($r as $row) {
            $phone_no = $row['phone_no'];
            $phone_no = substr($phone_no, -10);
            $phone_no2 = $row['phone_no2'];
            $len = strlen($phone_no2);
            if ($len >= 10) {
                $phone_no2 = substr($phone_no2, -10);
            } else {
                $phone_no2 = 'NO PHONE2';
            }
            $email = $row['email'];
            $oid = $row['id'];
            $cust_uid = $row['cust_uid'];


            $sql2 = " SELECT
                        SUM( CASE WHEN o.order_status='5' THEN 1 ELSE 0 END )  `completed`,
                        SUM( CASE WHEN o.order_status='4' THEN 1 ELSE 0 END )  `fake`,
                        SUM( CASE WHEN o.order_status='2' THEN 1 ELSE 0 END )  `canceled`,
                        SUM( CASE WHEN o.order_status='8' THEN 1 ELSE 0 END )  `canceled_cust`,
                        SUM( CASE WHEN o.order_status='10' THEN 1 ELSE 0 END ) `failed_cust`,
                        SUM( CASE WHEN o.order_status='3' THEN 1 ELSE 0 END ) `failed`,
                        SUM( CASE WHEN o.order_status='7' THEN 1 ELSE 0 END ) `canceled_rest`,
                        SUM( CASE WHEN o.order_status='9' THEN 1 ELSE 0 END ) `failed_rest`,

                        SUM( CASE WHEN o.Complaint='1' THEN 1 ELSE 0 END ) `complaint`,
                        SUM( CASE WHEN o.payment_type='cod' THEN 1 ELSE 0 END ) `cod`,
                        SUM( CASE WHEN o.payment_type='Online_Payment' THEN 1 ELSE 0 END ) `online`,

                        SUM( CASE WHEN o.failed_reason='201' THEN 1 ELSE 0 END )  `train_late`,
                        SUM( CASE WHEN o.failed_reason='202' THEN 1 ELSE 0 END )  `journey_cancel`,
                        SUM( CASE WHEN o.failed_reason='203' THEN 1 ELSE 0 END )  `waitlist`,
                        SUM( CASE WHEN o.failed_reason='204' THEN 1 ELSE 0 END )  `cust_not_responding`,
                        SUM( CASE WHEN o.failed_reason='205' THEN 1 ELSE 0 END )  `wrongly_ordered`,
                        SUM( CASE WHEN o.failed_reason='206' THEN 1 ELSE 0 END )  `incorrect_contact`,
                        SUM( CASE WHEN o.failed_reason='207' THEN 1 ELSE 0 END )  `train_late`,

                        SUM( CASE WHEN o.order_status <> '10000' THEN 1 ELSE 0 END )  `order_count`

                        FROM tbl_order_table o
                        INNER JOIN tbl_journey j
                        ON o.cust_id=j.cust_id
                        WHERE (j.phone_no like '%$phone_no%' or j.phone_no like '%$phone_no2%' or j.email='$email')
                         AND j.test_order=0 AND o.order_status <> 1 AND o.order_status <> 11 AND o.order_status <> 12";

            $r2 = help::read($sql2);
            $r3[1] = $r2;

            foreach ($r3 as $value) {
//                        echo $cust_uid;
//                        echo '~~~~~';
                echo $score = (($value['completed'] * 90) + ($value['fake'] * -90) + ($value['canceled'] * 80) + ($value['canceled_cust'] * 70) + ($value['failed_cust'] * -70) + ($value['canceled_rest'] * 90) + ($value['failed_rest'] * 90) + ($value['complaint'] * -3) + ($value['online'] * 10) + ($value['train_late'] * 20) + ($value['journey_cancel'] * -10) + ($value['waitlist'] * -5) + ($value['cust_not_responding'] * -50) + ($value['wrongly_ordered'] * -20) + ($value['incorrect_contact'] * -100)) / ($value['order_count']);
                echo '~~';
                echo $oid;
//                        echo '~~';
//                        echo $email;
//                        echo '~~';
//                        echo $phone_no;
//                        echo '~~';
//                        echo $phone_no2;
//                        echo '~~';
//                        echo $value['order_count'];
//                        echo '~~';
//                        echo $value['completed'] ;
//                        echo '~~';
                if (($value['order_count'] > 1) && (($value['order_count'] / 2) < ($value['completed'])) && ($value['order_count'] > $value['completed'])) {
                    echo '---------------------------------';
                    $bonus_score = ($value['completed'] * 5) / $value['order_count'];
                    $score = $score + $bonus_score;
                }
                echo $score;

                if ($score != '') {
                    if ((int) $score == $score) {
                        
                    } else {
                        $score = number_format($score, 1);
                    }

                    date_default_timezone_set('Asia/Calcutta');
                    $current_time = date("Y-m-d h:i:s");
                    $sql3 = "UPDATE `tbl_customer` SET `credibility_score`='$score',`score_updated_at`='$current_time' where `id`='$cust_uid'";
                    help::execute($sql3);
                }

//                        date_default_timezone_set('Asia/Calcutta');
//                        $current_time= date("Y-m-d h:i:s");
//                        $sql3="UPDATE `tbl_customer` SET `credibility_score`='$score',`score_updated_at`='$current_time' where `id`='$cust_uid'";
//                        help::execute($sql3);

                echo '<br>';
            }
        }

//                    $cc[0] = 'anoob.cr@yatrachef.com';
//                    $to = 'anoob2196@gmail.com';
//                    $subject='User score cron';
//                    $content="User Score Crone executed";
//
//                  $x = help::Mail_Bulk($subject, $content, $to, $from = 'no-reply@yatrachef.com', $title = '', $cc, $text = 0);
    }

    public function actionUserScore() {
        $today = date('Y-m-d');
        $sql = "SELECT o.id,o.cust_uid,j.email,j.phone_no,j.phone_no2
              FROM tbl_order_table o
              INNER JOIN tbl_journey j
              ON o.cust_id=j.cust_id
              INNER JOIN tbl_customer c
              ON o.cust_uid=c.id
              WHERE  DATE(o.real_day_time)='$today'
              AND o.order_status=1 and c.score_updated_at is NULL";

        $r = help::readAll($sql);
        $i = 0;
        $j = 0;

        foreach ($r as $row) {
            $phone_no = $row['phone_no'];
            $phone_no = substr($phone_no, -10);
            $phone_no2 = $row['phone_no2'];
            $len = strlen($phone_no2);
            if ($len >= 10) {
                $phone_no2 = substr($phone_no2, -10);
            } else {
                $phone_no2 = 'NO PHONE2';
            }
            $email = $row['email'];
            $oid = $row['id'];
            $cust_uid = $row['cust_uid'];


            $sql2 = " SELECT
                        SUM( CASE WHEN o.order_status='5' THEN 1 ELSE 0 END )  `completed`,
                        SUM( CASE WHEN o.order_status='4' THEN 1 ELSE 0 END )  `fake`,
                        SUM( CASE WHEN o.order_status='2' THEN 1 ELSE 0 END )  `canceled`,
                        SUM( CASE WHEN o.order_status='8' THEN 1 ELSE 0 END )  `canceled_cust`,
                        SUM( CASE WHEN o.order_status='10' THEN 1 ELSE 0 END ) `failed_cust`,
                        SUM( CASE WHEN o.order_status='3' THEN 1 ELSE 0 END ) `failed`,
                        SUM( CASE WHEN o.order_status='7' THEN 1 ELSE 0 END ) `canceled_rest`,
                        SUM( CASE WHEN o.order_status='9' THEN 1 ELSE 0 END ) `failed_rest`,

                        SUM( CASE WHEN o.Complaint='1' THEN 1 ELSE 0 END ) `complaint`,
                        SUM( CASE WHEN o.payment_type='cod' THEN 1 ELSE 0 END ) `cod`,
                        SUM( CASE WHEN o.payment_type='Online_Payment' THEN 1 ELSE 0 END ) `online`,

                        SUM( CASE WHEN o.failed_reason='201' THEN 1 ELSE 0 END )  `train_late`,
                        SUM( CASE WHEN o.failed_reason='202' THEN 1 ELSE 0 END )  `journey_cancel`,
                        SUM( CASE WHEN o.failed_reason='203' THEN 1 ELSE 0 END )  `waitlist`,
                        SUM( CASE WHEN o.failed_reason='204' THEN 1 ELSE 0 END )  `cust_not_responding`,
                        SUM( CASE WHEN o.failed_reason='205' THEN 1 ELSE 0 END )  `wrongly_ordered`,
                        SUM( CASE WHEN o.failed_reason='206' THEN 1 ELSE 0 END )  `incorrect_contact`,
                        SUM( CASE WHEN o.failed_reason='207' THEN 1 ELSE 0 END )  `train_late`,

                        SUM( CASE WHEN o.order_status <> '10000' THEN 1 ELSE 0 END )  `order_count`

                        FROM tbl_order_table o
                        INNER JOIN tbl_journey j
                        ON o.cust_id=j.cust_id
                        WHERE (j.phone_no like '%$phone_no%' or j.phone_no like '%$phone_no2%' or j.email='$email')
                         AND j.test_order=0 AND o.order_status <> 1 AND o.order_status <> 11 AND o.order_status <> 12";

            $r2 = help::read($sql2);
            if ($r2['order_count'] != '') {

                $old_cust[$i] = $r2;
                $old_cust[$i]['phone_no'] = $phone_no;
                $old_cust[$i]['phone_no2'] = $phone_no2;
                $old_cust[$i]['email'] = $email;
                $old_cust[$i]['oid'] = $oid;
                $old_cust[$i]['cust_uid'] = $cust_uid;
                $i++;
            } else {
                $new_cust[$j] = $r2;
                $new_cust[$j]['phone_no'] = $phone_no;
                $new_cust[$j]['phone_no2'] = $phone_no2;
                $new_cust[$j]['email'] = $email;
                $new_cust[$j]['oid'] = $oid;
                $new_cust[$j]['cust_uid'] = $cust_uid;
                $j++;
            }
        }

        foreach ($old_cust as $value) {
            $score = (($value['completed'] * 90) + ($value['fake'] * -90) + ($value['canceled'] * 80) + ($value['canceled_cust'] * 70) + ($value['failed_cust'] * -70) + ($value['canceled_rest'] * 90) + ($value['failed_rest'] * 90) + ($value['complaint'] * -3) + ($value['online'] * 10) + ($value['train_late'] * 20) + ($value['journey_cancel'] * -10) + ($value['waitlist'] * -5) + ($value['cust_not_responding'] * -50) + ($value['wrongly_ordered'] * -20) + ($value['incorrect_contact'] * -100)) / ($value['order_count']);
//                        echo '~~';
//                        echo $value['oid'];
//                        echo '~~';
//                        echo $value['email'];
//                        echo '~~';
//                        echo $value['phone_no'];
//                        echo '~~';
//                        echo $value['phone_no2'];
//                        echo '~~';
//                        echo $value['order_count'];
//                        echo '~~';
//                        echo $value['completed'] ;
//                        echo '***';
//                        echo $value['cod'];
//                        echo '***';
//                        echo $value['order_count'];
//                        echo '***';
            if (($value['order_count'] > 1) && (($value['order_count'] / 2) < ($value['completed'])) && ($value['order_count'] > $value['completed'])) {
//                            echo '---------------------------------';
                $bonus_score = ($value['completed'] * 5) / $value['order_count'];
                $score = $score + $bonus_score;
            }
//                        echo $score;

            if ($score != '') {
                if ((int) $score == $score) {
                    
                } else {
                    $score = number_format($score, 1);
                }
                $cust_uid = $value['cust_uid'];
                date_default_timezone_set('Asia/Calcutta');
                $current_time = date("Y-m-d h:i:s");
                echo $sql3 = "UPDATE `tbl_customer` SET `credibility_score`='$score',`score_updated_at`='$current_time' where `id`='$cust_uid'";
                help::execute($sql3);
            }
            echo '<br>';
        }



        foreach ($new_cust as $value) {

            $email = $value['email'];
            $phone_no = $value['phone_no'];
            $phone_no2 = $value['phone_no2'];



            $sql3 = " SELECT
                        SUM( CASE WHEN o.payment_type='cod' THEN 1 ELSE 0 END ) `cod`,
                        SUM( CASE WHEN o.payment_type='Online_Payment' THEN 1 ELSE 0 END ) `online`,
                        SUM( CASE WHEN o.order_status <> '10000' THEN 1 ELSE 0 END )  `order_count`,
                        SUM( CASE WHEN ((j.pnr != '0') or (j.pnr != 'NA') or (j.pnr != 'null')) THEN 1 ELSE 0 END )  `pnr`
                        FROM tbl_order_table o
                        INNER JOIN tbl_journey j
                        ON o.cust_id=j.cust_id
                        WHERE (j.phone_no like '%$phone_no%' or j.phone_no like '%$phone_no2%' or j.email='$email')
                        AND j.test_order=0 AND o.order_status = 1 ";
            $value2 = help::read($sql3);

            if (strlen($phone_no2) >= 10) {
                $value2['phone_no2'] = 1;
            } else {
                $value2['phone_no2'] = 0;
            }
//                        print_r($value2);
//                        echo '<br>';
//                        echo $value['oid'];
//                        echo '~~';
//                        echo $value2['order_count'];
//                        echo '~~';


            $score = (($value2['cod'] * 70) + ($value2['pnr'] * 5) + ($value2['online'] * 90) + ($value2['phone_no2'] * 5)) / ($value2['order_count']);
            echo '<br>';

            $cust_uid = $value['cust_uid'];
            date_default_timezone_set('Asia/Calcutta');
            $current_time = date("Y-m-d h:i:s");
            echo $sql4 = "UPDATE `tbl_customer` SET `credibility_score`='$score',`score_updated_at`='$current_time' where `id`='$cust_uid'";
            help::execute($sql4);
        }
    }

    public function actionProblemOrders() {
        help::execute("UPDATE tbl_order_table SET issue_status = NULL");
        $menu_banned = $rest_closed_p = $rest_closed_t = array();
        $sql = "select o.id as oid,o.res_id,o2.menu_id,date(o.real_day_time) as del_date
              FROM tbl_order_table o
              INNER JOIN tbl_order_table2 o2
              ON o.id=o2.order_id
              INNER JOIN tbl_journey j
              ON j.cust_id=o.cust_id
              WHERE j.test_order=0 and o.order_status=1 and o.id > 40000
              ORDER BY real_day_time";

        $result = help::readAll($sql);
        $res_id_temp = '0';
        foreach ($result as $row) {
            $oid = $row['oid'];
            $res_id = $row['res_id'];
            $menu_id = $row['menu_id'];
            $delivery_date = $row['del_date'];
            $flag = 0;

            if ($res_id != $res_id_temp) {
                $sql2 = "SELECT `status`,disable_start,disable_end FROM `tbl_restaurant` WHERE `id`='$res_id'";
                $r = help::read($sql2);
                $status_res = $r['status'];
                if ($r['disable_start'] != '') {
                    $ds = $r['disable_start'];
                    $ds = str_replace('/', '-', $ds);
                    $de = $r['disable_end'];
                    $de = str_replace('/', '-', $de);
                    $ds = date("d-m-Y", strtotime($ds));
                    $de = date("d-m-Y", strtotime($de));

                    $ds = strtotime($ds);
                    $de = strtotime($de);
                    $delivery_date = strtotime($delivery_date);
                    if (($delivery_date >= $ds) && ($delivery_date <= $de)) {
                        $flag = 1;
                    }
                }

                if ($status_res == 0) {
                    $rest_closed_p[] = $oid;
                }

                if ($flag == 1) {
                    $rest_closed_t[] = $oid;
                }
            }
            $res_id_temp = $res_id;

            $sql3 = "SELECT `status` FROM `tbl_menu` WHERE `id`='$menu_id'";
            $status_menu = help::getScalar($sql3);
            if ($status_menu == 0) {
                $menu_banned[] = $oid;
            }
        }

        echo '<pre>';
        $menu_banned = array_flip($menu_banned);
        $rest_closed_p = array_flip($rest_closed_p);
        $rest_closed_t = array_flip($rest_closed_t);

        $menu_banned = array_map(function() {
            return 3;
        }, $menu_banned);

        $rest_closed_t = array_map(function() {
            return 2;
        }, $rest_closed_t);

        $rest_closed_p = array_map(function() {
            return 1;
        }, $rest_closed_p);

//      print_r($menu_banned);
//      print_r($rest_closed_p);
//      print_r($rest_closed_t);


        $full = $rest_closed_t + $menu_banned;
        $full = $rest_closed_p + $full;




        foreach ($full as $key => $value) {
            echo $sql4 = "UPDATE `tbl_order_table` SET `issue_status`='$value' where id='$key'";
            if (help::execute($sql4)) {
                echo $key;
                echo 'Success<br>';
            } else {
                echo '--' . $key;
                echo 'Failed<br>';
            }
        }
    }

    public function actionmake_refund($oid = 0) {
        OrderController::createtag($msg = 'Customer canceled from RY APP', $id = $oid, $type = 'Order Cancellation', $cat = 36);
        $result = $this->actionClearScoreDate($oid);
    }

    public function actionry_make_refund($oid = 0) {
        OrderController::createtag($msg = 'Customer canceled from RY APP (new)', $id = $oid, $type = 'Order Cancellation', $cat = 36);
        $result = $this->actionryClearScoreDate($oid);
    }

    public function refund_processing() { //cron used to refund req.std to proccessing
        $sql = "SELECT r.order_id,r.refund_time,o.order_status
FROM tbl_refund r
INNER JOIN tbl_order_table o ON o.id=r.order_id
WHERE r.refund_status = 1 AND o.order_status!=1 
ORDER BY `o`.`order_status`  DESC";
//        echo '<pre>';
        $data = help::readAll($sql);
        $success = 0;
        foreach ($data as $row) {
            $oid = $row['order_id'];
            $created_time = date('Y-m-d H:i:s');
            $hours48 = date('Y-m-d H:i:s', strtotime($created_time . ' + 48 hours'));
            $sql = "INSERT INTO `tbl_refund_log` (`order_id`, `event_time`, `message`,`refund_status`) VALUES
                                                  ('$oid', '$created_time', 'Refund status changed to processing,Due time " . $hours48 . "', '2')";
            $sql1 = "UPDATE tbl_refund SET refund_status='2',refund_time='$hours48' WHERE order_id='$oid'";
            if ((help::execute($sql)) && (help::execute($sql1))) {
                $success++;
                OrderController::createtag($msg = 'Refund status : <b>Approval Pending</b><br>Due Time : ' . $hours48, $id = $oid, $type = 'Refund Approval Pending', $cat = 15);
            }
        }
        help::Mail($subject = 'REFUND ACTIVATED', $content = 'REFUND OK ' . $success . '/' . count($data), $to = 'akhil.tm@yatrachef.com', $type = 1);
    }

    public function actionrefund_processing1() {
        $x = $this->refund_processing();
        print_r($x);
//        $sql = "SELECT order_id,event_time,message,refund_status,count(id) FROM `tbl_refund_log` GROUP BY order_id
//ORDER BY `tbl_refund_log`.`event_time`  ASC";
//        echo '<pre>';
//        $data = help::readAll($sql);
//        foreach ($data as $row) {
////            print_r($row);
//            $oid = $row['order_id'];
//            $rtime = $row['event_time'];
//            echo $sql1 = "UPDATE tbl_refund SET refund_time='$rtime' WHERE order_id='$oid'";
//            echo '<br>';
//            if (help::execute($sql1)) {
//                echo 'success ' . $oid . '<br>';
//            } else {
//                echo 'failed ' . $oid . '<br>';
//            }
//        }
    }

    public function actionGetLeads1() {
//        $hostname = '{pop.gmail.com:995/pop3/ssl}INBOX';
        $hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
        $username = 'yatrachefleads@gmail.com'; //'leads@yatrachef.com';
        $password = '@Stevejobs1'; //@YC812781700!
        $inbox = @imap_open($hostname, $username, $password) or die('Cannot connect to Gmail: ' . imap_last_error());
        $emails = imap_search($inbox, 'ALL'); //ALL
        echo 'ok';
        $error = imap_last_error();
        print_r($error);

        if ($emails) {
            rsort($emails);
            $i = 1;
            foreach ($emails as $email_number) {
                $i;
                /* get information specific to this email */
                $overview = imap_fetch_overview($inbox, $email_number, 0);
                /* get mail message */


                $body = imap_fetchbody($inbox, $email_number, "1.1");
                if ($body == "") {
                    $new_body = $body = imap_fetchbody($inbox, $email_number, "1");
                }

                $body = preg_replace('/\s+/', ' ', $body);
                $body = strip_tags($body, '<a>');
                $body = str_replace("'", "=*", $body);

                if (strpos($overview[0]->from, '<') !== false) {
                    $tempVar1 = explode('<', $overview[0]->from);
                    $from_new = $tempVar1[0];
                    $tempVar1 = explode('>', $tempVar1[1]);
//                    print_r($overview[0]->from);
                    $email_from = $tempVar1[0];
                    $email_from = str_replace(' ', '', $email_from);
                } else {
                    $email_from = str_replace(' ', '', $overview[0]->from);
                }
//                if (($email_from == 'info@railyatri.in') || ($email_from == 'noreply@railyatri.in')) {
                if (($email_from == 'info@railyatri.in') || ($email_from == 'noreply@railyatri.in')) {
                    if (strpos($body, 'RY Code------') !== false) {

                        $subject = $overview[0]->subject;
                        $date = date('Y-m-d H:i:s', strtotime($overview[0]->date));
                        $from = $overview[0]->from;
                        $temp1 = explode('RY Code', $body);
                        $temp1[1] = utf8_encode(quoted_printable_decode($temp1[1]));
                        if (strpos($temp1[1], 'User Mobile Number') !== false) {
                            $temp2 = explode('User Mobile Number', $temp1[1]);
                        } else if (strpos($temp1[1], 'User = Mobile Number') !== false) {
                            $temp2 = explode('User = Mobile Number', $temp1[1]);
                        } else {
                            $temp2 = explode('User Mobile Number', $temp1[1]);
                        }

                        $RYcode = $temp2[0];
                        $temp3 = explode('Alternate Phone', $temp2[1]);
                        $ph1 = $temp3[0];
                        $temp4 = explode('Service Date', $temp3[1]);
                        $ph2 = $temp4[0];
                        $temp5 = explode('Train Number', $temp4[1]);
                        $service_date = $temp5[0];
                        $service_date = date('Y-m-d', strtotime($service_date));
                        $temp6 = explode('Train Number', $temp5[1]);


                        if (strpos($temp6[0], 'Station Code') !== false) {
                            $temp7 = explode('Station Code', $temp6[0]);
                            $train = $temp7[0];
                            if (strpos($temp7[1], 'Interested In') !== false) {
                                $temp9 = explode('Interested In', $temp7[1]);
                                $station_code = $temp9[0];
                                $temp10 = explode('Advertisement', $temp9[1]);
                                $interested_in = $temp10[0];
                            }
                        } else {

                            $station_code = 'NA';
                            if (strpos($temp6[0], 'Interested In') !== false) {
                                $temp10 = explode('Interested In', $temp6[0]);
                                $train = $temp10[0];
                                $interested_in = $temp10[1];
                            } else {
                                $interested_in = 'NA';
                                $temp11 = explode('Advertisement', $temp6[0]);
                                $train = $temp11[0];
                            }
                        }
                        $created_time = date('Y-m-d H:i:s');
                        $sql = "SELECT Ticket_Id FROM `tbl_ticket` WHERE Ticket_Name LIKE '%$RYcode%'";
                        $already_exist = help::read($sql);
                        if ($already_exist == NULL) {
                            $sql = "INSERT INTO `tbl_leads`(`Created_Time`, `Received_Time`, `Service_Date`, `Subject`, `RY_code`, `Phone_1`, `Phone_2`, `Train`, `From`,`station`,`Interested`,`Full_data`)
                       VALUES ('$created_time','$date','$service_date','$subject','$RYcode','$ph1','$ph2','$train','$from','$station_code','$interested_in','$body')";
                            if (help::execute($sql)) {
                                $sql = "SELECT id FROM tbl_leads WHERE Phone_1='$ph1' AND Phone_2='$ph2' AND Created_Time='$created_time'";
                                $t_sub_id = help::getscalar($sql);

                                help::CreateTicket($res_id = 0, $Due_time = $created_time, $Ticket_Type = 10, $source = 9, $source_cat = 3, $t_name = 'Lead From Railyatri ' . $RYcode, $t_status = 1, $c_name = 'Unknown', $c_email = 'Unknown', $c_phone = $ph1, $t_sub_id);
                                echo 'success<br>';
                            } else {
                                echo 'failed<br>';
                            }
                        } else {
                            $m_msg = '<table>
                        <tr><td>Ry-Code</td><td>' . $RYcode . '</td></tr>
                        <tr><td>User Mobile Number</td><td>' . $ph1 . '</td></tr>
                        <tr><td>Alternate Phone</td><td>' . $ph2 . '</td></tr>
                        <tr><td>Service Date</td><td>' . $service_date . '</td></tr>
                        <tr><td>Train Number</td><td>' . $train . '</td></tr>
                        <tr><td>Station Code</td><td>' . $station_code . '</td></tr>
                        <tr><td>Interested In</td><td>' . $interested_in . '</td></tr>
                          </table><br><br>';
                            $sql = "SELECT t.Status,t.Ticket_Created_Time,t.Priority,p.Respond FROM tbl_ticket t
                             INNER JOIN tbl_sla_policy p ON p.Id=Priority
                             WHERE t.Ticket_Id='$already_exist[Ticket_Id]'";
                            $res = help::read($sql);
                            $Due_time = date("Y-m-d H:i:s", strtotime("+" . $res['Respond'] . " minutes", strtotime($created_time)));
                            if (strpos($subject, 'RESUBMITTED') !== false) {
                                $referance = 2;
                            } else if (strpos($subject, 'ESCALATION') !== false) {
                                $referance = 1;
                            } else {
                                $referance = 3;
                            }
                            if (($res['Status'] == 5) || ($res['Status'] == 6)) {
                                $sql = "UPDATE tbl_ticket SET Status='1',Ticket_Created_Time='$created_time',Due_time='$Due_time',Reference='$referance' WHERE Ticket_Id='$already_exist[Ticket_Id]'";
                                help::execute($sql);
                            } else {
                                $sql = "UPDATE tbl_ticket SET Ticket_Created_Time='$created_time',Due_time='$Due_time',Reference='$referance' WHERE Ticket_Id='$already_exist[Ticket_Id]'";
                                help::execute($sql);
                            }
                            $this->createtag2($msg = $m_msg, $id = $already_exist['Ticket_Id'], $type = $subject, $category = '11', $thread_type = '2');
                        }




                        $i++;


//   die;
                    } else {
                        echo 'email not matched<hr><br>';
                    }
                } else if (($email_from == 'instantemail@justdial.com') || ($email_from == 'web.user@justdial.com')) {
                    echo '<pre>';
                    $subject = $overview[0]->subject;
                    $date = date('Y-m-d H:i:s', strtotime($overview[0]->date));
                    $from = $overview[0]->from;
//                   echo '<br>';
//                    print_r($body);
                    if (strpos($body, 'Caller Name:') !== false) {
                        $tempbody1 = explode('Caller Name:', $body);
                        $tempbody2 = explode('from', $tempbody1[1]);

                        $customer_name = str_replace('Dear ', '', $tempbody2[0]);
                        $tempbody3 = explode('Caller Requirement:', $tempbody2[1]);

                        $cfrom = preg_replace('/\s+/', '', $tempbody3[0]);
                        $tempbody4 = explode('Call Date & Time:', $tempbody3[1]);
                        $crequirement = $tempbody4[0];

                        $tempbody5 = explode('Branch Info:', $tempbody4[1]);
                        $c_calltime = $tempbody5[0];

                        City:
                        print_r($tempbody5);


                        echo $customer_name . '<br>' . $cfrom . '<br>' . $crequirement . '<br>' . $c_calltime . '<br>';
                    }
                    echo '<hr>';
                    die;
                }
            }
        }
        imap_close($inbox);
        echo "Done";
    }

    public function actionleadtest() {

        if ((isset($_GET['Leadid'])) && (isset($_GET['Leadtype'])) && ($_GET['Leadid'] != '') && ($_GET['Leadtype'] != '')) {
            echo $lead_id = $_GET['Leadid'];
            echo $_GET['Leadtype'];
            $Leadtype = $_GET['Leadtype'];
            $Prefix = (isset($_GET['Prefix'])) ? $_GET['Prefix'] : 'NULL';
            $Name = (isset($_GET['Name'])) ? $_GET['Name'] : 'NULL';
            $Mobile = (isset($_GET['Mobile'])) ? $_GET['Mobile'] : 'NULL';
            $Phone = (isset($_GET['Phone'])) ? $_GET['Phone'] : 'NULL';
            $Email = (isset($_GET['Email'])) ? $_GET['Email'] : 'NULL';
            $Date = (isset($_GET['Date'])) ? $_GET['Date'] : 'NULL';
            $Category = (isset($_GET['Category'])) ? $_GET['Category'] : 'NULL';
            $Area = (isset($_GET['Area'])) ? $_GET['Area'] : 'NULL';
            $City = (isset($_GET['City'])) ? $_GET['City'] : 'NULL';
            $BranchArea = (isset($_GET['BranchArea'])) ? $_GET['BranchArea'] : 'NULL';
            $DncMobile = (isset($_GET['DncMobile'])) ? $_GET['DncMobile'] : 'NULL';
            $DncPhone = (isset($_GET['DncPhone'])) ? $_GET['DncPhone'] : 'NULL';
            $Company = (isset($_GET['Company'])) ? $_GET['Company'] : 'NULL';
            $Pincode = (isset($_GET['Pincode'])) ? $_GET['Pincode'] : 'NULL';
            $time = (isset($_GET['time'])) ? $_GET['time'] : 'NULL';
            $branchpin = (isset($_GET['branchpin'])) ? $_GET['branchpin'] : 'NULL';
            $Created_time = date('Y-m-d H:i:s');
            $sql = "INSERT INTO `tbl_justdial_leads`( `Leadid`, `Leadtype`, `Prefix`, `Name`, `Mobile`, `Phone`, `Email`, `Date`, `Category`, `Area`, `City`, `BranchArea`, `DncMobile`, `DncPhone`, `Company`, `Pincode`, `Time`, `Branchpin`, `Created_time`, `Lead_Status`) "
                    . "VALUES ('$lead_id','$Leadtype','$Prefix','$Name','$Mobile','$Phone','$Email','$Date','$Category','$Area','$City','$BranchArea','$DncMobile','$DncPhone','$Company','$Pincode','$time','$branchpin','$Created_time','0')";
            if (help::execute($sql)) {
                echo 'RECEIVED';
            } else {
                echo 'FAILED';
            }
        } else {
            $this->redirect('/error');
        }
    }

    public function review_weekly() {
        $today = date('Y-m-d', strtotime("-1 days"));
        $start_date = date('Y-m-d', strtotime("-7 days"));
        $sql = "SELECT DATE(r1.Date_time) as Date_time,r1.Rel_Id as rest_id,r2.rest_name,r1.Order_id,r1.Review,r1.Rating,s.station_name
            FROM tbl_user_reviews r1
            INNER JOIN tbl_restaurant r2
            ON r1.Rel_Id = r2.id
            INNER JOIN tbl_order_table o
            ON o.id=r1.Order_id
            INNER JOIN tbl_stations s
            ON s.id=r2.station_id
            WHERE r2.ry_is_preferred_vendor=1 and r1.Rating<>''
            and DATE(r1.Date_time) BETWEEN '$start_date' and  '$today'  ORDER BY  r1.Rel_Id  "; //and r1.Review<>''
        $data = help::readAll($sql);


        if ($data != NULL) {



            $heading = Array('Date' => 'Date', 'rest_id' => 'Rest Id', 'Restaurant' => 'Restaurant Name', 'Order_id' => 'Order_id', 'Review' => 'Review', 'Rating' => 'Rating', 'Station_Name' => 'Station Name');
            $review_data[0] = implode('#@#', $heading);

            foreach ($data as $row) {
                $review_data[] = implode('#@#', $row);
            }

            $today = date('d-m-Y');
//            $file = fopen("$today.csv", "w");
            $path = Yii::app()->basePath . "/../assets/FrontEnd/weekly_report/$today.csv";
            $file = fopen($path, 'w');

            foreach ($review_data as $line) {
                fputcsv($file, explode('#@#', $line));
            }

            fclose($file);

            $cc[0] = 'anoob.cr@yatrachef.com';
            $cc[1] = 'rameez@yatrachef.com';


            $to = 'prabir.pp@yatrachef.com';
            $path = Yii::app()->basePath . "/../assets/FrontEnd/weekly_report/";
            $attach[0] = "$today.csv";
            $x = help::Mail_Attachment($subject = 'Weekly Review Report', $content = 'please find the attached document', $to, $from = 'no-reply@yatrachef.com', $title = '', $cc, $attach, $path);
//        $this->layout = 'sss';
//        $this->render('weekly_review_report', array('data' => $data));
        }
    }

//------------------------------------------------alternate Stations start----------------------------------------------------------

    public function actionOtherService() {


        $path1 = '/var/www/vhosts/train_scrap/Api/Indianrail_Api.php';
        include($path1);
        $today = date('Y-m-d');
        $sql6 = "UPDATE `tbl_order_table` SET `alt_station`=NULL where date(`real_day_time`)=CURDATE() and 	order_status=1 ";
        help::execute($sql6);

        $sql = "SELECT o.id,o.res_id,j.cust_id,j.train_no,o.real_day_time as sta,o.expected_arrival as eta,s.station_code
              FROM tbl_order_table o
              INNER JOIN tbl_journey j
              ON o.cust_id=j.cust_id
              INNER JOIN tbl_stations s
              ON o.station=s.id
              WHERE  DATE(o.real_day_time)='$today' and o.order_status=1 order by o.id desc";

        $r = help::readAll($sql);
        $path = '/var/www/vhosts/cc.yatrachef.com/assets/scrap/liveStatus.php';
        include($path);
        $Livestatus = new Livestatus();

        foreach ($r as $row) {
            $eta = strtotime($row['eta']);
            $sta = strtotime($row['sta']);
            $late = round(abs($eta - $sta) / 60, 2);
            $stn_code = $row['station_code'];
            $trainNum = $row['train_no'];
            $oid = $row['id'];
            $rest_id = $row['res_id'];
            echo '<br>';
//               print_r($late);
            if ($late > 60) {
//                $train_late_details[]=$row['id'].'_'.$row['train_no'].'_'.$row['sta'];
//                  echo $trainNum;
//                  echo '---';
//                  echo $row['id'];
//                  echo '---';
//                  echo $stn_code;
                $available_service = $this->actionFindStation($row['id'], $row['train_no'], $row['sta'], $late, $stn_code);
//                echo '<pre>';
//                  print_r($available_service);
                $code = reset($available_service);
//                echo $trainNum;
//                echo '---';
//                print_r($code);
                $temp_code = explode('<->', $code);
                $code = $temp_code[0];
                $station_name = $temp_code[1];
                $STA = $row['sta'];
                $result = $this->actionFindETA($Livestatus, $train = $trainNum, $code = $code, $STA);
                if ($result['status'] == '200') {

                    $eta_new_station = $result['ETAT'];
//                  ,r.rest_name,s.station_name
                    $sql4 = "SELECT r.lead_time
                    FROM tbl_restaurant r
                    INNER JOIN tbl_stations s
                    on s.id=r.station_id
                    where s.station_code='$code'";

                    $lead_time = help::readAll($sql4);
                    array_multisort($lead_time);
                    $lead_time = $lead_time[0]['lead_time'];

                    date_default_timezone_set('Asia/Kolkata');
                    $cur_time = date('H:i:s');
                    $cur_time_plus_lead = date("H:i:s", strtotime("+$lead_time minutes", strtotime($cur_time)));


                    if ((strtotime($eta_new_station)) >= (strtotime($cur_time_plus_lead))) {
//                        echo $oid;
//                        echo '<br>';
//                        print_r($code);
//                        echo '<br>';
//                        echo $eta_new_station = $result['ETAT'];
//                        echo '<br>';
//                        echo $station_name;

                        $output = $station_name . '##' . $eta_new_station;
                        $sql5 = "UPDATE `tbl_order_table` SET alt_station='$output' where `id`='$oid'";
                        help::execute($sql5);
                    }
                } else {
                    
                }
            }
        }
    }

    public function actionFindStation($oid, $trainNum, $sta, $late, $stn_code) {
//        Y-m-d
//        echo '<br>';
//        echo $late;
//        echo '<br>';
        $new_time = date("H:i", strtotime("-$late minutes", strtotime($sta)));
        $relaxed_time = $late + 180;
//                echo '<br>';
        $relaxed_time = date("H:i", strtotime("-$relaxed_time minutes", strtotime($sta))); // add 2 hour relaxation
// to the approximation time
//              $temp_sta=explode(' ', $sta);
//              $sta=$temp_sta[1];
        $Indianrail = new Indianrail_Api();
        $csv = $Indianrail->getTrain($trainNum);
        $flag = 1;
        $flag2 = 1;
        foreach ($csv as $row) {

            if (($row[2] != $stn_code) && ($flag == 1)) {
                $time = $row[5];
                if ($time == 'Source') {
                    $time = $row[6];
                }
                $prev_stn_code[$time] = $row[2];
                $prev_stn_details[] = $row;
            } else if ($row[2] == $stn_code) {
                $flag = 0;
            }
        }

        $sql = "SELECT s.station_code,s.station_name, r.break_start, r.break_end, r.lunch_start, r.lunch_end, r.dinner_start, r.dinner_end
                FROM tbl_restaurant r
                INNER JOIN tbl_stations s ON s.id = r.station_id
                WHERE r.status =1";

        $sevice_stations_details = help::readAll($sql);

        foreach ($sevice_stations_details as $row) {
            $sevice_stations_codes[] = $row['station_code'];
            $temp_station_code = $row['station_code'];
            $sevice_stations_names[$temp_station_code] = $row['station_name'];
        }
        $sevice_stations_codes = array_unique($sevice_stations_codes);

        echo '<pre>';
        $result = array_intersect($prev_stn_code, $sevice_stations_codes);
//                print_r($result);

        $result = array_reverse($result);
        $temp_key = '24:00';
        foreach ($result as $key => $value) {
//                    echo '---';
//                    print_r($key);
//                    echo '---';
//                    print_r($temp_key);

            if (($flag2 == 1) && (strtotime($key) >= strtotime($relaxed_time)) && (strtotime($temp_key) > strtotime($key))) {
                $available_service[$key] = $value . '<->' . $sevice_stations_names[$value];
                $temp_key = $key;
            } else {
                $flag2 = 0;
            }
        }
        return $available_service;
    }

    public function actionFindETA($Livestatus, $train = 0, $code = '0', $STA) {


//    echo $train;
//    echo '<br>';
//    echo $code;
//    die;
        $currentDay = date('d-m-Y');

        $result = $Livestatus->fetch($train, $code, $dayType = 1);
//        echo '<pre>';
//        print_r($result);
        $result->exp_arrival = preg_replace('/\s+/', ' ', $result->exp_arrival);
        if ($result->sch_arrival) {
            @$act_arr = explode('-', $result->sch_arrival);
            @$year6 = explode('-', $result->date);
            @$year5 = $year6[2]; //3
            @$year5 = str_replace(' ', '', @$year5);
            @$date5 = $act_arr[0];
            @$date5 = trim($date5, ' ');
            @$zz = explode(' ', $act_arr[1]);
            @$tim = $zz[1];
            @$month5 = $zz[0];
            @$month5 = date('m', strtotime($month5));
            $date5 = preg_replace('/\s+/', ' ', $date5);
            $date5 = str_replace(' ', '', $date5);
            @$apiDate = $date5 . '-' . $month5 . '-' . $year5;
            @$apiDate2 = $year5 . '-' . $month5 . '-' . $date5 . ' ' . $tim;
            if ((strpos($date5, 'Train Source') !== false) || (strpos($date5, 'TrainSource') !== false) || (strpos($date5, 'Source') !== false) || (strpos($date5, 'So') !== false)) {
                @$deliveryX = explode(' ', $STA);
                @$apiDate = date("d-m-Y", strtotime($deliveryX[0]));
                @$apiDate2 = $STA;
            }
        } else {
            $apiDate = 0;
        }

        if ($result->exp_arrival == '0') {//act arrival
            @$arrival_type = 1; //act
            @$expected_arrival = 0;
            if ((strpos($result->act_arrival, 'Train Source') !== false) || (strpos($result->act_arrival, 'Source') !== false)) {

                $actual_arrival = $apiDate2;
            } else {//when date and time showing
                @$sexp = explode(' ', $result->act_arrival);
                @$act_arr = explode('-', $result->act_arrival);
                @$time = $sexp[2];
                @$year = explode('-', $result->date);
                @$year = $year[2]; //3
                @$year = str_replace(' ', '', @$year);
                @$date = $act_arr[0];
                @$month = $act_arr[1];
                $month2Spl2 = explode(' ', $month);
                @$month = date('m', strtotime($month2Spl2[0]));
                $date = preg_replace('/\s+/', ' ', $date);
                $date = str_replace(' ', '', $date);
                @$actual_arrival = $year . '-' . $month . '-' . $date . ' ' . $time;
            }
        } else {//exp arrival
            $arrival_type = 2; //exp arrival
            $actual_arrival = 0;
            if (strpos($result->exp_arrival, 'blink') !== false) {
                $evalue = explode('blink', $result->exp_arrival);
                $result->exp_arrival = $evalue[0]; //problem waiting for update
            }
            if (strpos($result->exp_arrival, 'Waiting for update') !== false) {
                $expected_arrival = $STA;
            } else {

                if (strpos($result->exp_arrival, 'blink') !== false) {
                    @$evalue = explode('blink', $result->exp_arrival);

                    @$year2 = explode('-', $result->date);
                    @$year2 = $year2[2]; //3
                    @$year2 = str_replace(' ', '', @$year2);


                    @$sexp2 = explode(' ', $result->exp_arrival);
                    @$ext_arr = explode('-', $sexp2[1]);
                    @$time2 = $sexp2[2];

                    @$date2 = $ext_arr[0];
                    @$month2 = $ext_arr[1];
                    $month2Spl1 = explode(' ', $month2);
                    @$month2 = date('m', strtotime($month2Spl1[0]));
                    $date2 = preg_replace('/\s+/', ' ', $date2);
                    $date2 = str_replace(' ', '', $date2);
                    @$expected_arrival = $year2 . '-' . $month2 . '-' . $date2 . ' ' . $time2;
                } else {
                    @$year2 = explode('-', $result->date);
                    @$year2 = $year2[2]; //3
                    @$year2 = str_replace(' ', '', $year2);
                    @$ext_arr = explode('-', $result->exp_arrival);
                    @$sexp3 = explode(' ', $ext_arr[1]);

                    @$time2 = @$sexp3[1];
                    @$date2 = $ext_arr[0];
                    @$date2 = str_replace(' ', '', @$date2);
                    @$month2 = $ext_arr[1];
                    $month2Spl = explode(' ', $month2);
                    @$month2 = date('m', strtotime($month2Spl[0]));
                    $date2 = preg_replace('/\s+/', ' ', $date2);
                    $date2 = str_replace(' ', '', $date2);
                    @$expected_arrival = $year2 . '-' . $month2 . '-' . $date2 . ' ' . $time2;
                }
            }
            if (strpos($result->exp_arrival, 'Cancelled for your Station') !== false) {
                @$expected_arrival = $STA;
                $reason = 'Cancelled for your Station ' . $code;
                $rstatus = 400;
            }
        }





        if ($expected_arrival == 0) {
            $arrival = $actual_arrival;
        } else if ($actual_arrival == 0) {
            $arrival = $expected_arrival;
        }
        $apiDate = str_replace(' ', '', $apiDate);

        $arrival = preg_replace('/\s+/', ' ', $arrival);
        $arrival = str_replace('*', '', $arrival);
        $xz = explode(' ', $arrival);
        $newTime = date("H:i:s", strtotime($xz[1]));
        $arrival = $xz[0] . ' ' . $newTime;

        if ($apiDate == $currentDay) {
            $rstatus = 200;
            $reason = 'OK';
        } else {

            $reason = 'Date Mismatch';
            $arrival = $STA;
            $rstatus = 400;
        }

        $response['status'] = $rstatus;
        $response['ETA'] = $arrival;
        $temp_arr = explode(' ', $arrival);
        $response['ETAD'] = ($temp_arr[0]);
        $response['ETAT'] = ($temp_arr[1]);
        $response['Details'] = $reason;
        return $response;
//        echo json_encode($response);
    }

    public function actionVendorActivity($order = 0, $event = NULL) {
        echo 'API REMOVED';
        die;
    }

//------------------------------------------------alternate Stations end----------------------------------------------------------

    public function actionFindFailedResturants() {
        $sql = "SELECT o.real_day_time,o.id,j.name,j.email as cust_email,j.phone_no,j.phone_no2,r.rest_name,r.email,r.contact_no1,r.contact_no1,(SELECT station_name FROM tbl_stations WHERE id=o.station) as station,o.order_status,t.ticket_id FROM tbl_order_table o
INNER JOIN tbl_journey j ON o.cust_id=j.cust_id
INNER JOIN tbl_restaurant r ON o.res_id=r.id
LEFT JOIN tbl_tagging t ON t.order_id=o.id
WHERE o.order_status='9'
GROUP BY o.id
limit 10";
        $odr = help::readAll($sql);
        echo '<pre>';
        print_r($odr);
    }

    public function actionFailedResturants($id = NULL) { //echo $id;die;
        if ($id != NULL) {
            $sql = "SELECT o.real_day_time,o.id,j.name,j.email as cust_email,j.phone_no,j.phone_no2,r.rest_name,r.email,r.contact_no1,r.contact_no1,(SELECT station_name FROM tbl_stations WHERE id=o.station) as station FROM tbl_order_table o
INNER JOIN tbl_journey j ON o.cust_id=j.cust_id
INNER JOIN tbl_restaurant r ON o.res_id=r.id
WHERE o.id=$id AND o.order_status='9'";
            $odr = help::read($sql);
            if ($odr != NULL) {
                $rest_name = explode('_', $odr['rest_name']);
                $rest_name = $rest_name[0];

                $orginal_data['name'] = $odr['name'];
                $orginal_data['phone'] = $odr['phone_no'];
                $orginal_data['email'] = $odr['cust_email'];

                $orginal_data['custom_fields'] = array('order_id' => (int) ($id));
                $orginal_data['description'] = 'Customer Name : ' . $odr['name'] . '<br><br>'
                        . 'Phone Number 1 : ' . $odr['phone_no'] . '<br><br>'
                        . 'Phone Number 2 : ' . $odr['phone_no2'] . '<br><br>'
                        . 'Email : ' . $odr['cust_email'] . '<br><br>'
                        . 'Order Id : ' . $id . '<br><br>'
                        . 'Restaurant Name : ' . $rest_name . '<br><br>'
                        . 'Station : ' . $odr['station'] . '<br><br>'
                        . 'Date of Delivery : ' . date('d-m-Y', strtotime($odr['real_day_time'])) . '<br><br>'
                        . '<a class="btn btn-primary" style="    background: rgb(173, 140, 91);" href="https://cc.yatrachef.com/index.php/order/details/id/' . $id . '" target="_blank">View Order</a>';

                $orginal_data['subject'] = $rest_name . ' Failed An Order #' . $id;
//            $orginal_data['custom_fields'] = array('train_no' => (int) ($cusdata['train_no']));
                $orginal_data['priority'] = 2;
                $orginal_data['status'] = 2;
                $orginal_data['source'] = 2;

//                $resp = help::NewFreshdeskTicket($orginal_data, $rep = 1);
//                $resp = json_decode($resp);
                $resp->id = 123;
                $msg = 'Ticket created for ' . $rest_name . ' failed order. Tickket id <a href="https://yatrachef.freshdesk.com/helpdesk/tickets/' . $resp->id . '"  target="_blank">#' . $resp->id . '</a>';
//                $this->createtag($msg, $id, $type = 'Ticket Created ' . $resp->id);
                echo OrderController::createtag($msg, $id, $type = 'Ticket Created for restaurant order failed ' . $resp->id, $cat = 5, $mode = 0, $user_id = $resp->id);
                die;
                echo '1';
//                return 1;
            }
        } else {
            echo '0';
//            return 0;
        }
        echo '0';
//        return 0;
    }

    public function actioncreateNote() {
        $orginal_data['incoming'] = boolval(1);
        $orginal_data['private'] = boolval(0);
        $orginal_data['body'] = 'test note 454564<br>hi test';
        $x = help::NewFreshdeskNote($orginal_data, $rep = 1, $ticket = 172290);
        $x = json_decode($x);
        if (isset($x->errors)) {
            echo 'ERROR';
        } else {
            echo $x->created_at;
        }
        echo '<pre>';
        print_r($x);
    }

    public function failure_report_monthly() {

        $today = date('Y-m-d', strtotime("-2 days"));
        $month = date('m', strtotime("-2 days"));
        $year = date('Y', strtotime("-2 days"));
        $start_date = $year . '-' . $month . '-01';

        $last_week_end = date('Y-m-d', strtotime($start_date . ' -1 days'));
        $month = date('m', strtotime($last_week_end));
        $year = date('Y', strtotime($last_week_end));
        $last_week_start = $year . '-' . $month . '-01';

//      $last_week_end = date('Y-m-d', strtotime("-8 days"));
//      $last_week_start = date('Y-m-d', strtotime("-14 days"));


        $sql = "SELECT
        r.rest_name,r.id as rest_id,r.status,am.name as onboarded_by,st.station_name,
        SUM( CASE WHEN ( o.order_status='5' or o.order_status='7' or o.order_status='9' or o.order_status='10') THEN 1 ELSE 0 END )  as Processed_Orders,
        SUM( CASE WHEN o.order_status='5' THEN 1 ELSE 0 END )  `completed`,
        SUM( CASE WHEN o.order_status='7' THEN 1 ELSE 0 END ) `canceled_rest`,
        SUM( CASE WHEN o.order_status='9' THEN 1 ELSE 0 END ) `failed_rest`,
        SUM( CASE WHEN o.order_status='10' THEN 1 ELSE 0 END ) `failed_cust`,
        SUM( r1.Rating ) `rating_sum`,
        SUM( CASE WHEN (r1.Rating!='' OR  r1.Rating IS NOT NULL  )THEN 1 ELSE 0 END ) `rating_count`

        FROM tbl_order_table o
        INNER JOIN tbl_journey j
        ON o.cust_id=j.cust_id
        INNER JOIN  tbl_restaurant r
        ON r.id=o.res_id
        INNER JOIN tbl_stations st
        ON r.station_id=st.id
        LEFT JOIN tbl_user_reviews r1
        ON r1.Order_id=o.id
        LEFT JOIN tbl_account_manager am
        ON r.account_manager_id=am.id
        WHERE DATE(o.real_day_time) BETWEEN '$start_date' AND '$today'
        AND j.test_order=0
        AND ( o.order_status='5' or o.order_status='7' or o.order_status='9' or o.order_status='10' )
        AND r.railyatri_availability=1 AND r.ry_is_preferred_vendor=1
        GROUP BY  o.res_id order by Processed_Orders DESC";

        $data = help::readAll($sql);


        foreach ($data as $row) {
            $all_res_id[] = $row['rest_id'];
        }


        $sql8 = "SELECT
        r.rest_name,r.id as rest_id,r.onboarded_by,r.status,
        SUM( CASE WHEN ( o.order_status='5' or o.order_status='7' or o.order_status='9' or o.order_status='10') THEN 1 ELSE 0 END )  as Processed_Orders,
        SUM( CASE WHEN o.order_status='5' THEN 1 ELSE 0 END )  `completed`,
        SUM( CASE WHEN o.order_status='7' THEN 1 ELSE 0 END ) `canceled_rest`,
        SUM( CASE WHEN o.order_status='9' THEN 1 ELSE 0 END ) `failed_rest`,
        SUM( CASE WHEN o.order_status='10' THEN 1 ELSE 0 END ) `failed_cust`,
        SUM( r1.Rating ) `rating_sum`,
        SUM( CASE WHEN (r1.Rating!='' OR  r1.Rating IS NOT NULL  )THEN 1 ELSE 0 END ) `rating_count`

        FROM tbl_order_table o
        INNER JOIN tbl_journey j
        ON o.cust_id=j.cust_id
        INNER JOIN  tbl_restaurant r
        ON r.id=o.res_id
        LEFT JOIN tbl_user_reviews r1
        ON r1.Order_id=o.id
        WHERE j.test_order=0
        AND ( o.order_status='5' or o.order_status='7' or o.order_status='9' or o.order_status='10' )
        AND r.railyatri_availability=1 AND r.ry_is_preferred_vendor=1
        GROUP BY  o.res_id order by Processed_Orders DESC";

        $data_full = help::readAll($sql8);
        foreach ($data_full as $key => $value) {
            if (in_array($value['rest_id'], $all_res_id)) {
                $data_full[$key] = $value;
            } else {
                
            }
        }


        foreach ($data_full as $key => $value) {
            $rest_id = $value['rest_id'];
            $failed_percent = (($value['failed_rest']) / ($value['Processed_Orders']) * 100);
            $full_failed1[$rest_id] = $failed_percent;
            $full_rating1[$rest_id] = $value['rating_sum'] / $value['rating_count'];
            $full_rating_count1[$rest_id] = $value['rating_count'];
        }



        $sql1 = "SELECT
        r.rest_name,r.id as rest_id,r.onboarded_by,r.status,
        SUM( CASE WHEN ( o.order_status='5' or o.order_status='7' or o.order_status='9' or o.order_status='10') THEN 1 ELSE 0 END )  as Processed_Orders,
        SUM( CASE WHEN o.order_status='5' THEN 1 ELSE 0 END )  `completed`,
        SUM( CASE WHEN o.order_status='7' THEN 1 ELSE 0 END ) `canceled_rest`,
        SUM( CASE WHEN o.order_status='9' THEN 1 ELSE 0 END ) `failed_rest`,
        SUM( CASE WHEN o.order_status='10' THEN 1 ELSE 0 END ) `failed_cust`,
        SUM( r1.Rating ) `rating_sum`,
        SUM( CASE WHEN (r1.Rating!='' OR  r1.Rating IS NOT NULL  )THEN 1 ELSE 0 END ) `rating_count`

        FROM tbl_order_table o
        INNER JOIN tbl_journey j
        ON o.cust_id=j.cust_id
        INNER JOIN  tbl_restaurant r
        ON r.id=o.res_id
        LEFT JOIN tbl_user_reviews r1
        ON r1.Order_id=o.id
        WHERE DATE(o.real_day_time) BETWEEN '$last_week_start' AND '$last_week_end'
        AND j.test_order=0
        AND ( o.order_status='5' or o.order_status='7' or o.order_status='9' or o.order_status='10' )
        AND r.railyatri_availability=1 AND r.ry_is_preferred_vendor=1
        GROUP BY  o.res_id order by Processed_Orders DESC";

        $data_last_week = help::readAll($sql1);

        foreach ($data_last_week as $key => $value) {
            if (in_array($value['rest_id'], $all_res_id)) {
                $data_last_week[$key] = $value;
            } else {
                
            }
        }

        foreach ($data_last_week as $key => $value) {
            $rest_id = $value['rest_id'];
            $failed_percent = (($value['failed_rest']) / ($value['Processed_Orders']) * 100);
            $last_week_failed1[$rest_id] = $failed_percent;
            $last_week_rating1[$rest_id] = $value['rating_sum'] / $value['rating_count'];
        }

        foreach ($data as $key => $value) {
            $temp_rest_id = $value['rest_id'];

            $failed_percent = (($value['failed_rest']) / ($value['Processed_Orders']) * 100);
//$failed_percent=number_format((float)$failed_percent, 2, '.', '');
            $failed_percent = round($failed_percent);
            $data[$key]['failed_percent'] = $failed_percent;

            $last_week_percent = $last_week_failed1[$temp_rest_id];
            $last_week_percent = round($last_week_percent);
//$last_week_percent=number_format((float)$last_week_percent, 2, '.', '');
//$data[$key]['failed_variation']=$last_week_percent-$failed_percent;
            $data[$key]['failed_percent_last_week'] = $last_week_percent;

            $full_failed = $full_failed1[$temp_rest_id];
            $full_failed = round($full_failed);
//$full_failed=number_format((float)$full_failed, 2, '.', '');
            $data[$key]['failed_percent_full'] = $full_failed;

            $rating = $value['rating_sum'] / $value['rating_count'];
            if ($rating != '') {
                $rating = number_format((float) $rating, 1, '.', '');
            }
            $data[$key]['rating'] = $rating;

            $last_week_rating = $last_week_rating1[$temp_rest_id];
            if ($last_week_rating != '') {
                $last_week_rating = number_format((float) $last_week_rating, 1, '.', '');
            }
//           $data[$key]['rating_variation']=$last_week_rating-$rating;
            $data[$key]['last_week_rating'] = $last_week_rating;

            $full_rating = $full_rating1[$temp_rest_id];
            $full_rating_count = $full_rating_count1[$temp_rest_id];
            if ($full_rating != '') {
                $full_rating = number_format((float) $full_rating, 1, '.', '');
            }
            $data[$key]['full_rating'] = $full_rating;
            $data[$key]['full_rating_count'] = $full_rating_count;
        }



        foreach ($data as $key => $value) {
            $temp_rest_id = $value['rest_id'];

            $failed_percent = (($value['failed_rest']) / ($value['Processed_Orders']) * 100);
            $failed_percent = number_format((float) $failed_percent, 1, '.', '');
//            $failed_percent=  round($failed_percent);
            $data[$key]['failed_percent_csv'] = $failed_percent;

            $last_week_percent = $last_week_failed1[$temp_rest_id];
//            $last_week_percent=  round($last_week_percent);
            $last_week_percent = number_format((float) $last_week_percent, 1, '.', '');
//$data[$key]['failed_variation']=$last_week_percent-$failed_percent;
            $data[$key]['failed_percent_last_week_csv'] = $last_week_percent;

            $full_failed = $full_failed1[$temp_rest_id];
//            $full_failed=  round($full_failed);
            $full_failed = number_format((float) $full_failed, 1, '.', '');
            $data[$key]['failed_percent_full_csv'] = $full_failed;

            $rating = $value['rating_sum'] / $value['rating_count'];

            if ($rating != '') {
                $rating = number_format((float) $rating, 1, '.', '');
            }
            $data[$key]['rating'] = $rating;
            $data[$key]['rating_count_current_week'] = $value['rating_count'];

            $last_week_rating = $last_week_rating1[$temp_rest_id];
            if ($last_week_rating != '') {
                $last_week_rating = number_format((float) $last_week_rating, 1, '.', '');
            }
//           $data[$key]['rating_variation']=$last_week_rating-$rating;
            $data[$key]['last_week_rating'] = $last_week_rating;

            $full_rating = $full_rating1[$temp_rest_id];
            $full_rating_count = $full_rating_count1[$temp_rest_id];
            if ($full_rating != '') {
                $full_rating = number_format((float) $full_rating, 1, '.', '');
            }
            $data[$key]['full_rating'] = $full_rating;
            $data[$key]['full_rating_count'] = $full_rating_count;
        }


        foreach ($data as $key => $subArr) {
//            unset($subArr['rest_id']);
            unset($subArr['rating_count']);
            unset($subArr['rating_sum']);
            $data[$key] = $subArr;
        }


        $content = '<div style="margin-bottom: 11px;
                margin-left: 67px;
                font-family: sans-serif;
                font-size: 15px;">
                </div>';
        $content .= '
                <table class="table table-bordered" width="650px" border="1" cellspacing="2" style="margin-bottom: 0px;">
                <tbody>
                <tr>
                <td colspan="" style="text-align: center;background: gray;color: white;">Rest.Name</td>
                <td colspan="" style="text-align: center;background: gray;color: white;">Processed Orders</td>
                <td colspan="" style="text-align: center;background: gray;color: white;">Completed</td>
                <td colspan="" style="text-align: center;background: gray;color: white;">Canceled</td>
                <td colspan="" style="text-align: center;background: gray;color: white;">Failed</td>

                <td colspan="" style="text-align: center;background: gray;color: white;">Failed overall %</td>

                <td colspan="" style="text-align: center;background: gray;color: white;">Rating last Month</td>

                <td colspan="" style="text-align: center;background: gray;color: white;">Overall rating</td>

                <td colspan="" style="text-align: center;background: gray;color: white;">Failed cust</td>
                <td colspan="" style="text-align: center;background: gray;color: white;">Vendor Manager</td>
                <td colspan="" style="text-align: center;background: gray;color: white;">Station Name</td>
                <td colspan="" style="text-align: center;background: gray;color: white;">Status</td>
                </tr>';

        foreach ($data as $row) {
            $row['failed_percent'] = $row['failed_percent'] . '%';
            $row['failed_percent_last_week'] = $row['failed_percent_last_week'] . '%';
            $row['failed_percent_full'] = $row['failed_percent_full'] . '%';
            if ($row['status'] == 1) {
                $row['status'] = 'Active';
                $colour = 'color: green;';
            } else {
                $row['status'] = 'Inactive';
                $colour = 'color: red;';
            }

            $content .= '<tr>
                <td style="text-align: center;">' . $row['rest_name'] . '</td>
                <td style="text-align: center;">' . $row['Processed_Orders'] . '</td>
                <td style="text-align: center;">' . $row['completed'] . '</td>
                <td style="text-align: center;">' . $row['canceled_rest'] . '</td>

                <td style="text-align: center;">' . $row['failed_rest'] . '(' . $row['failed_percent'] . ')</td>
                <td style="text-align: center;">' . $row['failed_percent_full'] . '</td>
                <td style="text-align: center;">' . $row['rating'] . '(' . $row['rating_count_current_week'] . ')</td>
                <td style="text-align: center;">' . $row['full_rating'] . '(' . $row['full_rating_count'] . ')</td>

                <td style="text-align: justify;">' . $row['failed_cust'] . '</td>
                <td style="text-align: justify;">' . $row['onboarded_by'] . '</td>
                <td style="text-align: justify;">' . $row['station_name'] . '</td>
                <td style="text-align: justify;' . $colour . '">' . $row['status'] . '</td>
                </tr> ';
        }

        foreach ($data as $key => $subArr) {
            $data2[$key]['rest_name'] = $data[$key]['rest_name'];
            $r_temp_id = $data[$key]['rest_id'];
            $data2[$key]['station_name'] = help::getscalar("SELECT s.station_name FROM tbl_restaurant r
            INNER JOIN tbl_stations s ON s.id=r.station_id
            WHERE r.id='$r_temp_id'");
            $data2[$key]['Processed_Orders'] = $data[$key]['Processed_Orders'];
            $data2[$key]['completed'] = $data[$key]['completed'];
            $data2[$key]['canceled_rest'] = $data[$key]['canceled_rest'];
            $data2[$key]['failed_rest'] = $data[$key]['failed_rest'];
            $data2[$key]['failed_percent_csv'] = $data[$key]['failed_percent_csv'];
            $data2[$key]['failed_percent_last_week_csv'] = $data[$key]['failed_percent_last_week_csv'];
            $data2[$key]['failed_percent_full_csv'] = $data[$key]['failed_percent_full_csv'];
            $data2[$key]['rating'] = $data[$key]['rating'];
            $data2[$key]['last_week_rating'] = $data[$key]['last_week_rating'];
            $data2[$key]['full_rating'] = $data[$key]['full_rating'];
            $data2[$key]['failed_cust'] = $data[$key]['failed_cust'];
            $data2[$key]['onboarded_by'] = $data[$key]['onboarded_by'];
            if ($data[$key]['status'] == 1) {
                $data[$key]['status'] = 'Active';
            } else {
                $data[$key]['status'] = 'Inactive';
            }
            $data2[$key]['status'] = $data[$key]['status'];

//                unset($subArr['failed_percent']);
//                unset($subArr['failed_percent_last_week']);
//                unset($subArr['failed_percent_full']);
//                $data[$key] = $subArr;
        }


        $heading = Array('rest_name' => 'rest_name', 'station_name' => 'Station Name', 'Processed_Orders' => 'Processed_Orders', 'completed' => 'completed', 'canceled_rest' => 'canceled_rest', 'failed_rest' => 'failed_rest', 'failed_percent_last_month' => 'failed_percent_last_month', 'failed_percent_two_months_ago' => 'failed_percent_two_months_ago', 'failed_percent_overall' => 'failed_percent_overall', 'rating_last_month' => 'rating_last_month', 'rating_two_month_ago' => 'rating_two_month_ago', 'overall_rating' => 'overall_rating', 'failed_cust' => 'failed_cust', 'onboarded_by' => 'onboarded_by', 'Status' => 'Status');
        $rest_data[0] = implode('#@#', $heading);

        foreach ($data2 as $row) {
            $rest_data[] = implode('#@#', $row);
        }

        $today = date('d-m-Y');
        $today = $today . '-Monthly_Failure_Report';
//        $file = fopen("$today.csv", "w");
        $path = Yii::app()->basePath . "/../assets/FrontEnd/weekly_report/$today.csv";
        $file = fopen($path, 'w');

        foreach ($rest_data as $line) {
            fputcsv($file, explode('#@#', $line));
        }
        fclose($file);
        $cc[0] = 'anoob.cr@yatrachef.com';
        $cc[1] = 'rameez@yatrachef.com';
        $cc[2] = 'kapil.raizada@stellingtech.com';
        $cc[3] = 'manish.rathi@stellingtech.com';
        $cc[4] = 'raghu.n@yatrachef.com';
        $cc[5] = 'dinesh.sharma@railyatri.in';
        $cc[6] = 'rk.shaw@railyatri.in';
        $cc[7] = 'sachin.saxena@stellingtech.com';
        $cc[8] = 'rishi.kapoor@railyatri.in';
        $cc[9] = 'sandeep.sharma@railyatri.in';

        $today2 = date('d/m/Y');
        $start_date2 = date("d/m/Y", strtotime($start_date));

        $to = 'arun@yatrachef.com';
        $cc2[0] = '';
        $path = Yii::app()->basePath . "/../assets/FrontEnd/weekly_report/";
        $attach[0] = "$today.csv";
        $x = help::Mail_Attachment($subject = "Monthly Restaurant Report($start_date2  -  $today2)", $content = $content, $to, $from = 'no-reply@yatrachef.com', $title = '', $cc, $attach, $path);
    }

    public function failure_report_weekly() {

//        $today = date('Y-m-d', strtotime("-1 days"));
//        $today2=$today;
//        $month = date('m', strtotime("-1 days"));
//        $year = date('Y', strtotime("-1 days"));
//        $start_date=$year.'-'.$month.'-01';
//
//        $last_week_end=date('Y-m-d',strtotime($start_date .' -1 days'));
//        $month = date('m', strtotime($last_week_end));
//        $year = date('Y', strtotime($last_week_end));
//        $last_week_start=$year.'-'.$month.'-01';

        $today = date('Y-m-d', strtotime("-1 days"));
        $start_date = date('Y-m-d', strtotime("-7 days"));
        $last_week_end = date('Y-m-d', strtotime("-8 days"));
        $last_week_start = date('Y-m-d', strtotime("-14 days"));

//      $last_week_end = date('Y-m-d', strtotime("-8 days"));
//      $last_week_start = date('Y-m-d', strtotime("-14 days"));


        $sql = "SELECT
        r.rest_name,r.id as rest_id,r.status,am.name as onboarded_by,st.station_name,
        SUM( CASE WHEN ( o.order_status='5' or o.order_status='7' or o.order_status='9' or o.order_status='10') THEN 1 ELSE 0 END )  as Processed_Orders,
        SUM( CASE WHEN o.order_status='5' THEN 1 ELSE 0 END )  `completed`,
        SUM( CASE WHEN o.order_status='7' THEN 1 ELSE 0 END ) `canceled_rest`,
        SUM( CASE WHEN o.order_status='9' THEN 1 ELSE 0 END ) `failed_rest`,
        SUM( CASE WHEN o.order_status='10' THEN 1 ELSE 0 END ) `failed_cust`,
        SUM( r1.Rating ) `rating_sum`,
        SUM( CASE WHEN (r1.Rating!='' OR  r1.Rating IS NOT NULL  )THEN 1 ELSE 0 END ) `rating_count`

        FROM tbl_order_table o
        INNER JOIN tbl_journey j
        ON o.cust_id=j.cust_id
        INNER JOIN  tbl_restaurant r
        ON r.id=o.res_id
        INNER JOIN tbl_stations st
        ON r.station_id=st.id
        LEFT JOIN tbl_user_reviews r1
        ON r1.Order_id=o.id
        LEFT JOIN tbl_account_manager am
        ON r.account_manager_id=am.id
        WHERE DATE(o.real_day_time) BETWEEN '$start_date' AND '$today'
        AND j.test_order=0
        AND ( o.order_status='5' or o.order_status='7' or o.order_status='9' or o.order_status='10' )
        AND r.railyatri_availability=1 AND r.ry_is_preferred_vendor=1
        GROUP BY  o.res_id order by Processed_Orders DESC";

        $data = help::readAll($sql);


        foreach ($data as $row) {
            $all_res_id[] = $row['rest_id'];
        }


        $sql8 = "SELECT
        r.rest_name,r.id as rest_id,r.onboarded_by,r.status,
        SUM( CASE WHEN ( o.order_status='5' or o.order_status='7' or o.order_status='9' or o.order_status='10') THEN 1 ELSE 0 END )  as Processed_Orders,
        SUM( CASE WHEN o.order_status='5' THEN 1 ELSE 0 END )  `completed`,
        SUM( CASE WHEN o.order_status='7' THEN 1 ELSE 0 END ) `canceled_rest`,
        SUM( CASE WHEN o.order_status='9' THEN 1 ELSE 0 END ) `failed_rest`,
        SUM( CASE WHEN o.order_status='10' THEN 1 ELSE 0 END ) `failed_cust`,
        SUM( r1.Rating ) `rating_sum`,
        SUM( CASE WHEN (r1.Rating!='' OR  r1.Rating IS NOT NULL  )THEN 1 ELSE 0 END ) `rating_count`

        FROM tbl_order_table o
        INNER JOIN tbl_journey j
        ON o.cust_id=j.cust_id
        INNER JOIN  tbl_restaurant r
        ON r.id=o.res_id
        LEFT JOIN tbl_user_reviews r1
        ON r1.Order_id=o.id
        WHERE j.test_order=0
        AND ( o.order_status='5' or o.order_status='7' or o.order_status='9' or o.order_status='10' )
        AND r.railyatri_availability=1 AND r.ry_is_preferred_vendor=1
        GROUP BY  o.res_id order by Processed_Orders DESC";

        $data_full = help::readAll($sql8);
        foreach ($data_full as $key => $value) {
            if (in_array($value['rest_id'], $all_res_id)) {
                $data_full[$key] = $value;
            } else {
                
            }
        }


        foreach ($data_full as $key => $value) {
            $rest_id = $value['rest_id'];
            $failed_percent = (($value['failed_rest']) / ($value['Processed_Orders']) * 100);
            $full_failed1[$rest_id] = $failed_percent;
            $full_rating1[$rest_id] = $value['rating_sum'] / $value['rating_count'];
            $full_rating_count1[$rest_id] = $value['rating_count'];
        }



        $sql1 = "SELECT
        r.rest_name,r.id as rest_id,r.onboarded_by,r.status,
        SUM( CASE WHEN ( o.order_status='5' or o.order_status='7' or o.order_status='9' or o.order_status='10') THEN 1 ELSE 0 END )  as Processed_Orders,
        SUM( CASE WHEN o.order_status='5' THEN 1 ELSE 0 END )  `completed`,
        SUM( CASE WHEN o.order_status='7' THEN 1 ELSE 0 END ) `canceled_rest`,
        SUM( CASE WHEN o.order_status='9' THEN 1 ELSE 0 END ) `failed_rest`,
        SUM( CASE WHEN o.order_status='10' THEN 1 ELSE 0 END ) `failed_cust`,
        SUM( r1.Rating ) `rating_sum`,
        SUM( CASE WHEN (r1.Rating!='' OR  r1.Rating IS NOT NULL  )THEN 1 ELSE 0 END ) `rating_count`

        FROM tbl_order_table o
        INNER JOIN tbl_journey j
        ON o.cust_id=j.cust_id
        INNER JOIN  tbl_restaurant r
        ON r.id=o.res_id
        LEFT JOIN tbl_user_reviews r1
        ON r1.Order_id=o.id
        WHERE DATE(o.real_day_time) BETWEEN '$last_week_start' AND '$last_week_end'
        AND j.test_order=0
        AND ( o.order_status='5' or o.order_status='7' or o.order_status='9' or o.order_status='10' )
        AND r.railyatri_availability=1 AND r.ry_is_preferred_vendor=1
        GROUP BY  o.res_id order by Processed_Orders DESC";

        $data_last_week = help::readAll($sql1);

        foreach ($data_last_week as $key => $value) {
            if (in_array($value['rest_id'], $all_res_id)) {
                $data_last_week[$key] = $value;
            } else {
                
            }
        }

        foreach ($data_last_week as $key => $value) {
            $rest_id = $value['rest_id'];
            $failed_percent = (($value['failed_rest']) / ($value['Processed_Orders']) * 100);
            $last_week_failed1[$rest_id] = $failed_percent;
            $last_week_rating1[$rest_id] = $value['rating_sum'] / $value['rating_count'];
        }

        foreach ($data as $key => $value) {
            $temp_rest_id = $value['rest_id'];

            $failed_percent = (($value['failed_rest']) / ($value['Processed_Orders']) * 100);
//$failed_percent=number_format((float)$failed_percent, 2, '.', '');
            $failed_percent = round($failed_percent);
            $data[$key]['failed_percent'] = $failed_percent;

            $last_week_percent = $last_week_failed1[$temp_rest_id];
            $last_week_percent = round($last_week_percent);
//$last_week_percent=number_format((float)$last_week_percent, 2, '.', '');
//$data[$key]['failed_variation']=$last_week_percent-$failed_percent;
            $data[$key]['failed_percent_last_week'] = $last_week_percent;

            $full_failed = $full_failed1[$temp_rest_id];
            $full_failed = round($full_failed);
//$full_failed=number_format((float)$full_failed, 2, '.', '');
            $data[$key]['failed_percent_full'] = $full_failed;

            $rating = $value['rating_sum'] / $value['rating_count'];
            if ($rating != '') {
                $rating = number_format((float) $rating, 1, '.', '');
            }
            $data[$key]['rating'] = $rating;

            $last_week_rating = $last_week_rating1[$temp_rest_id];
            if ($last_week_rating != '') {
                $last_week_rating = number_format((float) $last_week_rating, 1, '.', '');
            }
//           $data[$key]['rating_variation']=$last_week_rating-$rating;
            $data[$key]['last_week_rating'] = $last_week_rating;

            $full_rating = $full_rating1[$temp_rest_id];
            $full_rating_count = $full_rating_count1[$temp_rest_id];
            if ($full_rating != '') {
                $full_rating = number_format((float) $full_rating, 1, '.', '');
            }
            $data[$key]['full_rating'] = $full_rating;
            $data[$key]['full_rating_count'] = $full_rating_count;
        }



        foreach ($data as $key => $value) {
            $temp_rest_id = $value['rest_id'];

            $failed_percent = (($value['failed_rest']) / ($value['Processed_Orders']) * 100);
            $failed_percent = number_format((float) $failed_percent, 1, '.', '');
//            $failed_percent=  round($failed_percent);
            $data[$key]['failed_percent_csv'] = $failed_percent;

            $last_week_percent = $last_week_failed1[$temp_rest_id];
//            $last_week_percent=  round($last_week_percent);
            $last_week_percent = number_format((float) $last_week_percent, 1, '.', '');
//$data[$key]['failed_variation']=$last_week_percent-$failed_percent;
            $data[$key]['failed_percent_last_week_csv'] = $last_week_percent;

            $full_failed = $full_failed1[$temp_rest_id];
//            $full_failed=  round($full_failed);
            $full_failed = number_format((float) $full_failed, 1, '.', '');
            $data[$key]['failed_percent_full_csv'] = $full_failed;

            $rating = $value['rating_sum'] / $value['rating_count'];

            if ($rating != '') {
                $rating = number_format((float) $rating, 1, '.', '');
            }
            $data[$key]['rating'] = $rating;
            $data[$key]['rating_count_current_week'] = $value['rating_count'];

            $last_week_rating = $last_week_rating1[$temp_rest_id];
            if ($last_week_rating != '') {
                $last_week_rating = number_format((float) $last_week_rating, 1, '.', '');
            }
//           $data[$key]['rating_variation']=$last_week_rating-$rating;
            $data[$key]['last_week_rating'] = $last_week_rating;

            $full_rating = $full_rating1[$temp_rest_id];
            $full_rating_count = $full_rating_count1[$temp_rest_id];
            if ($full_rating != '') {
                $full_rating = number_format((float) $full_rating, 1, '.', '');
            }
            $data[$key]['full_rating'] = $full_rating;
            $data[$key]['full_rating_count'] = $full_rating_count;
        }


        foreach ($data as $key => $subArr) {
//            unset($subArr['rest_id']);
            unset($subArr['rating_count']);
            unset($subArr['rating_sum']);
            $data[$key] = $subArr;
        }


        $content = '<div style="margin-bottom: 11px;
                margin-left: 67px;
                font-family: sans-serif;
                font-size: 15px;">
                </div>';
        $content .= '
                <table class="table table-bordered" width="650px" border="1" cellspacing="2" style="margin-bottom: 0px;">
                <tbody>
                <tr>
                <td colspan="" style="text-align: center;background: gray;color: white;">Rest.Name</td>
                <td colspan="" style="text-align: center;background: gray;color: white;">Processed Orders</td>
                <td colspan="" style="text-align: center;background: gray;color: white;">Completed</td>
                <td colspan="" style="text-align: center;background: gray;color: white;">Canceled</td>
                <td colspan="" style="text-align: center;background: gray;color: white;">Failed</td>

                <td colspan="" style="text-align: center;background: gray;color: white;">Failed overall %</td>

                <td colspan="" style="text-align: center;background: gray;color: white;">Rating last Week</td>

                <td colspan="" style="text-align: center;background: gray;color: white;">Overall rating</td>

                <td colspan="" style="text-align: center;background: gray;color: white;">Failed cust</td>
                <td colspan="" style="text-align: center;background: gray;color: white;">Vendor Manager</td>
                <td colspan="" style="text-align: center;background: gray;color: white;">Station Name</td>
                <td colspan="" style="text-align: center;background: gray;color: white;">Status</td>
                </tr>';

        foreach ($data as $row) {
            $row['failed_percent'] = $row['failed_percent'] . '%';
            $row['failed_percent_last_week'] = $row['failed_percent_last_week'] . '%';
            $row['failed_percent_full'] = $row['failed_percent_full'] . '%';
            if ($row['status'] == 1) {
                $row['status'] = 'Active';
                $colour = 'color: green;';
            } else {
                $row['status'] = 'Inactive';
                $colour = 'color: red;';
            }

            $content .= '<tr>
                <td style="text-align: center;">' . $row['rest_name'] . '</td>
                <td style="text-align: center;">' . $row['Processed_Orders'] . '</td>
                <td style="text-align: center;">' . $row['completed'] . '</td>
                <td style="text-align: center;">' . $row['canceled_rest'] . '</td>

                <td style="text-align: center;">' . $row['failed_rest'] . '(' . $row['failed_percent'] . ')</td>
                <td style="text-align: center;">' . $row['failed_percent_full'] . '</td>
                <td style="text-align: center;">' . $row['rating'] . '(' . $row['rating_count_current_week'] . ')</td>
                <td style="text-align: center;">' . $row['full_rating'] . '(' . $row['full_rating_count'] . ')</td>

                <td style="text-align: justify;">' . $row['failed_cust'] . '</td>
                <td style="text-align: justify;">' . $row['onboarded_by'] . '</td>
                <td style="text-align: justify;">' . $row['station_name'] . '</td>
                <td style="text-align: justify;' . $colour . '">' . $row['status'] . '</td>
                </tr> ';
        }

        foreach ($data as $key => $subArr) {
            $data2[$key]['rest_name'] = $data[$key]['rest_name'];
            $r_temp_id = $data[$key]['rest_id'];
            $data2[$key]['station_name'] = help::getscalar("SELECT s.station_name FROM tbl_restaurant r
            INNER JOIN tbl_stations s ON s.id=r.station_id
            WHERE r.id='$r_temp_id'");
            $data2[$key]['Processed_Orders'] = $data[$key]['Processed_Orders'];
            $data2[$key]['completed'] = $data[$key]['completed'];
            $data2[$key]['canceled_rest'] = $data[$key]['canceled_rest'];
            $data2[$key]['failed_rest'] = $data[$key]['failed_rest'];
            $data2[$key]['failed_percent_csv'] = $data[$key]['failed_percent_csv'];
            $data2[$key]['failed_percent_last_week_csv'] = $data[$key]['failed_percent_last_week_csv'];
            $data2[$key]['failed_percent_full_csv'] = $data[$key]['failed_percent_full_csv'];
            $data2[$key]['rating'] = $data[$key]['rating'];
            $data2[$key]['last_week_rating'] = $data[$key]['last_week_rating'];
            $data2[$key]['full_rating'] = $data[$key]['full_rating'];
            $data2[$key]['failed_cust'] = $data[$key]['failed_cust'];
            $data2[$key]['onboarded_by'] = $data[$key]['onboarded_by'];
            if ($data[$key]['status'] == 1) {
                $data[$key]['status'] = 'Active';
            } else {
                $data[$key]['status'] = 'Inactive';
            }
            $data2[$key]['status'] = $data[$key]['status'];

//                unset($subArr['failed_percent']);
//                unset($subArr['failed_percent_last_week']);
//                unset($subArr['failed_percent_full']);
//                $data[$key] = $subArr;
        }


        $heading = Array('rest_name' => 'rest_name', 'station_name' => 'Station Name', 'Processed_Orders' => 'Processed_Orders', 'completed' => 'completed', 'canceled_rest' => 'canceled_rest', 'failed_rest' => 'failed_rest', 'failed_percent_last_week' => 'failed_percent_last_week', 'failed_percent_two_weeks_ago' => 'failed_percent_two_weeks_ago', 'failed_percent_overall' => 'failed_percent_overall', 'rating_last_week' => 'rating_last_week', 'rating_two_week_ago' => 'rating_two_week_ago', 'overall_rating' => 'overall_rating', 'failed_cust' => 'failed_cust', 'onboarded_by' => 'onboarded_by', 'Status' => 'Status');
        $rest_data[0] = implode('#@#', $heading);

        foreach ($data2 as $row) {
            $rest_data[] = implode('#@#', $row);
        }

        $today = date('d-m-Y');
        $today = $today . 'Restaurant_Report';
//        $file = fopen("$today.csv", "w");
        $path = Yii::app()->basePath . "/../assets/FrontEnd/weekly_report/$today.csv";
        $file = fopen($path, 'w');

        foreach ($rest_data as $line) {
            fputcsv($file, explode('#@#', $line));
        }

        fclose($file);
        $cc[0] = 'anoob.cr@yatrachef.com';
        $cc[1] = 'rameez@yatrachef.com';
        $cc[2] = 'kapil.raizada@stellingtech.com';
        $cc[3] = 'manish.rathi@stellingtech.com';
        $cc[4] = 'raghu.n@yatrachef.com';
        $cc[5] = 'dinesh.sharma@railyatri.in';
        $cc[6] = 'rk.shaw@railyatri.in';
        $cc[7] = 'sachin.saxena@stellingtech.com';
        $cc[8] = 'rishi.kapoor@railyatri.in';
        $cc[9] = 'kadiyala.siva@railyatri.in';
        $cc[10] = 'rahul.kumar@railyatri.in';
        $cc[11] = 'sandeep.sharma@railyatri.in';



        $today2 = date('d/m/Y');
        $start_date2 = date("d/m/Y", strtotime($start_date));

        $to = 'arun@yatrachef.com';
        $cc2[0] = '';
        $path = Yii::app()->basePath . "/../assets/FrontEnd/weekly_report/";
        $attach[0] = "$today.csv";
        echo $x = help::Mail_Attachment($subject = "Weekly Restaurant Report($start_date2  -  $today2)", $content = $content, $to, $from = 'no-reply@yatrachef.com', $title = '', $cc, $attach, $path);
    }

    public function failure_report_weekly_09_05_2017() {

        $today = date('Y-m-d', strtotime("-1 days"));
        $start_date = date('Y-m-d', strtotime("-7 days"));
        $last_week_end = date('Y-m-d', strtotime("-8 days"));
        $last_week_start = date('Y-m-d', strtotime("-14 days"));


        $sql = "SELECT
        r.rest_name,r.id as rest_id,r.onboarded_by,r.status,
        SUM( CASE WHEN ( o.order_status='5' or o.order_status='7' or o.order_status='9' or o.order_status='10') THEN 1 ELSE 0 END )  as Processed_Orders,
        SUM( CASE WHEN o.order_status='5' THEN 1 ELSE 0 END )  `completed`,
        SUM( CASE WHEN o.order_status='7' THEN 1 ELSE 0 END ) `canceled_rest`,
        SUM( CASE WHEN o.order_status='9' THEN 1 ELSE 0 END ) `failed_rest`,
        SUM( CASE WHEN o.order_status='10' THEN 1 ELSE 0 END ) `failed_cust`,
        SUM( r1.Rating ) `rating_sum`,
        SUM( CASE WHEN (r1.Rating!='' OR  r1.Rating IS NOT NULL  )THEN 1 ELSE 0 END ) `rating_count`

        FROM tbl_order_table o
        INNER JOIN tbl_journey j
        ON o.cust_id=j.cust_id
        INNER JOIN  tbl_restaurant r
        ON r.id=o.res_id
        LEFT JOIN tbl_user_reviews r1
        ON r1.Order_id=o.id
        WHERE DATE(o.real_day_time) BETWEEN '$start_date' AND '$today'
        AND j.test_order=0
        AND ( o.order_status='5' or o.order_status='7' or o.order_status='9' or o.order_status='10' )
        AND r.railyatri_availability=1 AND r.ry_is_preferred_vendor=1
        GROUP BY  o.res_id order by Processed_Orders DESC";

        $data = help::readAll($sql);

        foreach ($data as $row) {
            $all_res_id[] = $row['rest_id'];
        }


        $sql8 = "SELECT
        r.rest_name,r.id as rest_id,r.onboarded_by,r.status,
        SUM( CASE WHEN ( o.order_status='5' or o.order_status='7' or o.order_status='9' or o.order_status='10') THEN 1 ELSE 0 END )  as Processed_Orders,
        SUM( CASE WHEN o.order_status='5' THEN 1 ELSE 0 END )  `completed`,
        SUM( CASE WHEN o.order_status='7' THEN 1 ELSE 0 END ) `canceled_rest`,
        SUM( CASE WHEN o.order_status='9' THEN 1 ELSE 0 END ) `failed_rest`,
        SUM( CASE WHEN o.order_status='10' THEN 1 ELSE 0 END ) `failed_cust`,
        SUM( r1.Rating ) `rating_sum`,
        SUM( CASE WHEN (r1.Rating!='' OR  r1.Rating IS NOT NULL  )THEN 1 ELSE 0 END ) `rating_count`

        FROM tbl_order_table o
        INNER JOIN tbl_journey j
        ON o.cust_id=j.cust_id
        INNER JOIN  tbl_restaurant r
        ON r.id=o.res_id
        LEFT JOIN tbl_user_reviews r1
        ON r1.Order_id=o.id
        WHERE j.test_order=0
        AND ( o.order_status='5' or o.order_status='7' or o.order_status='9' or o.order_status='10' )
        AND r.railyatri_availability=1 AND r.ry_is_preferred_vendor=1
        GROUP BY  o.res_id order by Processed_Orders DESC";

        $data_full = help::readAll($sql8);
        foreach ($data_full as $key => $value) {
            if (in_array($value['rest_id'], $all_res_id)) {
                $data_full[$key] = $value;
            } else {
                
            }
        }


        foreach ($data_full as $key => $value) {
            $rest_id = $value['rest_id'];
            $failed_percent = (($value['failed_rest']) / ($value['Processed_Orders']) * 100);
            $full_failed1[$rest_id] = $failed_percent;
            $full_rating1[$rest_id] = $value['rating_sum'] / $value['rating_count'];
        }

        $sql1 = "SELECT
        r.rest_name,r.id as rest_id,r.onboarded_by,r.status,
        SUM( CASE WHEN ( o.order_status='5' or o.order_status='7' or o.order_status='9' or o.order_status='10') THEN 1 ELSE 0 END )  as Processed_Orders,
        SUM( CASE WHEN o.order_status='5' THEN 1 ELSE 0 END )  `completed`,
        SUM( CASE WHEN o.order_status='7' THEN 1 ELSE 0 END ) `canceled_rest`,
        SUM( CASE WHEN o.order_status='9' THEN 1 ELSE 0 END ) `failed_rest`,
        SUM( CASE WHEN o.order_status='10' THEN 1 ELSE 0 END ) `failed_cust`,
        SUM( r1.Rating ) `rating_sum`,
        SUM( CASE WHEN (r1.Rating!='' OR  r1.Rating IS NOT NULL  )THEN 1 ELSE 0 END ) `rating_count`

        FROM tbl_order_table o
        INNER JOIN tbl_journey j
        ON o.cust_id=j.cust_id
        INNER JOIN  tbl_restaurant r
        ON r.id=o.res_id
        LEFT JOIN tbl_user_reviews r1
        ON r1.Order_id=o.id
        WHERE DATE(o.real_day_time) BETWEEN '$last_week_start' AND '$last_week_end'
        AND j.test_order=0
        AND ( o.order_status='5' or o.order_status='7' or o.order_status='9' or o.order_status='10' )
        AND r.railyatri_availability=1 AND r.ry_is_preferred_vendor=1
        GROUP BY  o.res_id order by Processed_Orders DESC";

        $data_last_week = help::readAll($sql1);

        foreach ($data_last_week as $key => $value) {
            if (in_array($value['rest_id'], $all_res_id)) {
                $data_last_week[$key] = $value;
            } else {
                
            }
        }

        foreach ($data_last_week as $key => $value) {
            $rest_id = $value['rest_id'];
            $failed_percent = (($value['failed_rest']) / ($value['Processed_Orders']) * 100);
            $last_week_failed1[$rest_id] = $failed_percent;
            $last_week_rating1[$rest_id] = $value['rating_sum'] / $value['rating_count'];
        }

        foreach ($data as $key => $value) {
            $temp_rest_id = $value['rest_id'];

            $failed_percent = (($value['failed_rest']) / ($value['Processed_Orders']) * 100);
//$failed_percent=number_format((float)$failed_percent, 2, '.', '');
            $failed_percent = round($failed_percent);
            $data[$key]['failed_percent'] = $failed_percent;

            $last_week_percent = $last_week_failed1[$temp_rest_id];
            $last_week_percent = round($last_week_percent);
//$last_week_percent=number_format((float)$last_week_percent, 2, '.', '');
//$data[$key]['failed_variation']=$last_week_percent-$failed_percent;
            $data[$key]['failed_percent_last_week'] = $last_week_percent;

            $full_failed = $full_failed1[$temp_rest_id];
            $full_failed = round($full_failed);
//$full_failed=number_format((float)$full_failed, 2, '.', '');
            $data[$key]['failed_percent_full'] = $full_failed;

            $rating = $value['rating_sum'] / $value['rating_count'];
            if ($rating != '') {
                $rating = number_format((float) $rating, 1, '.', '');
            }
            $data[$key]['rating'] = $rating;

            $last_week_rating = $last_week_rating1[$temp_rest_id];
            if ($last_week_rating != '') {
                $last_week_rating = number_format((float) $last_week_rating, 1, '.', '');
            }
//           $data[$key]['rating_variation']=$last_week_rating-$rating;
            $data[$key]['last_week_rating'] = $last_week_rating;

            $full_rating = $full_rating1[$temp_rest_id];
            if ($full_rating != '') {
                $full_rating = number_format((float) $full_rating, 1, '.', '');
            }
            $data[$key]['full_rating'] = $full_rating;
        }


        foreach ($data as $key => $value) {
            $temp_rest_id = $value['rest_id'];

            $failed_percent = (($value['failed_rest']) / ($value['Processed_Orders']) * 100);
            $failed_percent = number_format((float) $failed_percent, 1, '.', '');
//            $failed_percent=  round($failed_percent);
            $data[$key]['failed_percent_csv'] = $failed_percent;

            $last_week_percent = $last_week_failed1[$temp_rest_id];
//            $last_week_percent=  round($last_week_percent);
            $last_week_percent = number_format((float) $last_week_percent, 1, '.', '');
//$data[$key]['failed_variation']=$last_week_percent-$failed_percent;
            $data[$key]['failed_percent_last_week_csv'] = $last_week_percent;

            $full_failed = $full_failed1[$temp_rest_id];
//            $full_failed=  round($full_failed);
            $full_failed = number_format((float) $full_failed, 1, '.', '');
            $data[$key]['failed_percent_full_csv'] = $full_failed;

            $rating = $value['rating_sum'] / $value['rating_count'];
            if ($rating != '') {
                $rating = number_format((float) $rating, 1, '.', '');
            }
            $data[$key]['rating'] = $rating;

            $last_week_rating = $last_week_rating1[$temp_rest_id];
            if ($last_week_rating != '') {
                $last_week_rating = number_format((float) $last_week_rating, 1, '.', '');
            }
//           $data[$key]['rating_variation']=$last_week_rating-$rating;
            $data[$key]['last_week_rating'] = $last_week_rating;

            $full_rating = $full_rating1[$temp_rest_id];
            if ($full_rating != '') {
                $full_rating = number_format((float) $full_rating, 1, '.', '');
            }
            $data[$key]['full_rating'] = $full_rating;
        }

        foreach ($data as $key => $subArr) {
//            unset($subArr['rest_id']);
            unset($subArr['rating_count']);
            unset($subArr['rating_sum']);
            $data[$key] = $subArr;
        }


        $content = '<div style="margin-bottom: 11px;
                margin-left: 67px;
                font-family: sans-serif;
                font-size: 15px;">
                </div>';
        $content .= '
                <table class="table table-bordered" width="650px" border="1" cellspacing="2" style="margin-bottom: 0px;">
                <tbody>
                <tr>
                <td colspan="" style="text-align: center;background: gray;color: white;">Rest name</td>
                <td colspan="" style="text-align: center;background: gray;color: white;">Processed Orders</td>
                <td colspan="" style="text-align: center;background: gray;color: white;">Completed</td>
                <td colspan="" style="text-align: center;background: gray;color: white;">Canceled rest</td>
                <td colspan="" style="text-align: center;background: gray;color: white;">Failed rest </td>
                <td colspan="" style="text-align: center;background: gray;color: white;">Failed last week %</td>
                <td colspan="" style="text-align: center;background: gray;color: white;">Failed two week ago %</td>
                <td colspan="" style="text-align: center;background: gray;color: white;">Failed overall %</td>
                <td colspan="" style="text-align: center;background: gray;color: white;">Rating last week</td>
                <td colspan="" style="text-align: center;background: gray;color: white;">Rating two week ago </td>
                <td colspan="" style="text-align: center;background: gray;color: white;">Overall rating</td>
                <td colspan="" style="text-align: center;background: gray;color: white;">Failed cust</td>
                <td colspan="" style="text-align: center;background: gray;color: white;">Onboarded By</td>
                <td colspan="" style="text-align: center;background: gray;color: white;">Status</td>
                </tr>';

        foreach ($data as $row) {
            $row['failed_percent'] = $row['failed_percent'] . '%';
            $row['failed_percent_last_week'] = $row['failed_percent_last_week'] . '%';
            $row['failed_percent_full'] = $row['failed_percent_full'] . '%';
            if ($row['status'] == 1) {
                $row['status'] = 'Active';
                $colour = 'color: green;';
            } else {
                $row['status'] = 'Inactive';
                $colour = 'color: red;';
            }

            $content .= '<tr>
                <td style="text-align: center;">' . $row['rest_name'] . '</td>
                <td style="text-align: center;">' . $row['Processed_Orders'] . '</td>
                <td style="text-align: center;">' . $row['completed'] . '</td>
                <td style="text-align: center;">' . $row['canceled_rest'] . '</td>
                <td style="text-align: justify;">' . $row['failed_rest'] . '</td>
                <td style="text-align: center;">' . $row['failed_percent'] . '</td>
                <td style="text-align: center;">' . $row['failed_percent_last_week'] . '</td>
                <td style="text-align: center;">' . $row['failed_percent_full'] . '</td>
                <td style="text-align: center;">' . $row['rating'] . '</td>
                <td style="text-align: justify;">' . $row['last_week_rating'] . '</td>
                <td style="text-align: center;">' . $row['full_rating'] . '</td>
                <td style="text-align: justify;">' . $row['failed_cust'] . '</td>
                <td style="text-align: justify;">' . $row['onboarded_by'] . '</td>
                <td style="text-align: justify;' . $colour . '">' . $row['status'] . '</td>
                </tr> ';
        }

        foreach ($data as $key => $subArr) {
            $data2[$key]['rest_name'] = $data[$key]['rest_name'];
            $r_temp_id = $data[$key]['rest_id'];
            $data2[$key]['station_name'] = help::getscalar("SELECT s.station_name FROM tbl_restaurant r
INNER JOIN tbl_stations s ON s.id=r.station_id
WHERE r.id='$r_temp_id'");
            $data2[$key]['Processed_Orders'] = $data[$key]['Processed_Orders'];
            $data2[$key]['completed'] = $data[$key]['completed'];
            $data2[$key]['canceled_rest'] = $data[$key]['canceled_rest'];
            $data2[$key]['failed_rest'] = $data[$key]['failed_rest'];
            $data2[$key]['failed_percent_csv'] = $data[$key]['failed_percent_csv'];
            $data2[$key]['failed_percent_last_week_csv'] = $data[$key]['failed_percent_last_week_csv'];
            $data2[$key]['failed_percent_full_csv'] = $data[$key]['failed_percent_full_csv'];
            $data2[$key]['rating'] = $data[$key]['rating'];
            $data2[$key]['last_week_rating'] = $data[$key]['last_week_rating'];
            $data2[$key]['full_rating'] = $data[$key]['full_rating'];
            $data2[$key]['failed_cust'] = $data[$key]['failed_cust'];
            $data2[$key]['onboarded_by'] = $data[$key]['onboarded_by'];
            if ($data[$key]['status'] == 1) {
                $data[$key]['status'] = 'Active';
            } else {
                $data[$key]['status'] = 'Inactive';
            }
            $data2[$key]['status'] = $data[$key]['status'];

//                unset($subArr['failed_percent']);
//                unset($subArr['failed_percent_last_week']);
//                unset($subArr['failed_percent_full']);
//                $data[$key] = $subArr;
        }


        $heading = Array('rest_name' => 'rest_name', 'station_name' => 'Station Name', 'Processed_Orders' => 'Processed_Orders', 'completed' => 'completed', 'canceled_rest' => 'canceled_rest', 'failed_rest' => 'failed_rest', 'failed_percent_last_week' => 'failed_percent_last_week', 'failed_percent_two_week_ago' => 'failed_percent_two_week_ago', 'failed_percent_overall' => 'failed_percent_overall', 'rating_last_week' => 'rating_last_week', 'rating_two_week_ago' => 'rating_two_week_ago', 'overall_rating' => 'overall_rating', 'failed_cust' => 'failed_cust', 'onboarded_by' => 'onboarded_by', 'Status' => 'Status');
        $rest_data[0] = implode('#@#', $heading);

        foreach ($data2 as $row) {
            $rest_data[] = implode('#@#', $row);
        }

        $today = date('d-m-Y');
        $today = $today . '-Weekly_Failure_Report';
//        $file = fopen("$today.csv", "w");
        $path = Yii::app()->basePath . "/../assets/FrontEnd/weekly_report/$today.csv";
        $file = fopen($path, 'w');

        foreach ($rest_data as $line) {
            fputcsv($file, explode('#@#', $line));
        }
        fclose($file);
        $cc[0] = 'anoob.cr@yatrachef.com';
        $cc[1] = 'rameez@yatrachef.com';
        $cc[2] = 'kapil.raizada@stellingtech.com';
        $cc[3] = 'manish.rathi@stellingtech.com';
        $cc[4] = 'rishi.kapoor@railyatri.in';
//        $cc[4] = 'vivek.singh@railyatri.in';
//        $cc[5] = 'thasneem.h@yatrachef.com';

        $to = 'arun@yatrachef.com';
//        $to2 = 'thasneem.h@yatrachef.com';
        $cc2[0] = '';
        $path = Yii::app()->basePath . "/../assets/FrontEnd/weekly_report/";
        $attach[0] = "$today.csv";

        $x = help::Mail_Attachment($subject = 'Weekly Failure Report', $content = $content, $to, $from = 'no-reply@yatrachef.com', $title = '', $cc, $attach, $path);
//        $x2 = help::Mail_Attachment($subject = 'Weekly Failure Report', $content = $content, $to2, $from = 'no-reply@yatrachef.com', $title = '', $cc2, $attach, $path);
    }

    public function actionReviewMailer() { //change in helpdesk (feedback queue),Queue controller have changes
//feedbackl status chaged or not
//          $response = OrderController::ReviewMailSend(436263);;die;
        $current_time = date('H:i');
        if ((strtotime($current_time) >= strtotime('07:00')) && (strtotime($current_time) <= strtotime('22:00'))) {
            $now = date('Y-m-d H:i:00');
            echo $now . '<br>';
            $str_now = strtotime($now);
            $c30_time = date('Y-m-d H:i:00', strtotime(' +30 minutes', $str_now));
            $str_c30_time = strtotime($c30_time);

            $sql = "SELECT o.cust_id,o.cust_uid,o.order_status,o.id,order_type,o.ordered_from,o.order_method,DATE(o.real_day_time) as del_date ,o.payment_type
FROM tbl_order_table o 
WHERE o.order_status='5' AND (DATE(o.real_day_time)= DATE_ADD(CURDATE(), INTERVAL -1 DAY) OR DATE(o.real_day_time)=CURDATE()) 
          AND o.id NOT IN (SELECT Order_Id FROM `tbl_user_review_details`)";

//        echo '<pre>';
            $data = Help::readAll($sql);
            echo 'Total COUNT : ' . $countx = count($data) . '<br>';
            $review_failed = array();
            foreach ($data as $row) {
                $oid = $row['id'];
                $sql1 = "SELECT t.event_time FROM tbl_tagging t WHERE t.order_id='$oid' AND (t.message LIKE '%Food Deliverd Status Changed and order completed%' OR t.events='Delivered To Customer') AND t.category!=1 ORDER BY event_time DESC limit 1";
                $tagging_time = Help::getscalar($sql1);
                if ($tagging_time != NULL) {
                    $dtime = $tagging_time;
                }
//            die;

                $str_dtime = strtotime($dtime);
                $int_time = date('Y-m-d H:i:00', strtotime(' +30 minutes', $str_dtime));
                echo $oid . '-----' . $dtime . '------' . $int_time . ' ---' . $row['ordered_from'];
                $str_int_time = strtotime($int_time);

//            if (($str_now <= $str_int_time) && ($str_c30_time >= $str_int_time)) {
                if (($row['order_type'] == 6) && ($row['ordered_from'] == 'RY Android') && (isset($dtime))) {
                    $url = 'http://notification.railyatri.in/qgraph/api/feedback/' . $oid;
                    $responce = $this->CurlTimeout($url, 35000);
                    $responce = json_decode($responce);
                    if (isset($responce->status[0]->success)) {
                        $success = $responce->status[0]->success;
                    } else {
                        $success = 0;
                    }
                    $failed0 = 0;
                    if (isset($responce->failure)) {
                        $failed0 = $responce->failure;
                    }
                    $sql = "INSERT INTO `tbl_foodLyfCycle_notification`( `order_id`, `success`, `failure`, `type`) VALUES ('$oid','$success','$failed0','5')";
                    Help::execute($sql);
                    $sql = "INSERT INTO `tbl_user_review_details`(`Mail_Send`,`Order_Id`, `Cust_Uid`, `DateTime`,`Type`) VALUES ('1','$oid','$row[cust_uid]','$now','2')";
                    if (Help::execute($sql)) {
                        echo 'updated S NOTIFICATION';
                    } else {
                        echo 'updated F';
                    }
                } else {
                    $response = OrderController::ReviewMailSend($oid);
                    if ($response == 1) {
                        echo '   <b>SUCCESS  MAIL ' . $row['order_type'] . '    ' . $row['ordered_from'] . '</b> ' . $url;
                    } else {
                        $review_failed[] = $oid;
                    }
                }
//            } else {
//                echo '   false';
//            }

                echo '<br>';
                if ($row['payment_type'] == 'cod') {
                    if ((help::getscalar("SELECT count(*) as count FROM tbl_order_table WHERE cust_id=" . $row['cust_id'])) == 1) {
                        $params['process_name'] = 'Paid bill send after order delivery for cod';
                        $params['url'] = 'https://cc.yatrachef.com/index.php/url2/bill/cust_id/' . $row['cust_id'] . '/mode/1/paid_bill/1/sms/0';
                        $params['interval'] = '1';
                        $params['process_start'] = '07:00:00';
                        $params['process_end'] = '22:00:00';
                        $params['process_type'] = '1';
                        $params['status'] = '1';
                        $params['relation_id'] = $row['cust_id'];
//                        $response = CMF::create_process($params);
                    }
                }
            }
        } else {
            echo 'cron off';
        }
//        $cc[0] = '';
//        $temp[0] = '';
//        Help::Mail_Bulk('Customer Review Cron Executed', 'COUNT ' . $countx, 'akhil.tm@yatrachef.com', $from = 'no-reply@yatrachef.com', $title = '', $cc, $text = 0);
    }

    public function CurlTimeout($url, $timeout) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//  curl_setopt($ch,CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, $timeout);
        $output = curl_exec($ch);

        curl_close($ch);
        return $output;
    }

    public function actionmenu_order_mail() {

        $one_hour_before = date('Y-m-d H:i:s', strtotime('-1 hour'));

        $sql = "select o.id,o2.menu_id from tbl_order_table o
        inner join tbl_order_table2 o2
        on o.id=o2.order_id
        WHERE o.ordering_time >'$one_hour_before'
        AND o.order_status<>11 AND o.order_status<>12 AND o2.menu_id
        BETWEEN  '27802'
        AND '27826'";



        $r = help::readAll($sql);
        if ($r != NULL) {
            $content = '<div style="margin-bottom: 11px;
                    margin-left: 67px;
                    font-family: sans-serif;
                    font-size: 15px;">
                    </div>';

            $content .= '<table class="table table-bordered" width="650px" border="1" cellspacing="2" style="margin-bottom: 0px;">
                    <tbody>
                    <tr>
                    <td colspan="" style="text-align: center;background: gray;color: white;">Order Id</td>
                    <td colspan="" style="text-align: center;background: gray;color: white;">Menu ID</td>
                    </tr>';

            foreach ($r as $row) {
                $content .= '<tr>
                    <td style="text-align: center;">' . $row['id'] . '</td>
                    <td style="text-align: center;">' . $row['menu_id'] . '</td>
                    </tr> ';
            }

            $cc[0] = 'anoob.cr@yatrachef.com';

            $to = 'arun@yatrachef.com';
            $subject = 'Order Alert (Menu id btw 27802 AND 27826)';
            $bcc[0] = 'thasneem.h@yatrachef.com';
            $text = strip_tags($content);

            $x = help::Mail_Bulk($subject, $content, $to, $from = 'no-reply@yatrachef.com', $title = '', $cc, $text = 0, $bcc);

            print_r($x);
        } else {
            echo 'no order';
        }
    }

    public function actioncod_in_payment_table() {
        $day = date('Y-m-d ');
        $sql = "select cust_id,id,ordering_person from tbl_order_table where payment_type='cod' and DATE(ordering_time)='$day'";
        $r = help::readAll($sql);
        foreach ($r as $row) {
            $cust_id = $row['cust_id'];
            $sql2 = "SELECT `id`,t_time,transaction_id,transaction_status FROM `tbl_payment` WHERE `cust_id`='$cust_id' and transaction_status='SUCCESS'";
            $r2 = help::read($sql2);
            if ($r2 != '') {
                $sql3 = "SELECT id FROM `tbl_order_table` WHERE payment_type LIKE '%Online_Payment%' and cust_id='$cust_id'";
                $r3 = help::readAll($sql3);
                if ($r3 == NULL) {
                    $r = help::readAll($sql);

                    if ($r != NULL) {
                        $o_id = $row['id'];
                        $result[$o_id]['id'] = $row['id'];
                        $result[$o_id]['cust_id'] = $cust_id;
                        $result[$o_id]['transaction_id'] = $r2['transaction_id'];
                        $result[$o_id]['t_time'] = $r2['t_time'];
                        $result[$o_id]['transaction_status'] = $r2['transaction_status'];
                    }
                }
            }
        }
        if ($result != NULL) {

            $content = '<div style="margin-bottom: 11px;
        margin-left: 67px;
        font-family: sans-serif;
        font-size: 15px;">
        </div>';

            $content .= '<table class="table table-bordered" width="650px" border="1" cellspacing="2" style="margin-bottom: 0px;">
        <tbody>
        <tr>
        <td colspan="" style="text-align: center;background: gray;color: white;">Order Id</td>
        <td colspan="" style="text-align: center;background: gray;color: white;">Bill ID</td>
        <td colspan="" style="text-align: center;background: gray;color: white;">Transaction ID</td>
        <td colspan="" style="text-align: center;background: gray;color: white;">Transaction Time</td>
        <td colspan="" style="text-align: center;background: gray;color: white;">Transaction Status</td>
        </tr>';


            foreach ($result as $row) {
                $content .= '<tr>
        <td style="text-align: center;">' . $row['id'] . '</td>
        <td style="text-align: center;">' . $row['cust_id'] . '</td>
        <td style="text-align: center;">' . $row['transaction_id'] . '</td>
        <td style="text-align: center;">' . $row['t_time'] . '</td>
        <td style="text-align: center;">' . $row['transaction_status'] . '</td>
        </tr> ';
            }

            $cc[0] = 'akhil.tm@yatrachef.com';
            $to = 'akhil.tm@yatrachef.com';
            $subject = 'Order Alert (COD order in tbl_payment)';
            $bcc[0] = '';

            $text = strip_tags($content);
            $x = help::Mail_Bulk($subject, $content, $to, $from = 'no-reply@yatrachef.com', $title = '', $cc, $text = 0, $bcc);

            print_r($content);
        }
    }

    public function actiondaily_used_coupons($test = NULL) {
        if ($test == NULL) {
            $day = date('Y-m-d', strtotime(' -1 day'));
        } else {
            $day = date('Y-m-d');
        }
        $content = '<div style="margin-bottom: 11px;
                    margin-left: 67px;
                    font-family: sans-serif;
                    font-size: 15px;">
                    </div>';
//        --------------------------------------------

        $sql = "select c.coupon_code,ROUND(sum(discounted) ,2) as total_discount,count(j.coupon) as order_count ,ROUND(sum(o.present_total) ,2) as gmv from tbl_journey j
                    INNER JOIN tbl_order_table o on j.cust_id=o.cust_id
                    INNER JOIN tbl_coupons c on c.id=j.coupon
                    where DATE(o.ordering_time)='$day'
                    and j.test_order=0 AND o.order_status <> '11' AND o.order_status <> '12' 
                    group by j.coupon ORDER BY order_count DESC";
//AND o.discounted!=0 AND c.id=coupon
        $coupon_data = help::readAll($sql);

        $total_dic = 0;
        $total_count = 0;
        $total_gmv = 0;
        foreach ($coupon_data as $row) {
            $total_dic += $row['total_discount'];
            $total_count += $row['order_count'];

            $row['disc_avg'] = round(($total_dic / $total_count), 1);

            $row['coupon_consuption'] = round((($row['total_discount'] / $row['order_count'])), 1);  // round((($total_dic / $total_gmv) * 100), 1);

            $row['gmv_dvalue'] = round((($row['total_discount'] / $row['gmv']) * 100), 0);
            $FINAL[] = $row;
        }


        $x['coupon_code'] = '<b>Total</b>';
        $x['total_discount'] = '<b>' . $total_dic . '</b>';
        $x['order_count'] = '<b>' . $total_count . '</b>';
        $x['coupon_consuption'] = '';
        $x['gmv_dvalue'] = '';
        $FINAL[] = $x;

//        echo '<pre>';
//        print_r($FINAL);
//        echo '</pre>';

        $content .= '
                <table class="table table-bordered" width="850px" border="1" cellspacing="2" style="margin-bottom: 0px;">
                    <tbody>
                    <tr>
                    <td colspan="" style="text-align: center;background: gray;color: white;">Coupon Code</td>
                    <td colspan="" style="text-align: center;background: gray;color: white;">Total Discount</td>
                    <td colspan="" style="text-align: center;background: gray;color: white;">Order Count</td>
                    <td colspan="" style="text-align: center;background: gray;color: white;">Consumption Value</td>
                    <td colspan="" style="text-align: center;background: gray;color: white;">DISC/GMV</td>
                    </tr>';
//        $total_dic = $total_count = 0;
        foreach ($FINAL as $row1) {
            if ($row1['gmv_dvalue'] != '') {
                $content .= '<tr >
                    <td style="text-align: center;">' . $row1['coupon_code'] . '</td>
                    <td style="text-align: center;">' . $row1['total_discount'] . '</td>
                    <td style="text-align: center;">' . $row1['order_count'] . '</td>
                    <td style="text-align: center;">' . $row1['coupon_consuption'] . '</td>
                    <td style="text-align: center;">' . $row1['gmv_dvalue'] . '%      ( <small>' . $row1['total_discount'] . ' / ' . $row1['gmv'] . ' </small>)</td>
                    </tr> ';
//            $total_dic += $row['total_discount'];
//            $total_count += $row['order_count'];
            }
        }


        $content .= '<tr style="    background: #e8d0a4;">
                   <td style="text-align: center;">Total</td>
                    <td style="text-align: center;">' . $row1['total_discount'] . '</td>
                    <td style="text-align: center;">' . $row1['order_count'] . '</td>
                       <td colspan="2"></td>
                    </tr>  </tbody> </table><br><br><br>';



//            print_r($FINAL);
//            die;
//        -------------------------------------------
//        $sql = "select j.coupon,c.coupon_code,ROUND(sum(discounted) ,2) as total_discount,count(j.coupon) as order_count from tbl_journey j
//                    INNER JOIN tbl_order_table o on j.cust_id=o.cust_id
//                    INNER JOIN tbl_coupons c on c.id=j.coupon
//                    where DATE(o.ordering_time)='$day'
//                    and (o.order_status=1 or o.order_status=5) and j.test_order=0
//                    group by j.coupon ";
//
//        $r = help::readAll($sql);



        $content_old_one = 'Old Report <br><table class="table table-bordered" width="650px" border="1" cellspacing="2" style="margin-bottom: 0px;">
                    <tbody>
                    <tr>
                    <td colspan="" style="text-align: center;background: gray;color: white;">Coupon Code</td>
                    <td colspan="" style="text-align: center;background: gray;color: white;">Total Discount</td>
                    <td colspan="" style="text-align: center;background: gray;color: white;">Order Count</td>
                    </tr>';
        $total_dic = $total_count = 0;
        foreach ($coupon_data as $row) {
            $content_old_one .= '<tr >
                    <td style="text-align: center;">' . $row['coupon_code'] . '</td>
                    <td style="text-align: center;">' . $row['total_discount'] . '</td>
                    <td style="text-align: center;">' . $row['order_count'] . '</td>
                    </tr> ';
            $total_dic += $row['total_discount'];
            $total_count += $row['order_count'];
        }
        $content_old_one .= '<tr style="    background: #e8d0a4;">
                    <td style="text-align: center;">Total</td>
                    <td style="text-align: center;">' . $total_dic . '</td>
                    <td style="text-align: center;">' . $total_count . '</td>
                    </tr>  </tbody> </table>';



//        echo $content;
//        die;
        if ($test == NULL) {
            $cc[1] = 'raghu.n@yatrachef.com';
            $cc[0] = 'rameez@yatrachef.com';
            $cc[2] = 'anoob.cr@yatrachef.com';
            $cc[3] = 'akhil.tm@yatrachef.com';
            $to = 'arun@yatrachef.com';
            $subject = 'Coupon Details(' . $day . ')';
            $bcc[0] = '';
            $text = strip_tags($content);
            $x = help::Mail_Bulk($subject, $content, $to, $from = 'no-reply@yatrachef.com', $title = '', $cc, $text = 0, $bcc);
        } else {
            echo $content;
        }
    }

    public function actionCoupon_new($from = '', $to = '') {
//        $q1_ch = str_replace('o.real_day_time', 'o.ordering_time', $q1);
        $sql = "select c.coupon_code,ROUND(sum(discounted) ,2) as total_discount,count(j.coupon) as order_count ,ROUND(sum(o.present_total) ,2) as gmv from tbl_journey j
                    INNER JOIN tbl_order_table o on j.cust_id=o.cust_id
                    INNER JOIN tbl_coupons c on c.id=j.coupon
                    where (DATE(o.ordering_time) BETWEEN '$from' AND '$to')
                    and j.test_order=0 AND o.order_status <> '11' AND o.order_status <> '12'  
                    group by j.coupon ORDER BY order_count DESC";
        $coupon_data = help::readAll($sql);

        $total_dic = 0;
        $total_count = 0;
        $total_gmv = 0;
        foreach ($coupon_data as $row) {
            $total_dic += $row['total_discount'];
            $total_count += $row['order_count'];

            $row['disc_avg'] = round(($total_dic / $total_count), 1);

            $row['coupon_consuption'] = round((($row['total_discount'] / $row['order_count'])), 1);  // round((($total_dic / $total_gmv) * 100), 1);

            $row['gmv_dvalue'] = round((($row['total_discount'] / $row['gmv']) * 100), 0);
            $FINAL[] = $row;
        }

//        echo '<pre>';
//        print_r($FINAL);
        $html = '<table  style="width: 99%;" border="1">
                                    <thead>
                                        <tr >
                                            <th>Coupon Code</th>
                                            <th>Total Discount</th>
                                            <th>Order Count</th>
                                            <th>Consumption Value</th>
                                             <th>GMV</th>
                                            <th>DISC/GMV</th>
                                        </tr>
                                    </thead>
                                    <tbody id="coupon_details">';
        foreach ($FINAL as $rw) {
            $html .= ' <tr >
            <td>' . $rw['coupon_code'] . '</td>
            <td>' . $rw['total_discount'] . '</td>
            <td>' . $rw['order_count'] . '</td>
            <td>' . $rw['coupon_consuption'] . '</td>
            <td>' . $rw['gmv'] . '</td>
            <td>' . $rw['gmv_dvalue'] . ' &nbsp;%</td>
            </tr >';
        }

        $html .= '</tbody> </table>';


        echo $html;
//
//        $x['coupon_code'] = '<b>Total</b>';
//        $x['total_discount'] = '<b>' . $total_dic . '</b>';
//        $x['order_count'] = '<b>' . $total_count . '</b>';
//        $x['coupon_consuption'] = '';
//        $x['gmv_dvalue'] = '';
//        $FINAL[] = $x;
    }

//-----------------------------------------LIVE STATUS MODULES---------------------------------------------------------------------------------------------------
    public function actionFirstETAcheck() {//find ETA for yesterday orders
        $current_time = date('H:i');
        if ((strtotime($current_time) >= strtotime('05:00')) && (strtotime($current_time) <= strtotime('23:00'))) {
            echo '<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />';
            $path = dirname(dirname(__FILE__)) . '/../assets/scrap/liveStatus_ry.php';
            include($path);
            $Livestatus = new Livestatus();
            ini_set('max_execution_time', 150);
            $sql = "SELECT o.ordering_time,o.eta_last_updated,o.DelayUpdate,o.our_exp_time,o.real_day_time,o.train_status,j.train_no,s.station_code,o.id,o.expected_arrival,o.trainDelay,o.distance,o.last_updated
            FROM tbl_order_table o
             INNER JOIN tbl_journey j ON j.cust_id=o.cust_id
            INNER JOIN tbl_stations s ON s.id=o.station
            WHERE o.order_status =  '1' AND o.orderPassedRest =0 AND o.orderConfirmRest =0
            AND DATE(o.ordering_time )=CURDATE()  AND DATE(o.real_day_time)=CURDATE() - INTERVAL 1 DAY"; // o.id=111025
            $data = help::readAll($sql);
            if ($data != NULL) {
//            echo '<pre>';
//            print_r($data);
//        die;
                foreach ($data as $row) {
                    $oid = $row['id'];
                    $delivery_date = date("d-m-Y", strtotime($row['real_day_time']));
                    $ordering_time = $row['ordering_time'];
                    $train = $row['train_no'];
                    $trCount = strlen($train);
                    if ($trCount == 4) {
                        $train = '0' . $train;
                    } else if ($trCount == 3) {
                        $train = '00' . $train;
                    }
                    $code = $row['station_code'];
//                echo $train . '- ' . $code . '--oid ' . $oid . ' ' . $delivery_date . ' <br>';
//                    -------------------------------------------------------------------------
                    $result = $this->FindLivestatus($Livestatus, $train, $code, $dayType = 0, $oid, $row['real_day_time'], $row['expected_arrival'], $row['our_exp_time'], $row['distance'], $row['last_updated']);
//                print_r($result);
                    if (($result->RESPONSE_CODE == 200) && ($result->JDATE == $delivery_date)) {
                        $now_exact = date('Y-m-d H:i:s');
                        if ($status == 1) {
                            $result->LAST_UPDT = $now_exact;
                        } //$result->TRAIN_STATUS
                        $sql = "call UPDATE_ALL('$result->EXP_ARVL','$result->DELAY','$result->DISTANCE','$result->LAST_UPDT','0','$result->ARIVAL_TYPE','$result->DELAY_UPDT','$result->OUR_EXP_TIME','$result->ORDER_ID',1,'$now_exact')";
                        if (help::execute($sql)) {
                            $Last_ETA = help::getscalar("SELECT ETA FROM `tbl_eta_history` WHERE Order_Id='$result->ORDER_ID' ORDER BY created_at DESC limit 1");
                            if (strtotime($Last_ETA) != strtotime($result->EXP_ARVL)) {
                                $sql1 = "INSERT INTO `tbl_eta_history`(`Station`,`Order_Id`, `STA`, `ETA`, `Delay`, `Last_Location`, `Last_Updation`, `Train`, `Created_At`) "
                                        . " VALUES ('$code','$result->ORDER_ID','$row[real_day_time]','$result->EXP_ARVL','$result->DELAY','$result->DELAY_UPDT','$result->LAST_UPDT','$train','$now_exact')";
                                help::execute($sql1);
                            }
                            echo '<br>Updated->' . $result->ORDER_ID . '-<br>';
                        } else {
                            echo '<br>failed->' . $result->ORDER_ID . '-<br>';
                        }
//                        --------------------------------------------------------
                        $cc[0] = '';
                        $to = 'akhil.tm@yatrachef.com';
                        $subject = 'FIND ETA FOR YESTERDAY ORDERS #' . $result->ORDER_ID;
                        $bcc[0] = '';
                        $content = 'sql=> ' . $sql;
                        $text = strip_tags($content);
                        $x = help::Mail_Bulk($subject, $content, $to, $from = 'no-reply@yatrachef.com', $title = '', $cc, $text = 0, $bcc);
//                        --------------------------------------------------------
                    }
                }
            }
        } else {
            echo 'cron off at this time';
        }
    }

    public static function FindLivestatus($Livestatus = NULL, $train = NULL, $code = NULL, $dayType = 1, $order_id = NULL, $STA = NULL, $ETA = NULL, $OTA = NULL, $DISTANCE = NULL, $LAST_UPDT = NULL) {
//        echo '<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />';
//        $path = dirname(dirname(__FILE__)) . '/../assets/scrap/liveStatus_ry.php';
//        include($path);
//        $Livestatus = new Livestatus();
//        $result = $Livestatus->fetch($train, $code, $dayType);
//        
        $result = $Livestatus->ryapi($train, $code, $dayType);

        if ($result->response_code != 200) {
            $result = $Livestatus->fetch($train, $code, $dayType);
        }
//        echo '<pre>';
//        print_r($result);
        if ((($result->response_code != 200) || $result->response_code == 200) && ($result->exp_arrival == 0) && ($result->sch_arrival == 0) && ($result->date == 0)) {
            $response = array('RESPONSE_CODE' => 400);
            $response = (object) $response;
            return $response;
        }
        if (isset($result->sch_departure)) {
            $result->sch_departure = strip_tags($result->sch_departure);
            $result->sch_departure = str_replace("* blink('0');", ' ', $result->sch_departure);
            @$sch_dept = explode('-', $result->sch_departure);
            @$year100 = explode('-', $result->date);
            @$year100 = @$year100[2]; //3
            @$year100 = str_replace(' ', '', $year100);
            @$date100 = $sch_dept[0];
            @$date100 = trim($date100, ' ');
            @$zz = explode(' ', $sch_dept[1]);
            @$tim = $zz[1];
            @$month100 = $zz[0];
//          @$month5 = date('m', strtotime($month5));
            $date100 = preg_replace('/\s+/', ' ', $date100);
            $date100 = str_replace(' ', '', $date100);
            @$sch_dept = $date100 . '-' . $month100 . '-' . $year100 . ' ' . $tim;
            $result->sch_departure = date("d-m-Y H:i:s", strtotime($sch_dept));
        } else {
            $result->sch_departure = 0;
        }
        $result->exp_arrival = preg_replace('/\s+/', ' ', $result->exp_arrival);
        if ($result->sch_arrival) {
            @$act_arr = explode('-', $result->sch_arrival);
            @$year6 = explode('-', $result->date);
            @$year5 = $year6[2]; //3
            @$year5 = str_replace(' ', '', @$year5);
            @$date5 = $act_arr[0];
            @$date5 = trim($date5, ' ');
            @$zz = explode(' ', $act_arr[1]);
            @$tim = $zz[1];
            @$month5 = $zz[0];
//          @$month5 = date('m', strtotime($month5));
            $date5 = preg_replace('/\s+/', ' ', $date5);
            $date5 = str_replace(' ', '', $date5);
            @$apiDate = $date5 . '-' . $month5 . '-' . $year5;
            @$apiDate = date("d-m-Y", strtotime($apiDate));
            @$apiDate2 = $year5 . '-' . $month5 . '-' . $date5 . ' ' . $tim;
            if (isset($result->source)) {
                $apiDate = date('d-m-Y', strtotime($result->sch_arrival));
                $apiDate2 = date('Y-m-d H:i:s', strtotime($result->sch_arrival));
            }
            if ((strpos($date5, 'Train Source') !== false) || (strpos($date5, 'TrainSource') !== false) || (strpos($result->act_arrival, 'Source') !== false)) {
                @$deliveryX = explode(' ', $STA);
                @$apiDate = date("d-m-Y", strtotime($deliveryX[0]));
                @$apiDate2 = $STA;
                if ((isset($result->sch_departure)) && ($result->sch_departure != 0)) {
                    @$deliveryX1 = explode(' ', $result->sch_departure);
                    @$apiDate = date("d-m-Y", strtotime($deliveryX1[0]));
                    @$apiDate2 = $result->sch_departure;
                }
            }
        } else {
            $apiDate = 0;
        }

        if ($result->exp_arrival == '0') { //act arrival
            @$arrival_type = 1; //act
            @$expected_arrival = 0;
            if ((strpos($result->act_arrival, 'Train Source') !== false) || (strpos($result->act_arrival, 'Source') !== false)) {
                $actual_arrival = $apiDate2;
            } else { //when date and time showing
                @$sexp = explode(' ', $result->act_arrival);
                @$act_arr = explode('-', $result->act_arrival);
                @$time = $sexp[2];
                @$year = explode('-', $result->date);
                @$year = $year[2]; //3
                @$year = str_replace(' ', '', @$year);
                @$date = $act_arr[0];
                @$month = $act_arr[1];
                $month2Spl2 = explode(' ', $month);
                @$month = date('m', strtotime($month2Spl2[0]));
                $date = preg_replace('/\s+/', ' ', $date);
                $date = str_replace(' ', '', $date);
                @$actual_arrival = $year . '-' . $month . '-' . $date . ' ' . $time;
                if ((isset($result->source)) && ($result->act_arrival != 0)) {
                    $actual_arrival = date('Y-m-d H:i:s', strtotime($result->act_arrival));
                }
            }
        } else { //exp arrival
            $arrival_type = 2; //exp arrival
            $actual_arrival = 0;
            if (strpos($result->exp_arrival, 'blink') !== false) {
                $evalue = explode('blink', $result->exp_arrival);
                $result->exp_arrival = $evalue[0]; //problem waiting for update
            }
            if (strpos($result->exp_arrival, 'Waiting for update') !== false) {

                if ($ETA == 0) {
                    $expected_arrival = $STA;
                } else {
                    $expected_arrival = $ETA;
                }
            } else {

                if (strpos($result->exp_arrival, 'blink') !== false) {
                    @$evalue = explode('blink', $result->exp_arrival);

                    @$year2 = explode('-', $result->date);
                    @$year2 = $year2[2]; //3
                    @$year2 = str_replace(' ', '', @$year2);


                    @$sexp2 = explode(' ', $result->exp_arrival);
                    @$ext_arr = explode('-', $sexp2[1]);
                    @$time2 = $sexp2[2];

                    @$date2 = $ext_arr[0];
                    @$month2 = $ext_arr[1];
                    $month2Spl1 = explode(' ', $month2);
                    @$month2 = date('m', strtotime($month2Spl1[0]));
                    $date2 = preg_replace('/\s+/', ' ', $date2);
                    $date2 = str_replace(' ', '', $date2);
                    @$expected_arrival = $year2 . '-' . $month2 . '-' . $date2 . ' ' . $time2;
                } else {
                    @$year2 = explode('-', $result->date);
                    @$year2 = $year2[2]; //3
                    @$year2 = str_replace(' ', '', $year2);
                    @$ext_arr = explode('-', $result->exp_arrival);
                    @$sexp3 = explode(' ', $ext_arr[1]);

                    @$time2 = @$sexp3[1];
                    @$date2 = $ext_arr[0];
                    @$date2 = str_replace(' ', '', @$date2);
                    @$month2 = $ext_arr[1];
                    $month2Spl = explode(' ', $month2);
                    @$month2 = date('m', strtotime($month2Spl[0]));
                    $date2 = preg_replace('/\s+/', ' ', $date2);
                    $date2 = str_replace(' ', '', $date2);
                    @$expected_arrival = $year2 . '-' . $month2 . '-' . $date2 . ' ' . $time2;
                }
            }
            if ((isset($result->source)) && ($result->exp_arrival != 0)) {
                $expected_arrival = date('Y-m-d H:i:s', strtotime($result->exp_arrival));
            }
            if (strpos($result->exp_arrival, 'Cancelled for your Station') !== false) {
                @$expected_arrival = $STA;
                $sql = "UPDATE tbl_order_table SET nottify='2' WHERE id=$order_id";
                help::execute($sql);
            }
        }


//            echo $result->last_location;
        if (strpos($result->last_location, 'Kms') !== false) {
            @$distance1 = explode('Kms', $result->last_location);
            @$train_status = $distance1[1];
            @$train_status = trim($train_status, '.)');
            @$status = trim($distance1[1], ".)");
            @$kms = explode('(', $distance1[0]);
            @$wcount = count($kms);
            @$wcount2 = $wcount - 2;
            @$wcount = $wcount - 1;

            @$distance = $kms[$wcount];


            @$delayUpdate = $kms[$wcount2];
            @$delayUpdate = explode('at', $delayUpdate);
            @$delayUpdate = $delayUpdate[1];
        } else {
            $distance = 0;
            $train_status = 0;
            $delayUpdate = 0;
        }
//            ---------------------------
        if (isset($result->lastUpdate)) {
            @$lastUpdated = $result->lastUpdate;
            @$lastUpdated = preg_replace('/\s+/', ' ', @$lastUpdated);
            @$lastUpdated = explode(' ', @$lastUpdated);
            @$lastUpdated = $lastUpdated[0] . ' ' . @$lastUpdated[1];
            if ((isset($result->source)) && ($result->lastUpdate != 0)) {
                $lastUpdated = $result->lastUpdate;
            }
        } else {
            $lastUpdated = 0;
        }


        $delay_arr = str_replace(' ', '', $result->delay_arrival) . '<br>';
        if ($actual_arrival != 0) {

            if ((strpos($result->act_arrival, 'Train Source') !== false) || (strpos($result->act_arrival, 'Source') !== false)) {
                $status1 = '2';
            } else {
                $status1 = '1';
            }
        } else {
            $status1 = '2';
        }
        if ($train_status == ' to go') {
            $status2 = '2'; //not reached
        } else if ($train_status == ' ahead') {
            $status2 = '1'; //reached
        } else {
            $status2 = '5'; //delay or something
        }
        if (($status1 == '1') || ($status2 == '1')) {
            $status = '1';
        } else {
            $status = '2';
        }

        $delay = $result->delay_arrival;
        if ($expected_arrival == 0) {
            $arrival = $actual_arrival;
        } else if ($actual_arrival == 0) {
            $arrival = $expected_arrival;
        }



        if ($distance == 0) {
            $distance = $DISTANCE;
        }
        if ($lastUpdated == 0) {
            $lastUpdated = $LAST_UPDT;
        }

//        if ($delayUpdate != 0) {
//            $year3 = explode('-', $result->date);
//            $year3 = $year3[2]; //3
//            $year3 = str_replace(' ', '', $year3);
//            $our_exp_time = $this->actionCalcTrainExpTime($year = $year3, $delayUpdate, $delayTime = $delay, $kms = $distance);
//            if ($our_exp_time <= $STA) {
        $our_exp_time = $STA;
//            } else {
//                $our_exp_time = $our_exp_time;
//            }
//        } else {
//            if ($status != '1') {
//                $our_exp_time = $STA;
//            } else {
//                $our_exp_time = $OTA;
//            }
//        }

        $apiDate = str_replace(' ', '', $apiDate);

        $arrival = preg_replace('/\s+/', ' ', $arrival);
        $arrival = str_replace('*', '', $arrival);
        $xz = explode(' ', $arrival);
        $newTime = date("H:i:s", strtotime($xz[1]));
        $arrival = $xz[0] . ' ' . $newTime;
        if (isset($result->source)) {
            $delay = $delay . '-' . $result->source;
        }

//--------------disable cron for some time interval-----------------------------------------------------------------------------------------------------
//                    $set1 = date('d-m-Y 11:00:00');
//                    $set2 = date('d-m-Y 04:00:00');
//                    $current = date('d-m-Y H:i:s');
//                    if (($current >= $set1) && ($current <= $set2)) {
//                        echo 'Cron Disabled';
//                    } else {
//
//                    }
//                        output array


        if (isset($result->source)) {
            $ETA_SOURCE = 'RY';
        } else {
            $ETA_SOURCE = 'YC';
        }
        $arrival = date('Y-m-d H:i:s', strtotime($arrival));
        $now_exact = date('Y-m-d H:i:s');
        $response = array('RESPONSE_CODE' => 200, 'JDATE' => $apiDate, 'SOURCE' => $ETA_SOURCE, 'EXP_ARVL' => $arrival, 'DELAY' => $delay, 'DISTANCE' => $distance, 'LAST_UPDT' => $lastUpdated, 'TRAIN_STATUS' => $status, 'ARIVAL_TYPE' => $arrival_type, 'DELAY_UPDT' => $delayUpdate, 'OUR_EXP_TIME' => $our_exp_time, 'TRAIN' => $train, 'STN_CODE' => $code, 'DAY_TYPE' => $dayType, 'CT_TIME' => $now_exact, 'ORDER_ID' => $order_id);
        $response = (object) $response;
        return $response;
    }

    public function actionCalcTrainExpTime($year, $DelayUpdate, $delayTime, $kms) {
        $DelayUpdate = explode(' ', $DelayUpdate);
        $time = $DelayUpdate[2];
        $day = $DelayUpdate[1];
        $month = explode('-', $day);

        $m = date('m', strtotime($month[1]));

        $d = $month[0];
//        print_r($time);

        $DelayUpdate = $year . '-' . $m . '-' . $d . ' ' . $time . ':00';
//echo '<br>';

        if ($delayTime <= '03:00') {//0-3 hrs delay
//            echo $delayTime . '<3 hrs<br>';
            if (($kms >= 0) && ($kms <= 10)) {
                $speed = 60; //km/hrecho '0-10';
            } else if (($kms >= 11) && ($kms <= 60)) {
                $speed = 60; //echo '11-60';
            } else if (($kms >= 61) && ($kms <= 100)) {
                $speed = 70; //echo '61-100';
            } else if (($kms >= 101) && ($kms <= 200)) {
                $speed = 80; //echo '101-200';
            } else if ($kms > 200) {
                $speed = 80; //echo '201<';
            }
        } else if ($delayTime >= '03:00') {//above 3 hrs delay
//            echo $delayTime . '>3 hrs<br>';
            if (($kms >= 0) && ($kms <= 10)) {
                $speed = 60; //km/hrecho '0-10';
            } else if (($kms >= 11) && ($kms <= 60)) {
                $speed = 60; //echo '11-60';
            } else if (($kms >= 61) && ($kms <= 100)) {
                $speed = 70; //echo '61-100';
            } else if (($kms >= 101) && ($kms <= 200)) {
                $speed = 80; //echo '101-200';
            } else if ($kms > 200) {
                $speed = 80; //echo '201<';
            }
        }

        $approx = ($kms / $speed);
        $getMin = ($approx * 60);

        $getMin = round($getMin);

        $DelayUpdate = strtotime($DelayUpdate);

        return date("Y-m-d H:i:s", strtotime("+" . $getMin . " minutes", $DelayUpdate));
    }

//    ------------------------------------------------------------------------------------------------------------------------------


    public function actionIncomplete_odr_promosms() {
        $path = '/var/www/vhosts/cc.yatrachef.com/assets/google_api/GoogleUrlApi.php';
        include($path);
        $key = 'AIzaSyAvbAW_v4fVJUqPy4y7Tt8KRA5cPL_vQJ0';
        $googer = new GoogleURLAPI($key);

        $request_count = 0;
        echo 'last5 ' . $last5 = date('H:i:s', strtotime('-5 minutes'));
//$last5='07:00:00';
        echo '<br>now ' . $now = date('H:i:s', strtotime('-1 minutes'));
        echo '<br>';
        $sql = "SELECT o.id,o.ry_journey_id,o.real_day_time,o.ordering_time,o.present_total,o.discounted,j.phone_no,j.phone_no2,j.name,j.email,o.order_status  ,count(phone_no) as count
        FROM tbl_order_table o
        INNER JOIN tbl_journey j ON j.cust_id=o.cust_id
        WHERE o.order_status='11' AND o.order_type!='16' AND o.order_type!='18' 
        AND DATE(o.ordering_time)=CURDATE() AND (TIME(o.ordering_time) BETWEEN '$last5' AND '$now') GROUP BY phone_no ORDER BY o.ordering_time DESC";
        $orders = help::readAll($sql);
        echo '<pre>';

        $coupons = array('0' => 'You havent placed your order yet! Complete your Order Now and get upto Rs.100 Off. Use coupon RETURN15. Hurry Up!');
//        'You havent placed your order yet! Complete your Order Now and get FLAT 30% Off. Use coupon RETURN1830. Hurry Up!'
//      '0' => 'We are waiting to serve you! Complete your Order Now and get Rs. 50 OFF. Use coupon RYGET50. Hurry Up! ',  '2' => 'You havent placed your order yet.Complete your Order Now and get Flat 50% Cashback. Use coupon CASHBACK50'
//Hi <name>, You haven�t placed your order yet. Complete your Order Now and get Flat 50% Off. Use coupon FREEFOOD50. Hurry! Min. Order Rs. 200
        foreach ($orders as $odr) {
            $email = $odr['email'];
            $sql = "SELECT COUNT(*) as count
        FROM tbl_order_table o
        INNER JOIN tbl_journey j ON j.cust_id=o.cust_id
        WHERE o.order_status='1' AND o.id!='" . $odr['id'] . "'
        AND DATE(o.ordering_time)=CURDATE() AND (j.email like '%$email%' AND (j.phone_no like '%" . $odr['phone_no'] . "%' OR j.phone_no2 like '%" . $odr['phone_no2'] . "%'))";
            $re_check = help::getscalar($sql);

            if ($re_check == 0) {
                $order_ids[] = $odr['id'];
                $random_coupon = array_rand($coupons);
                $selected_coupons = $coupons[$random_coupon];
//                $selected_coupons . '---' . $odr['phone_no'] . '<br>';
                $long_url = 'http://m.rytr.in/cart/' . $odr['ry_journey_id'];
//                $url_short = $googer->shorten($long_url);

                $url_short = $long_url;

                $sms_msg = 'Hi ' . $odr['name'] . ', ' . $selected_coupons . ' ' . $url_short;

                $guid = Help::SMSAPI(3, $odr['phone_no'], $sms_msg);
//                $guid = Help::SMSAPI(3, 9633500719, $sms_msg.'_ id '.$odr['id']);

                print_r('<h1>' . $guid . '<br>' . $guid1 . '</h1>');
                print_r($odr);
//                echo '<a href="https://cc.yatrachef.com/index.php/order/FullList?Stype=j.phone_no&search=' . $odr['phone_no'] . '&eml=' . $odr['email'] . '" target="_blank">check link</a>  ';
//                die;
                OrderController::createtag($msg = 'Incomplete order promo sms send to ' . $odr['name'] . ' (' . $random_coupon . ')', $id = $odr['id'], $type = 'Incomplete Promo SMS', $cat = 37);
                $request_count++;
            }
        }
//42891, 42892 ,43406 FREEFOOD50
//        if ($request_count != 0) {
//            $order_ids = json_encode($order_ids);
//            echo '<hr>' . 'SMS COUNT : ' . $request_count;
//            $cc[0] = '';
//            $temp[0] = '';
//            $to = 'akhil.tm@yatrachef.com';
//            $subject = 'INCOMPLETE PROMO ' . $request_count;
//            $text = strip_tags($order_ids);
//            $x = help::Mail_Bulk($subject, $order_ids, $to, $from = 'support@yatrachef.com', $title = 'TESTING MODE', $cc, $text = 0);
//        }
    }

    public function actionexotel_post_verify_calls() {
//        $cdate = date('Y-m-d H:i:s');
//        $imp = json_encode($_POST);
//        $sql = "INSERT INTO `test`(`content`, `date`,`call_status`) "
//                . " VALUES ('$imp-POST','$cdate','601')";
//        help::execute($sql);
//              $imp1 = json_encode($_GET);
//              $sql = "INSERT INTO `test`(`content`, `date`,`call_status`) "
//                     . " VALUES ('$imp1-GET','$cdate','601')";
//           help::execute($sql);
        if (isset($_POST['CallSid'])) {
            $sid = $_POST['CallSid'];
            switch ($_POST['Status']) {
                case "completed":$cstatus = 1;
                    break;
                case "failed":$cstatus = 2;
                    break;
                case "busy":$cstatus = 3;
                    break;
                case "no-answer":$cstatus = 4;
                    break;
                default: $cstatus = NULL;
                    break;
            }
            $sql = "UPDATE tbl_automated_calls SET call_status=$cstatus WHERE unique_id='$sid'";
            help::execute($sql);
            echo '200 OK';
        } else {
            echo '400';
        }

        if (isset($_GET['CallSid'])) {
            $sid = $_GET['CallSid'];
            $cinput = str_replace('"', '', $_GET['digits']);
            $call_end = date('Y-m-d H:i:s', strtotime($_GET['CurrentTime']));
            $sql = "UPDATE tbl_automated_calls SET call_input='$cinput',call_end_datetime='$call_end' WHERE unique_id='$sid'";
            if (help::execute($sql)) {
                
            }
        }
        if (isset($_GET['order_id'])) {
            $satisfy = 0;
            $cinput = help::read("SELECT call_input,call_status FROM `tbl_automated_calls` WHERE order_id='" . $_GET['order_id'] . "' ORDER BY call_start_datetime DESC");
            if ($cinput['call_input'] != NULL) {
                switch ($cinput['call_input']) {
                    case 1: $msg = 'Customer got food ,Response from automated calls ';
                        $sql = "UPDATE tbl_order_table SET order_status='5' WHERE id='" . $_GET['order_id'] . "'";
                        if (help::execute($sql)) {
                            $msg .= '<br>Change order status as Completed';
                            $satisfy = 5;
                        }
                        break;
                    case 2: $msg = 'Customer did not get the food, Response from automated calls '; //refund API
                        $sql = "UPDATE tbl_order_table SET order_status='3'  WHERE id='" . $_GET['order_id'] . "'";
                        if (help::execute($sql)) {
                            $msg .= ',Change the status to Order Failed';
                            $satisfy = 1;
                        }

                        break;
                    case 9: $msg = 'Customer requested talk to the  food adviser option';
                        break;
                    default: $msg = 'No response from auto v call..please contact TECH Team';
                        break;
                }

                OrderController::createtag($msg, $id = $_GET['order_id'], $type = 'Automated food delivery confirmation call', $cat = 37);
                if ($satisfy != 0) {
                    $user_id = help::getscalar("SELECT railyatri_user_id  FROM `tbl_order_table` WHERE `id` = " . $_GET['order_id']);
                    if ($user_id != NULL) {
                        $params['process_name'] = 'User Satisfaction API (C)';
                        $params['url'] = 'https://cc.yatrachef.com/index.php/url2/CustomerSatidfy/uid/' . $user_id . '/oid/' . $_GET['order_id'] . '/satisfy/' . $satisfy;
                        $params['interval'] = '1';
                        $params['process_start'] = '07:00:00';
                        $params['process_end'] = '22:00:00';
                        $params['process_type'] = '1';
                        $params['status'] = '1';
                        $response = CMF::create_process($params);
                    }
                }
            } else if (($cinput['call_input'] == NULL) && ($cinput['call_status'] != 1)) {
                $msg = 'IVR Response : ';
                if ($cinput['call_status'] == 2) {
                    $msg .= 'Call Failed';
                } else if ($cinput['call_status'] == 3) {
                    $msg .= 'Customer busy';
                } else if ($cinput['call_status'] == 4) {
                    $msg .= 'Customer not answered';
                } else {
                    $msg .= $cinput['call_status'];
                }
                OrderController::createtag($msg, $id = $_GET['order_id'], $type = 'Automated food delivery confirmation call (IVR)', $cat = 37);
            }
            if ($cinput['call_input'] == 2) {
                $now0 = date('Y-m-d H:i:s');
                $data01 = help::read("SELECT train_status,eta_last_updated,expected_arrival,id  FROM `tbl_order_table` WHERE `id` = '" . $_GET['order_id'] . "'");
                $sql = "INSERT INTO `tbl_train_tracking`(`order_id`, `eta`, `last_updated`, `now`) VALUES ('" . $_GET['order_id'] . "','" . $data01['expected_arrival'] . "','" . $data01['eta_last_updated'] . "','$now0')";
                if (help::execute($sql)) {
                    
                }
            }
        }
        echo '200 OK';
    }

    public function actionFreshdeskPost() {
        $cdate = date('Y-m-d H:i:s');
        $imp = json_decode($_POST);
//        $imp = $imp1 = $_POST;
        $imp1 = $_POST['freshdesk_webhook'];
        $content = '<br>Agent Name : ' . $imp1['ticket_agent_name'] . '<br>Note: ' . $imp1['ticket_latest_private_comment'] . '<br>public commet' . $imp1['ticket_latest_public_comment'] . '<br> ODR ' . $imp1['ticket_order_id'] . '<br>triger event : ' . $imp1['triggered_event'];
        if ($imp1['triggered_event'] == '{note_type:private}') {
            $msg = 'Added a note in freshdesk <br> <i>Note : - </i>' . strip_tags($imp1['ticket_latest_private_comment']);
        } else if ($imp1['triggered_event'] == '{note_type:public}') {
            $msg = 'Added a note in freshdesk <br> <i>Note : - </i>' . strip_tags($imp1['ticket_latest_public_comment']);
        } else {
            $events = str_replace('{', '', $imp1['triggered_event']);
            $events = str_replace('}', '', $events);
//            $events = explode(':', $events);
            //Replay Mail sent to customer
            $msg = 'Events : ' . $events . ' <br><a href="http://yatrachef.freshdesk.com/helpdesk/tickets/' . $imp1['ticket_id'] . '" target="_blank">click to view</a>';
        }
        $order_id = $imp1['ticket_order_id'];

        $agent_id = help::getscalar("SELECT emp_id  FROM `tbl_callcenter` WHERE  email like '%" . $imp1['ticket_agent_email'] . "%'");
        if ($agent_id == NULL) {
            $msg .= '<b>' . $imp1['ticket_agent_name'] . '</b>';
        }
        OrderController::createtag($msg, $order_id, $type = 'Added a note in  #' . $imp1['ticket_id'], $cat = 39, $mode = 0, $user_id = $imp1['ticket_id'], $loginId = $agent_id);
//        
//        $imp1 = implode(',', $imp1);
//        $count = count($imp);
//        $cc[0] = '';
//        $temp[0] = '';
//        $to = 'akhil.tm@yatrachef.com';
//        $subject = 'FRESHDESK POST TEST ' . $cdate;
//        $text = strip_tags($imp);
//        $x = help::Mail_Bulk($subject, 'count- ' . $count . $imp, $to, $from = 'support@yatrachef.com', $title = 'TESTING MODE', $cc, $text = 0);
//https://cc.yatrachef.com/index.php/url2/FreshdeskPost
    }

    public function actionFreshdesk_Agents_Sync() {
        $sql = "SELECT email  FROM `tbl_callcenter` WHERE suspend=0 AND (Freshdesk_Id is NULL OR Freshdesk_Id='0')";
        $list = help::readAll($sql);
        $x = help::Freshdesk_Agents(NULL, 1, $row['email']);
        foreach ($list as $row) {
            if ($row['email'] != NULL) {
                $x = help::Freshdesk_Agents(NULL, 1, $row['email']);
                if (isset($x[0]['Id']) && ($x[0]['Id'] != NULL)) {
                    $id = $x[0]['Id'];
                    echo $row['email'] . '   ';
                    $sql = "UPDATE `tbl_callcenter` SET `Freshdesk_Id`='$id' WHERE `email` LIKE '%" . $x[2]['Email'] . "%' AND roll!='-1'";
                    if (help::execute($sql)) {
                        echo 'success ';
                        $x = array();
                    } else {
                        echo $row['email'] . ' ==  ' . $x[2]['Email'];
                        echo 'failed';
                    }
                }
                echo '<br>';
            } else {
                
            }
        }
    }

    public function actionrest_mail() {
        $today = date('Y-m-d', strtotime("-1 days"));
        $start_date = date('Y-m-d', strtotime("-7 days"));

        $today1 = date('d-m-Y', strtotime("-1 days"));
        $start_date1 = date('d-m-Y', strtotime("-7 days"));

        $sql = "SELECT o.res_id,r.rest_name,r.email,s.station_name,r.user_rating as overall_rating,sum(o.Complaint) as complaint_count,r.email,r.status
        FROM tbl_order_table o
        INNER JOIN tbl_journey j ON o.cust_id=j.cust_id
        left JOIN tbl_restaurant r ON o.res_id=r.id
        left JOIN tbl_stations s ON o.station=s.id
        left JOIN tbl_user_reviews ur ON ur.Order_id=o.id
        WHERE j.test_order=0 AND  o.order_status <> '11' AND o.order_status <> '12' 
        AND DATE(o.real_day_time) <='$today' AND DATE(o.real_day_time)>='$start_date' 
        GROUP BY o.res_id
        ORDER BY COUNT(o.res_id) DESC"; //ORDER BY COUNT(o.res_id) DESC";// OR order_status = '8' OR order_status = '2'
//        limit 0,1

        $summary1 = help::readAll($sql);

        $sql5 = "SELECT ur.Rel_Id as res_id,AVG(ur.Rating) `this_week_rating`,count(ur.Rating) as rated_orders_count
        FROM tbl_order_table o
        INNER JOIN tbl_journey j ON o.cust_id=j.cust_id
        left JOIN tbl_restaurant r ON o.res_id=r.id
        left JOIN tbl_stations s ON o.station=s.id
        left JOIN tbl_user_reviews ur ON ur.Order_id=o.id
        WHERE j.test_order=0 AND  o.order_status <> '11' AND o.order_status <> '12' 
        AND DATE(ur.Date_time) <='$today' AND DATE(ur.Date_time)>='$start_date' 
        GROUP BY o.res_id
        ORDER BY COUNT(o.res_id) DESC";

        $result5 = help::readAll($sql5);

        foreach ($result5 as $key => $value) {
            foreach ($summary1 as $key2 => $value2) {
                if ($value['res_id'] == $value2['res_id']) {
                    $summary1[$key2]['rated_orders_count'] = $value['rated_orders_count'];
                    $summary1[$key2]['this_week_rating'] = $value['this_week_rating'];
                }
            }
        }


        foreach ($summary1 as $row) {
            if ($row['rated_orders_count'] > 0) {
                $summary[] = $row;
            }
        }

        $sql2 = "SELECT ur.Rel_Id ,ur.Order_id,DATE(o.real_day_time) as real_day_time,ur.Review,ur.Rating,DATE(ur.Date_time) as dt FROM tbl_user_reviews ur
            inner join tbl_order_table o
            on o.id=ur.Order_id
            WHERE DATE(ur.Date_time) <='$today' 
            AND DATE(ur.Date_time)>='$start_date' ORDER BY ur.Date_time ASC ";
        $r = help::readAll($sql2);

        $sql3 = " select o.id,o.res_id,DATE(o.real_day_time) as real_day_time,t.message FROM tbl_order_table o 
        INNER JOIN tbl_journey j ON o.cust_id=j.cust_id
        left join tbl_tagging t on t.order_id=o.id
        WHERE j.test_order=0 AND  o.order_status <> '11' AND o.order_status <> '12' and o.Complaint=1 and t.category=1
        AND DATE(o.real_day_time) <='$today' AND DATE(o.real_day_time)>='$start_date'  ";

        $c = help::readAll($sql3);

        $sql4 = "SELECT r.id,am.email
        FROM tbl_restaurant r
        Left join tbl_account_manager am
        on r.account_manager_id=am.id";

        $manager = help::readAll($sql4);

        foreach ($manager as $row) {
            $rid = $row['id'];
            $m_email = $row['email'];
            $manager_email[$rid] = $m_email;
        }


        foreach ($summary as $row1) {
            $res_id1 = $row1['res_id'];

            foreach ($r as $row) {
                if ($res_id1 == $row['Rel_Id']) {
                    $reviews[$res_id1][] = $row;
                }
            }
        }

        foreach ($summary as $row1) {
            $res_id1 = $row1['res_id'];
            foreach ($c as $row) {
                if ($res_id1 == $row['res_id']) {
                    $complaints[$res_id1][] = $row;
                }
            }
        }

        $this->layout = 'NULL';
        $this->render('rest_mail', array('summary' => $summary, 'reviews' => $reviews, 'today' => $today1, 'start_date' => $start_date1, 'complaints' => $complaints, 'manager_email' => $manager_email));
    }

    public function actiontrain_tickets() {
        //http://bin.mailgun.net/8bfb5844
        if (isset($_POST)) {
            $now = date('Y-m-d H:i:s');
//            $sql = "INSERT INTO `tbl_train_ticket_data`( `data`,`datetime`) "
//                    . " VALUES ('test','$now')";
//            if (help::execute($sql)) {
//                
//            }
//            $imp = implode('##', $_POST['booking']);
//            $imp = $_POST;
//            $json = json_decode($_POST);



            $json_en = json_encode($_POST);
            $decode_joson = json_decode($json_en);
            $booking = $decode_joson->booking;
            $book_decode = json_decode($booking);

            $passenger = $decode_joson->passengers;
            $passenger_decode = json_decode($passenger);
            foreach ($passenger_decode as $psgr) {
                $names[] = $psgr->name;
            }
            $sing_name = $names[0];
            $names0 = implode(',', $names);




//            -----------------------------

            $from_code = explode('|', $book_decode->from_sta);
            $from_code = str_replace(' ', '', $from_code[0]);
            $to_code = explode('|', $book_decode->to_sta);
            $to_code = str_replace(' ', '', $to_code[0]);
            $doj = date('d-m-Y', strtotime($book_decode->date_of_journey));

            $train = explode(' - ', $book_decode->train_number);
            $train_no = $train[0];

            $ran = mt_rand(100000, 999999);
            $doj0 = date('l,d M,Y', strtotime($doj));
            $link = 'https://cc.yatrachef.com/index.php/home/GetPnrStatus/pnr_no/' . $book_decode->pnr_number . '/from/' . $from_code . '/to/' . $to_code . '/datepicker/' . $doj0 . '/cname/' . $sing_name . '/cphone/+91' . $book_decode->user_mobile . '/uid/' . $ran . '/u/0?email=' . $book_decode->user_email . '&pnr=' . $train_no;


            $url0 = "https://api.yatrachef.com/live/index.php/mobApi/api/KEY/MTIw5/PNR/" . $book_decode->pnr_number . "/TNUM/" . $train_no . "/bSTN/" . $from_code . "/dSTN/" . $to_code . "/DOJ/" . $doj . "/SEAT/26/COCAH/B2";
            $res_en = help::CurlGetReq($url0, 3000);
            $res = json_decode($res_en);
            $res = (Array) $res;
            $count = (count($res) - 1);

//            $url = "https://partnerapi.yatrachef.com/index.php/food/available/KEY/MTIw5/PNR/2222166818/TNUM/12138/bSTN/" . $from_code . "/dSTN/" . $to_code . "/DOJ/" . $doj . "/SEAT/26/COACH/B2";
//            $res = json_decode(help::CurlGetReq($url, 3000));
            $query_resp = $query_ap = '';
            if ($count != 0) {
                $sql = "INSERT INTO `tbl_train_ticket_data`( `url`,`datetime`,`booking`,`passenger`,`train_name`,`user_email`, `user_mobile`, `from`, `to`, `date_of_journey`, `no_of_passenger`, `ry_user_id`,`Names`,`pnr_number`,`train`,`food_availability`) "
                        . " VALUES ('$link','$now','','','$book_decode->train_number','$book_decode->user_email','$book_decode->user_mobile','$book_decode->from_sta','$book_decode->to_sta','$book_decode->date_of_journey','$book_decode->no_of_passenger','$book_decode->user_id','$names0','$book_decode->pnr_number','$train_no','$count')";
            } else {
                $sql = "INSERT INTO `tbl_train_ticket_data`( `url`,`datetime`,`booking`,`passenger`,`train_name`,`user_email`, `user_mobile`, `from`, `to`, `date_of_journey`, `no_of_passenger`, `ry_user_id`,`Names`,`pnr_number`,`train`,`food_availability`) "
                        . " VALUES ('$link','$now','','','$book_decode->train_number','$book_decode->user_email','$book_decode->user_mobile','$book_decode->from_sta','$book_decode->to_sta','$book_decode->date_of_journey','$book_decode->no_of_passenger','$book_decode->user_id','$names0','$book_decode->pnr_number','$train_no','100')";
            }
//            --------------------------
//            $sql = "INSERT INTO `tbl_train_ticket_data`( `data`,`datetime`,`booking`,`passenger`,`train`,`user_email`, `user_mobile`, `from`, `to`, `date_of_journey`, `no_of_passenger`, `ry_user_id`,`Names`,`pnr_number`) "
//                    . " VALUES ('','$now','$booking','$json_en','$book_decode->train_number','$book_decode->user_email','$book_decode->user_mobile','$book_decode->from_sta','$book_decode->to_sta','$book_decode->date_of_journey','$book_decode->no_of_passenger','$book_decode->user_id','$names0','$book_decode->pnr_number')";

            if (help::execute($sql)) {
                echo 'SUCCESS';
            } else {
                echo 'FAILED';
            }

//            $url0 = "https://api.yatrachef.com/live/index.php/mobApi/api/KEY/MTIw5/PNR/" . $book_decode->pnr_number . "/TNUM/" . $train_no . "/bSTN/" . $from_code . "/dSTN/" . $to_code . "/DOJ/" . $doj . "/SEAT/26/COCAH/B2";
////            $url = "https://api.yatrachef.com/live/index.php/mobApi/api/KEY/MTIw5/PNR/1234567890/TNUM/12625/bSTN/ERS/dSTN/NDLS/DOJ/29-08-2017/SEAT/1/COCAH/AA";
//            $res_en = help::CurlGetReq($url, 3000);
//            $res = json_decode($res_en);
//            $res = (Array) $res;
//            $count = (count($res) - 1);
//            $sql = "INSERT INTO `tbl_train_ticket_data`( `data`,`datetime`,`booking`,`passenger`) "
//                    . " VALUES ('test','$now','$count','$url0')";
//            if (help::execute($sql)) {
//                
//            }
        }
    }

    public function actionpartner_menu_updation() {
        $sql = "update `tbl_menu` 
        set partner_availability =1
        where (`ry_category` LIKE  '%17%' OR  `ry_category` LIKE  '%27%' OR  `ry_category` LIKE  '%30%' OR  `ry_category` LIKE  '%35%')";

        help::execute($sql);
    }

    public function ConvertMinutes($x, $y) {
        $time1 = strtotime($x);
        $time2 = strtotime($y);
        $diff1 = $time2 - $time1;
        return $minutes = ($diff1 / (60));
    }

    public function actionDeliveryConfirmation() {

        if (help::checkalive(40) == 0) {
            die('De-Active');
        }
        $current_time = date('H:i');
        if ((strtotime($current_time) >= strtotime('09:00')) && (strtotime($current_time) <= strtotime('22:00'))) {
            echo 'true';
        } else {
            echo 'fail';
            die;
        }


//        $sql = "SELECT o.id as orderId,o.vendor_dispatch_time,o.order_type,r.rest_name,s.station_name,r.contact_no1,r.contact_no2,o.railyatri_user_id,o.cust_id,o.real_day_time as delivery_time,o.payment_type,o.cust_id,o.res_id,o.train_status,o.eta_last_updated,TIME(eta_last_updated) as time,d.sending_time,d.id as cnf_id,d.ivr_sending_time
//                FROM tbl_order_table o
//                INNER JOIN tbl_restaurant r ON o.res_id=r.id
//                INNER JOIN tbl_stations s ON s.id=r.station_id
//                LEFT JOIN tbl_delivery_confirmation_notification d ON o.id=d.order_id
//        WHERE o.order_status='1' AND ( DATE(real_day_time)=CURDATE() ) 
//        AND (o.online_to_cod<>1 OR o.online_to_cod IS NULL)  AND o.train_status='1'  AND o.orderPassedRest='1' AND o.orderConfirmRest='1'
//        ORDER BY `o`.`expected_arrival`  ASC limit 100";
//        
        $sql = "SELECT o.id as orderId,o.ordering_person,o.temp_delivery_status,o.expected_arrival,o.order_type,r.rest_name,s.station_name,r.contact_no1,r.contact_no2,o.railyatri_user_id,o.cust_id,o.real_day_time as delivery_time,o.payment_type,o.cust_id,o.res_id,o.train_status,o.eta_last_updated,TIME(eta_last_updated) as time,d.sending_time,d.id as cnf_id,d.ivr_sending_time
                FROM tbl_order_table o
                INNER JOIN tbl_restaurant r ON o.res_id=r.id
                INNER JOIN tbl_stations s ON s.id=r.station_id
                LEFT JOIN tbl_delivery_confirmation_notification d ON o.id=d.order_id
        WHERE o.order_status='1' AND ( DATE(real_day_time)=CURDATE() ) 
        AND (o.online_to_cod<>1 OR o.online_to_cod IS NULL)  AND (o.train_status='1' OR o.temp_delivery_status!='0')  AND o.orderPassedRest='1' AND o.orderConfirmRest='1'
        ORDER BY `o`.`expected_arrival`  ASC limit 200";
//o.id='257620';
//        "o.order_status='1' AND ( DATE(real_day_time)=CURDATE() ) 
//        AND (o.online_to_cod<>1 OR o.online_to_cod IS NULL)  AND o.train_status='1'  AND o.orderPassedRest='1' AND o.orderConfirmRest='1'
//        ORDER BY `o`.`expected_arrival`  ASC limit 1";
        $orders = help::readAll($sql);
        $now_ymd = date('Y-m-d H:i:00');
        echo $now = date('d-m-Y H:i:00');
        echo '----' . count($orders) . '---';
        echo '<pre>';
        foreach ($orders as $odr) {
            $order_id = $odr['orderId']; //'257620';
            echo $differnce = $this->ConvertMinutes($x = $odr['eta_last_updated'], $y = $now);
            $sta_differnce = $this->ConvertMinutes($x = $odr['expected_arrival'], $y = $now);

            if ($sta_differnce >= 0) {


                if ((($differnce >= 10) || ($odr['temp_delivery_status'] != 0)) && ($odr['sending_time'] == NULL)) {
//                echo $differnce;die;
                    print_r($odr);
                    if (($odr['railyatri_user_id'] != 0) && ($odr['ordering_person'] == 'RY')) {
                        echo 'RY AND APP';
//                    echo $differnce;

                        $rest_name = explode('_', $odr['rest_name']);
                        $rest_name = $rest_name[0];
                        $delivery_time = date('d-m-Y', strtotime($odr['delivery_time']));


                        $app_id = "APA91bGdTotqx_LKFGoUJmjQAyE-_Ul-I40YWeitUEO93AnYc1pZGbmZN2ot2_AHi0vx4YFrywSozB3AWUreGYXQoWoCkYimKPP8L04iQ5TZCvWxLlELGmRjbBPQpBeE-zzsLmDJyHPe";    // Replace this value by android_app_id of Railyatri user
                        $notification_id = "TEST1";     // Notification Id provided to you
                        $title = "Confirm your food delivery.";        // Title of notification
                        $message = "Did you receive your food?";    // Body of notification, text upto 150 characters  
                        $push_tag = "";           // Default string
                        $push_type = "3";                // Must be 3
                        $extra_key = "http://m.rytr.in/delivery-confirmation/" . $order_id . "/" . $odr['station_name'] . "/" . $delivery_time . "/" . $rest_name . "/" . (($odr['contact_no1'] != '') ? $odr['contact_no1'] : $odr['contact_no2']);
                        $image_url = ''; //"http://images.railyatri.in/ry_images_prod/2922/original/Notification_Heritage-eateries-of-Thiruvananthapuram.jpg?1501911234"; // Image url or can be empty string or NULL


                        $requestData = array(
                            "user_id[]" => $odr['railyatri_user_id'], //'282418', //$odr['railyatri_user_id'],
                            "notification_id" => $notification_id,
                            "title" => $title,
                            "message" => $message,
                            "push_tag" => $push_tag,
                            "push_type" => $push_type,
                            "extra_key" => $extra_key,
                            "image_url" => $image_url
                        );
                        $notification_res = $this->DeliveryConfirmation_Notification($requestData);

                        $sql = "INSERT INTO `tbl_delivery_confirmation_notification`(`order_id`, `notification_success`, `sending_time`,`order_type`) "
                                . " VALUES ('$order_id','$notification_res','$now_ymd','" . $odr['order_type'] . "')";
                        help::execute($sql);
                        echo $notification_res . ' <b style="color:green;">Notification SEND</b>';

                        $tag_msg = "Automated Delivery Confirmation Initiated (N).";
                        OrderController::createtag($tag_msg, $id = $order_id, $type = 'Automated Delivery Confirmation', $cat = 5);
                    } else {

                        echo '<b style="color:red;">NOT RY APP initiate call-' . $order_id . '</b>';
                        if (($odr['ivr_sending_time'] == NULL)) {
                            echo 'NO RESPONSE, <b style="color:blue;">Initiate IVR CALL</b>';
                            $phone_number = help::getscalar("SELECT phone_no FROM `tbl_journey` WHERE cust_id='" . $odr['cust_id'] . "'");
                            $phone_number = str_replace('+', '', $phone_number);
                            $api_res = AutomatedController::exotel($phone_number, $order_id, $voice_plain = '', $odr['eta_last_updated']); //$oid //$odr['phone_no']
                            echo $api_res->Call->Status;
                            if ($api_res->Call->Status == 'in-progress') {
                                $sql = "INSERT INTO `tbl_delivery_confirmation_notification`(`order_id`,`ivr_status`,`ivr_sending_time`,`order_type`) VALUES ('$order_id','1','$now_ymd','" . $odr['order_type'] . "')";
//                          $sql = "UPDATE `tbl_delivery_confirmation_notification` SET `ivr_status`='1',`ivr_sending_time`='$now_ymd' WHERE id='" . $odr['cnf_id'] . "'";
                                help::execute($sql);
                                $tag_msg = "Automated Delivery Confirmation Initiated (C).";
                                OrderController::createtag($tag_msg, $id = $order_id, $type = 'Automated Delivery Confirmation', $cat = 5);
                            }
                        }
                    }
                } else if ($odr['sending_time'] != NULL) {
                    echo 'Check response notification response : ' . $odr['orderId'] . '--';

                    $notification_time = $this->ConvertMinutes($x = $odr['sending_time'], $y = $now);
                    echo $notification_time;


                    $sql = "SELECT received_order,reached_train FROM `order_confirmations` WHERE order_id='$order_id' ORDER BY id DESC limit 1";
                    $confirm_data = help::read($sql);
                    $satisfy = 0;
                    if ($confirm_data != NULL) {
                        print_r($confirm_data);
                        if (($confirm_data['received_order'] == '1') && ($confirm_data['reached_train'] == '1')) {
                            echo 'got food';
                            $satisfy = 5;
                            if (help::execute("update tbl_order_table SET order_status='5' WHERE id='$order_id'")) {
                                $tag_msg = "Food Deliverd Status Changed and <b>order completed</b> with customer response via Notification";
                                OrderController::createtag($tag_msg, $id = $order_id, $type = 'Automated Customer Response (N)', $cat = 40);
                            }
                        } else if (($confirm_data['received_order'] == '0') && ($confirm_data['reached_train'] == '1')) {
                            echo 'train reached';
                            $satisfy = 1;
                            if (help::execute("update tbl_order_table SET order_status='3' WHERE id='$order_id'")) {
                                $tag_msg = "Train reached at the station, Assuming <b>order is failed</b>. Customer response from notification";
                                OrderController::createtag($tag_msg, $id = $order_id, $type = 'Automated Customer Response (N)', $cat = 40);
                            }
                        } else if (($confirm_data['received_order'] == '0') && ($confirm_data['reached_train'] == '0')) {
                            echo 'train not reached';
                            if (help::execute("update tbl_order_table SET train_status='2' WHERE id='$order_id'")) {
                                $tag_msg = "Train not reached at the station. Customer response from notification";
                                OrderController::createtag($tag_msg, $id = $order_id, $type = 'Automated Customer Response (N)', $cat = 40);
                            }
                        } else {

                            help::Mail($subject = 'CUSTOMER NOTIFICATION RESPONSE', $content = 'Order id : ' . $order_id . '<hr>' . json_encode($confirm_data), $to = 'akhil.tm@yatrachef.com', $type = 1);
                        }
                        if ($satisfy != 0) {
                            $params['process_name'] = 'User Satisfaction API (N)';
                            $params['url'] = 'https://cc.yatrachef.com/index.php/url2/CustomerSatidfy/uid/' . $odr['railyatri_user_id'] . '/oid/' . $order_id . '/satisfy/' . $satisfy;
                            $params['interval'] = '1';
                            $params['process_start'] = '07:00:00';
                            $params['process_end'] = '22:00:00';
                            $params['process_type'] = '1';
                            $params['status'] = '1';
                            $response = CMF::create_process($params);
                        }
                    } else {
                        if (($notification_time >= 10) && ($odr['ivr_sending_time'] == NULL)) {
                            echo 'NO RESPONSE, <b style="color:blue;">Initiate IVR CALL</b>';
                            $phone_number = help::getscalar("SELECT phone_no FROM `tbl_journey` WHERE cust_id='" . $odr['cust_id'] . "'");
                            $phone_number = str_replace('+', '', $phone_number);
                            $api_res = AutomatedController::exotel($phone_number, $order_id, $voice_plain = '', $odr['eta_last_updated']); //$oid //$odr['phone_no']
                            echo $api_res->Call->Status;
                            if ($api_res->Call->Status == 'in-progress') {
                                $sql = "UPDATE `tbl_delivery_confirmation_notification` SET `ivr_status`='1',`ivr_sending_time`='$now_ymd',`order_type`='" . $odr['order_type'] . "' WHERE id='" . $odr['cnf_id'] . "'";
                                help::execute($sql);
                            }
//                        print_r($api_res);
//                        echo '<hr>';
//                        print_r($api_res);
                        } else {
                            echo "AUTOMATION CLOSED (" . $notification_time . " - " . $odr['ivr_sending_time'] . ")";
                        }
                    }
                } else {
                    echo 'NOTHING TRIGGERED';
                }
            }

            echo '<hr>';
        }
//        help::Mail($subject = 'AUTOMATED NOTIFICATION', $content = '12', $to = 'akhil.tm@yatrachef.com', $type = 1);
    }

    public function DeliveryConfirmation_Notification($requestData) {

        $applicationType = "application/json";

        $ch = curl_init('http://notification.railyatri.in/api/gcm/send-notification');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($requestData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result);
        return $result->success;
    }

    public function actionfailure_report_daily() {

        $today = date('Y-m-d', strtotime("-1 days"));
        $month_start = date('Y-m-1');

        $sql = "SELECT
        r.rest_name,r.id as rest_id,r.status,r.railyatri_availability,am.name as onboarded_by,st.station_name,s.state,
        SUM( CASE WHEN ( o.order_status='5' or o.order_status='7' or o.order_status='9' or o.order_status='10') THEN 1 ELSE 0 END )  as Processed_Orders,
        SUM( CASE WHEN o.order_status='5' THEN 1 ELSE 0 END )  `completed`,
        SUM( CASE WHEN o.order_status='7' THEN 1 ELSE 0 END ) `canceled_rest`,
        SUM( CASE WHEN o.order_status='9' THEN 1 ELSE 0 END ) `failed_rest`,
        SUM( CASE WHEN o.order_status='10' THEN 1 ELSE 0 END ) `failed_cust`,
        SUM( r1.Rating ) `rating_sum`,
        SUM( CASE WHEN (r1.Rating!='' OR  r1.Rating IS NOT NULL  )THEN 1 ELSE 0 END ) `rating_count`

        FROM tbl_order_table o
        INNER JOIN tbl_journey j
        ON o.cust_id=j.cust_id
        INNER JOIN  tbl_restaurant r
        ON r.id=o.res_id
        INNER JOIN tbl_stations st
        ON r.station_id=st.id
        LEFT JOIN tbl_user_reviews r1
        ON r1.Order_id=o.id
        LEFT JOIN tbl_account_manager am
        ON r.account_manager_id=am.id
        LEFT JOIN tbl_state s
        ON r.state=s.id
        WHERE DATE(o.real_day_time)   between '$month_start' and '$today'
        AND j.test_order=0
        AND ( o.order_status='5' or o.order_status='7' or o.order_status='9' or o.order_status='10' )
        GROUP BY  o.res_id order by Processed_Orders DESC";

        $data = help::readAll($sql);


        foreach ($data as $row) {
            $rid = $row['rest_id'];
            ;
            $all_res_id[] = $row['rest_id'];
            $full_array[$rid] = $row;
        }

        foreach ($data as $row) {
            $rid2 = $row['rest_id'];
            ;
            $full_array[$rid2]['Processed_current_month'] = $row['Processed_Orders'];
            $full_array[$rid2]['failed_rest_current_month'] = $row['failed_rest'];
            $full_array[$rid2]['rating_sum_current_month'] = $row['rating_sum'];
            $full_array[$rid2]['rating_count_current_month'] = $row['rating_count'];
        }






        $sql8 = "SELECT
        r.id as rest_id,
        SUM( CASE WHEN o.order_status='9' THEN 1 ELSE 0 END ) `failed_rest`,
        SUM( CASE WHEN ( o.order_status='5' or o.order_status='7' or o.order_status='9' or o.order_status='10') THEN 1 ELSE 0 END )  as Processed_Orders,
        SUM( r1.Rating ) `rating_sum`,
        SUM( CASE WHEN (r1.Rating!='' OR  r1.Rating IS NOT NULL  )THEN 1 ELSE 0 END ) `rating_count`
        FROM tbl_order_table o
        INNER JOIN tbl_journey j
        ON o.cust_id=j.cust_id
        INNER JOIN  tbl_restaurant r
        ON r.id=o.res_id
        LEFT JOIN tbl_user_reviews r1
        ON r1.Order_id=o.id
        WHERE j.test_order=0
        AND ( o.order_status='5' or o.order_status='7' or o.order_status='9' or o.order_status='10' )
        GROUP BY  o.res_id order by Processed_Orders DESC";

        $data_full = help::readAll($sql8);


        foreach ($data_full as $row) {
            $rid2 = $row['rest_id'];
            $full_array[$rid2]['Processed_Orders_Full'] = $row['Processed_Orders'];
            $full_array[$rid2]['failed_rest_Full'] = $row['failed_rest'];
            $full_array[$rid2]['rating_sum_full'] = $row['rating_sum'];
            $full_array[$rid2]['rating_count_full'] = $row['rating_count'];
        }


        foreach ($full_array as $row) {

            $rid3 = $row['rest_id'];
            $failed_percent_current_month = (($row['failed_rest_current_month']) / ($row['Processed_current_month']) * 100);
            $failed_percent_overall = (($row['failed_rest_Full']) / ($row['Processed_Orders_Full']) * 100);
            $rating_current_month = $row['rating_sum_current_month'] / $row['rating_count_current_month'];
            $rating_overall = $row['rating_sum_full'] / $row['rating_count_full'];

            $failed_percent_current_month1 = round($failed_percent_current_month, 1);
            $failed_percent_overall1 = round($failed_percent_overall, 1);
            $rating_current_month1 = round($rating_current_month, 1);
            $rating_overall1 = round($rating_overall, 1);

            $full_array[$rid3]['failed_percent_current_month'] = $failed_percent_current_month1;
            $full_array[$rid3]['failed_percent_overall'] = $failed_percent_overall1;
            $full_array[$rid3]['rating_current_month'] = $rating_current_month1;
            $full_array[$rid3]['rating_overall'] = $rating_overall1;
        }



        foreach ($full_array as $row) {
            $rid4 = $row['rest_id'];
            if ($rid4 != '') {
                $final_array[$rid4]['rest_id'] = $row['rest_id'];
                $final_array[$rid4]['rest_name'] = $row['rest_name'];
                $final_array[$rid4]['station_name'] = $row['station_name'];
                $final_array[$rid4]['state'] = $row['state'];
                if ($row['railyatri_availability'] == 1) {
                    $final_array[$rid4]['type'] = 'Premium';
                } else if ($row['railyatri_availability'] == 0) {
                    $final_array[$rid4]['type'] = 'Non premium';
                }

                if ($row['status'] == 1) {
                    $final_array[$rid4]['status'] = 'Active';
                } else if ($row['status'] == 0) {
                    $final_array[$rid4]['status'] = 'Inactive';
                }

                $final_array[$rid4]['Restaurant_Manager'] = $row['onboarded_by'];
                $final_array[$rid4]['Processed_Orders'] = $row['Processed_Orders'];
                $final_array[$rid4]['completed'] = $row['completed'];
                $final_array[$rid4]['canceled_rest'] = $row['canceled_rest'];
                $final_array[$rid4]['failed_rest'] = $row['failed_rest'];
                $final_array[$rid4]['failed_percent_current_month'] = $row['failed_percent_current_month'];
                $final_array[$rid4]['failed_percent_overall'] = $row['failed_percent_overall'];
                $final_array[$rid4]['rating_current_month'] = $row['rating_current_month'];
                $final_array[$rid4]['rating_overall'] = $row['rating_overall'];
                $final_array[$rid4]['failed_cust'] = $row['failed_cust'];
            }
        }


        $heading = Array('rest_id' => 'Rest_id', 'rest_name' => 'Rest_name', 'station_name' => 'Station Name', 'State' => 'State', 'type' => 'Type', 'status' => 'Status', 'Restaurant_Manager' => 'Restaurant_Manager',
            'Processed_Orders_current_month' => 'Processed_Orders_current_month', 'completed_current_month' => 'completed_current_month', 'canceled_rest_current_month' => 'canceled_rest_current_month', 'failed_rest_current_month' => 'failed_rest_current_month', 'failed_percent_current_month' => 'failed_percent_current_month',
            'failed_percent_overall' => 'failed_percent_overall', 'rating_current_month' => 'rating_current_month', 'rating_overall' => 'rating_overall', 'failed_cust_current_month' => 'failed_cust_current_month');
        $rest_data[0] = implode('#@#', $heading);

        foreach ($final_array as $row) {
            $rest_data[] = implode('#@#', $row);
        }

        $today = date('Y-m-d', strtotime("-1 days"));
        $today = $today . '-Rest_Report_new';
//        $file = fopen("$today.csv", "w");
        $path = Yii::app()->basePath . "/../assets/FrontEnd/weekly_report/$today.csv";
        $file = fopen($path, 'w');

        foreach ($rest_data as $line) {
            fputcsv($file, explode('#@#', $line));
        }

        fclose($file);
        $cc[0] = 'rishi.kapoor@railyatri.in';
        $cc[1] = 'anoob.cr@railyatri.in';

        $today2 = date('Y-m-d', strtotime("-1 days"));
        $start_date2 = date("d/m/Y", strtotime($start_date));

        $to = 'rameez@yatrachef.com';
        $cc2[0] = '';
        $path = Yii::app()->basePath . "/../assets/FrontEnd/weekly_report/";
        $attach[0] = "$today.csv";
        echo $x = help::Mail_Attachment($subject = "Restaurant Performance Report--($today2)", $content = 'Hi All,<br>Please Find The Attached File', $to, $from = 'no-reply@yatrachef.com', $title = '', $cc, $attach, $path);

//        $this->actionapp_usage(); 
        $this->actionwow_update();
    }

    public function actionapp_usage() {
        //vendor app
        $today = date('Y-m-d', strtotime("-1 days"));
        $month_start = date('Y-m-1');

//           $sql = "SELECT r.rest_name,v.res_id, a.name,count(v.order_id) as order_count,
//            SUM( CASE WHEN v.order_confirm is not null THEN 1 ELSE 0 END )  `oc`,
//            SUM( CASE WHEN v.dispatch is not null THEN 1 ELSE 0 END )  `dispatch`,
//            SUM( CASE WHEN v.deliverd is not null THEN 1 ELSE 0 END )  `delivered`,
//            SUM( CASE WHEN t.category='14' THEN 1 ELSE 0 END )  `oc_sms`,
//            SUM( CASE WHEN t.message  LIKE  '%Enable Order Confirmed By Restaurant%' THEN 1 ELSE 0 END )  `oc_cc`
//            FROM tbl_order_table o
//            INNER JOIN tbl_vendor_app_usage v  ON v.order_id=o.id
//            LEFT JOIN tbl_tagging t on o.id=t.order_id
//            INNER JOIN tbl_journey j ON o.cust_id=j.cust_id 
//            INNER JOIN tbl_restaurant r ON r.id=v.res_id 
//            LEFT join tbl_account_manager a ON r.account_manager_id=a.id
//            WHERE DATE(o.real_day_time)  between '$month_start' and '$today'
//            AND j.test_order='0' AND r.auto_order_pass_status='1'
//            GROUP BY v.res_id  ";


        $sql = "SELECT r.rest_name,v.res_id, a.name,count(v.order_id) as order_count,
            SUM( CASE WHEN v.order_confirm is not null THEN 1 ELSE 0 END ) `oc`, 
            (SELECT COUNT(t.order_id) FROM tbl_tagging t WHERE   t.category='14' AND t.order_id=o.id) as 'oc_sms',
            (SELECT COUNT(t.order_id) FROM tbl_tagging t WHERE   t.message LIKE '%Enable Order Confirmed By Restaurant%' AND t.order_id=o.id) as 'oc_cc',
            SUM( CASE WHEN v.dispatch is not null THEN 1 ELSE 0 END ) `dispatch`, 
            SUM( CASE WHEN v.deliverd is not null THEN 1 ELSE 0 END ) `delivered`

            FROM tbl_order_table o 
            inner JOIN tbl_vendor_app_usage v ON v.order_id=o.id
            INNER JOIN tbl_journey j ON o.cust_id=j.cust_id 
            INNER JOIN tbl_restaurant r ON r.id=v.res_id 
            LEFT join tbl_account_manager a ON r.account_manager_id=a.id 
            WHERE DATE(o.real_day_time)  between '$month_start' and '$today'
            AND j.test_order='0' AND r.auto_order_pass_status='1' GROUP BY v.res_id";
        $r = help::readAll($sql);

        foreach ($r as $key => $row) {
            $oc_percent = ($row['oc'] / $row['order_count']) * 100;
            $dispatch_percent = ($row['dispatch'] / $row['order_count']) * 100;
            $delivered_percent = ($row['delivered'] / $row['order_count']) * 100;

            $r[$key]['oc_percent'] = round($oc_percent, 1);
            $r[$key]['dispatch_percent'] = round($dispatch_percent, 1);
            $r[$key]['delivered_percent'] = round($delivered_percent, 1);
        }




        $heading = array('rest_name' => 'rest_name', 'res_id' => 'res_id', 'manager_name' => 'manager_name', 'order_count_current_month' => 'order_count_current_month', 'confirmed_app' => 'confirmed_app', 'confirmed_sms' => 'confirmed_sms', 'confirmed_callcenter' => 'confirmed_callcenter',
            'dispatch_current_month' => 'dispatch_current_month', 'delivery_current_month' => 'delivery_current_month', 'confirmed_percent' => 'confirmed percent', 'dispatch_percent' => 'dispatch percent', 'delivery_percent' => 'delivery percent');
        $app_data[0] = implode('#@#', $heading);

        foreach ($r as $row) {
            $app_data[] = implode('#@#', $row);
        }


        $today = date('Y-m-d', strtotime("-1 days"));
        $today = $today . '-App_usage_Report';
//        $file = fopen("$today.csv", "w");
        $path = Yii::app()->basePath . "/../assets/FrontEnd/weekly_report/$today.csv";
        $file = fopen($path, 'w');

        foreach ($app_data as $line) {
            fputcsv($file, explode('#@#', $line));
        }

        fclose($file);


        $cc[0] = 'rishi.kapoor@railyatri.in';
        $cc[1] = 'rameez@yatrachef.com';
        $cc[2] = 'anoob.cr@yatrachef.com';

        $today2 = date('Y-m-d', strtotime("-1 days"));
        $start_date2 = date("d/m/Y", strtotime($start_date));

//        $to = 'anoob.cr@yatrachef.com'; 
        $to = 'arun@yatrachef.com';

        $cc2[0] = '';
        $path = Yii::app()->basePath . "/../assets/FrontEnd/weekly_report/";
        $attach[0] = "$today.csv";
        echo $x = help::Mail_Attachment($subject = "RY App Usage Report--($today2)", $content = 'Hi All,<br>Please Find The Attached File', $to, $from = 'no-reply@yatrachef.com', $title = '', $cc, $attach, $path);
    }

    public function actionwow_update() {
        $sql = "UPDATE `tbl_menu` SET `wow_id`=1 WHERE item_name like '%wow%'";
        help::execute($sql5);
    }

    public function actionOxigenCancelOrder($order = NULL) {
        $actual_resp = 0;
        if ($order != NULL) {
            $order_id = $order;
            $sql = "SELECT o.cust_id,o.ordering_person,j.oxigen_user_id,j.pnr,o.present_total,j.phone_no,j.name"
                    . " FROM tbl_order_table o "
                    . " INNER JOIN tbl_journey j ON j.cust_id=o.cust_id"
                    . " WHERE o.id='$order_id'";
            $r1 = help::read($sql);


            if ($r1['cust_id'] != NULL) {

                $transact = help::read("SELECT transaction_id,amount FROM `tbl_payment` WHERE cust_id='" . $r1['cust_id'] . "' AND transaction_status='SUCCESS' 
                                         ORDER BY t_time DESC limit 1");
                $params = array('user_id' => $r1['oxigen_user_id'], 'agent_id' => $r1['ordering_person'], 'pnr_no' => $r1['pnr'], 'invoice_id' => $r1['cust_id'], 'order_id' => $order_id, 'order_amount' => $r1['present_total'], 'pg_trans_id' => $transact['transaction_id']);
                $params = json_encode($params);
                $url = "https://railmeal.oximall.com/oximeal/cancellation";
                $response_json = $response = $this->Oxi_CurlPost($url, $params);
                $response = json_decode($response);




                if ((isset($response->cancellation)) && ($response->cancellation == 1)) {
                    $can_id = $response->can_trans_id;
                    $sql2 = "UPDATE `tbl_order_table` SET `order_status`='8' WHERE id='$order_id'";
                    if (help::execute($sql2)) {
                        $resp = 'CANCELED';

                        $sql = "SELECT value FROM `settings` WHERE id=5";
                        $sms_api_type = help::getScalar($sql);
//                $message = 'Hi Your order ' . $order_id . ' has been successfully canceled. Feel free to order again. For support please contact 08137813700';
                        $message = 'Hi ' . $r1['name'] . ', Your order ' . $order_id . ' has been successfully canceled. Feel free to order again. In case of refunds, please contact your booking agent. For support please contact 08137813700';
                        $guid[] = help::SMSAPI($sms_api_type, $r1['phone_no'], $message);
                        $actual_resp = 1;
                    } else {
                        $resp = 'CANCELATION FAILED (1)';
                        $actual_resp = 0;
                    }
                } else {
                    $resp = 'CANCELATION FAILED'; //BUT API FAILED
                    $actual_resp = 0;
                }

                $response_json = $response_json . '=>' . $resp;

                $now = date('Y-m-d H:i:s');
                $sql = "INSERT INTO `monitor_oxigen_api`(`order_id`, `reqesut`, `response`,`datetime`) VALUES ('$order_id','$params','$response_json','$now')";
                help::execute($sql);

                $actual_resp = 0;
            } else {
//                echo 'ORDER DATA NOT FOUND';
                $actual_resp = 0;
            }
        } else {
            $actual_resp = 0;
        }
        return $actual_resp;
    }

    public function Oxi_CurlPost($url, $params) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_USERPWD, "Oxi_meal_railyatri:@xigen_m5al2@17");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public function actionSMS_CHECK() {
        $gatway = help::checkalive(5);


        $url2 = file_get_contents("http://sapteleservices.com/SMS_API/balanceinfo.php?username=yatra2&password=12345");
        $result1 = explode('T-', $url2);
        $result1 = explode('P-', $result1[1]);
        $balance4 = $result1[0];

        $url = file_get_contents("http://sapteleservices.in/SMS_API/balanceinfo.php?username=yatra2&password=123456");
        $result = explode('-', $url);
        $result = explode('Promotional Credits', $result[1]);
        $result = explode('<br>', $result[0]);
        $balance1 = $result[0];

        $test[4] = ($balance4 > 0) ? 1 : 0;
        $test[1] = ($balance1 > 0) ? 1 : 0;
        $new_gatway = 3;
        if (($gatway == 4)) {
            if ($test[1] == 1) {
                $new_gatway = 1;
            } else if ($test[4] == 1) {
                $new_gatway = 4;
            }
        } else if (($gatway == 1)) {
            if ($test[4] == 1) {
                $new_gatway = 4;
            } else if ($test[1] == 1) {
                $new_gatway = 1;
            }
        } else if (($gatway == 3)) {
            if ($test[4] == 1) {
                $new_gatway = 4;
            } else if ($test[1] == 1) {
                $new_gatway = 1;
            }
        }

//        if (($test[4] == 0) && ($test[1] == 0)) {
//            $new_gatway = 3;
//        } else if (($test[4] == 1) && ($test[1] == 1)) {
//            $new_gatway = ($gatway == 4) ? 1 : 4;
//        }
//        echo '<hr>'    . $new_gatway . '---';
//        die;
        $gatway_new_name = ($new_gatway == 3) ? 'RY' : (($new_gatway == 1) ? 'SAP.IN' : 'SAP.COM' );
        $gatway_old_name = ($gatway == 3) ? 'RY' : (($gatway == 1) ? 'SAP.IN' : 'SAP.COM' );
        $sql = "UPDATE settings SET value='$new_gatway' WHERE id='5'";
        if (help::execute($sql)) {
            $msg = "Automatically SMS changed from $gatway_old_name to $gatway_new_name";
            $now = date('Y-m-d H:i:s');
            $sql = "INSERT INTO `tbl_activities`(`date_time`, `title`, `message`,`type`) VALUES ('$now','SMS GATEWAY CHANGES','$msg','11')";
            help::execute($sql);
            echo '1';
        } else {
            echo '0';
        }
    }

    public function actionRestSearch($key = NULL) {
        if ($key != NULL) {
            $sql = "SELECT id,rest_name FROM `tbl_restaurant` WHERE status='1' AND rest_name like '%$key%' limit 10";
            echo '<ul>';
            foreach (help::readAll($sql) as $row) {
                echo '<li onclick="dataid(\'' . $row['id'] . '\',\'' . $row['rest_name'] . '\')">' . $row['rest_name'] . '</li>';
            }
            echo '</ul>';
        }
    }

    public function actionCustomerSatidfy($uid = NULL, $oid = NULL, $satisfy = NULL) {
//        array('user_id' => '13303212', 'order_id' => '257620', 'satisfaction' => '5');
        if (($uid != NULL) && ($oid != NULL) && ($satisfy != NULL)) {

            $url = "http://api.railyatri.in/update-user-satisfaction.json";
            $requestData = array('user_id' => $uid, 'order_id' => $oid, 'satisfaction' => $satisfy);
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($requestData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('x-secret-key: 6012b8413428fd6a97c9579ebd6387d397139068', 'x-client-id: RY_RhT6hkb', 'Accept: application/json',));

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


            $result = curl_exec($ch);
            curl_close($ch);
            $result = json_decode($result);
            print_r($result);
//            echo $result->success;
        } else {
            echo '-1';
        }
    }

    public function actionPepsiOrdernotify() {
        die;
        $current_time = date('H:i');
        if ((strtotime($current_time) >= strtotime('09:00')) && (strtotime($current_time) <= strtotime('21:00'))) {
            
        } else {
            die;
        }
        $last_1hr_date = date('H:i:s', strtotime('-3 hour'));
        $cdate = date('H:i:s');
//        echo $last_1hr_date . '---' . $cdate;
//        $sql = "SELECT o.id,o.real_day_time ,o.order_status,r.rest_name,s.station_name,o.ordering_time
//        FROM tbl_order_table o
//        INNER JOIN tbl_restaurant r ON r.id=o.res_id
//        INNER JOIN tbl_stations s ON s.id=o.station
//        INNER JOIN tbl_order_table2 p ON o.id=p.order_id
//        INNER JOIN tbl_menu m ON m.id=p.menu_id 
//        WHERE DATE(o.ordering_time)=CURDATE() AND (TIME(o.ordering_time) BETWEEN '$last_1hr_date' AND '$cdate') AND  o.order_status not in ('11','12') AND m.ry_category like '%36%' ";

        $sql = "SELECT o.id,o.real_day_time ,o.order_status,r.rest_name,s.station_name,o.ordering_time,p.item_name
        FROM tbl_order_table o
        INNER JOIN tbl_restaurant r ON r.id=o.res_id
        INNER JOIN tbl_stations s ON s.id=o.station
        INNER JOIN tbl_order_table2 p ON o.id=p.order_id
        INNER JOIN tbl_menu m ON m.id=p.menu_id 
        WHERE DATE(o.ordering_time)=CURDATE() AND (TIME(o.ordering_time) BETWEEN '$last_1hr_date' AND '$cdate') AND  o.order_status not in ('11','12') AND m.combo_id is not null GROUP BY o.id";

        $pepsi = help::readAll($sql);
//        echo '<pre>';
//        print_r($pepsi);die;
//        $content='Sir,<br><br>Bill sending for combo orders is difficult, we can\'t set bill trigger for ry orders. <br><br>Please check below list is ok.';
        $content = '<div style="margin-bottom: 11px;
                    margin-left: 67px;
                    font-family: sans-serif;
                    font-size: 15px;">
                    </div>';

        $content .= '<table class="table table-bordered" width="650px" border="1" cellspacing="2" style="margin-bottom: 0px;">
                    <tbody>
                    <tr>
                    <td colspan="" style="text-align: center;background: gray;color: white;">Order Id</td>
                    <td colspan="" style="text-align: center;background: gray;color: white;">Restaurant</td>
                    <td colspan="" style="text-align: center;background: gray;color: white;">Station</td>
                    <td colspan="" style="text-align: center;background: gray;color: white;">Ordering Time</td>
                    <td colspan="" style="text-align: center;background: gray;color: white;">Order Status</td>
                    <td colspan="" style="text-align: center;background: gray;color: white;">Item Name</td>
                    </tr>';
        $total_dic = $total_count = 0;
        foreach ($pepsi as $row) {
            $rest_name = explode('_', $row['rest_name']);
            $rest_name = $rest_name[0];
            $content .= '<tr >
                    <td style="text-align: center;"><a target="_blank" href="https://cc.yatrachef.com/index.php/order/details/id/' . $row['id'] . '" >' . $row['id'] . '</a></td>
                    <td style="text-align: center;">' . $rest_name . '</td>
                    <td style="text-align: center;">' . $row['station_name'] . '</td>
                    <td style="text-align: center;">' . $row['ordering_time'] . '</td>
                    <td style="text-align: center;">' . $row['order_status'] . '</td>
                        <td style="text-align: center;">' . $row['item_name'] . '</td>
                    </tr> ';
            $total_dic += $row['total_discount'];
            $total_count += $row['order_count'];
        }
        $content .= ' </tbody> </table>';
        $content .= '<br>* order status : 1:pendin,4:fake,5:completed,7:can-rest,8:can-cust,9:fail-res,10:fail-cust';
//        echo $content;
//        die;
//        $cc[0] = 'rishi.kapoor@railyatri.in';
        $cc[0] = 'akhil.tm@yatrachef.com';

        $to = 'arun@yatrachef.com';
        $subject = 'Last 3 hour Combo Orders';
        $bcc[0] = '';
        $text = strip_tags($content);
        if ($pepsi != NULL) {
            $x = help::Mail_Bulk($subject, $content, $to, $from = 'no-reply@yatrachef.com', $title = '', $cc, $text = 0, $bcc);
            echo $x;
        }
    }

    public function actionBill($cust_id = 0, $mode = 1, $paid_bill = 0, $sms = 1, $partial = 0, $resend = 0) {
        if ($mode == 1) {
            $logo_url = ' <img src="https://cc.yatrachef.com/assets/FrontEnd/img/logo-new.png" class="CToWUd" style="width: 130px;margin: 10px 0 4px 0px;">';
            $border_color = 'rgb(255,84,0)';
            $sms_title = 'YatraChef';
        } else if ($mode == 2) { //oxigen
            $logo_url = '<img src="https://oxigen.yatrachef.com/images/rylogo.png" class="CToWUd" style="width: 160px;margin: 18px 0 4px 0px;">';
            $border_color = '#0061a9';
            $sms_title = 'RailYatri';
        }

        $sql = "SELECT value FROM `settings` WHERE id=5";
        $sms_api_type = help::getScalar($sql);

        $sql = "SELECT r.rest_address,o.present_total,o.discounted,o.adjusted,o.tax,o.delivery_charge,o.hotel_total,o.payment_type,o.ordering_time,o.cust_id,o.id AS  `Order ID` ,j.seat_no,j.coach_no, o.real_day_time AS  `Delivery Date Time` , r.rest_name AS  `Rest.Name` , s.station_name AS  `Location` , o.present_total AS  `Price` , j.train_no , j.train_name , j.pnr AS  `PNR` , j.name AS  `Name` , j.email AS  `Email` , j.phone_no AS  `Phone` ,vendor_discount_amt,vendor_gst_amt,vendor_share,yc_share,yc_round_off_amt, yc_gst_amt
FROM tbl_order_table o
INNER JOIN tbl_journey j ON o.cust_id = j.cust_id
INNER JOIN tbl_restaurant r ON o.res_id = r.id
INNER JOIN tbl_stations s ON o.station = s.id
WHERE o.cust_id ='" . $cust_id . "' ";
        $order_details = help::readAll($sql);



        if ($order_details[0]['payment_type'] == 'Online_Payment') {
            $pay_mode = 'Online Payment';
            $pay_status = 'Paid';
        } else if ($order_details[0]['payment_type'] == 'cod') {
            $pay_mode = 'COD';
            $pay_status = 'Unpaid';
        } else {
            $pay_mode = '';
            $pay_status = '';
        }

        if ($paid_bill == 1) {
            $pay_mode = 'COD';
            $pay_status = 'Paid on Delivery';
            $params['process_name'] = 'Paid on Delivery bill';
//          $params['mail_to_cc'] = $to . ',akhil.tm@yatrachef.com'; 
            $params['mail_type'] = 2;
        }



//
//        echo '<pre>';
//        
//        print_r($order_details[0]['payment_type']);die;
        $html = '<html>
    <title>Food In Train</title>
    <body>
        <div style="padding:18px;max-width:840px;margin:auto;background:#f5f5f5;border:10px solid #fff">


            <div style="padding:8px 0;font-size:22px;font-weight:bold;border-top:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:center;background:' . $border_color . ';border-radius:5px 5px 5px 5px;color:white">
                <strong>Receipt</strong>
            </div>



            <div style="float:left;">' . $logo_url . '
                

            </div>

            <div style="float: right;overflow:hidden;line-height:1.5em;    margin-top: 8px;">
                <dt style="float:left;clear:both;font-weight:bold">Receipt Id #' . $order_details[0]['cust_id'] . '</dt>

               
                <dt style="float:left;clear:both;font-weight:bold">Date of Receipt ' . date('d-m-Y', strtotime($order_details[0]['ordering_time'])) . '</dt>
                

            </div>
            <div style="clear:both;"></div>


            <div style="text-align:left;padding-top:10px;color:#333;    clear: both;">
                <p style="
    margin: 0;
">Hi ' . $order_details[0]['Name'] . ' , </p>
                <br>
                
                Thank you for ordering through ' . $sms_title . '. For any clarification on the order please call us at <b>0 8137 8137 00</b> or mail us at <b><a href="mailto:support@yatrachef.com" target="_blank">support@yatrachef.com</a>.</b>
            </div>

            <hr>
            <br>
            <div style="text-align:left">
                <table style="width:100%">

                    <tbody><tr>
                            <td style="padding-left:10px"><strong>Name</strong></td><td>:</td><td>' . $order_details[0]['Name'] . '</td><td><strong>Contact No</strong></td><td>:</td><td>' . $order_details[0]['Phone'] . '</td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px"><strong>Mode of Payment</strong></td><td>:</td><td>' . $pay_mode . '</td>

                        </tr>


                    </tbody></table>
            </div>
            <hr style="border:1px dotted #aaaaaa">

            <div style="margin-right:0;float:left;width:100%;text-align:left;padding-bottom:30px;color:#333;padding-left:10px">
                <h3 style="float:left;">Receipt Status</h3>
                <strong style="
    float: left;
    margin: 23px 0 0 27px;
">Receipt is <em>' . $pay_status . '</em></strong>
            </div>




            <table style="text-align:center;padding-bottom:18px;width:300px;padding-left:255px;width:100%">


                <caption style="color:#333"><strong style="font-size:43px">My Food Tray</strong></caption>


            </table>

            <hr>';

//            <!------------------------------------REST_BLOCK START--------------------------------------------------------------------------------->
        foreach ($order_details as $row) {

            $adjusted = $row['adjusted'];
            $adjusted = number_format($adjusted, 2);

            $discounted = $row['discounted'];
            $discounted = number_format($discounted, 2);

            $vendor_discount_amt = $row['vendor_discount_amt'];
            $vendor_discount_amt = number_format($vendor_discount_amt, 2);

            $yc_gst_amt = $row['yc_gst_amt'];
            $yc_gst_amt = number_format($yc_gst_amt, 2);

            $vendor_gst_amt = $row['vendor_gst_amt'];
            $vendor_gst_amt = number_format($vendor_gst_amt, 2);

            $base_price = $row['vendor_share'];
            $delivery_charge = $row['delivery_charge'];
            $appli_charges = $delivery_charge + $row['yc_share'];
            $round_off = number_format($row['yc_round_off_amt'], 2);

            $Rest_name = $row['Rest.Name'];
            if (strpos($Rest_name, '_') !== false) {
                $Rest_name = explode('_', $Rest_name);
                $Rest_name = $Rest_name[0];
            }
            if ($order_details[0]['payment_type'] == 'cod') {
                $message = "Dear " . $order_details[0]['Name'] . ", Thank you for ordering with " . $sms_title . ". We have registered your order ID " . $row['Order ID'] . ". Order to be delivered at " . $row['Location'] . " ,Train Name :" . $row['train_no'] . " - " . $row['train_name'] . " Coach: " . $row['coach_no'] . " Seat : " . $row['seat_no'] . " on " . date('d-m-Y', strtotime($row['Delivery Date Time'])) . " by " . $Rest_name . ". Amount due Rs" . $row['present_total'] . ", Please be at your Seat. Wishing you a Safe and Delicious Yatra. For support please contact 08137813700";
            } else if ($order_details[0]['payment_type'] == 'Online_Payment') {
                $message = "Dear " . $order_details[0]['Name'] . ", Thank you for ordering with " . $sms_title . ". We have registered your order ID " . $row['Order ID'] . ". Order to be delivered at " . $row['Location'] . " ,Train Name :" . $row['train_no'] . " - " . $row['train_name'] . " Coach:" . $row['coach_no'] . " Seat:" . $row['seat_no'] . " on " . date('d-m-Y', strtotime($row['Delivery Date Time'])) . " by " . $Rest_name . ". Amount Paid Rs" . $row['present_total'] . ", Please be at your Seat. Wishing you a Safe and Delicious Yatra. For support please contact 08137813700";
            } else {
                
            }
            $phone = str_replace('+91', '', $order_details[0]['Phone']);
            $phone = str_replace('+', '', $order_details[0]['Phone']);
            $cdatet = date('Y-m-d H:i:s');
            if ($sms == 1) {
                $guid01 = help::SMSAPI($sms_api_type, $phone, $message);
                $guid[] = $guid01;
//            if ($mode == 1) {
                $api_db = ($sms_api_type - 1);
                $SMS_TEXT = str_replace("'", '', $message);
                $sql = "INSERT INTO `tbl_sms_data`(`cust_id`, `sms_id`, `date_time`, `attempt`,`massage`, `phone`,`type`,`Api_Used`) 
                        VALUES ('$cust_id','$guid01','$cdatet','1','$SMS_TEXT','$phone','1','$api_db')";
                Help::execute($sql);
            } else {
                $guid[] = 0;
            }
            $order_ids[] = $row['Order ID'];

//            }
            $html .= '<div class="rest_block">
                <table style="width:100%;text-align:center">
                    <tbody><tr>

                            <th style="font-size:22px;text-align:center;padding-bottom:0px">' . $Rest_name . '</th></tr>
                                <tr><td style="    font-size: 11px;
    text-align: center;
    font-family: sans-serif;    text-transform: capitalize;">' . strtolower($row['rest_address']) . '</td></tr>
</tbody></table>
                <table style="width:100%">

                    <tbody><tr>
                            <td style="width:19%;padding-left:10px"><strong>Order ID</strong></td><td>:</td><td style="width:26%">' . $row['Order ID'] . '</td>

                            <td><strong>Station</strong></td><td>:</td><td>' . $row['Location'] . '</td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px"><strong>Arrival time</strong></td><td>:</td><td>' . date('H:i', strtotime($row['Delivery Date Time'])) . '</td>
                            <td style="width:15%"><strong>Delivery</strong></td><td>:</td><td style="width:40%">' . date('d-m-Y', strtotime($row['Delivery Date Time'])) . '</td>
                        </tr>
                    </tbody></table>
                <hr style="border:1px dotted #aaaaaa;width:100%">
<table style="width:100%;font-size:12px;border-collapse:collapse;border-spacing:0;color:#333">
                    <thead>
                        <tr>
                            <th style="font-weight:bold;background:' . $border_color . ';width:42%;text-align:left;height:32px;font-size:16px;padding-left:10px;border-top-left-radius:5px;color:white">Item</th>
                            <th style="font-size:16px;font-weight:bold;background:' . $border_color . ';text-align:center;width:37%;height:32px;color:white">Quantity</th>
                            <th style="font-size:16px;font-weight:bold;background:' . $border_color . ';text-align:center;width:37%;height:32px;color:white"></th>
                            <th style="background:' . $border_color . ';width:13%"></th>
                            <th style="font-size:16px;text-align:center;background:' . $border_color . ';width:15%;height:32px;padding-right:10px;border-top-right-radius:5px;color:white">Price </th>
                        </tr>
                    </thead>';
            foreach (help::readAll("SELECT item_name,item_price,item_quantity,price_cart FROM `tbl_order_table2` WHERE order_id='" . $row['Order ID'] . "'") as $rw) {
                $html .= ' 
                    <tbody>
                        <tr>
                            <th style="text-align:left;background:#fff;width:42%;height:28px;padding-left:10px">' . $rw['item_name'] . '</th>
                            <td style="text-align:center;background:#fff;width:37%;height:28px">' . $rw['item_quantity'] . '</td>
                            <td style="text-align:right;padding:0px 8px 0 0;background:#fff;width:37%;height:28px">(1 * ' . $rw['item_price'] . ')</td>
                            <td style="text-align:right;background:#fff;height:28px;color:#333;padding-right:10px"><span>Rs.</span></td>
                            <td style="text-align:right;width:21%;background:#fff;height:28px;color:#333;padding-right:10px">  ' . $rw['price_cart'] . '</td>
                        </tr>

                    ';
            }

            $html .= ' </tbody>

                </table><table style="text-align:left;width:100%;color:#333;background:rgb(199,188,170);border-bottom-right-radius:5px;border-bottom-left-radius:5px;font-family:Century Gothic">
                    <tbody><tr><th style="width:89%;text-align:right;padding-top:8px">Base Price:</th><td style="text-align:right">:</td><td style="width:1%;text-align:right;padding-right:10px"></td><td style="text-align:right;width:2%"><strong><span>Rs.</span></strong></td><td style="text-align:right;padding-right:10px"><strong>' . $base_price . '</strong></td></tr>
                 ';
//            if ($row['tax'] != 0) {
            $html .= '<tr>
                        </tr><tr><th style="width:89%;text-align:right;padding-top:8px">Taxes:</th><td style="text-align:right">:</td><td style="width:1%;text-align:right;padding-right:10px"></td><td style="text-align:right;width:2%"><span>Rs.</span></td><td style="text-align:right;padding-right:10px"> ' . ($yc_gst_amt + $vendor_gst_amt + $adjusted + $round_off) . '</td></tr>
                        <tr>';
//            }
//            if ($row['delivery_charge'] != 0) {
//                $html .= '<tr><th style="width:89%;text-align:right;padding-top:8px">Delivery Charge:</th><td style="text-align:right">:</td><td style="width:1%;text-align:right;padding-right:10px"></td><td style="text-align:right;width:2%"><span>Rs.</span></td><td style="text-align:right;padding-right:10px"> ' . $row['delivery_charge'] . '</td></tr>
//                        <tr> </tr>';
//            }
//            if ($row['adjusted'] != 0) {
            $html .= '<tr><th style="width:89%;text-align:right;padding-top:8px">Applicable Charges:</th><td style="text-align:right">:</td><td style="width:1%;text-align:right;padding-right:10px"></td><td style="text-align:right;width:2%"><span>Rs.</span></td><td style="text-align:right;padding-right:10px">' . $appli_charges . '</td></tr>
                        <tr>
                        </tr>';
//            }
            if ($row['discounted'] != 0) {
                $html .= '<tr><th style="width:89%;text-align:right;padding-top:8px">Discount:</th><td style="text-align:right">:</td><td style="width:1%;text-align:right;padding-right:10px"></td><td style="text-align:right;width:2%"><span>Rs.</span></td><td style="text-align:right;padding-right:10px"> ' . ( $discounted + $vendor_discount_amt) . '</td></tr>';
            }
            $html .= '
                      
                        
                        <tr>
                            <th style="width:89%;text-align:right;padding-bottom:8px;padding-top:8px;font-weight:600"><b>Total</b></th><td style="text-align:right;width:2%">:</td>
                            <td style="width:1%;text-align:right;padding-right:10px"></td><td style="text-align:right"><strong><span>Rs.</span></strong></td><td style="text-align:right;padding-right:10px"><strong>' . $row['present_total'] . '</strong></td>
                        </tr>
                    </tbody></table>

            </div>';
            $grand_total[] = $row['present_total'];
        }
//            <!------------------------------------REST_BLOCK END--------------------------------------------------------------------------------->


        $html .= '<br>
            <table style="    color: #333;
    width: 100%;
   
    border-spacing: 0px;">
                <caption style="font-size:16px"><strong></strong></caption>

                <tbody>
                   ';
        if ($partial == 1) {
            $pay_details = help::getscalar("SELECT (amount) amount FROM `tbl_payment` WHERE cust_id='$cust_id'");
            if ($pay_details != NULL) {
                $html .= '<tr>
                        <th style="font-size:14px;border-radius:5px 0px 0px 5px;text-align:left;width:50%;height:30px;padding-left:10px;color:black">Amount Paid:</th>

                        <td style="height:30px;color:black"></td><td style="color:black"></td><td style="border-bottom-right-radius:5px;border-top-right-radius:5px;color:black;padding-right:10px;font-size:14px;text-align:right"><strong><span style="font-size:14px">Rs. </span></strong><strong>  ' . (round($pay_details / 100)) . '</strong></td>
                    </tr><tr>
                        <th style="font-size:14px;border-radius:5px 0px 0px 5px;text-align:left;width:50%;height:30px;padding-left:10px;color:black">Amount Due:</th>

                        <td style="height:30px;color:black"></td><td style="color:black"></td><td style="border-bottom-right-radius:5px;border-top-right-radius:5px;color:black;padding-right:10px;font-size:14px;text-align:right"><strong><span style="font-size:14px">Rs. </span></strong><strong>  ' . ((array_sum($grand_total)) - (round($pay_details / 100))) . '</strong></td>
                    </tr>';
            }
        }
        $html .= ' <tr>
                        <th style="font-size:18px;border-radius:5px 0px 0px 5px;text-align:left;width:50%;height:30px;padding-left:10px;background:#444444;color:#ffffff">Grand Total:</th>

                        <td style="height:30px;background:#444444;color:#ffffff"></td><td style="background:#444444;color:#ffffff"></td><td style="background:#444444;border-bottom-right-radius:5px;border-top-right-radius:5px;color:#ffffff;padding-right:10px;font-size:18px;text-align:right"><strong><span style="font-size:18px">Rs. </span></strong><strong>  ' . array_sum($grand_total) . '</strong></td>
                    </tr>
            </tbody>
            </table><div class="yj6qo"></div><div class="adL">











            </div></div>

    </body>
</html>';
        $cc[0] = '';
        $to = $order_details[0]['Email'];
//        echo $html;
//        die;
        if ($mode == 1) {
            $bcc[0] = '';
            $subject = 'Your Order For Food Has been Successfully Placed - Receipt for #' . $order_details[0]['cust_id'];
            $params['process_name'] = 'Order confirmation MAIL';
            if ($sms == 1) {
                $params['process_name'] = 'Order confirmation MAIL and SMS sent to customer';
            }
            if ($paid_bill == 2) {
                $params['process_name'] = 'Re-send Order confirmation MAIL';
            }

            $params['mail_content'] = str_replace("'", "\'", $html);  //addslashes($content);
            $params['sms_content'] = $subject;
            $params['mail_to_cc'] = $to;
            $params['mail_type'] = 1;

            if (($partial == 1)) {
                $params['mail_to_cc'] = 'akhil.tm@yatrachef.com';
            }

            $params['interval'] = '0';
            $params['process_start'] = '06:00:00';
            $params['process_end'] = '23:00:00';
            $params['process_type'] = '1';
            $params['status'] = '1';
            $params['type'] = '4';
            $params['relation_id'] = $order_details[0]['cust_id'];


            $response = CMF::create_process($params);
//        --------------------------------------------------------------
            $date2 = date("Y-m-d H:i:s");
//        $message1 = addslashes($html_mail['HTML']); 
            $mail_html0 = str_replace("'", "\'", $html);
            $sql = "INSERT INTO `tbl_invoice`(invoice_id,date,content,send_status,order_type)
              VALUES('" . $order_details[0]['cust_id'] . "','$date2','$mail_html0','1','1')";
            help::execute($sql);

//            --------------------------------
            if ($paid_bill == 1) {
//                $msg = "Paid Bill Send to $to for Invoice id #" . $order_details[0]['cust_id'];
//                $now = date('Y-m-d H:i:s');
//                $sql = "INSERT INTO `tbl_activities`(`date_time`, `title`, `message`,`type`) VALUES ('$now','Paid bill request','$msg','13')";
//                help::execute($sql);
//                foreach ($order_ids as $ods) {
//                    OrderController::createtag($msg, $ods, $type = 'Paid bill after delivery status is ON', $cat = 5);
//                }

                echo 'Done';
                die;
//                echo 'SUCCESS (close the browser tab)';
//                die;
            }

//            ----------------------------
        } else if ($mode == 2) {
            $bcc[0] = "arun@yatrachef.com";
            $bcc[1] = "rameez@yatrachef.com";
            $bcc[2] = "akhil.tm@yatrachef.com";
            $subject = 'Your order has been placed with RailYatri.in - Receipt for RY#' . $order_details[0]['cust_id'];
            $text = strip_tags($html);
            $x = help::Mail_Bulk($subject, $html, $to, $from = 'support@yatrachef.com', $title = '', $cc, $text = 0, $bcc);
        }


        return array('MAIL' => $x, 'SMS' => $guid, 'HTML' => $html);
    }

    public function actionpepsiorders() {
        $today = date('Y-m-d', strtotime("-1 days"));
        $sql = "
        SELECT date(o.ordering_time) as od,o.id,o2.item_name,o2.item_quantity,r.rest_name,s.station_name,s2.state
        FROM  tbl_order_table o
        INNER JOIN tbl_order_table2 o2
        on o.id=o2.order_id
        left join tbl_restaurant r
        on o.res_id=r.id
        left join tbl_stations s
        on r.station_id=s.id
        left join tbl_state s2
        on r.state=s2.id
        WHERE  DATE(o.ordering_time)  ='$today'  and o.order_status <> 11 and o.order_status <>12
        and (o2.combo_id >0 or o2.item_name LIKE '%Pepsi%' OR o2.item_name LIKE '%Mirinda%' OR o2.item_name LIKE '%Mountain%' OR o2.item_name LIKE '%7 Up%' )
        ORDER BY r.rest_name DESC";

        $r = help::readAll($sql);

        $heading = array('ordering_date' => 'ordering_date', 'order_id' => 'order_id', 'item_name' => 'item_name', 'item_quantity' => 'item_quantity', 'rest_name' => 'rest_name', 'station_name' => 'station_name', 'state' => 'state');
        $app_data[0] = implode('#@#', $heading);

        foreach ($r as $row) {
            $app_data[] = implode('#@#', $row);
        }



        $today = $today . '-Pepsico_Order_Report';
        //        $file = fopen("$today.csv", "w");
        $path = Yii::app()->basePath . "/../assets/FrontEnd/pepsi_report/$today.csv";
        $file = fopen($path, 'w');

        foreach ($app_data as $line) {
            fputcsv($file, explode('#@#', $line));
        }

        fclose($file);

        $cc[0] = 'anoob.cr@yatrachef.com';
        $cc[1] = 'rameez@yatrachef.com';
        $cc[2] = 'rishi.kapoor@railyatri.in';
        $cc[3] = 'vivek.gour@railyatri.in';
        $cc[4] = 'sourabh.shekhar@railyatri.in';


        $today2 = date('Y-m-d', strtotime("-1 days"));
        $start_date2 = date("d/m/Y", strtotime($start_date));
        $to = 'arun@yatrachef.com';
        $path = Yii::app()->basePath . "/../assets/FrontEnd/pepsi_report/";
        $attach[0] = "$today.csv";

        echo $x = help::Mail_Attachment($subject = "Pepsico Order Report-($today2)", $content = 'Hi,<br>Please Find The Attached File', $to, $from = 'no-reply@yatrachef.com', $title = '', $cc, $attach, $path);
    }

    public function actionaquafinaorders() {
        $today = date('Y-m-d', strtotime("-1 days"));

        $sql = "SELECT DATE( o.ordering_time ) AS ordering_date, o.id, o2.item_name, o2.item_quantity, r.rest_name, s.station_name, s2.state
        FROM tbl_order_table o
        INNER JOIN tbl_order_table2 o2 ON o.id = o2.order_id
        LEFT JOIN tbl_restaurant r ON o.res_id = r.id
        LEFT JOIN tbl_stations s ON r.station_id = s.id
        LEFT JOIN tbl_state s2 ON r.state = s2.id
        WHERE DATE(o.ordering_time)  ='$today' 
        AND ( o2.item_name LIKE  '%aquafina%')
        ORDER BY `o2`.`item_name` ASC";
//        and o.order_status <>11 AND o.order_status <>12

        $r = help::readAll($sql);

        $heading = array('ordering_date' => 'ordering_date', 'order_id' => 'order_id', 'item_name' => 'item_name', 'item_quantity' => 'item_quantity', 'rest_name' => 'rest_name', 'station_name' => 'station_name', 'state' => 'state');
        $app_data[0] = implode('#@#', $heading);

        foreach ($r as $row) {
            $app_data[] = implode('#@#', $row);
        }



        $today = $today . '-Aquafina_Report';
        //        $file = fopen("$today.csv", "w");
        $path = Yii::app()->basePath . "/../assets/FrontEnd/aquafina_report/$today.csv";
        $file = fopen($path, 'w');

        foreach ($app_data as $line) {
            fputcsv($file, explode('#@#', $line));
        }

        fclose($file);

        $cc[0] = 'anoob.cr@yatrachef.com';
        $cc[1] = 'rameez@yatrachef.com';
        $cc[2] = 'rishi.kapoor@railyatri.in';
        $cc[3] = 'vivek.gour@railyatri.in';
        $cc[4] = 'sourabh.shekhar@railyatri.in';




        $today2 = date('Y-m-d', strtotime("-1 days"));
        $start_date2 = date("d/m/Y", strtotime($start_date));
        $to = 'arun@yatrachef.com';
        $path = Yii::app()->basePath . "/../assets/FrontEnd/aquafina_report/";
        $attach[0] = "$today.csv";

        echo $x = help::Mail_Attachment($subject = "Aquafina Order Report-($today2)", $content = 'Hi,<br>Please Find The Attached File', $to, $from = 'no-reply@yatrachef.com', $title = '', $cc, $attach, $path);
    }

    public function actiontrain_combo() {

        $sql = 'UPDATE  `tbl_menu` SET  `count` =0,count_calc=NULL,train_combo=NULL WHERE  `partner_availability` =1 ';
        help::execute($sql);

        $sql2 = "SELECT DISTINCT r.id FROM tbl_restaurant r 
                left join tbl_menu m on r.id=m.res_id 
                WHERE m.partner_availability =1 and m.status=1 and r.status=1 and (m.item_name LIKE '%wow%' or m.item_name LIKE '%thali%' or m.item_name LIKE '%meal%')";
        $r = help::readAll($sql2);

        foreach ($r as $row) {
            $rid = $row['id'];
            $sql3 = "select o2.menu_id,o2.item_name,sum(o2.item_quantity) as order_count,m.type from tbl_order_table o
                inner join tbl_order_table2 o2
                on o.id=o2.order_id 
                left join tbl_menu m
                on o2.menu_id=m.id
                where o.res_id='$rid' and o.order_status=5 and m.partner_availability =1 and m.price>0 and m.status=1
                and (m.item_name LIKE '%wow%' or m.item_name LIKE '%thali%' or m.item_name LIKE '%meal%')    
                group by o2.menu_id ";

            $r = help::readAll($sql3);

            foreach ($r as $row) {
                $mid = $row['menu_id'];
                $oc = $row['order_count'];
                $type = $row['type'];
                if ($type == 1) {
                    $sql4 = "UPDATE `tbl_menu` SET `count`='$oc',count_calc=1 where id='$mid'";
                } else {
                    $sql4 = "UPDATE `tbl_menu` SET `count`='$oc',count_calc=0 where id='$mid'";
                }

                help::execute($sql4);
            }
        }

        $sql5 = "SELECT id, res_id, count,item_name FROM `tbl_menu` WHERE `count_calc` =1  GROUP BY res_id ORDER BY count DESC ";
        $r2 = help::readAll($sql5);

        foreach ($r2 as $row2) {
//                $res_id=$row2['res_id']; 
//                $list[$res_id][]=$row2['id'];
//                $list[$res_id][]=$row2['item_name']; 

            $id = $row2['id'];
            echo $sql6 = "UPDATE `tbl_menu` SET `train_combo`=1 WHERE id='$id'";
            echo '<br>';
            help::execute($sql6);
        }

        $sql6 = "SELECT id, res_id, `count`,item_name FROM `tbl_menu` WHERE `count_calc` =0  GROUP BY res_id ORDER BY count DESC ";
        $r3 = help::readAll($sql6);
        foreach ($r3 as $row3) {
//                $res_id=$row3['res_id']; 
//                 $list[$res_id][]=$row3['id'];
//                $list[$res_id][]=$row3['item_name']; 

            $id = $row3['id'];
            echo $sql7 = "UPDATE `tbl_menu` SET `train_combo`=1 WHERE id='$id'";
            echo '<br>';
            help::execute($sql7);
        }
    }

    public function actionCreateFDticketforNegativeReview() {
        $current_time = date('H:i');
        if ((strtotime($current_time) >= strtotime('07:00')) && (strtotime($current_time) <= strtotime('22:00'))) {

            $sql = "SELECT o.freshdesk_ticket,o.real_day_time,o.order_status,o.id,u.Rating,u.Rel_Id,j.name,j.email as cust_email,j.phone_no,j.phone_no2,r.rest_name,r.email,r.contact_no1,r.contact_no1,(SELECT station_name FROM tbl_stations WHERE id=o.station) as station,o.ordered_from,u.Review
            FROM tbl_order_table o
            LEFT JOIN tbl_user_reviews u ON o.id=u.Order_id
            INNER JOIN tbl_journey j ON o.cust_id=j.cust_id
            INNER JOIN tbl_restaurant r ON o.res_id=r.id
            WHERE  (DATE(o.real_day_time) BETWEEN DATE(CURDATE()-INTERVAL 1 DAY) AND CURDATE() ) AND (u.Rating=1 OR u.Rating=2)  AND o.freshdesk_ticket is NULL AND (u.Review is not null AND u.Review!='')
            ORDER BY `u`.`Review`  DESC";
            $data = help::readAll($sql);
            echo '<pre>';

            foreach ($data as $odr) {
//            print_r($odr);

                $id = $odr['id'];
                $subject = '';


                $rest_name = explode('_', $odr['rest_name']);
                $rest_name = $rest_name[0];

                $orginal_data['name'] = $odr['name'];
                $orginal_data['phone'] = $odr['phone_no'];
                $orginal_data['email'] = $odr['cust_email'];

                $orginal_data['custom_fields'] = array('order_id' => (int) ($id));
                $orginal_data['description'] = 'Customer Rating : <b>' . $odr['Rating'] . ' Star</b><br>Customer Review : <b style="color: #bf3434;">' . $odr['Review'] . '</b> <br><br>Customer Name : ' . $odr['name'] . '<br>'
                        . 'Phone Number 1 : ' . $odr['phone_no'] . '<br>'
                        . 'Phone Number 2 : ' . $odr['phone_no2'] . '<br>'
                        . 'Email : ' . $odr['cust_email'] . '<br>'
                        . 'Order Id : <b>' . $id . '</b><br>'
                        . 'Restaurant Name : ' . $rest_name . '<br>'
                        . 'Station : ' . $odr['station'] . '<br><br>'
                        . 'Date of Delivery : ' . date('d-m-Y', strtotime($odr['real_day_time'])) . '<br><br>'
                        . '<a class="btn btn-primary" style="    background: rgb(173, 140, 91);" href="https://cc.yatrachef.com/index.php/order/details/id/' . $id . '" target="_blank">View Order</a>';




                $ticket_reason = 'Negative Feedback - ' . $rest_name . ' for Order Id #' . $id;

                $orginal_data['subject'] = $ticket_reason;    //            $orginal_data['custom_fields'] = array('train_no' => (int) ($cusdata['train_no']));
                $orginal_data['priority'] = 1;
                $orginal_data['status'] = 2;
                $orginal_data['source'] = 2;
                $orginal_data['group_id'] = 9000113860;
                $orginal_data['type'] = 'Complaint';



                print_r($orginal_data);

                $resp = help::NewFreshdeskTicket($orginal_data, $rep = 1);
                $resp = json_decode($resp);
                //      $resp->id = 123;
                $msg = 'Ticket created for ' . $rest_name . ' failed order. Tickket id <a href="https://yatrachef.freshdesk.com/helpdesk/tickets/' . $resp->id . '"  target="_blank">#' . $resp->id . '</a>';
                OrderController::createtag($msg, $id, $type = 'Ticket Created for Negative feedback ' . $resp->id, $cat = 39, $mode = 0, $user_id = $resp->id);
                if ($resp->id != NULL) {
                    if (help::execute("UPDATE tbl_order_table SET freshdesk_ticket='$resp->id' WHERE id='$id'")) {
                        echo 'SUCCESS';
                    }
                }

//            echo '<br>';
//                die;
            }
        }
    }

    public function actionUpdateSamplesFeedback() {
        $sql = "SELECT c.emp_id,c.recording_url,c.order_id  FROM tbl_callList c
LEFT JOIN sample_products_feedback s ON s.order_id=c.order_id
WHERE call_type='3' AND DATE(s.date_time ) = CURDATE() AND s.recording_url is NULL";
        $data = help::readAll($sql);
        echo '<pre>';
        foreach ($data as $row) {
            print_r($row);
            $sql = "UPDATE sample_products_feedback SET recording_url='" . $row['recording_url'] . "' , emp_id='" . $row['emp_id'] . "' WHERE order_id='" . $row['order_id'] . "'";
            echo $sql . '<br>';
            if (help::execute($sql)) {
                echo 'SUCCESS';
            } else {
                echo 'FAIL';
            }
        }
    }

    public function actionUpdateETAafterOdrSuccess($oid, $eta = NULL) {

        $msg = 'Updated ETA ' . $eta;
        OrderController::createtag($msg, $oid, $type = 'ETA updation', $cat = 5);

        $url = "https://cc.yatrachef.com/index.php/url2/UpdateETAafterOdrSuccess/oid/413609/eta/2017-12-26%2012:11:00";
    }

    public function actioncombo_update() {
        $sql = "SELECT res_id
        FROM  `tbl_menu` 
        WHERE  `combo_id` IS NOT NULL group by res_id ";

        $r = help::readAll($sql);
        foreach ($r as $row) {
            $res_id = $row['res_id'];
            $sql2 = "SELECT  GROUP_CONCAT(id  SEPARATOR ', ') as combo_id FROM tbl_menu  WHERE res_id='$res_id' and ry_category LIKE '%36%' and status=1";
            $r2 = help::getScalar($sql2);

            if ($r2 == '') {
                $sql3 = "UPDATE `tbl_menu` SET `combo_id`=NULL where res_id='$res_id' and `combo_id` is not null";
            } else {
                $sql3 = "UPDATE `tbl_menu` SET `combo_id`='$r2' where res_id='$res_id' and `combo_id` is not null";
            }

            if (help::execute($sql3)) {
                $this->combo_mountain_dew();
            } else {
                echo $res_id;
                echo '<br>';
            }
        }
    }

    public function combo_mountain_dew() {
        $sql = "SELECT id,combo_id,res_id  FROM `tbl_menu` WHERE `combo_id` IS NOT NULL";
        $r = help::readAll($sql);

        foreach ($r as $row) {
//            $m = array();

            $cid = $row['combo_id'];

            $r1 = explode(',', $cid);
            if (count($r1) > 1) {
                $menu_id = $row['id'];
                $mid1 = $r1[0];
                $mid2 = $r1[1];
                $mid3 = $r1[2];
                $mid4 = $r1[3];

                $sql1 = "select item_name from tbl_menu where id='$mid1'";
                $r = help::getScalar($sql1);

                if (strpos($r, 'Pepsi') !== false) {
                    echo $r;
                    echo '<br>';
                } else {
                    $menu_id = $row['id'];
                    $res_id = $row['res_id'];
                    $sql2 = "select id from tbl_menu where item_name like '%Pepsi%' and res_id='$res_id' and status=1";
                    $r2 = help::getScalar($sql2);
                    if ($r2 > 1) {
                        $m[0] = str_replace(' ', '', $r2);
                        $m[1] = str_replace(' ', '', $mid1);
                        $m[2] = str_replace(' ', '', $mid2);
                        $m[3] = str_replace(' ', '', $mid3);
                        $m[4] = str_replace(' ', '', $mid4);
                    }

                    $m2 = array_unique($m);
                    $new = implode(',', $m2);
                    $sql2 = "UPDATE `tbl_menu` SET `combo_id`='$new' where id='$menu_id'";
                    if (help::execute($sql2)) {
                        echo $sql2;
                        echo '<br>';
                    } else {
                        echo '----------' . $menu_id . '---------';
                        echo '<br>';
                    }
                }
            }
        }
    }

    public function actionUpdateMissedCalls() {
        $sql = 'SELECT call_response_id,phone,Rep_Id,extension,date_time,duration,status,id,picked_up,call_response,called_number 
              FROM `tbl_callList` 
              WHERE date_time >= DATE_SUB(NOW(),INTERVAL 5 HOUR) AND picked_up=0
              AND (status=1 OR (status=4 AND TIME( duration ) >= "00:00:06")) AND (call_response="2" OR phone="8039513455")
              GROUP BY phone ORDER BY date_time ASC'; // AND called_number!="914847110156" AND called_number!="914847110158" 
        $data = help::readAll($sql);
        echo '<pre>';
        foreach ($data as $row) {
            $id = $row['id'];
            if (($row['phone'] == '8039513455') || ($row['phone'] == '918039513455')) {
                $sql = "UPDATE `tbl_callList` SET `picked_up`='1',`who_picked_up`='Auto' WHERE id='$id'";
                if (help::execute($sql)) {
                    echo 'S';
                } else {
                    echo 'F';
                }
            }
            if ($row['call_response_id'] != NULL) {
                $sql = "SELECT duration FROM `tbl_callList` WHERE `id` = " . $row['call_response_id'] . " AND TIME( duration ) <= '00:00:10'";
                $call_recived = help::getscalar($sql);

                if ($call_recived == NULL) {
                    $sql = "UPDATE `tbl_callList` SET `picked_up`='1',`who_picked_up`='Auto' WHERE id='$id'";
                    if (help::execute($sql)) {
                        echo 'S';
                    } else {
                        echo 'F';
                    }
                }
            }
            echo '<hr>';
//            print_r($row);
        }
    }

    public function actionBulkODRdelivery() {
        $sql = "SELECT id,DATE(real_day_time)  FROM `tbl_order_table` WHERE `order_status` =1 AND `vendor_dispatch_time` IS NOT NULL  AND `temp_delivery_status` =1 AND YEAR(real_day_time)='2018' ";
        $data = help::readAll($sql);
        foreach ($data as $row) {
            $id = $row['id'];
            $tag = "Food Deliverd Status Changed using automated system.( vendor dispatched and food delivered from vendor app)";
            OrderController::createtag($msg = $tag, $id = $row['id'], $type = 'Delivered To Customer', $cat = 5);
            $sql1 = "UPDATE tbl_order_table SET order_status='5' WHERE id='$id' AND order_status='1'";
            if (help::execute($sql1)) {
                $statue = 'success';
            } else {
                $statue = 'failed';
            }
            echo $id . '----' . $statue . '<br>';
//            die;
        }
    }

    public function actionDeleteUnwantedData() {
        $sql1 = "DELETE FROM `history_order_table` WHERE DATE(updated_time) NOT BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()";
        if (help::execute($sql1)) {
            echo 'SUCCESS history_order_table <br>';
        }
        $sql2 = "DELETE FROM `history_menu` WHERE DATE(last_updated_at) NOT BETWEEN CURDATE() - INTERVAL 100 DAY AND CURDATE()";
        if (help::execute($sql2)) {
            echo 'SUCCESS history_menu <br>';
        }
        $sql3 = "DELETE FROM  `tbl_cron_process` WHERE STATUS IS NULL AND DATE( created_at ) NOT BETWEEN CURDATE( ) - INTERVAL 30 DAY AND CURDATE( )";
        if (help::execute($sql3)) {
            echo 'SUCCESS tbl_cron_process <br>';
        }
    }

    public function actionClearCallList() {
//        $last_id = help::getscalar("SELECT id FROM `backup_tbl_callList`  ORDER By id DESC limit 1");
        echo $sql = "INSERT INTO backup_tbl_callList 
(SELECT * FROM tbl_callList WHERE  DATE(date_time) NOT BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE())";
        if (help::execute($sql)) {
            $sql = "DELETE FROM tbl_callList 
                    WHERE DATE(date_time) NOT BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()";
            if (help::execute($sql)) {
                echo 'SUCCESS';
            }
        }
    }

    public function actionrestaurantFailedOrder($oid = NULL, $reason_id = NULL) {
        if (($oid == NULL) && ($reason_id == NULL)) {
            echo '0';
            die;
        }

        $now = date('Y-m-d H:i:s');

        $sql = "SELECT failed_by_rest_code,reason_type,description FROM `cancel_reasons` where id='$reason_id'";
        $data_temp = help::read($sql);
        $yc_reason = $data_temp['failed_by_rest_code'];
        $reason_type = $data_temp['reason_type'];
        $failed_reason = ($yc_reason != NULL) ? $yc_reason : $reason_id;

//        $html='order id : '.$oid.'<br>reason id- '.$reason_id.'<br>marked id-'.$failed_reason.'<br>'.$data_temp['failed_by_rest_code'];
//        $html.='<br>rtype'.$reason_type;
//        $cc[0] = '';
//        $bcc[0] = $temp[0] = '';
//        $to = 'akhil.tm@yatrachef.com';
//        $subject = 'Vtest';
//        $text = strip_tags($content);
//        $x = help::Mail_Bulk($subject, $html, $to, $from = 'no-reply@yatrachef.com', $title = 'TESTING', $cc, $text = 0, $bcc);
        $res_id = help::getscalar("SELECT res_id FROM `tbl_order_table` WHERE `id` = '$oid'");
        if ($reason_type == 3) {
            $sql = "UPDATE tbl_order_table SET order_status='9',failed_reason='$failed_reason',updated_at='$now' where id='$oid'";
            if (help::execute($sql)) {
                $msg = 'Order Status Changed to <b>Failed by Restaurant</b> From RY Vendor App<br>Reason : ' . $data_temp['description'];
                $events = 'Order Failed by Restaurant';
                $this->entertag($oid, $category = 43, $msg, $events, $res_id);

                $sql0 = "SELECT `wallet_amount`,`online` FROM `tbl_order_table` WHERE id='$oid'";
                $r0 = help::read($sql0);
                $wallet_amount = $r0['wallet_amount'];
                $pg_amount = $r0['online'];
                $ctime = date('Y-m-d H:i:s');

                if (($wallet_amount > 0) || ($pg_amount > 0)) {

                    $sql1 = "SELECT  `pg_refund`, `wallet_refund` FROM `tbl_refund` WHERE order_id=$oid";
                    $r = help::read($sql1);

                    if ($r == '') {
                        $sql2 = "INSERT INTO `tbl_refund`( `order_id`, `pg_refund`, `pending_pg_refund`, `wallet_refund`, `pending_wallet_refund`,
            `sc_refund`, `pending_sc_refund`, `refund_mode`, `refund_status`, `refund_time`,refund_req_source)
            values('$oid','$pg_amount','$pg_amount','$wallet_amount','$wallet_amount','','','1','1','$ctime','6')";
                    } else {
                        $sql2 = "UPDATE `tbl_refund` SET `pg_refund`=$pg_amount,`pending_pg_refund`=$pg_amount,
            `wallet_refund`=$wallet_amount,`pending_wallet_refund`=$wallet_amount,`sc_refund`='',
            `pending_sc_refund`='',`refund_mode`='1',`refund_status`='1',`refund_time`='$ctime',refund_req_source='6' WHERE order_id='$oid'";
                    }


                    $sql3 = "INSERT INTO `tbl_refund_log`( `order_id`, `refund_amount`, `event_time`, `agent_id`, `message`)
            VALUES ('$oid','$pg_amount+$wallet_amount','$ctime','','Refund was raised when order was marked as failed by restaurant from RY Vendor App')";
                    $check0 = 0;
                    if ((help::execute($sql2)) && (help::execute($sql3))) {
                        $check0 = 1;
                        $url = 'http://test.railyatri.in/api/insert-refund-history.json?order_id=' . $oid . '&event_name=ticket_cancelled&ecomm_type=0';
                        $output = help::api_get($url, $time_out = 8000, $json = 1);

                        $this->entertag($oid, $category = '', $msg = "Refund was raised when order was marked as failed by restaurant from RY Vendor App", $events = 'Refund raised');
                    }
                }


                $sql4 = "SELECT id FROM `tbl_rest_failed_orders` WHERE `order_id`='$oid'";
                $result2 = help::getScalar($sql4);
                $cdate = date('Y-m-d H:i:s');
                if ($result2 == '' || $result2 == NULL) {
                    $sql5 = "INSERT INTO `tbl_rest_failed_orders`(`order_id`, `cancellation_charge`, `order_fail_time`,`last_updated`, `order_status`)
            VALUES ('$oid','100','$cdate','$cdate','')";

                    help::execute($sql5);
                    $msg = '<b>100 Rupees Penality charged</b> when the order is marked as failed by restaurant from RY vendor app ';
                    $this->entertag($tag_msg, $id = $oid, $type = 'Cancellation fee charged', $cat = 37);
                    $this->entertag($oid, $category = '37', $msg, $events = 'penality charged');
                }
                echo '1';
            } else {
                echo '0';
            }
        } else if ($reason_type == 4) {
            $sql = "UPDATE tbl_order_table SET order_status='3',failed_reason='$failed_reason',updated_at='$now' where id='$oid'";
            if (help::execute($sql)) {
                $msg = 'Order Status Changed to <b>Failed</b> From RY Vendor App<br>Reason : ' . $data_temp['description'];
                $events = 'Order Failed';
                $this->entertag($oid, $category = 45, $msg, $events, $res_id);
                echo '1';
            } else {
                echo '0';
            }
        }
    }

    public function actionrestaurantCanceledOrder($oid) {

        $msg = 'Order Status Changed to Canceled by Restaurant From RY Vendor App, & Alert mail send to the account manager';
        $events = 'Order Canceled by Restaurant';
        $this->entertag($oid, $category = 44, $msg, $events);

        $sql0 = "SELECT `wallet_amount`,`online` FROM `tbl_order_table` WHERE id='$oid'";
        $r0 = help::read($sql0);
        $wallet_amount = $r0['wallet_amount'];
        $pg_amount = $r0['online'];
        $ctime = date('Y-m-d H:i:s');

        if (($wallet_amount > 0) || ($pg_amount > 0)) {

            $sql1 = "SELECT  `pg_refund`, `wallet_refund` FROM `tbl_refund` WHERE order_id=$oid";
            $r = help::read($sql1);

            if ($r == '') {
                $sql2 = "INSERT INTO `tbl_refund`( `order_id`, `pg_refund`, `pending_pg_refund`, `wallet_refund`, `pending_wallet_refund`,
            `sc_refund`, `pending_sc_refund`, `refund_mode`, `refund_status`, `refund_time`,refund_req_source)
            values('$oid','$pg_amount','$pg_amount','$wallet_amount','$wallet_amount','','','1','1','$ctime','6')";
            } else {
                $sql2 = "UPDATE `tbl_refund` SET `pg_refund`=$pg_amount,`pending_pg_refund`=$pg_amount,
            `wallet_refund`=$wallet_amount,`pending_wallet_refund`=$wallet_amount,`sc_refund`='',
            `pending_sc_refund`='',`refund_mode`='1',`refund_status`='1',`refund_time`='$ctime',refund_req_source='6' WHERE order_id='$oid'";
            }


            $sql3 = "INSERT INTO `tbl_refund_log`( `order_id`, `refund_amount`, `event_time`, `agent_id`, `message`)
            VALUES ('$oid','$pg_amount+$wallet_amount','$ctime','','Refund was raised when order was marked as Canceled by restaurant from RY Vendor App')";

            if ((help::execute($sql2)) && (help::execute($sql3))) {
                $url = 'http://api.railyatri.in/api/insert-refund-history.json?order_id=' . $oid . '&event_name=ticket_cancelled&ecomm_type=0';
                $output = help::api_get($url, $time_out = 8000, $json = 1);

                $this->entertag($oid, $category = '', $msg = "Refund was raised when order was marked as Canceled by restaurant from RY Vendor App", $events = 'Refund raised');
            }
        }



        help::api_get('http://api.yatrachef.com/live/index.php/app/CancelRest_mail/oid/' . $oid, $time_out = 10000, $json = 1);

        print_r("1");
    }

    public function entertag($oid, $category = '', $msg = '', $events = '', $res_id = NULL) {
        $q1 = $q2 = '';
        if ($res_id != NULL) {
            $q1 = ',user_type,tagged_by';
            $q2 = ",'1','$res_id'";
        }
        $cdate = date('Y-m-d H:i:s');
        $sql = "INSERT into tbl_tagging(order_id,category,message,events,event_time $q1)
            VALUES('$oid','43','$msg','$events','$cdate' $q2)";
        help::execute($sql);
    }

    public function actionBulkMailAlert() {
        $sql = "SELECT j.name,s.station_name,o.cod,o.online,o.id as orderId,r.rest_name,o.real_day_time,o.payment_type,o.cust_id,o.issue_status,o.present_total,o.verify_customer_display,o.orderPassedRest,o.orderConfirmRest,o.vendor_dispatch_time,(SELECT GROUP_CONCAT(item_name  SEPARATOR ', ')  FROM `tbl_order_table2` WHERE `order_id` = o.id) as `menu_items`
                FROM tbl_order_table o
                INNER JOIN tbl_restaurant r ON r.id=o.res_id
                INNER JOIN tbl_stations s ON s.id=o.station
                INNER JOIN tbl_journey j ON j.cust_id=o.cust_id
                WHERE o.order_status='1' AND (o.splOption1='1' OR o.present_total>1500) AND ( (DATE(o.real_day_time) = CURDATE() AND TIME(o.real_day_time) >='20:00:00' ) OR (DATE(o.real_day_time) = CURDATE() + INTERVAL 1 DAY  AND TIME(o.real_day_time) <='22:00:00') )
                ORDER BY real_day_time ASC, r.id ASC ";
        $bulk_data = help::readAll($sql);
        $total_count = sizeof($bulk_data);

        $html = '';
        $style = 'border-right:1px solid #cccccc;border-bottom:1px solid #cccccc;padding:3px;text-align:center;';
        $html .= '<div>
<div style="    position: absolute;padding: 7px 0px;width: 100%;text-align: left;font-weight: 100;">Orders in between 8pm to 10pm</div>
    <div style="padding: 7px 0px;width: 70%;text-align: right;font-weight: 100;">Total Orders : ' . $total_count . '</div>
<div>  
            <table class="table table-striped table-bordered" border="0" style="border:1px solid #cccccc;    width: 100%;">
                            <thead>
                                <tr  style="background: #e0e0e0;' . $style . '">
                                    <th style="' . $style . '"> Order_ID</th>
                                        <th style="' . $style . '"> Client</th>
                                    <th style="' . $style . '"> Rest.Name </th>
                                    <th style="' . $style . '"> STA DT</th>
                                    <th style="' . $style . '"> STA TIME</th>
                                    <th style="' . $style . '"> Payment</th>
                                    <th style="' . $style . '"> Value</th>
                                    <th style="' . $style . '"> CV</th>
                                     <th style="' . $style . '"> OP</th>
                                          <th style="' . $style . '"> OC</th>
                                              <th style="border-bottom:1px solid #cccccc;"> DISP</th>
                                               <th style="border-bottom:1px solid #cccccc;"> COD</th>
                                               <th style="border-bottom:1px solid #cccccc;"> Online</th>
                                                 <th style="border-bottom:1px solid #cccccc;"> Menu</th>
                                    </tr style="' . $style . '"></thead><tbody>';
        $i = 0;
        foreach ($bulk_data as $row) {
            $temp_rest = explode('_', $row['rest_name']);
            $html .= '<tr style="' . $style . '">
                                    <td style="' . $style . '"><a target="_blank" href="https://cc.yatrachef.com/index.php/order/details/id/' . $row['orderId'] . '" >' . $row['orderId'] . '</a></td>
                                    <td style="' . $style . '">' . $row['name'] . '</td> 
                                    <td style="' . $style . '">' . $temp_rest[0] . ' <br><small>(' . $row['station_name'] . ')</td>
                                    <td style="' . $style . '">' . date('d-m-Y', strtotime($row['real_day_time'])) . '</td>
                                         <td style="' . $style . '">' . date('H:i:s', strtotime($row['real_day_time'])) . '</td>
                                    <td style="' . $style . '">' . (($row['payment_type'] == 'Online_Payment') ? 'Online' : 'Cod') . '</td>
                                    <td style="' . $style . '">' . $row['present_total'] . '</td>
                                    <td style="' . $style . '">' . (( $row['verify_customer_display'] == 1) ? '<b>YES</b>' : 'NO') . '</td>
                                    <td style="' . $style . '">' . (( $row['orderPassedRest'] == 1) ? '<b>YES</b>' : 'NO') . '</td>
                                    <td style="' . $style . '">' . (( $row['orderConfirmRest'] == 1) ? '<b>YES</b>' : 'NO') . '</td>
                                    <td style="' . $style . '">' . (( $row['vendor_dispatch_time'] == NULL) ? 'NO' : '<b>YES</b>') . '</td>
                                        <td style="' . $style . '">' . $row['cod'] . '</td>
                                             <td style="' . $style . '">' . $row['online'] . '</td>
                                            
                                            <td style="border-bottom:1px solid #cccccc;"><small>' . $row['menu_items'] . '</small></td>
                                       
                                    </tr>';
            $i++;
        }
        $html .= '</tbody></table>';
//        echo $html;
//        die;

        $today = date('d-m-Y');
        $tomorrow = date("Y-m-d", strtotime("+1 day"));

        $cc[0] = 'preeti.n@yatrachef.com';
        $cc[1] = 'rishi.kapoor@railyatri.in';
        $cc[2] = 'rahul.rajpoot@railyatri.in';
        $cc[3] = 'DINESH.PANT@railyatri.in';
        $cc[4] = 'akhil.tm@yatrachef.com';

        $bcc[0] = $temp[0] = '';
        $to = 'rameez@yatrachef.com';
        $subject = 'Bulk Order Details ( ' . $today . ' - ' . $tomorrow . ' )';
        $text = strip_tags($content);
//        if ($view_more == NULL) {
//            echo 'send mail'; echo $html;
        $x = help::Mail_Bulk($subject, $html, $to, $from = 'no-reply@yatrachef.com', $title = 'Bulk Orders', $cc, $text = 0, $bcc);
//            print_r($x);
//        } else {
//            echo $html;
//        }
    }

    public function actionNicotex() {
        $sql = "SELECT o.id as order_id,DATE(o.ordering_time) as delivery_date,o.real_day_time,j.email,j.name,j.phone_no,j.train_no,j.train_name,j.pnr,j.seat_no,j.coach_no,s.station_name,r.rest_name
FROM tbl_order_table o
INNER JOIN tbl_restaurant r ON r.id=o.res_id
INNER JOIN tbl_journey j ON j.cust_id=o.cust_id
INNER JOIN tbl_stations s ON o.station= s.id
WHERE o.order_status NOT IN ('11','12') AND j.test_order=0 AND o.sample_product_ids='2' AND DATE(o.ordering_time)=DATE_ADD(CURDATE(), INTERVAL -1 DAY)
ORDER BY DATE(o.ordering_time) DESC";
//         $sql = "SELECT o.id as order_id,DATE(o.ordering_time) as delivery_date,o.real_day_time,j.name,j.email,j.phone_no,j.train_no,j.train_name,j.pnr,j.seat_no,j.coach_no,s.station_name,r.rest_name
//FROM tbl_order_table o
//INNER JOIN tbl_restaurant r ON r.id=o.res_id
//INNER JOIN tbl_journey j ON j.cust_id=o.cust_id
//INNER JOIN tbl_stations s ON o.station= s.id
//WHERE o.order_status NOT IN ('11','12') AND j.test_order=0 AND o.sample_product_ids='2' AND (DATE(o.ordering_time) BETWEEN DATE_ADD(CURDATE(), INTERVAL -14 DAY) AND DATE_ADD(CURDATE(), INTERVAL -1 DAY))
//ORDER BY DATE(o.ordering_time) DESC";
        $bulk_data = help::readAll($sql);
        $total_count = sizeof($bulk_data);

        $html = '';
        $style = 'border-right:1px solid #cccccc;border-bottom:1px solid #cccccc;padding:3px;text-align:center;';
        $html .= '<div>

    <div style="padding: 7px 0px;width: 100%;text-align: right;font-weight: 100;">Total Orders : ' . $total_count . '</div>
<div>  
            <table class="table table-striped table-bordered" border="0" style="border:1px solid #cccccc;    width: 100%;">
                            <thead>
                                <tr  style="background: #e0e0e0;' . $style . '">
                                    <th style="' . $style . '"> Order_ID</th>
                                    <th style="' . $style . '   ; width: 90px;"> Ordering Dt</th>
                                         <th style="' . $style . '   ; width: 90px;"> Delivery Dt</th>
                                              <th style="' . $style . '   ; width: 90px;"> STA</th>
                                    <th style="' . $style . '"> Customer Name </th>
                                    <th style="' . $style . '"> Customer Phone </th>
                                         <th style="' . $style . '"> C. Email </th>
                                    <th style="' . $style . '"> Rest.Name </th>
                                    <th style="' . $style . '"> Station </th>
                                    <th style="' . $style . '"> Train</th>
                                    <th style="' . $style . '"> Train Name</th>
                                    <th style="' . $style . '"> PNR</th>
                                    <th style="border-bottom:1px solid #cccccc;"> Seat/Coach</th>
                                    </tr style="' . $style . '"></thead><tbody>';
        $i = 0;
        foreach ($bulk_data as $row) {
            $temp_rest = explode('_', $row['rest_name']);
            $html .= '<tr style="' . $style . '">
                                    <td style="' . $style . '">' . $row['order_id'] . '</td>
                                    <td style="' . $style . '">' . date('d-m-Y', strtotime($row['delivery_date'])) . '</td>
                                        <td style="' . $style . '">' . date('d-m-Y', strtotime($row['real_day_time'])) . '</td>
                                            <td style="' . $style . '">' . date('H:i', strtotime($row['real_day_time'])) . '</td>
                                    <td style="' . $style . '">' . $row['name'] . '</td>
                                    <td style="' . $style . '">' . $row['phone_no'] . '</td>
                                        <td style="' . $style . '">' . $row['email'] . '</td>
                                    <td style="' . $style . '">' . $temp_rest[0] . '</td>
                                    <td style="' . $style . '">' . $row['station_name'] . '</td>    
                                    <td style="' . $style . '">' . $row['train_no'] . '</td>
                                    <td style="' . $style . '">' . $row['train_name'] . '</td>    
                                    <td style="' . $style . '">' . $row['pnr'] . '</td>    
                                    <td style="border-bottom:1px solid #cccccc;">' . $row['seat_no'] . ' / ' . $row['coach_no'] . '</td>    
                                   
                                       
                                    </tr>';
            $i++;
        }
        $html .= '</tbody></table>';
//        echo $html;die;

        $today = date('d-m-Y');
        $tomorrow = date("Y-m-d", strtotime("-1 day"));

        $cc[0] = 'arun@yatrachef.com';
        $cc[1] = 'akhil.tm@yatrachef.com';
//        $cc[0] = '';

        $bcc[0] = $temp[0] = '';
        $to = 'vivek.gour@railyatri.in';
        $subject = 'Nicotex Order Details ( ' . $tomorrow . ' )';
        $text = strip_tags($content);
        $x = help::Mail_Bulk($subject, $html, $to, $from = 'no-reply@yatrachef.com', $title = 'Nicotex Report', $cc, $text = 0, $bcc);
    }

    public function actionNicotexFeedback() {

        $date = date("Y-m-d", strtotime("-1 day"));
        $q1 = " AND DATE(o.ordering_time)='$date' ";

        $sql = "SELECT o.id as order_id,DATE(o.ordering_time) as ordering_date,s.station_name,r.rest_name,m.name as rest_manager,f.question3,f.comments,f.date_time as feedback_time
            FROM tbl_order_table o
            INNER JOIN tbl_restaurant r ON r.id=o.res_id
            INNER JOIN tbl_journey j ON j.cust_id=o.cust_id
            INNER JOIN tbl_stations s ON o.station= s.id
            INNER JOIN sample_products_feedback f ON o.id=f.order_id
            LEFT JOIN tbl_account_manager m ON m.id=r.account_manager_id
            WHERE  j.test_order=0 $q1 AND f.sample_id='2'  AND o.sample_product_ids='2'
            ORDER BY `ordering_date`  DESC";
        $bulk_data = help::readAll($sql);
        $total_count = sizeof($bulk_data);
//'<form action="https://cc.yatrachef.com/index.php/url2/NicotexFeedback" method="get">
//            <input type="text" name="date" placeholder="Date YYYY-MM-DD"/><input type="submit" name="search"/>
//</form>'
        $html = '';
        $style = 'border-right:1px solid #cccccc;border-bottom:1px solid #cccccc;padding:3px;text-align:center;';
        $html .= '<div>

    <div style="padding: 7px 0px;width: 70%;text-align: right;font-weight: 100;">Total Orders : ' . $total_count . '</div>
<div>  
            <table class="table table-striped table-bordered" border="0" style="border:1px solid #cccccc;    width: 70%;">
                            <thead>
                                <tr  style="background: #e0e0e0;' . $style . '">
                                    <th style="' . $style . '"> Order_ID</th>
                                    <th style="' . $style . '   ; width: 90px;"> Ordering Dt</th>
                                    <th style="' . $style . '"> Station </th>
                                   
                                    <th style="' . $style . '"> Rest.Name </th>
                                    <th style="' . $style . '"> Station </th>
                                    <th style="' . $style . '"> Manager</th>
                                    <th style="' . $style . '"> Nicotex Received</th>
                                  
                                   
                                    </tr style="' . $style . '"></thead><tbody>';
        $i = 0;
        foreach ($bulk_data as $row) {
            $temp_rest = explode('_', $row['rest_name']);
            $html .= '<tr style="' . $style . '">
                                    <td style="' . $style . '">' . $row['order_id'] . '</td>
                                    <td style="' . $style . '">' . date('d-m-Y', strtotime($row['ordering_date'])) . '</td>
                                    <td style="' . $style . '">' . $row['station_name'] . '</td>
                                    <td style="' . $style . '">' . $temp_rest[0] . '</td>
                                    <td style="' . $style . '">' . $row['station_name'] . '</td>    
                                    <td style="' . $style . '">' . $row['rest_manager'] . '</td>
                                    <td style="' . $style . '">' . (($row['question3'] == 1) ? '<b>Yes</b>' : 'No') . '</td>    
                                  
                                 
                                   
                                       
                                    </tr>';
            $i++;
        }
        $html .= '</tbody></table>';

        die;
//        echo $html;
//        die;
//        $today = date('d-m-Y');


        $cc[0] = 'rishi.kapoor@railyatri.in';
        $cc[1] = 'akhil.tm@yatrachef.com';

        $bcc[0] = $temp[0] = '';
        $to = 'rameez@yatrachef.com';
        $subject = 'Nicotex Feedback Details ( ' . $date . ' )';
        $text = strip_tags($content);
        $x = help::Mail_Bulk($subject, $html, $to, $from = 'no-reply@yatrachef.com', $title = 'Nicotex Feedback Report', $cc, $text = 0, $bcc);
    }

    public function actionBTLcalls($date = NULL) {
        $style = 'border-right:1px solid #cccccc;border-bottom:1px solid #cccccc;padding:3px;'; //text-align:center;
        $date = date("Y-m-d", strtotime($date)); //"-1 day"
        $sql = "SELECT phone,count(*) as count   FROM `tbl_callList` WHERE `called_number` LIKE '%4847103314%' AND DATE(date_time)='$date' GROUP BY phone";

        $calls = help::readAll($sql);
        $total_count = sizeof($calls);
        $html .= '<div>

    <div style="padding: 7px 0px;width: 50%;text-align: right;font-weight: 100;">Date : ' . $date . ' &nbsp;&nbsp;&nbsp;Total Orders : ' . $total_count . '</div>
<div>  
            <table class="table table-striped table-bordered" border="0" style="border:1px solid #cccccc;    width: 50%;">
                            <thead>
                                <tr  style="background: #e0e0e0;' . $style . '">
                                    <th style="' . $style . '"> Phone Number</th>
                                    <th style="' . $style . '   ; width: 90px;"> Count</th>
                                    <th style="' . $style . '"> Order Status </th>
                                   </tr style="' . $style . '"></thead><tbody>';
        $i = 0;
        $count = 0;
        foreach ($calls as $row) {

            $html .= '<tr style="' . $style . '">
                                    <td style="' . $style . '">' . $row['phone'] . '</td>
                                    <td style="' . $style . '">' . $row['count'] . '</td>
                                    <td style="' . $style . '"><a target="_blank" href="https://cc.yatrachef.com/index.php/order/FullList?Stype=j.phone_no&search=' . $row['phone'] . '&Search=Search">Link</a></td>
                                     </tr>';
            $i++;
            $count += $row['count'];
        }
        $html .= '<tr style="' . $style . '">
                                    <td style="' . $style . '">Total</td>
                                    <td style="' . $style . '">' . $count . '</td>
                                    <td style="' . $style . '"></td>
                                     </tr>';
        $html .= '</tbody></table>';
        echo $html;
    }

}
