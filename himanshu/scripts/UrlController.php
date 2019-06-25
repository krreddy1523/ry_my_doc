<?php

class UrlController extends Controller {

    public function actionMailTest() {
        help::Mail($subject = 'CRON TEST' . rand(1, 10), $content = 'new cron success time ' . $cdate, $to = 'akhil.tm@yatrachef.com', $type = 1);
    }

    public function actionUpdateRealtimeTracking() {
        $sql = "UPDATE tbl_mob_ord_summary_tracking SET status=0";
        if (help::execute($sql)) {
            echo '1';
        } else {
            echo '0';
        }
    }

    public function FindNewOrder() {
        $sql = "SELECT o.real_day_time,o.id,j.name,j.email,o.order_status as DAY
            FROM tbl_order_table o
            INNER JOIN tbl_journey j ON o.cust_id=j.cust_id
            WHERE j.test_order=0 AND o.order_status=1 AND j.phone_no like '%9821051719%'"; //
        $list = help::readAll($sql);
        $count = count($list);
        if ($count > 1) {

            foreach ($list as $row) {
                $data = 'Odr id ' . $row['id'] . ' ,Delvry time ' . $row['real_day_time'] . ' <br>';
            }
            $c = help::Mail($subject = 'New Order. FROM 9821051719', $content = $data, 'akhil.tm@yatrachef.com');
            $c = help::Mail($subject = 'New Order. FROM 9821051719', $content = $data, 'rameez@yatrachef.com');
            echo 'TR';
        } else {
            echo 'FU FAIL';
        }
    }

    public function actionRemoveTestOrderFromQueue() {
        $sql = "SELECT o.real_day_time,o.id,o.order_status,j.test_order FROM tbl_order_table o
INNER JOIN tbl_journey j ON j.cust_id=o.cust_id
WHERE (DATE(o.real_day_time)=CURDATE() OR DATE(o.real_day_time)=CURDATE() + INTERVAL 1 DAY OR DATE(o.real_day_time)=CURDATE() - INTERVAL 1 DAY ) AND o.order_status=1 AND j.test_order<>0";
        $data = help::readAll($sql);
        foreach ($data as $row) {
            echo $oid = $row['id'];
            $sql = "UPDATE tbl_order_table SET order_status='8' WHERE id='$oid'";
            if (help::execute($sql)) {
                echo 'success<br>';
            } else {
                echo 'fail<br>';
            }
        }
        $this->redirect($this->createUrl('/Queue'));
    }

    public function actionDeleteAgentRating() { // remove test order
        $sql = "SELECT p.res_id,p.order_id,o.cust_id,j.test_order FROM tbl_order_table o
INNER JOIN tbl_process_team_rating p ON o.id=p.order_id
INNER JOIN tbl_journey j ON o.cust_id=j.cust_id
WHERE j.test_order<>0";
        $data = help::readAll($sql);
        print_r($data);
        $i = 1;
        foreach ($data as $row) {
            echo $i . '---';
            $id = $row['order_id'];
//            print_r($id);
            $sql = "DELETE FROM `tbl_process_team_rating` WHERE `order_id`='$id'";
            if (help::execute($sql)) {
                echo 'success';
            } else {
                echo 'fail';
            }
            echo '<br>';
            $i++;
        }
    }

    public function actionUpdateAgentRating() {//update agent rating in tbl_rest
        $sql = "SELECT id,user_rating FROM `tbl_restaurant` ORDER BY id DESC";
        $res = help::readAll($sql);
        foreach ($res as $row) {
            echo $res_id = $row['id'];
            $user_raing = $row['user_rating'];
            echo '---';
            $sql = "SELECT (SUM(Quality)/count(id)) as quality,(SUM(Packaging)/count(id)) as Packaging,(SUM(Delivery)/count(id)) as Delivery,
                    (SUM(Complaint)/count(id)) as Complaint,(SUM(Communication)/count(id)) as Communication,count(*) as count
                    FROM `tbl_process_team_rating` WHERE `res_id` = '$res_id'";
            $values = help::read($sql);
            $quality = round($values['quality'], 1);
            $Packaging = round($values['Packaging'], 1);
            $Delivery = round($values['Delivery'], 1);
            $Complaint = round($values['Complaint'], 1);
            $Communication = round($values['Communication'], 1);
            $total_count = round($values['count'], 1);
            $avg_rating = (($quality + $Packaging + $Delivery + $Complaint + $Communication) / 5);
            $avg_rating = round($avg_rating, 1);

            $sql2 = "SELECT
        SUM( CASE WHEN Rating='5' OR (vendor_experience='5' AND `Rating` IS NULL ) THEN 1 ELSE 0 END ) `five`,
        SUM( CASE WHEN Rating='4' OR (vendor_experience='4' AND `Rating` IS NULL ) THEN 1 ELSE 0 END ) `four`,
        SUM( CASE WHEN Rating='3' OR (vendor_experience='3' AND `Rating` IS NULL ) THEN 1 ELSE 0 END ) `three`,
        SUM( CASE WHEN Rating='2' OR (vendor_experience='2' AND `Rating` IS NULL ) THEN 1 ELSE 0 END ) `two`,
        SUM( CASE WHEN Rating='1' OR (vendor_experience='1' AND `Rating` IS NULL ) THEN 1 ELSE 0 END ) `one`,
        AVG(Rating) as rating,COUNT(Rating) as user_count
	FROM tbl_user_reviews WHERE  `Rel_Id` =  '$res_id'";

            $r = help::read($sql2);
            if (array_search("", $r) !== false) {
                $five = 0;
                $four = 0;
                $three = 0;
                $two = 0;
                $one = 0;
            } else {
                $five = $r['five'];
                $four = $r['four'];
                $three = $r['three'];
                $two = $r['two'];
                $one = $r['one'];
            }

            $both_count = $one + $two + $three + $four + $five;
            $mail_plus_feedback = (($five * 5) + ($four * 4) + ($three * 3) + ($two * 2) + $one) / ($both_count);
            $mail_plus_feedback = round($mail_plus_feedback, 1);
            $mail_plus_feedback = ($mail_plus_feedback != '0.0') ? $mail_plus_feedback : 0;

            $user_c = $r['user_count'];
            $avg = $r['rating'];
            $avg = round($avg, 1);
            $avg = ($avg != '0.0') ? $avg : 0;

            //$sql = "INSERT INTO `tbl_restaurant_rating`( `Res_id`, `User_rating`, `agent_rating_avg`, `Quality`, `Packaging`, `Delivery`, `Complaint`, `Communication`, `Last_updated`) "
            //     . " VALUES ('$res_id','$user_raing','$avg_rating','$quality','$Packaging','$Delivery','$Complaint','$Communication',NOW())";
            echo $sql = "UPDATE `tbl_restaurant_rating` SET `User_rating`=$avg,`all_rating`='$mail_plus_feedback',`agent_rating_avg`=$avg_rating,`Quality`=$quality,`Packaging`=$Packaging,`Delivery`=$Delivery,`Complaint`=$Complaint,`Communication`=$Communication,`one_star`=$one,`two_star`=$two,`three_star`=$three,`four_star`=$four,`five_star`=$five,`Last_updated`=NOW() WHERE `Res_id`=$res_id";
            if (help::execute($sql)) {

                $sql = "SELECT Id FROM tbl_restaurant_rating WHERE Res_id='$res_id' AND User_rating='$avg' AND agent_rating_avg='$avg_rating' AND Quality='$quality'";
                $rate_id = help::getscalar($sql);
                echo '<br>';
                echo $update = "UPDATE tbl_restaurant SET user_rating='$avg',`all_rating`='$mail_plus_feedback',user_rating_count='$user_c',`agent_rating`='$avg_rating',agent_rating_id='$rate_id' WHERE id='$res_id'";
                help::execute($update);

                help::execute($sql);
                echo 'success';
            } else {
                echo 'fail';
            }
//            print_r($values);
            echo '<br>';
//            die;
        }
    }

    public function actionrest_success_percent() {
        $today = date('Y-m-d', strtotime("-0 days"));
        $start_date = '2015-05-01';

        $sql = "SELECT
        r.rest_name,r.id as rest_id,
        SUM( CASE WHEN ( o.order_status='5' or o.order_status='7' or o.order_status='9') THEN 1 ELSE 0 END )  as Processed_Orders,
        SUM( CASE WHEN o.order_status='5' THEN 1 ELSE 0 END )  `completed`,
        (SUM( CASE WHEN o.order_status='5' THEN 1 ELSE 0 END )/SUM( CASE WHEN ( o.order_status='5' or o.order_status='7' or o.order_status='9') THEN 1 ELSE 0 END ))*100  `success_percent`

        FROM tbl_order_table o
        INNER JOIN tbl_journey j
        ON o.cust_id=j.cust_id
        INNER JOIN  tbl_restaurant r
        ON r.id=o.res_id

        WHERE DATE(o.real_day_time) BETWEEN '$start_date' AND '$today'
        AND j.test_order=0
        AND ( o.order_status='5' or o.order_status='7' or o.order_status='9' or o.order_status='10' )
        GROUP BY  o.res_id order by Processed_Orders DESC";

        $data = help::readAll($sql);

        foreach ($data as $row) {
            $rest_id = $row['rest_id'];
            $sp = $row['success_percent'];
            $sp = round($sp, 1);
            if ($sp > 0) {
                $sql2 = "UPDATE `tbl_restaurant` SET `delivery success percent`='$sp' where id='$rest_id'";
                if (help::execute($sql2)) {
                    echo 'ok';
                }
            }
        }
    }

    public function actionUpdateAgentRating_april_15() {//update agent rating in tbl_rest
        $sql = "SELECT id,user_rating FROM `tbl_restaurant` ORDER BY id DESC";
        $res = help::readAll($sql);
        foreach ($res as $row) {
            echo $res_id = $row['id'];
            $user_raing = $row['user_rating'];
            echo '---';
            $sql = "SELECT (SUM(Quality)/count(id)) as quality,(SUM(Packaging)/count(id)) as Packaging,(SUM(Delivery)/count(id)) as Delivery,(SUM(Complaint)/count(id)) as Complaint,(SUM(Communication)/count(id)) as Communication,count(*) as count  FROM `tbl_process_team_rating` WHERE `res_id` = '$res_id'";
            $values = help::read($sql);
            $quality = round($values['quality'], 1);
            $Packaging = round($values['Packaging'], 1);
            $Delivery = round($values['Delivery'], 1);
            $Complaint = round($values['Complaint'], 1);
            $Communication = round($values['Communication'], 1);
            $total_count = round($values['count'], 1);
            $avg_rating = (($quality + $Packaging + $Delivery + $Complaint + $Communication) / 5);
            $avg_rating = round($avg_rating, 1);

            $sql2 = "SELECT
        SUM( CASE WHEN Rating='5' OR (vendor_experience='5' AND `Rating` IS NULL ) THEN 1 ELSE 0 END ) `five`,
        SUM( CASE WHEN Rating='4' OR (vendor_experience='4' AND `Rating` IS NULL ) THEN 1 ELSE 0 END ) `four`,
        SUM( CASE WHEN Rating='3' OR (vendor_experience='3' AND `Rating` IS NULL ) THEN 1 ELSE 0 END ) `three`,
        SUM( CASE WHEN Rating='2' OR (vendor_experience='2' AND `Rating` IS NULL ) THEN 1 ELSE 0 END ) `two`,
        SUM( CASE WHEN Rating='1' OR (vendor_experience='1' AND `Rating` IS NULL ) THEN 1 ELSE 0 END ) `one`
	FROM tbl_user_reviews WHERE  `Rel_Id` =  '$res_id'";

            $r = help::read($sql2);
            if (array_search("", $r) !== false) {
                $five = 0;
                $four = 0;
                $three = 0;
                $two = 0;
                $one = 0;
            } else {
                $five = $r['five'];
                $four = $r['four'];
                $three = $r['three'];
                $two = $r['two'];
                $one = $r['one'];
            }

            $user_c = $one + $two + $three + $four + $five;
            $avg = (($five * 5) + ($four * 4) + ($three * 3) + ($two * 2) + $one) / ($user_c);
            $avg = round($avg, 1);
            $avg = ($avg != '0.0') ? $avg : 0;

            //$sql = "INSERT INTO `tbl_restaurant_rating`( `Res_id`, `User_rating`, `agent_rating_avg`, `Quality`, `Packaging`, `Delivery`, `Complaint`, `Communication`, `Last_updated`) "
            //     . " VALUES ('$res_id','$user_raing','$avg_rating','$quality','$Packaging','$Delivery','$Complaint','$Communication',NOW())";
            echo $sql = "UPDATE `tbl_restaurant_rating` SET `User_rating`=$avg,`agent_rating_avg`=$avg_rating,`Quality`=$quality,`Packaging`=$Packaging,`Delivery`=$Delivery,`Complaint`=$Complaint,`Communication`=$Communication,`one_star`=$one,`two_star`=$two,`three_star`=$three,`four_star`=$four,`five_star`=$five,`Last_updated`=NOW() WHERE `Res_id`=$res_id";
            if (help::execute($sql)) {

                $sql = "SELECT Id FROM tbl_restaurant_rating WHERE Res_id='$res_id' AND User_rating='$avg' AND agent_rating_avg='$avg_rating' AND Quality='$quality'";
                $rate_id = help::getscalar($sql);
                echo '<br>';
                echo $update = "UPDATE tbl_restaurant SET user_rating='$avg',user_rating_count='$user_c',`agent_rating`='$avg_rating',agent_rating_id='$rate_id' WHERE id='$res_id'";
                help::execute($update);

                help::execute($sql);
                echo 'success';
            } else {
                echo 'fail';
            }
//            print_r($values);
            echo '<br>';
//            die;
        }
    }

    public function actionUpdateAgentRatingOld_1() {//update agent rating in tbl_rest
        $sql = "SELECT id,user_rating FROM `tbl_restaurant` ORDER BY id DESC";
        $res = help::readAll($sql);
        foreach ($res as $row) {
            echo $res_id = $row['id'];
            $user_raing = $row['user_rating'];
            echo '---';
            $sql = "SELECT (SUM(Quality)/count(id)) as quality,(SUM(Packaging)/count(id)) as Packaging,(SUM(Delivery)/count(id)) as Delivery,(SUM(Complaint)/count(id)) as Complaint,(SUM(Communication)/count(id)) as Communication,count(*) as count  FROM `tbl_process_team_rating` WHERE `res_id` = '$res_id'";
            $values = help::read($sql);
            $quality = round($values['quality'], 1);
            $Packaging = round($values['Packaging'], 1);
            $Delivery = round($values['Delivery'], 1);
            $Complaint = round($values['Complaint'], 1);
            $Communication = round($values['Communication'], 1);
            $total_count = round($values['count'], 1);
            $avg_rating = (($quality + $Packaging + $Delivery + $Complaint + $Communication) / 5);
            $avg_rating = round($avg_rating, 1);
            //$sql = "INSERT INTO `tbl_restaurant_rating`( `Res_id`, `User_rating`, `agent_rating_avg`, `Quality`, `Packaging`, `Delivery`, `Complaint`, `Communication`, `Last_updated`) "
            //     . " VALUES ('$res_id','$user_raing','$avg_rating','$quality','$Packaging','$Delivery','$Complaint','$Communication',NOW())";
            $sql = "UPDATE `tbl_restaurant_rating` SET `User_rating`=$user_raing,`agent_rating_avg`=$avg_rating,`Quality`=$quality,`Packaging`=$Packaging,`Delivery`=$Delivery,`Complaint`=$Complaint,`Communication`=$Communication,`Last_updated`=NOW() WHERE `Res_id`=$res_id";
            if (help::execute($sql)) {
                $sql = "SELECT Id FROM tbl_restaurant_rating WHERE Res_id='$res_id' AND User_rating='$user_raing' AND agent_rating_avg='$avg_rating' AND Quality='$quality'";
                $rate_id = help::getscalar($sql);
                $sql = "UPDATE `tbl_restaurant` SET `agent_rating`='$avg_rating',agent_rating_id='$rate_id' WHERE id='$res_id'";

                help::execute($sql);
                echo 'success';
            } else {
                echo 'fail';
            }
//            print_r($values);
            echo '<br>';
//            die;
        }
    }

    public function actionUpdateAgentRating_old_2() {//update agent rating in tbl_rest
        $sql = "SELECT id,user_rating FROM `tbl_restaurant` ORDER BY id DESC";
        $res = help::readAll($sql);
        foreach ($res as $row) {
            echo $res_id = $row['id'];
            $user_raing = $row['user_rating'];
            echo '---';
            $sql = "SELECT (SUM(Quality)/count(id)) as quality,(SUM(Packaging)/count(id)) as Packaging,(SUM(Delivery)/count(id)) as Delivery,(SUM(Complaint)/count(id)) as Complaint,(SUM(Communication)/count(id)) as Communication,count(*) as count  FROM `tbl_process_team_rating` WHERE `res_id` = '$res_id'";
            $values = help::read($sql);
            $quality = round($values['quality'], 1);
            $Packaging = round($values['Packaging'], 1);
            $Delivery = round($values['Delivery'], 1);
            $Complaint = round($values['Complaint'], 1);
            $Communication = round($values['Communication'], 1);
            $total_count = round($values['count'], 1);
            $avg_rating = (($quality + $Packaging + $Delivery + $Complaint + $Communication) / 5);
            $avg_rating = round($avg_rating, 1);

            $sql2 = "SELECT
        SUM( CASE WHEN Rating='5' OR (vendor_experience='5' AND `Rating` IS NULL ) THEN 1 ELSE 0 END ) `five`,
        SUM( CASE WHEN Rating='4' OR (vendor_experience='4' AND `Rating` IS NULL ) THEN 1 ELSE 0 END ) `four`,
        SUM( CASE WHEN Rating='3' OR (vendor_experience='3' AND `Rating` IS NULL ) THEN 1 ELSE 0 END ) `three`,
        SUM( CASE WHEN Rating='2' OR (vendor_experience='2' AND `Rating` IS NULL ) THEN 1 ELSE 0 END ) `two`,
        SUM( CASE WHEN Rating='1' OR (vendor_experience='1' AND `Rating` IS NULL ) THEN 1 ELSE 0 END ) `one`
	FROM tbl_user_reviews WHERE  `Rel_Id` =  '$res_id'";

            $r = help::read($sql2);
            if (array_search("", $r) !== false) {
                $five = 0;
                $four = 0;
                $three = 0;
                $two = 0;
                $one = 0;
            } else {
                $five = $r['five'];
                $four = $r['four'];
                $three = $r['three'];
                $two = $r['two'];
                $one = $r['one'];
            }


            //$sql = "INSERT INTO `tbl_restaurant_rating`( `Res_id`, `User_rating`, `agent_rating_avg`, `Quality`, `Packaging`, `Delivery`, `Complaint`, `Communication`, `Last_updated`) "
            //     . " VALUES ('$res_id','$user_raing','$avg_rating','$quality','$Packaging','$Delivery','$Complaint','$Communication',NOW())";
            $sql = "UPDATE `tbl_restaurant_rating` SET `User_rating`=$user_raing,`agent_rating_avg`=$avg_rating,`Quality`=$quality,`Packaging`=$Packaging,`Delivery`=$Delivery,`Complaint`=$Complaint,`Communication`=$Communication,`one_star`=$one,`two_star`=$two,`three_star`=$three,`four_star`=$four,`five_star`=$five,`Last_updated`=NOW() WHERE `Res_id`=$res_id";
            if (help::execute($sql)) {
                $sql = "SELECT Id FROM tbl_restaurant_rating WHERE Res_id='$res_id' AND User_rating='$user_raing' AND agent_rating_avg='$avg_rating' AND Quality='$quality'";
                $rate_id = help::getscalar($sql);
                $sql = "UPDATE `tbl_restaurant` SET `agent_rating`='$avg_rating',agent_rating_id='$rate_id' WHERE id='$res_id'";

                help::execute($sql);
                echo 'success';
            } else {
                echo 'fail';
            }
//            print_r($values);
            echo '<br>';
//            die;
        }
    }

//    -----------------------------------------------------
    public function actionTestpostdata() {
        $now_curdate = date('Y-m-d');


        error_reporting(0);
        $this->layout = 'none';
        $call_type = 0;
        $category = 0;
        if (isset($_POST)) {
            $data = json_encode($_POST);
            $call_temp_status = @$_POST['callStatus'];
            $ph_no = @$_POST['callerNumber'];
            $size_array = count($_POST);
            $cdate = date('Y-m-d H:i:s');
            $time_stamp = strtotime($cdate);
            $CallUUID = @$_POST['CallUUID'];
            $first_hit = 0;
//            if (($size_array==3)&&(isset($_POST['CallUUID']))&&(isset($_POST['callerNumber']))&&(isset($_POST['calledNumber']))&&($_POST['calledNumber']!=NULL)&&($_POST['callerNumber']!=NULL)&&(!isset($_POST['extension']))&&(!isset($_POST['totalCallDuration']))&&(!isset($_POST['AgentNumber']))) {
//                $first_hit=1;
//            }
//            #######################ONLINE ACTIVITY START########################################
            $agent_q1 = $mycalluid = $whotake = '';
            if ((isset($_POST['agentNumber'])) && (isset($_POST['callerNumber'])) && (isset($_POST['CallUUID']))) {
                $agent_q1 = $_POST['agentNumber'];
                $whotake = explode('_', $agent_q1);
                $whotake = $whotake[1];

                $agent_db = help::read("SELECT first_name,emp_id FROM `tbl_callcenter` WHERE communication_phone='$whotake' AND status='1' AND suspend=0");
                $whotake = $agent_db['first_name'] . '_IN_CALL';
                $agent3 = $agent = $agent_db['emp_id'];
                $mycalluid = $_POST['CallUUID'];
                $call_status = 1;
                $sql = "UPDATE tbl_callcenter SET call_status='1' WHERE emp_id='$agent'";
                help::execute($sql);
            } else if ((isset($_POST['callStatus'])) && ($_POST['callStatus'] == 'Connected')) {
                //&& (isset($_POST['AgentNumber'])) && (isset($_POST['CallUUID'])) && ($_POST['CallUUID'] == $mycalluid) && ($_POST['AgentNumber'] == $agent_q1)
                $whotake1 = explode('_', $_POST['AgentNumber']);
                $whotake1 = $whotake1[1];
                $whotake1 = help::read("SELECT first_name,emp_id FROM `tbl_callcenter` WHERE communication_phone='$whotake1' AND status='1' AND suspend=0");
                $whotake = $whotake1['first_name'] . '_IN_FREE';
                $agent3 = $agent2 = $whotake1['emp_id'];
                $call_status = 0;
                $sql = "UPDATE tbl_callcenter SET call_status=NULL WHERE emp_id='$agent2'";
                help::execute($sql);
            } else if ((isset($_POST['destination'])) && (isset($_POST['callerid'])) && (isset($_POST['status'])) && (isset($_POST['extension'])) && (($_POST['status'] == 'ANSWERED') || ($_POST['status'] == 'CANCEL') || ($_POST['status'] == 'NOANSWER') || ($_POST['status'] == 'CONGESTION'))) {
                $whotake2 = explode('_', $_POST['extension']);
                $whotake2 = $whotake2[1];
                $ph_no = @$_POST['destination'];
                if ($whotake2 != 735) {
                    $whotake2 = help::read("SELECT first_name,emp_id FROM `tbl_callcenter` WHERE communication_phone='$whotake2' AND status='1' AND suspend=0");
                    $whotake = $whotake2['first_name'] . '_OUT_FREE';
                    $agent3 = $whotake2['emp_id'];
                } else {
                    $agent_temp = help::read("SELECT value,Comments  FROM `settings` WHERE `id` = 29");
                    $agent3 = $agent_temp['value'];
                    $whotake = $agent_temp['Comments'] . '_OUT_FREE';
                }
                $cuiid = substr($ph_no, -4);
                $cuiid = $cuiid . '*' . $agent3 . '*' . date('d');
                $sql = "SELECT call_type FROM `test` WHERE `CallUUID`='$cuiid' AND emp_id='$agent3' AND online_status='1' ORDER BY id DESC limit 1";
                $call_type = help::getscalar($sql);
                $call_status = 0;
                $sql = "UPDATE tbl_callcenter SET call_status=NULL WHERE emp_id='$agent3'";
                help::execute($sql);
//                {"extension":"aru*039_785","destination":"919633500719","callerid":"914847110154","duration":"5","status":"ANSWERED","date":"2016:10:07 12:35:13"}
            } else if ((isset($_POST['destination'])) && (isset($_POST['extension'])) && (isset($_POST['callerid'])) && (count($_POST) == 3)) {
                $whotake3 = explode('_', $_POST['extension']);
                $whotake3 = $whotake3[1];

                $ph_no = @$_POST['destination'];
                $db_data03 = help::read("SELECT first_name,emp_id FROM `tbl_callcenter` WHERE communication_phone='$whotake3' AND status='1' AND suspend=0");
                $whotake = $db_data03['first_name'] . '_IN_FREE';
                $agent3 = $db_data03['emp_id'];
                $call_status = 1;
                if ($whotake3 == '735') {
                    $agent3 = help::getscalar("SELECT value  FROM `settings` WHERE `id` = 29");
                }
                $sql = "UPDATE tbl_callcenter SET call_status=1 WHERE emp_id='$agent3'";
                help::execute($sql);
                if ($_POST['callerid'] == '') {
                    $category = 2;
                }
            }

//            #######################ONLINE ACTIVITY END########################################
//            --------------------best sol start----------------------------
            $temp_extension = '';
            if ((isset($_POST['agentNumber'])) && (isset($_POST['callerNumber'])) && ($size_array == 3)) {
                $temp3 = explode('_', $_POST['agentNumber']);
                $temp_extension = $temp3[1];
                $first_hit = 1;
                file_get_contents('https://api.yatrachef.com/live/index.php/CallerId/finduser/phone/' . $ph_no . '/extn/' . $temp_extension);
            }
            if ((isset($_POST['callerNumber'])) && (isset($_POST['calledNumber'])) && ($size_array == 3)) {
                $first_hit = 100;
            }
//            --------------------best sol end----------------------------
//            $qthead = $qtans = '';
//            if ($call_type != 0) {
//                $qthead = ",`call_type`";
//                $qtans = ",'$call_type'";
//            }
//            $sql = "INSERT INTO `test`(`content`, `date`,`call_status`,`ph_no`,`First_Hit`,`hit_timestamp`,`CallUUID`,`Extension`,`online_status`,`emp_id` $qthead) "
//                    . " VALUES ('$data','$cdate','$call_temp_status','$ph_no','$first_hit','$time_stamp','$CallUUID','$temp_extension','$call_status','$agent3' $qtans)";
//            help::execute($sql);
            if ((isset($_POST['extension'])) && (isset($_POST['callerid'])) && (isset($_POST['status']))) {//dailed calls //&&($_POST['status']=='ANSWERED')
                $temp1 = explode('_', $_POST['extension']);
                $extension = $temp1[1];
                $caller_n = $_POST['destination'];
                $called_n = $_POST['callerid'];
                $dtime = date('Y-m-d H:i:s', strtotime($_POST['date']));
                $duration = gmdate("H:i:s", $_POST['duration']);
                if ($_POST['status'] == 'BUSY') {
                    $status = 5;
                } else if ($_POST['status'] == 'ANSWERED') {
                    $status = 3;
                } else if ($_POST['status'] == 'CANCEL') {
                    $status = 6;
                } else {
                    $status = 7;
                }

                $insert = 1;
                //, `recording_url`
                $sql = "INSERT INTO `tbl_callList`(`extension`, `phone`, `called_number`, `date_time`, `duration`, `status`,`Callcenter_Type`,`call_type`,`emp_id`) "
                        . " VALUES ('$extension','$caller_n','$called_n','$dtime','$duration','$status','2','$call_type','$agent3')";
                help::execute($sql);
            } else if ((isset($_POST['callStatus'])) && ($_POST['callStatus'] == 'Connected')) {//incoming connected
                $temp2 = explode('_', $_POST['AgentNumber']);
                $extension = $temp2[1];
                $caller_n = $_POST['callerNumber'];
                $called_n = $_POST['calledNumber'];
                $dtime = date('Y-m-d H:i:s', strtotime($_POST['callDate']));
                $duration = gmdate("H:i:s", $_POST['totalCallDuration']);
                $status = 2;

                if ($now_curdate == '2017-10-19') {
                    $status = 1;
                }
                $rec_url = $_POST['recording_URL'];
                $sql = "INSERT INTO `tbl_callList`(`extension`, `phone`, `called_number`, `date_time`, `duration`, `status`,`Callcenter_Type`, `recording_url`,`emp_id`) "
                        . " VALUES ('$extension','$caller_n','$called_n','$dtime','$duration','$status','2','$rec_url','$agent3')";
                help::execute($sql);
            } else if ((isset($_POST['callStatus'])) && ($_POST['callStatus'] == 'Not Connected')) { //incoming not connected
                //$temp2 = explode('_', $_POST['AgentNumber']);
                $extension = ($_POST['AgentNumber'] == '') ? 681 : $_POST['AgentNumber'];
                $caller_n = $_POST['callerNumber'];
                $called_n = $_POST['calledNumber'];
                $dtime = date('Y-m-d H:i:s', strtotime($_POST['callDate']));
                $duration = gmdate("H:i:s", $_POST['totalCallDuration']);
                $status = 4;
                $rec_url = $_POST['recording_URL'];
                $sql = "INSERT INTO `tbl_callList`(`extension`, `phone`, `called_number`, `date_time`, `duration`, `status`,`Callcenter_Type`, `recording_url`,`emp_id`) "
                        . " VALUES ('$extension','$caller_n','$called_n','$dtime','$duration','$status','2','$rec_url','$agent3')";
                help::execute($sql);
            } else if ((isset($_POST['callStatus'])) && ($_POST['callStatus'] == '')) { //misscall
                //$temp2 = explode('_', $_POST['AgentNumber']);
                $extension = ($_POST['AgentNumber'] == '') ? 681 : $_POST['AgentNumber'];
                $caller_n = $_POST['callerNumber'];
                $called_n = $_POST['calledNumber'];
                $dtime = date('Y-m-d H:i:s', strtotime($_POST['callDate']));
                $duration = gmdate("H:i:s", $_POST['totalCallDuration']);
                $status = 1;
                $rec_url = $_POST['recording_URL'];
                $sql = "INSERT INTO `tbl_callList`(`extension`, `phone`, `called_number`, `date_time`, `duration`, `status`,`Callcenter_Type`, `recording_url`) "
                        . " VALUES ('$extension','$caller_n','$called_n','$dtime','$duration','$status','2','$rec_url')";
                help::execute($sql);
            } else {
                
            }
//            #####################################################################
            $qthead = $qtans = '';
            if ($call_type != 0) {
                $qthead = ",`call_type`";
                $qtans = ",'$call_type'";
            }
            $sql = "INSERT INTO `test`(`content`, `date`,`call_status`,`ph_no`,`First_Hit`,`hit_timestamp`,`CallUUID`,`Extension`,`online_status`,`emp_id`,`status`,`category` $qthead) "
                    . " VALUES ('$data','$cdate','$call_temp_status','$ph_no','$first_hit','$time_stamp','$CallUUID','$temp_extension','$call_status','$agent3','$status','$category' $qtans)";
            help::execute($sql);
//            ####################################################################
            if (($status == 1 || $status == 4)) {
                $now = date('H:i:s');
                if ((strtotime($now) >= strtotime('07:00:00')) && (strtotime($now) <= strtotime('22:00:00'))) {
                    //$msg = 'Thank you for calling YatraChef.com. All our agents are currently busy. We will call you back at the earliest. Feel free to WhatsApp us at 08137813700.';
                    // if ($now_curdate == '2017-10-19') {
                    $msg = 'Sorry we are closed today. Place your order with us at yatrachef.com.Use the code DIWALI and avail 15% discount on your order.Wish you a delicious Diwali.';
                    // }
                } else {
                    $msg = 'Sorry our food advisors are only available from 7 am to 10 pm. We will call you back after 7 am. To order food in train visit us at www.yatrachef.com.';
                }
//                $sql = "SELECT value FROM `settings` WHERE id=5";
//                $sms_api_type = help::getScalar($sql);
//                if ($sms_api_type == 1) {
//                    $guid = help::SMSAPI(1, $caller_n, $msg);
//                } else if ($sms_api_type == 2) {
//                    $guid = help::SMSAPI(2, $caller_n, $msg);
//                }
                $guid = help::SMSAPI(3, $caller_n, $msg);
            }
        }
        echo 'Ok';
    }

    public function actionDailyOnce_Cron() {
        echo 'true';
        $x = file_get_contents('https://cc.yatrachef.com/index.php/url/RY_api_report');
        //$y=    file_get_contents('https://cc.yatrachef.com/index.php/url/GetRYcount/daily/1');
        // $z=file_get_contents("https://cc.yatrachef.com/index.php/url/ReportToApi/catg/0");
        print_r($x);
        print_r($z);
    }

//    public function actionDailyOnce_Cron_report($step = 0) { // morning 1
//        $today = date('Y-m-d');
//        $timestamp = strtotime(date('Y-m-d'));
//        if (date('D', $timestamp) === 'Mon') { //weekly report
//            if ($step == 1) {
//                $x1 = file_get_contents("https://cc.yatrachef.com/index.php/url/ReportToApi/catg/2");
//            } else if ($step == 2) {
//                $x3 = file_get_contents("https://cc.yatrachef.com/index.php/url/ReportToApi/catg/5");
//            } else {
//                $x1 = file_get_contents("https://cc.yatrachef.com/index.php/url/ReportToApi/catg/1");
//            }
//            print_r($x1);
//        }
//        $monday = date('Y-m-d', strtotime('First Monday of ' . date('F o', strtotime($today))));
//        if (date('d') == '01') { //monthly report
//            if ($step == 1) {
//                $x2 = file_get_contents("https://cc.yatrachef.com/index.php/url/ReportToApi/catg/4");
//            } else if ($step == 2) {
//                $x3 = file_get_contents("https://cc.yatrachef.com/index.php/url/ReportToApi/catg/6");
//            } else {
//                $x2 = file_get_contents("https://cc.yatrachef.com/index.php/url/ReportToApi/catg/3");
//            }
//            print_r($x2);
//        }
//        if ($step == 3) {
//            $z = file_get_contents("https://cc.yatrachef.com/index.php/url/ReportToApi/catg/0");
//            print_r($z);
//            die;
////         $z=file_get_contents("https://cc.yatrachef.com/index.php/url/DeleteAgentRating");
//        } else {
////          $z=file_get_contents("https://cc.yatrachef.com/index.php/url/UpdateAgentRating");
//        }
//    }
//
//    public function actionReportToApi($catg = 0) {
//        if ($catg == 0) { // daily
//            $res = ReportController::actionFoodOrderReport($date = '', $type = 0, $rt = 0, $mail = 1);
//        } else if ($catg == 1) {//weekly prm
//            $res = ReportController::actionFoodOrderReport($date = '', $type = 1, $rt = 0, $mail = 1);
//        } else if ($catg == 2) {//weekly reg
//            $res = ReportController::actionFoodOrderReport($date = '', $type = 1, $rt = 1, $mail = 1);
//        } else if ($catg == 3) {//monthly reg
//            $res = ReportController::actionFoodOrderReport($date = '', $type = 2, $rt = 0, $mail = 1);
//        } else if ($catg == 4) {//monthly reg
//            $res = ReportController::actionFoodOrderReport($date = '', $type = 2, $rt = 1, $mail = 1);
//        } else if ($catg == 5) {//weekly finance
//            $res = ReportController::actionFoodOrderReport($date = '', $type = 3, $rt = 1, $mail = 1);
//        } else if ($catg == 6) {//monthly finance
//            $res = ReportController::actionFoodOrderReport($date = '', $type = 4, $rt = 1, $mail = 1);
//        }
//        print_r($res);
//    }

    public function actionRY_api_report($type = 0) { //railyatri api redirection details(order_type=8)
        if ($type == 1) {
            echo '<pre>';
//        first time cron ----------------start---------------------
            $sql = "SELECT COUNT(*) as count,DATE(ordering_time) as Date,order_status,SUM(CASE WHEN order_status=5 THEN 1 ELSE 0 END) status FROM `tbl_order_table` WHERE `order_type` = 8 GROUP BY DATE(ordering_time)";
            $data = help::readAll($sql);
            $completed = 0;
            foreach ($data as $row) {
                $sql = "INSERT INTO `tbl_railyatri_api_report`(`date_time`, `type`, `total_count`, `convert_count`)"
                        . " VALUES ('$row[Date]','2','$row[count]','$row[status]')";
                if (help::execute($sql)) {
                    echo 'OK<br>';
                }
            }
            die;
//        first time cron ----------------end---------------------
        } else {
            $cdate = date('Y-m-d');
            //$cdate = date('2016-02-14');
            $sql = "SELECT * FROM `tbl_railyatri_api_report` WHERE `type`=1 AND DATE(date_time)='$cdate'";
            $data_list = help::readAll($sql);
            // echo '<pre>';
            $case_1 = $case_2 = $case_3 = $case_4 = $case_5 = $case_6 = 0;
            foreach ($data_list as $rw) {
                ($rw['case_1'] == 1) ? $case_1++ : '';
                ($rw['case_2'] == 1) ? $case_2++ : '';
                ($rw['case_3'] == 1) ? $case_3++ : '';
                ($rw['case_4'] == 1) ? $case_4++ : '';
                ($rw['case_5'] == 1) ? $case_5++ : '';
                ($rw['case_6'] == 1) ? $case_6++ : '';
            }
            $total = $case_1 + $case_2 + $case_3 + $case_4 + $case_5 + $case_6;

            $sql = "SELECT COUNT(id) as convert_count FROM `tbl_order_table` WHERE order_type = 8 AND DATE(ordering_time)='$cdate' AND order_status=5";
            //$sql = "SELECT COUNT(*) as count,DATE(ordering_time) as Date,order_status,SUM(CASE WHEN order_status=5 THEN 1 ELSE 0 END) status FROM `tbl_order_table` WHERE `order_type` = 8 AND DATE(ordering_time)='$cdate'";
            $daily_report = help::read($sql);
            if ($daily_report != NULL) {
                $completed_count = ($daily_report['convert_count'] != NULL) ? $daily_report['convert_count'] : 0;
            } else {
                $completed_count = 0;
            }
            $sql = "INSERT INTO `tbl_railyatri_api_report`(`date_time`, `type`, `total_count`, `case_1`, `case_2`, `case_3`, `case_4`, `case_5`, `case_6`, `convert_count`) VALUES ('$cdate','2','$total','$case_1','$case_2','$case_3','$case_4','$case_5','$case_6','$completed_count')";
            if (help::execute($sql)) {
                $sql = "DELETE FROM `tbl_railyatri_api_report` WHERE type='1' AND DATE(date_time)='$cdate'";
                if (help::execute($sql)) {
                    echo 'success<br>';
                    help::Mail($subject = 'CRON REPORT-API REDIRECTION', $content = 'Api redirection Cron' . $cdate, $to = 'akhil.tm@yatrachef.com', $type = 1);
                }
            } else {
                echo 'error';
            }
        }
    }

    public function actionGetRYcount($daily = 0) {
        $count = help::getscalar("SELECT COUNT(*) FROM tbl_order_table WHERE order_type='6' AND order_status='11' AND ordering_person='RY' ORDER BY id DESC");
        if ($daily == 0) {
            $q1 = 'LIMIT 10';
            $q2 = '';
            $subject = 'Order details (' . $count . ')';
            $to = 'amit.sharma@railyatri.in'; //dinesh.rathi@railyatri.in
//            $cc[0] = 'suchithra@yatrachef.com';
//            $cc[1] = 'vivek.singh@railyatri.in';
//            $cc[3] = 'arunima.srivastava@stellingtech.com';
            $cc[0] = 'devki.yadav@railyatri.in';
            $cc[1] = 'ycmealsconversion@googlegroups.com';
            $cc[2] = 'amit.sharma@railyatri.in';
            $cc[3] = 'rishi.kapoor@railyatri.in';
        } else {
            $q1 = '';
            $q2 = 'AND DATE(ordering_time)=CURDATE()';
            $date = date('d-m-Y');
            // $q2 = "AND DATE(ordering_time)='$date'";
            $to = 'arun@yatrachef.com';
            $cc[0] = 'akhil.tm@yatrachef.com';
            $subject = 'Order details of  ' . $date . ' (' . $count . ')';
        }

        $sql = "SELECT o.order_status,o.id,o.real_day_time,o.ordering_time,o.cust_id,j.name,s.station_name FROM tbl_order_table o "
                . " INNER JOIN tbl_journey j ON j.cust_id=o.cust_id"
                . " INNER JOIN tbl_stations s ON o.station=s.id "
                . " WHERE o.order_type='6' AND order_status='11' AND o.ordering_person='RY' $q2 ORDER BY id DESC $q1";
        $data = help::readAll($sql);

        $x = '
<!doctype html>
<html>
    <head>
        <meta name="viewport" content="width=device-width">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>YatraChef</title>
        <style>
            /* -------------------------------------
                GLOBAL
            ------------------------------------- */
            * {
                font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
                font-size: 100%;
                line-height: 1.6em;
                margin: 0;
                padding: 0;
            }



            body {
                -webkit-font-smoothing: antialiased;
                height: 100%;
                -webkit-text-size-adjust: none;
                width: 100% !important;
            }


            /* -------------------------------------
                ELEMENTS
            ------------------------------------- */
            a {
                color: #348eda;
            }






            /* -------------------------------------
                BODY
            ------------------------------------- */
            .order_det td{
                /*border: 1px solid gray;*/
            }
            table.body-wrap {
                padding: 20px;
                width: 100%;
            }

            table.body-wrap .container {
                border: 1px solid #f0f0f0;
            }
            table td{
                    font-size: 14px;
            }


            /* -------------------------------------
                FOOTER
            ------------------------------------- */
            table.footer-wrap {
                clear: both !important;
                width: 100%;
            }

            .footer-wrap .container p {
                color: #666666;
                font-size: 12px;

            }

            table.footer-wrap a {
                color: #999999;
            }

            table th{
               text-align: left;
            }

            /* ---------------------------------------------------
                RESPONSIVENESS
            ------------------------------------------------------ */

            /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
            .container {
                clear: both !important;
                display: block !important;
                Margin: 0 auto !important;
                max-width: 600px !important;
            }

            /* Set the padding on the td rather than the div for Outlook compatibility */
            .body-wrap .container {
                padding: 20px;
            }

            /* This should also be a block element, so that it will fill 100% of the .container */
            .content {
                display: block;
                margin: 0 auto;
                max-width: 600px;
            }


            .content table {
                width: 100%;
               padding: 4px;
            }

        </style>
    </head>

    <body bgcolor="#f6f6f6">

        <!-- body -->
        <table class="body-wrap" bgcolor="#f6f6f6">
            <tr>
                <td></td>
                <td class="container" bgcolor="#FFFFFF">

                    <!-- content -->
                    <div class="content">
                        <table style="">
                            <tr>
                                <td>

                                    <p>Incomplete order from RY = ' . $count . '</p>
                                    <p style="height: 10px;"></p>
                                    <table class="order_det">
                                        <tr class="order_det">
                                            <th>Sl.No</th>
                                            <th>Order Id</th>
                                            <th>Cust.Name</th>
                                            <th>Station</th>
                                            <th>Delivery Dt</th>
                                            <th style="text-align: center;">Status</th>
                                        </tr>';
        $i = 1;
        foreach ($data as $row) {
            if ($row['order_status'] == 5) {
                $status = 'Completed';
            } else if ($row['order_status'] == 4) {
                $status = 'Fake Order';
            } else if ($row['order_status'] == 3) {
                $status = 'Failed';
            } else if ($row['order_status'] == 2) {
                $status = 'Canceled';
            } else if ($row['order_status'] == 1) {
                $status = 'Pending';
            } else if (($row['order_status'] == 7)) {
                $status = 'Canceled(Rest.) ';
            } else if (($row['order_status'] == 8)) {
                $status = 'Canceled(Cust.) ';
            } else if (($row['order_status'] == 9)) {
                $status = 'Failed(Rest.) ';
            } else if (($row['order_status'] == 10)) {
                $status = 'Failed(Cust.) ';
            } else if (($row['order_status'] == 11)) {
                $status = 'Incomplete';
            } else {
                $status = $row['order_status'];
            }
//            $msg.='<tr><th>' . $row['id'] . '</th><th>' . $row['cust_id'] . '</th><th>' . $row['name'] . '</th><th>' . $row['real_day_time'] . '</th><th>' . $row['ordering_time'] . '</th></tr>';
            $x .= '<tr class="order_det">
                                            <td>' . $i . '</td>
                                            <td>' . $row['id'] . '</td>
                                            <td>' . substr($row['name'], 0, 11) . '..</td>
                                            <td>' . $row['station_name'] . '</td>
                                            <td title="' . date('d-m-Y H:i', strtotime($row['ordering_time'])) . '">' . date('d-m-Y H:i', strtotime($row['real_day_time'])) . '</td>
                                            <td style="text-align: center;">' . $status . '</td>
                                        </tr>';
            $i++;
        }




        $x .= '
            <tr><td colspan="6" style="text-align: center;padding-top: 20px;">' . date('d-m-Y H:i:s') . '</td></tr>
</table>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!-- /content -->

                </td>
                <td></td>
            </tr>
        </table>

        <!-- /body -->

        <!-- footer -->
        <table class="footer-wrap">
            <tr>
                <td></td>
                <td class="container">

                    <!-- content -->
                    <div class="content">
                        <table>
                            <tr>
                                <td align="center">

                                </td>
                            </tr>
                        </table>
                    </div>
                    <!-- /content -->

                </td>
                <td></td>
            </tr>
        </table>
        <!-- /footer -->

    </body>
</html>
';
//        echo $x;
        $temp[0] = '';
        echo $x = help::Mail_Attachment($subject, $x, $to, $from = 'support@yatrachef.com', $title = 'YatraChef', $cc, $attach = $temp, $path = '');

//        echo $x;
    }

    public function actionIndex() {
        echo 'OK';


        $phone = '9633500719';
        $message = 'Dear test1,Thank you for ordering with YatraChef.We have registered your order ID 12345';
        echo $guid = help::SMSAPI(3, $phone, $message);
        die;

        $cdatet = date('Y-m-d H:i:s');
        $sql = "INSERT INTO `tbl_sms_data`(`oid`, `sms_id`, `date_time`, `attempt`,`massage`, `phone`,`type`,`Api_Used`)
                        VALUES ('29705','$guid','$cdatet','1','$message','$phone','2','1')";
        help::execute($sql);
    }

    public function actiontemp_paymentstatus() {
        $sql = "SELECT id,cust_id,type,partialPayment  FROM `tbl_payment` WHERE `partialPayment` = 2 AND `type` = 0";
        $r = help::readAll($sql);
        echo '<pre>';
        foreach ($r as $rw) {

            $sql = "UPDATE tbl_payment SET type='1' WHERE partialPayment='2' AND id='$rw[id]' AND cust_id='$rw[cust_id]'";
            if (help::execute($sql)) {
                echo 's<br>';
            } else {
                echo 'f<br>';
            }
        }
    }

    public function actionUpdateOnlineFailed() {
//        $sql = "SELECT o.cust_id,o.id,o.payment_type,o.Payment_status,p.transaction_status,p.PaymentID
//FROM tbl_order_table o
//LEFT OUTER JOIN tbl_payment p ON o.cust_id=p.cust_id
//WHERE o.order_status='1' AND o.payment_type='Online_Payment' ";
        $sql = "SELECT o.cust_id,o.id,o.payment_type,o.Payment_status,o.order_status
                FROM tbl_order_table o
                WHERE o.payment_type='Online_Payment' ";
        //AND DATE(o.real_day_time)='2014-12-28'
        $r = help::readAll($sql);
        echo '<pre>';
        foreach ($r as $rw) {
            $sql = "SELECT transaction_status FROM tbl_payment WHERE cust_id='$rw[cust_id]'";
            $cpayment = help::getscalar($sql);
            if ($cpayment == NULL) {
                $update = help::execute("UPDATE tbl_journey SET test_order='3' WHERE cust_id='$rw[cust_id]'");
                print_r($rw);
            }

//            if (strpos('SUCCESS', $rw['transaction_status']) !== FALSE) {
//
//            } else {
//            }
        }
    }

    public function actionReview21Ticket() {
        $res = ReportController::actionReview21Ticket();
    }

    public function actionUpdateStatusCrons() { //daily one
//        $url = 'https://cc.yatrachef.com/index.php/url/Review21Ticket';
//        $z = file_get_contents($url);
        $url = 'https://cc.yatrachef.com/index.php/url/UpdateComplaints';
        $z = file_get_contents($url);
//        $res = $this->CurlPost($url);
//        $url = 'https://cc.yatrachef.com/index.php/url/UpdateReview';
//        $res = $this->CurlPost($url);

        $z = file_get_contents("https://cc.yatrachef.com/index.php/url/DeleteAgentRating");
        $z = file_get_contents("https://cc.yatrachef.com/index.php/url/UpdateAgentRating");
        $z = file_get_contents("https://cc.yatrachef.com/index.php/url/rest_success_percent");


        file_get_contents("https://cc.yatrachef.com/index.php/url2/cod_in_payment_table");

        $sql = "DELETE FROM `tbl_eta_history`  WHERE Created_At <=CURDATE() - INTERVAL 30 DAY ";
        $x = 'ETA CLEAR FAILED';
        if (help::execute($sql)) {
            $x = 'ETA CLEAR SUCCESS';
        }

        file_get_contents("https://cc.yatrachef.com/index.php/url2/UpdateSamplesFeedback");


        help::Mail($subject = 'CRON REPORT-Update review,complaints,combiflam feedback.', $content = 'update complaints,rest review,delete agent rating from procees,update agent rating' . $cdate . '<br>' . $x, $to = 'akhil.tm@yatrachef.com', $type = 1);
        print_r($res);
    }

    public function CurlPost($url) {
        $ch = curl_init();
        $timeout = 1;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public function actionUpdateReview() {
        $sql = "SELECT id FROM `tbl_restaurant`";
        $res = Help::readAll($sql);
        foreach ($res as $rw) {
            $resid = $rw['id'];
            $temp = Help::read("SELECT AVG(Rating) as rating,COUNT(Rating) as user_count FROM `tbl_user_reviews` WHERE Rel_Id='$resid'");
            $avg = $temp['rating'];
            $user_c = $temp['user_count'];

            $avg = number_format((float) $avg, 1, '.', '');
            $avg = ($avg != '0.0') ? $avg : 0;
            $update = "UPDATE tbl_restaurant SET user_rating='$avg',user_rating_count='$user_c' WHERE id='$resid'";
            if (Help::execute($update)) {
                echo 's';
            } else {
                echo 'F';
            }
            echo '<br>';
        }
    }

    public function actionUpdateComplaints() { //update complaints and feed bak
        $sql = "SELECT t.order_id,t.category FROM tbl_tagging t
WHERE (t.category='3' OR t.category='1' ) AND DATE(t.event_time)=CURDATE()
ORDER BY `t`.`event_time`  ASC"; //AND  DATE(t.event_time) <='01-08-2015'
        $up = help::readAll($sql);
        foreach ($up as $rw) {
            $oid = $rw['order_id'];
            $cat = $rw['category'];
            if ($cat == 1) {
                $update = "UPDATE tbl_order_table SET Complaint='$cat' WHERE id='$oid'";
            } else if ($cat == 3) {
                $update = "UPDATE tbl_order_table SET Feedback='$cat' WHERE id='$oid'";
            }
//            $update = "UPDATE tbl_order_table SET Feedback='1' WHERE id='$oid'";
            if (help::execute($update)) {
                echo 's<br>';
            } else {
                echo 'f' . $oid . '<br>';
            }
        }
    }

    public function actionBulkStatus_change() {
        echo $path = Yii::getPathOfAlias('webroot') . '/assets/failed.csv';
        if (file_exists($path)) {
            $csv = $this->actionTest($path);
            echo '<pre>';
//            print_r($csv);
            foreach ($csv as $data) {
                echo $oid = $data[0];
                $status = $data[1];
                echo '--';

                $sql = "UPDATE tbl_order_table SET order_status='8' WHERE id='$oid' AND order_status='2'";
                $sql = "UPDATE tbl_order_table SET Linking='$status' WHERE id='$oid' ";
                if (help::execute($sql)) {
                    echo 's';
                } else
                    echo 'f';
//                $sql="SELECT Linking FROM tbl_order_table WHERE id='$oid'";
//                echo help::getscalar($sql);
                echo '<br>';
            }
        }
    }

    public function actionCust_id_missing() { //daily cron check,
        $sql = "SELECT `cust_id`,name FROM `tbl_journey`  WHERE `test_order`=0 ";
        $cust_id = help::readAll($sql);
        foreach ($cust_id as $row) {
            $c = $row['cust_id'];
            $sql = "SELECT `id` FROM `tbl_order_table` WHERE `cust_id`=$c";
            $oid = help::getScalar($sql);

            if ($oid == '') {
                $not_in_order_tbl[] = $c;
            }
        }
        foreach ($not_in_order_tbl as $row) {
            $sql = "SELECT `id` FROM `temp_order_table` WHERE `cust_id`=$row";
            $oid_temp = help::read($sql);

            if ($oid_temp == '') {
                $not_in_temp[] = $row;
            }
        }


        $count = count($not_in_temp);
        $imp = implode(',<br>', $not_in_temp);
//        print_r($imp);
        $dt = date('d-m-Y');
        help::Mail($subject = 'Customer Id differ with tbl_order_table ' . $dt . ',Total count(' . $count . ')', $content = $imp, $to = 'akhil.tm@yatrachef.com');
    }

    public function actionDaily_Bounce() {
//        $sql="SELECT `Status`,`To`,`Rel_Id`,`DateTime` FROM tbl_email_status WHERE `Status`='2'";
//        $bounce=help::readAll($sql);
//        echo '<pre>';
//        print_r($bounce);
//        foreach ($bounce as $list){
//            $sql="SELECT id,order_type,order_owner FROM tbl_order_table WHERE cust_id='6023' ORDER BY ordering_time DESC LIMIT 1";
//            $det=help::read($sql);
//            print_r($det);
////            $sql="INSERT INTO `tbl_bounce_list`(`Email`, `Bounce`, `Rel_Id`, `DateTime`, `Order_Taken_By`) VALUES ('$list[To]','$list[Status]','$list[Rel_Id]','$list[DateTime]')";
//        }
    }

    public function actionCheckMailStatus() { //echo 'HI';
        if (isset($_POST['recipient'])) { //https://cc.yatrachef.com/index.php/url/EmailBounceCheck
//            echo '<pre>';
            echo $to = $_POST['recipient'];
            // help::mail($subject, $content, $to = 'akhil.tm@yatrachef.com');
            if ($_POST['event'] == 'delivered') {
                $status = '1';
            } else if ($_POST['event'] == 'dropped') {
                $status = '2';
            } else if ($_POST['event'] == 'bounced') {
                $status = '3';
            } else if ($_POST['event'] == 'complained') {
                $status = '4';
            } else {
                $status = '5';
            }

            $exp = explode('Message-Id", "', $_POST['message-headers']);
            $exp1 = explode('"], ["', $exp[1]);
            $messageId = str_replace(' ', '', $exp1[0]);
            echo $messageId;
            if (strpos($messageId, '@mg.yatrachef.com>') !== false) {
                $to = str_replace(' ', '', $to);
                $sql = "SELECT `Status` FROM `tbl_email_status` WHERE `To` = '$to' AND Status='0' AND Message_Id='$messageId'";
                $ml = help::getscalar($sql);
                if ($ml != NULL) {
                    $sql = "UPDATE `tbl_email_status` SET Status='$status' WHERE `Message_Id`='$messageId' AND `Status`='$ml' AND `To`='$to'";
                    if (help::execute($sql)) {
                        echo 'Updated';
                    } else {
                        echo 'failed';
                    }
                }
            } else {
                echo 'dsfds';
            }
        } else {
            echo 'not found';
        }
    }

    public function actionEmailBounceCheck() {
        if (isset($_POST['recipient'])) { //https://cc.yatrachef.com/index.php/url/EmailBounceCheck
            echo '<pre>';
            print_r($_POST);
            $too = mysql_real_escape_string($_POST['recipient']);
//            $sql="SELECT "
//            $err=  mysql_real_escape_string($_POST['error']);
//            echo $sql="INSERT INTO `TEST`(`To`, `Error`, `header`) VALUES ('$too','$err','$_POST[event]')";
//            help::execute($sql);
            echo 'ok';
        }
    }

    public function actionResolve_OneTime() {
        $sql = "SELECT Ticket_Id,Status,Ticket_Sub_Id FROM tbl_ticket WHERE Ticket_Type=1 AND Ticket_Sub_Id<>0 AND  DATE(Ticket_Created_Time)<>CURDATE()";
//        echo $sql="SELECT order_status,id FROM tbl_order_table WHERE NOT(order_status=1)";
        $status = help::readAll($sql);
        echo '<pre>';
        if ($status != NULL) {
            foreach ($status as $row) {
//                print_r($row);
                $sql = "SELECT order_status FROM tbl_order_table WHERE id='$row[Ticket_Sub_Id]'";
                $sts = help::getScalar($sql);

                $tick_st = 5;
                if ($sts == 1) {
                    $tick_st = 1;
                } else if ($sts == 2) {
                    $tick_st = 5;
                } else if ($sts == 3) {
                    $tick_st = 5;
                } else if ($sts == 4) {
                    $tick_st = 5;
                } else if ($sts == 5) {
                    $tick_st = 5;
                } else {
//                    echo $row['Ticket_Sub_Id'];
//                    echo $sql;
                }
                if (($tick_st == 5) || ($tick_st == 1)) {
//                    echo $sql;
                    echo $tick_st . '<br>';
                    $sql = "UPDATE tbl_ticket SET Status='$tick_st' WHERE Ticket_Id='$row[Ticket_Id]'";
                    if (help::execute($sql)) {
                        echo 'suc<br>';
                    } else {
                        echo 'fail<br>';
                    }
                }
            }
        }
        die;
    }

    public function Railyatri($pnr) {
        error_reporting(0);
        // $url = 'http://coa-pnr-1698218593.ap-southeast-1.elb.amazonaws.com/api/pnr/journey/' . $pnr . '/null/null/null/null/null.json';
        $url = 'http://pnr.railyatri.in//api/pnr/journey/' . $pnr . '/null/null/null/null/null.json?for_vendor=1';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 2000);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($data);
        if ((isset($data)) && ($data->status == 'OK')) {
            $stdClass = new stdClass();
            $stdClass->pnr = $pnr;
            $stdClass->response_code = 200;
            $stdClass->train_num = $data->train_number;
            $stdClass->train_name = $data->train_name;
            $stdClass->from_station->code = $data->board_from;
            $stdClass->from_station->name = $data->board_from_name;
            $stdClass->to_station->code = $data->board_to;
            $stdClass->to_station->name = $data->board_to_name;

            $stdClass->boarding_point->code = $data->board_from;
            $stdClass->boarding_point->name = $data->board_from_name;
            $stdClass->reservation_upto->code = $data->board_to;
            $stdClass->reservation_upto->name = $data->board_to_name;
            $stdClass->doj = $data->travel_date;
            $stdClass->class = $data->class;
            $length1 = sizeof($data->passenger);
            $stdClass->no_of_passengers = $length1;
            for ($i = 0; $i < $length1; $i++) {
//            $j = ($i - 1);
                $stdClass->passengers[$i]->sr = $i + 1;
                $stdClass->passengers[$i]->booking_status = preg_replace('/\s+/', ' ', $data->passenger[$i]->seat_number);
                $stdClass->passengers[$i]->current_status = preg_replace('/\s+/', ' ', $data->passenger[$i]->status);
            }
            if ($data->chart_prepared == 1) {
                $stdClass->chart_prepared = 'Y';
            } else {
                $stdClass->chart_prepared = 'N';
            }
            return $stdClass;
        } else {
            $stdClass->response_code = 400;
            $stdClass->error = 'System Error1';
            $stdClass->pnr = $pnr;
            return $stdClass;
        }
//        print_r($data->passenger);
    }

    public function actionRailyatriReport($type = 0) {
        $date = date('Y-m-d');
        if ($type == 1) {
            $q1 = '';
            $subject = "Railyatri All Report Till $date";
        } else if ($type == 2) {
            if (isset($_POST['date'])) {
                $date = $_POST['date'];
                $q1 = "WHERE DATE(Created_Time) LIKE '$date'";
                $subject = "Railyatri All Report Till $date";
            } else {
                die;
            }
        } else {
            $q1 = 'WHERE DATE(Created_Time)=CURDATE()';
//            $q1="WHERE Created_Time LIKE '%2015-04-17%'";
//            $q1="WHERE (Created_Time BETWEEN '2015-04-01 00:00:00' AND '2015-04-13 00:00:00')";

            $subject = "Railyatri $date Report";
        }
        $sql = "SELECT * FROM tbl_leads $q1";
        $list = help::readAll($sql);
        echo count($list);
        echo '<pre>';
        $temp3 = '';
        $i = 2;
        $completed = 'No';
        $list1[0] = 'Date of placing order,Number,Alternate number,RY Code,Train number,Station code,service date,Escalation received yes / No,Action Taken,call back status closed / open ,Closed date & time,Final Action ,Order ID,Delivery Status ,order confirmed  Yes/No';
        $list1[1] = ',';
        foreach ($list as $row) {
            $sql = "SELECT Ticket_Id,Reference,Status,Resolve_Time FROM `tbl_ticket` WHERE Ticket_Type='10' AND Ticket_Sub_Id='$row[Id]'";
            $ticket = help::read($sql);

            $A = $row['Created_Time'];
            $B = $row['Phone_1'];
            $C = $row['Phone_2'];
            $D = $row['RY_code'];
            $temp1 = explode('-', $row['Train']);
            $E = $temp1[0];
            if (strpos($row['station'], '(') !== false) {
                $temp2 = explode('(', $row['station']);
                $temp2 = str_replace(')', '', $temp2[1]);
                $F = $temp2;
            } else {
                $F = $row['station'];
            }

            $G = $row['Service_Date'];
            if ($ticket['Reference'] == 2) {
                $H = 'Yes';
            } else {
                $H = 'No';
            }
//            print_r($ticket);
            if ($ticket != NULL) {
                $sql = "SELECT `message` FROM `tbl_tagging` WHERE `ticket_id`=$ticket[Ticket_Id] AND thread_type='1' AND category='0' ORDER By Id DESC LIMIT 1";
                $action = help::read($sql);

                if ($action != NULL) {
                    $I = strip_tags($action['message']);
                    $I = preg_replace('/\s+/', ' ', $I);
                    $I = str_replace(",", '.', $I);
                    $I = str_replace("&nbsp;", '', $I);
                } else {
                    $I = '';
                }

                if ($ticket['Status'] == 1) {
                    $J = 'Open';
                } else if ($ticket['Status'] == 2) {
                    $J = 'Pending Confirmation';
                } else if ($ticket['Status'] == 3) {
                    $J = 'Waiting for Customer';
                } else if ($ticket['Status'] == 4) {
                    $J = 'In Process';
                } else if ($ticket['Status'] == 5) {
                    $J = 'Resolved';
                    $temp3 = $ticket['Resolve_Time'];
                } else if ($ticket['Status'] == 5) {
                    $J = 'Closed';
                } else {
                    $J = '';
                }
            } else {
                $I = '';
                $J = '';
            }

            $K = $temp3;
            $L = $I;
            $M = $row['OrderPlaced'];
            if ($M != 0) {
                $sql = "SELECT order_status FROM tbl_order_table WHERE Id=$M";
                $Order_Status = help::getScalar($sql);
                if ($Order_Status != NULL) {
                    if ($Order_Status == 1) {
                        $Status1 = 'Pending';
                    } else if ($Order_Status == 2) {
                        $Status1 = 'Canceled';
                    } else if ($Order_Status == 3) {
                        $Status1 = 'Failed';
                    } else if ($Order_Status == 4) {
                        $Status1 = 'Fakse order';
                    } else if ($Order_Status == 5) {
                        $Status1 = 'Completed';
                        $completed = 'Yes';
                    }
                }
            } else {
                $Status1 = '';
                $completed = 'No';
            }

            $N = $Status1;
            $O = $completed;

            $list1[$i] = $A . ',' . $B . ',' . $C . ',' . $D . ',' . $E . ',' . $F . ',' . $G . ',' . $H . ',' . $I . ',' . $J . ',' . $K . ',' . $L . ',' . $M . ',' . $N . ',' . $O;
            $i++;
        }
//        echo '<pre>';
//        print_r($list1);die;
//        die;

        $path = dirname(dirname(__FILE__)) . '/../assets/ticket/Railyatri_report/' . $date . '_report.csv';

//        echo $path= Yii::app()->request->baseUrl.'/assets/ticket/report.csv';die;
        $fp = fopen($path, 'w');
        foreach ($list1 as $fields) {
            $var = explode(',', $fields);
            fputcsv($fp, $var);
        }
        fclose($fp);
//        $path = dirname(dirname(__FILE__)) . '/../assets/ticket/Railyatri_report/';
        $file_name = $date . '_report.csv';
        $content = "<p>Hi,</p><p>This is an automated mail,</p><p>Please click the link for {{link}}&nbsp;Rail Yatri Daily Report&nbsp;</p><p><br></p>";
        echo $url = "<a href='https://cc.yatrachef.com/assets/ticket/Railyatri_report/$file_name' target='_blank'>Link</a>";
        $content = str_replace('{{link}}', $url, $content);
//        help::mail($subject, $content, $to = 'akhil.tm@yatrachef.com');
        if ($type != 2) {
            help::Mail($subject, $content, $to = 'rameez@yatrachef.com');
        }
//        help::Mail_Attached($subject='TEST', $content='TEST mail Attached', $to='akhil.tm@yatrachef.com', $from='support@yatrachef.com', $title='qqq',$path,$file_name);
        echo '===>';
//        print_r($list);
    }

    public function actionEscalationMails() {
        $ch = curl_init();
        $url = $this->createUrl('/url/EscalationMails1');
        $url = 'https://cc.yatrachef.com/' . $url;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//  curl_setopt($ch,CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 35000);
        $output = curl_exec($ch);

        curl_close($ch);
        print_r($output);
    }

    public function actionEscalationMails1() {
//        $sql = "SELECT t.Due_time,t.Ticket_Created_Time,t.Assigned_Operator,t.Ticket_Id,t.Status,t.Customer_Name,t.Ticket_Type,t.Ticket_Name,t.Resolve_Mail_Violated,t.OverDue_Mail,t.Unassigned_Mail,s.escalation_mail,s.Resolve,s.Respond,a.Group FROM tbl_ticket t
//                LEFT JOIN tbl_sla_assign a ON a.Id=Ticket_Type
//                LEFT JOIN tbl_sla_policy s ON s.Id=a.Priority
//                WHERE ((t.Ticket_Type<>'1') AND (t.Ticket_Type<>'2')) AND DATE(t.Due_time)=CURDATE()";
        $sql = "call CRON_MODULE(2)";
        $data = help::readAll($sql);
//        print_r($data);die;
        if ($data != NULL) {

            if ($data != NULL) {
                $current_time = date('Y-m-d H:i:s');
                $str_current = strtotime($current_time);
                $sql = "SELECT `Subject`,`Content`,`Type` FROM `tbl_email_template` WHERE `Status`='0'";
                $email_template = help::readAll($sql);

//        print_r($email_template);
//        die;
                foreach ($data as $row) {
                    $assigned = $row['Assigned_Operator'];
                    echo $ticket_id = $row['Ticket_Id'];
                    echo '<br>';
                    $created_time = $row['Ticket_Created_Time'];
                    $due_time = $row['Due_time'];
                    $str_created = strtotime($created_time);
                    $str_due = strtotime($due_time);
                    $url = "<a target='_blank' href='https://cc.yatrachef.com/index.php/helpdesk/Ticket/id/$ticket_id'>#$ticket_id</a>";
//---------------------------------------------------------------------------------------------------------------------------
                    $DUE = ceil($this->ConvertMinutes($x = $current_time, $y = $due_time));
                    $CRTIME = ceil($this->ConvertMinutes($x = $current_time, $y = $created_time));
                    if (($row['Ticket_Type'] != 1) || ($row['Ticket_Type'] != 2)) {
//                        if (($row['Status'] != 5) && ($row['Status'] != 6)) {
                        if ($row['Status'] == 1) {
                            if ($row['NewTicket_Mail'] == '0') {
                                $sql = "SELECT ticket_id FROM tbl_tagging WHERE category='0' AND thread_type='1' AND events LIKE '%Ticket Reassigned%' AND Ticket_Id =$ticket_id";
                                $reassign = help::getScalar($sql);
                                if ($reassign == NULL) {
                                    echo $CRTIME . ' true';
                                    if (($CRTIME == -28) || ($CRTIME == -29) || ($CRTIME == -30) || ($CRTIME == -31) || ($CRTIME == -32) || ($CRTIME == -33) || ($CRTIME == -34)) {
                                        echo ' time ok';
//                    ---------spl-------------
                                        $sql = "SELECT email,first_name FROM tbl_callcenter WHERE status='1' AND roll='1' AND emp_id='$assigned'";
                                        $temp25 = help::read($sql);
                                        foreach ($email_template as $typ1) {
                                            if ($typ1['Type'] == '1') {
                                                $url1 = "<a target='_blank' href='https://cc.yatrachef.com/index.php/helpdesk/Ticket/id/$ticket_id'>Click Me</a>";
                                                $email_subject = str_replace('{{ticket.id}}', $ticket_id, $typ1['Subject']);
                                                $email_subject = str_replace('{{ticket.subject}}', $row['Ticket_Name'], $email_subject);
//                                                echo '<br>';
                                                $email_content = str_replace('{{ticket.url}}', $url1, $typ1['Content']);
                                                $email_content = str_replace('{{ticket.id}}', '#' . $ticket_id, $email_content);
                                                $email_content = str_replace('{{ticket.subject}}', $email_subject, $email_content);
                                                $email = $temp25['email'];
//                                                echo '<br>';
                                                $email_content = str_replace('{{ticket.agent.name}}', $temp25['first_name'], $email_content);
                                                help::Mail2($subject = $email_subject, $content = $email_content, $to = $email, $from = 'support@yatrachef.com', $title = 'New Ticket Assigned');
                                            }
                                        }
//                    -------------------------
                                    } else {
                                        echo 'F0 Failed<br>';
                                    }
                                }
                            }
//die;
                            $rttemp = ($row['Respond'] + 15);
//                                echo 'F-'. $row['Status'].'-'.$ticket_id.'-'.$DUE.'>-'.$rttemp.'<br>';
                            if ($DUE >= $rttemp) { //Over due timing
//                                echo 'S-'.$row['Status'].'-'.$ticket_id.'-'.$DUE.'>-'.$rttemp.'<br>';
                                if ($row['OverDue_Mail'] == 0) {
                                    if ($row['escalation_mail'] == '1') {
                                        $sql = "UPDATE tbl_ticket SET OverDue_Mail='1' WHERE Ticket_Id='$ticket_id'";
                                        if (help::execute($sql)) {
                                            foreach ($email_template as $typ1) {
                                                if ($typ1['Type'] == '2') {//template
                                                    $temp_sub = $typ1['Subject'];
                                                    $temp_content = $typ1['Content'];
                                                    $temp_sub = str_replace('{{ticket.id}}', $ticket_id, $temp_sub);
                                                    $temp_sub = str_replace('{{ticket.subject}}', $row['Ticket_Name'], $temp_sub);

                                                    $temp_content = str_replace('{{ticket.id}}', $url, $temp_content);
                                                    $temp_content = str_replace('{{ticket.fr_due_by_hrs}}', $DUE . ' Min ', $temp_content);
                                                    $temp_content = str_replace('{{ticket.subject}}', $row['Ticket_Name'], $temp_content);
                                                    $temp_content = str_replace('{{ticket.requester.email}}', $row['Customer_Name'], $temp_content);
//                                                    help::Mail($subject = $temp_sub, $content = $temp_content, $to = 'akhil.tm@yatrachef.com');
                                                    help::Mail2($subject = $temp_sub, $content = $temp_content, $to = 'hafeez.m@yatrachef.com', $from = 'support@yatrachef.com', $title = 'No Response-[' . $ticket_id . ']');
                                                }
                                            }
                                            echo 'Send mail 1 #' . $ticket_id . '<br>';
                                        }
                                    }
                                }
                            }
//                    echo 'Overdue success<br>';
                        } else {
//                            echo 'F1-' . $ticket_id . '<br>';
                        }
//                echo $row['Resolve'].'-----';
//---------------------------------------------------------------------------------------------------------------------------

                        if (($row['Status'] != 5) && ($row['Status'] != 1) && ($row['Status'] != 6)) { //resolve mail
//                        $RESOLVE_TIME = date('Y-m-d H:i:s', strtotime($created_time . ' + ' . $row['Resolve'] . ' min'));s
                            $RESOLVE = ceil($this->ConvertMinutes($x = $current_time, $y = $due_time));
//                            echo $row['Status'] . '-' . $ticket_id . '<br>';
                            if ($RESOLVE >= ($row['Resolve']) + 30) {
                                if ($row['Resolve_Mail_Violated'] == '0') {
                                    if ($row['escalation_mail'] == '1') {
                                        $sql = "UPDATE tbl_ticket SET Resolve_Mail_Violated='1' WHERE Ticket_Id='$ticket_id'";
                                        if (help::execute($sql)) {
                                            foreach ($email_template as $typ2) {
                                                if ($typ2['Type'] == '3') {
                                                    $temp_sub2 = $typ2['Subject'];
                                                    $temp_content2 = $typ2['Content'];
                                                    $temp_sub2 = str_replace('{{ticket.id}}', $ticket_id, $temp_sub2);
                                                    echo $temp_sub2 = str_replace('{{ticket.subject}}', $row['Ticket_Name'], $temp_sub2);

                                                    $temp_content2 = str_replace('{{ticket.id}}', $url, $temp_content2);
                                                    $temp_content2 = str_replace('{{ticket.due_by_hrs}}', $RESOLVE . ' Min ', $temp_content2);
                                                    $temp_content2 = str_replace('{{ticket.subject}}', $row['Ticket_Name'], $temp_content2);
                                                    $temp_content2 = str_replace('{{ticket.requester.email}}', $row['Customer_Name'], $temp_content2);
//                                                    help::Mail($subject = $temp_sub2, $content = $temp_content2, $to = 'akhil.tm@yatrachef.com');
                                                    help::Mail2($subject = $temp_sub2, $content = $temp_content2, $to = 'hafeez.m@yatrachef.com', $from = 'support@yatrachef.com', $title = 'Resolve pending -[' . $ticket_id . ']');
                                                }
                                            }
                                        }
                                    }
                                }
                            }
//                    echo '<br>';
//                    echo 'dsg ' . $row['Status'] . '<br>';
                        } else {
                            echo 'F2 ' . $ticket_id . '<br>';
                        }
                    } else {
                        echo 'd';
                    }
//---------------------------------------------------------------------------------------------------------------------------
                    if ($row['Ticket_Type'] != 10) {
                        if ($row['Assigned_Operator'] == '0') { //Unassigned escalation
                            $UNA = ceil($this->ConvertMinutes($x = $current_time, $y = $created_time));
                            if ($UNA <= 30) {
                                if (($row['Status'] != 5) && ($row['Status'] != 6)) {
                                    if ($row['Unassigned_Mail'] == '0') {
//                        echo $sql = "UPDATE tbl_ticket SET Unassigned_Mail='1' WHERE Ticket_Id='$ticket_id'";
//                        if (help::execute($sql)) {
                                        foreach ($email_template as $typ3) {
                                            if ($typ3['Type'] == '4') {
                                                $temp_sub3 = $typ3['Subject'];
                                                $temp_content3 = $typ3['Content'];
                                                $temp_sub3 = str_replace('{{ticket.id}}', $ticket_id, $temp_sub3);
                                                echo $temp_sub3 = str_replace('{{ticket.subject}}', $row['Ticket_Name'], $temp_sub3);
//
                                                $temp_content3 = str_replace('{{ticket.id}}', $url, $temp_content3);
                                                $temp_content3 = str_replace('{{ticket.group.assign_time_mins}}', $UNA . ' Min ', $temp_content3);
                                                $temp_content3 = str_replace('{{ticket.description}}', 'Requestor Name: ' . $row['Customer_Name'], $temp_content3);
                                                $sql = "SELECT Name FROM tbl_user_group WHERE Id='$row[Group]'";
                                                $groupName = help::getScalar($sql);
                                                $temp_content3 = str_replace('{{ticket.group.name}}', $groupName, $temp_content3);
                                                $temp_content3 = str_replace('{{ticket.subject}}', $row['Ticket_Name'], $temp_content3);
//                                                help::Mail($subject = $temp_sub3, $content = $temp_content3, $to = 'akhil.tm@yatrachef.com');
                                                help::Mail2($subject = $temp_sub3, $content = $temp_content3, $to = 'hafeez.m@yatrachef.com', $from = 'support@yatrachef.com', $title = 'Unassigned -[' . $ticket_id . ']');
                                            }
                                        }
//                        }
//                            echo '<br>';
                                    }
                                }
                            } else {
//                                echo '=>F3-' . $ticket_id . '<br>';
                            }
                        }
                    }
//---------------------------------------------------------------------------------------------------------------------------
                }
            } else {
                echo 'Null';
            }
        } else {
            echo 'NULL';
        }
    }

    public function actionGetLeads() {
        $ch = curl_init();
        $url = $this->createUrl('/url/GetLeads1');
        $url = 'https://cc.yatrachef.com/' . $url;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//  curl_setopt($ch,CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 35000);
        $output = curl_exec($ch);

        curl_close($ch);
        print_r($output);
    }

    public function actiongetMail1() {
        $ch = curl_init();
        $url = $this->createUrl('/url/getMail1_safe_call');
        $url = 'https://cc.yatrachef.com/' . $url;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//  curl_setopt($ch,CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 35000);
        $output = curl_exec($ch);

        curl_close($ch);
        print_r($output);
    }

//  public function actionMail_test() {
//        require_once(dirname(dirname(__FILE__)) . '/../assets/Mailer/mail-attchement/mail_test.php');
//        $mailA = new ReadAttachment();
////        $host = '{pop.gmail.com:995/pop3/ssl}INBOX';
//           $host = '{imap.gmail.com:993/imap/ssl}INBOX';
//        $login = 'akhiltm22@gmail.com';
//        $password = 'Qwertyuiop12345!';
//        $savedirpath = dirname(dirname(__FILE__)) . '/../assets/Mailer/mail-attchement/Files';
////        $x = $mailA->getdata_leads($host, $login, $password, $savedirpath, $delete_emails = false);
////        $x = $mailA->get_leads($host, $login, $password, $savedirpath, $delete_emails = false);
//        $x = $mailA->getdata($host, $login, $password, $savedirpath, $delete_emails = false);
//        echo '<pre>';
//        print_r($x);
//    }
    public function actiongetMail1_safe_call() {
        require_once(dirname(dirname(__FILE__)) . '/../assets/Mailer/mail-attchement/class.emailattachment.php');
        $mailA = new ReadAttachment();
        $host = '{pop.gmail.com:995/pop3/ssl}INBOX';
        $login = 'yatrachefleads@gmail.com';
        $password = '@Stevejobs1';
        $savedirpath = dirname(dirname(__FILE__)) . '/../assets/Mailer/mail-attchement/Files';
//        $x = $mailA->getdata_leads($host, $login, $password, $savedirpath, $delete_emails = false);
        $x = $mailA->get_leads($host, $login, $password, $savedirpath, $delete_emails = false);
        echo '<pre>';
        print_r($x);
    }

    public function actiongetMail2() {
//        require_once(dirname(dirname(__FILE__)) . '/../assets/Mailer/mail-attchement/class.emailattachment.php');
        require_once(dirname(dirname(__FILE__)) . '/../assets/Mailer/mail-attchement/osticket/MailFetch.php');
        $mailA = new ReadAttachment();
        $host = '{pop.gmail.com:995/pop3/ssl}INBOX';
        $login = 'yatrachefforwards@gmail.com';
        $password = '@Stevejobs1';
        $savedirpath = dirname(dirname(__FILE__)) . '/../assets/Mailer/mail-attchement/Files';
        $x = $mailA->getdata($host, $login, $password, $savedirpath, $delete_emails = false);
        echo '<pre>';
        print_r($x);
    }

    public function actionGet_All_Mail() {
        require_once(dirname(dirname(__FILE__)) . '/../assets/Mailer/mail-attchement/class.emailattachment.php');
        $mailA = new ReadAttachment();


        $host = '{pop.gmail.com:995/pop3/ssl}INBOX';
//        $host = '{imap.gmail.com:993/imap/ssl}INBOX';
        $login = 'support@yatrachef.com';
        $password = '@Stevejobs1';
//        $login = 'akhil.tm@yatrachef.com';
//        $password = 'qwerty12345';
        $savedirpath = dirname(dirname(__FILE__)) . '/../assets/Mailer/mail-attchement/Files';
        $x = $mailA->getdata($host, $login, $password, $savedirpath, $delete_emails = false);
        echo '<pre>';
        print_r($x);
    }

    public function actionGetLeads1() {
        $hostname = '{pop.gmail.com:995/pop3/ssl}INBOX';
//        $hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
        $username = 'leads@yatrachef.com'; //'yatrachefleads@gmail.com';
        $password = '@Stevejobs1'; //@YC812781700!
        $inbox = @imap_open($hostname, $username, $password) or die('Cannot connect to Gmail: ' . imap_last_error());
        $emails = imap_search($inbox, 'ALL');
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
                    $body = imap_fetchbody($inbox, $email_number, "1");
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

//                echo '<pre>';
//                if (($email_from == 'info@railyatri.in') || ($email_from == 'noreply@railyatri.in')) {
                if (strpos($body, 'RY Code') !== false) {
                    if (($email_from == 'info@railyatri.in') || ($email_from == 'noreply@railyatri.in')) {
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
                }
            }
        }
        imap_close($inbox);
        echo "Done";
    }

    public function actionHotelDetails() {
        $sql = "SELECT id,rest_name,station_id FROM tbl_restaurant";
        $rest = help::readAll($sql);

        foreach ($rest as $r1) {
            echo $r1['id'];
            echo '-----';
            echo $sql = "SELECT o.day,o.id,o.res_id,o.present_total,o.payment_type,o.station,j.name,s.station_name FROM tbl_order_table o
        INNER JOIN tbl_journey j ON j.cust_id=o.cust_id
        INNER JOIN tbl_stations s ON s.id = o.station
        WHERE o.res_id='$r1[id]' AND o.station='$r1[station_id]'";
//            echo $r1['station_id'];

            $list = help::readAll($sql);

            if ($list != NULL) {
                echo '<pre>';
                $sql = "SELECT product_margin,company_margin FROM tbl_menu WHERE res_id=" . $list[0]['res_id'] . "";
                $menu = help::read($sql);
                $prod_mar = $menu['product_margin'];
                $comp_mar = $menu['company_margin'];
                $i = 0;
                foreach ($list as $row) {
                    $present_total = $row['present_total'];
//            echo '<br>';
                    if ($comp_mar == 20) {
                        $yt = $present_total * 0.1667;
                    } else {
                        $yt = $present_total * 0.1818;
                    }
                    $yt;
                    $hotel_amount = $present_total - $yt;
//            echo '<br>';
                    $array[$i] = $row['day'] . ',' . $row['name'] . ',' . $row['station_name'] . ',' . $row['payment_type'] . ',' . $present_total . ',' . $hotel_amount . ',' . $yt . ',' . $r1['rest_name'];
//            echo $path = dirname(__FILE__);die;
//
                    $i++;
                }


//


                print_r($array);

                $rname = $r1['rest_name'] . '.csv';
                $path = "C:\Users\New\Desktop\upload\Hotels\ $rname";
                $fp = fopen($path, 'w');
                foreach ($array as $fields) {
                    $var = explode(',', $fields);
                    fputcsv($fp, $var);
                }
                fclose($fp);
                echo 'true';
            } else {
                echo 'not found<br>';
            }
        }
    }

    public function actionmenu_upadate_all() {
        $sql = "select * from tbl_menu WHERE parcel_charge<>0";
        $result = help::readAll($sql);

        foreach ($result as $row) {
            $temp = ($row['price'] * $row['company_margin']) / (100);
            $price_cart = $row['price'] + $temp + $row['parcel_charge'];
            $price_cart = floor($price_cart);
            $row['id'];
            $sql = "update tbl_menu set price_cart='$price_cart' where res_id='$row[res_id]' AND item_name='$row[item_name]'";
            if (help::execute($sql)) {
                echo 'success' . $row['id'] . '<br>';
            }
        }
    }

    public function actionCheckNew() { //echo '{"status":1,"timestamp":"1420094419"}';die;
        $sql = "SELECT timestamp,update_time FROM tbl_store_timestamp WHERE type='1' ORDER BY id DESC LIMIT 1";
        $x = help::read($sql);
        $timestamp = $x['timestamp'];
        $update_time = $x['update_time'];
        $lastmodif = isset($_GET['timestamp']) ? $_GET['timestamp'] : 0;
        if ($lastmodif == 'null') {
            $lastmodif = time();
        }
        $currentmodif = $timestamp;
        while ($currentmodif <= $lastmodif) {
            usleep(10000);
            clearstatcache();
            $y = help::read($sql);
            $currentmodif = $y['timestamp'];
            $update_time = $y['update_time'];
        }
        $response = array();
        $response['status'] = 1;
        $response['timestamp'] = $currentmodif;
        $response['update_time'] = strtotime($update_time);
        $response['current_time'] = strtotime(date('Y-m-d H:i:s'));
        echo json_encode($response);
    }

    public function actionNewEvent() {
        $sql = "SELECT id FROM tbl_order_table WHERE update_status<>0";
        $list = help::readAll($sql);
        if ($list != NULL) {
            $msTime = time();
            $ctimeDate = date('Y-m-d H:i:s');
            $sql = "UPDATE tbl_store_timestamp SET timestamp='$msTime',update_time='$ctimeDate'  WHERE type=1";
            if (help::execute($sql)) {
                echo 'success';
                $sql = "UPDATE tbl_order_table SET update_status=0";
                help::execute($sql);
            } else {
                echo 'failed';
            }
        } else {
            echo 'Fail2';
        }
//        echo '<pre>';
//        print_r($list);
    }

    public function actionActiveLoginCron() {

//        $sql = "SELECT emp_id,last_active FROM tbl_callcenter WHERE  `status` = 1 AND `last_active` < DATE_SUB(NOW(), INTERVAL 30 SECOND)";
        $sql = "CALL READ_ALL(5,0)";
        $res = help::readAll($sql);
        if ($res != NULL) {
            foreach ($res as $row) {
                $id = $row['emp_id'];
                $x1 = strtotime($row['last_active']);
                $update = "UPDATE tbl_callcenter SET status='0' WHERE emp_id=$id";
                $sql = "UPDATE tbl_login_history SET logout_time='$row[last_active]' WHERE emp_id='$id'";
                if ((help::execute($update)) || (help::execute($sql))) {
                    echo 'success ' . $id . '<br>';
                }
            }
        } else {
            echo 'fail';
        }
    }

    public function actionCzentric_Cron($type = 0) {//0:missed,1:recived or dailed
        if (isset($_POST)) {
            if ($_POST['Phone_No'] != NULL) {
                if ($type == 0) {
                    echo $type;
                    $phone1 = $_POST['Phone_No'];
                    $db_frmt_dt = $_POST['Date_Time'];

                    $sql = "SELECT phone FROM tbl_callList WHERE phone='$phone1' AND status='1' AND date_time >= DATE_SUB(NOW(), INTERVAL 1 HOUR)"; //AND date_time >= DATE_SUB(NOW(), INTERVAL 1 HOUR)
                    $already_exist = help::getScalar($sql);
                    if ($already_exist != NULL) {
                        
                    } else {
                        if ((strtotime($db_frmt_dt) >= strtotime('07:00:00')) && (strtotime($db_frmt_dt) <= strtotime('21:00:00'))) {
//                            help::mail($subject = "SMS 1", $content = 'POST ' . $phone1 . '-' . $db_frmt_dt, $to = 'akhil.tm@yatrachef.com');
//                            $db_frmt_dt = '2015-08-28';
//                            if (strtotime($db_frmt_dt) == strtotime(date('Y-m-d'))) {
//                                $msg = 'Sorry, Our call center will remain closed due to Onam festivities. You can still place your order at www.yatrachef.com . We wish you a happy and prosperous Onam';
//                                $sms_id = help::sendmsg($phone1, $msg);
//                                } else {
                            $msg = 'Thank you for calling YatraChef.com. All our agents are currently busy. We will call you back at the earliest. Feel free to WhatsApp us at 08137813700.';
                            $sms_id = help::sendmsg($phone1, $msg);
//                                }
//                                echo '<span style="color:green;">SMS send check with alredy send within 1 hr=>' . $phone . '-' . $sms_id . '-' . $db_frmt_dt . '</span><br>';
                        }
                    }


                    $sql = "INSERT INTO `tbl_callList`(`call_slno`,`extension`, `phone`, `date_time`, `duration`, `status`,`Rep_Id`,`sms_id`,`Callcenter_Type`)
                                VALUES ('0','681','$phone1','$db_frmt_dt','00:00','1','0','0','1')";
                    if (help::execute($sql)) {
                        echo 'Success S<br>';
                        if ((strtotime($db_frmt_dt) >= strtotime('07:00:00')) && (strtotime($db_frmt_dt) <= strtotime('21:00:00'))) {
                            
                        } else {
//                            $sms_id = help::sendmsg($phone1, $msg = 'Sorry our food advisors are only available from 7 am to 9 pm. We will call you back after 7 am. To order food in train visit us at www.yatrachef.com.');
//                            echo '<span style="color:lightred;">Send sms between 9pm to 7am =>' . $phone . '-' . $sms_id . '-' . $db_frmt_dt . '</span><br>';
                        }
                    } else {
                        echo 'failed S<br>';
                    }
                } else if ($type == 1) {
                    echo $type;
                    if (strpos($_POST['C_Type'], 'INBOUND') !== false) {
                        $status = 2;
                    } else if (strpos($_POST['C_Type'], 'OUTBOUND') !== false) {
                        $status = 3;
                    }
                    $phone1 = $_POST['Phone_No'];
                    $db_frmt_dt = $_POST['C_Start_Time'];
                    $sql = "INSERT INTO `tbl_callList`(`call_slno`,`extension`, `phone`, `date_time`, `duration`, `status`,`Rep_Id`,`sms_id`,`Callcenter_Type`)
                                VALUES ('0','$_POST[Agent_ID]','$phone1','$db_frmt_dt','00:00','$status','0','0','1')";
                    if (help::execute($sql)) {
                        echo 'Success S<br>';
                    } else {
                        echo 'failed S<br>';
                    }
                }
            }
        } else {
            echo 'null';
        }
    }

    public function actionCallListCron() { //for fetch current day call list
        $pathfile = 'http://yatrachef.ddns.net/neos.txt';
//        $pathfile = 'http://202.83.46.11/neos.txt';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $pathfile);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//  curl_setopt($ch,CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 35000);
        $output = curl_exec($ch);
        curl_close($ch);
        $fileObj = fopen($pathfile, "rt");
        while (( $line = fgets($fileObj))) {
            $res = explode(' ', $line);
//             print_r($res);
            $sl_no = $res[0];
            $ext = $res[2];
            if ($res[14] == '') {
                $phone = $res[16];
            } else {
                $phone = $res[14];
                if ($phone == '') {
                    
                }
            }

            $lengthPh = strlen($phone);
            if ($lengthPh == 11) {
                if ($res[21] == '') {
                    $date = $res[23];
                    $duration = $res[28];
                    $status = $res[35];
                    $time = $res[24];
                } else {
                    $date = $res[21];
                    $duration = $res[26];
                    $status = $res[35];
                    $time = $res[22];
                }
            } else if ($lengthPh == 12) {
                $duration = $res[25];
                $status = $res[34];
                $date = $res[20];
                $time = $res[21];
            } else if ($lengthPh == 10) {
                $duration = $res[27];
                $status = $res[36];
                $date = $res[22];
                $time = $res[23];
            } else {
                $status = '0';
            }
            $cyear = date('Y');
            $cday = date('d');
            $cmonth = date('m');
            $check_format = $cday . '/' . $cmonth;
            $db_frmt_dt = date('Y-m-d ' . $time);
            $db_frmt_dt = date('Y-m-d H:i:s', strtotime($db_frmt_dt));
//            $check_format = '20/05';
            $date = preg_replace('/\s+/', ' ', $date);
            $check_format = preg_replace('/\s+/', ' ', $check_format);
            if ($date == $check_format) {
                if ($ext != '') {
                    $sql = "SELECT emp_id FROM `tbl_callcenter` WHERE `communication_phone`=$ext";
                    $rep_id = help::getscalar($sql);
                    if ($rep_id == '') {
                        $rep_id = '';
                    }
                    if ((strpos($status, 'U') !== false) || (strpos($status, 'R') !== false)) {
                        $status = str_replace('*', '', $status);
                        if (strpos($status, 'U') !== false) {
                            $status1 = 1;
                            $sql = "SELECT phone FROM tbl_callList WHERE phone='$phone' AND date_time >= DATE_SUB(NOW(), INTERVAL 1 HOUR)";
                            $already_exist = help::getScalar($sql);
                            if ($already_exist != NULL) {
//                                echo $already_exist.'--'.$phone.'<br>';
                            } else {
                                if ((strtotime($db_frmt_dt) >= strtotime('07:00:00')) && (strtotime($db_frmt_dt) <= strtotime('21:00:00'))) {
                                    if (($ext != '700') && ($ext != '785') && ($ext != '766') && ($ext != '788') && ($ext != '799') && ($ext != '787') && ($ext != '720')) {
                                        $sms_id = help::sendmsg($phone, $msg = 'Thank you for calling YatraChef.com. All our agents are currently busy. We will call you back at the earliest. Feel free to WhatsApp us at 08137813700.');
                                        echo '<span style="color:green;">SMS send check with alredy send within 1 hr=>' . $phone . '-' . $sms_id . '-' . $db_frmt_dt . '</span><br>';
                                    }
                                }
                            }
                            if ((strtotime($db_frmt_dt) >= strtotime('07:00:00')) && (strtotime($db_frmt_dt) <= strtotime('21:00:00'))) {
                                
                            } else {
                                if (($ext != '700') && ($ext != '785') && ($ext != '766') && ($ext != '788') && ($ext != '799') && ($ext != '787') && ($ext != '720')) {
                                    $sms_id = help::sendmsg($phone, $msg = 'Sorry our food advisors are only available from 7 am to 9 pm. We will call you back after 7 am. To order food in train visit us at www.yatrachef.com.');
                                    echo '<span style="color:lightred;">Send sms between 9pm to 7am =>' . $phone . '-' . $sms_id . '-' . $db_frmt_dt . '</span><br>';
                                }
                            }
                        } else if (strpos($status, 'R') !== false) {
                            $status1 = 2;
                        }
                        $sql = "CALL insert_pnr_cron('1','$sl_no','$ext','$phone','$db_frmt_dt','$duration','$status1','$rep_id','$sms_id')";
                        if (help::execute($sql)) {
                            echo 'Success<br>';
                        } else {
                            echo 'failed<br>';
                        }
                    }
                    $status = str_replace('*', '', $status);
                    if (strpos($status, 'S') !== false) {
                        $phone1 = $phone;
                        $status2 = 3;
                        $db_frmt_dt = date('Y-m-d ' . $time);
                        $sql = "CALL insert_pnr_cron('1','$sl_no','$ext','$phone1','$db_frmt_dt','$duration','$status2','$rep_id','0')";
                        if (help::execute($sql)) {
                            echo 'Success S<br>';
                        } else {
                            echo 'failed S<br>';
                        }
                    }
                } else {
                    echo $res[0] . '-->' . $phone . '->' . $status . '------------------>' . $duration . '<br>';
                }
            }
        }
//        file_get_contents('http://yatrachef.ddns.net/clearmyfile.php');
        $url = 'http://yatrachef.ddns.net/clearmyfile.php';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//  curl_setopt($ch,CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 35000);
        $output = curl_exec($ch);
        curl_close($ch);
    }

    public function actionCallListCron__344234() { //for fetch current day call list
        $pathfile = 'http://yatrachef.ddns.net/neos.txt';
//        $pathfile = 'http://202.83.46.11/neos.txt';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $pathfile);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//  curl_setopt($ch,CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 35000);
        $output = curl_exec($ch);
        curl_close($ch);
        $fileObj = fopen($pathfile, "rt");
        while (( $line = fgets($fileObj))) {
            $res = explode(' ', $line);
//             print_r($res);
            $sl_no = $res[0];
            $ext = $res[2];
            if ($res[14] == '') {
                $phone = $res[16];
            } else {
                $phone = $res[14];
                if ($phone == '') {
                    
                }
            }

            $lengthPh = strlen($phone);
            if ($lengthPh == 11) {
                if ($res[21] == '') {
                    $date = $res[23];
                    $duration = $res[28];
                    $status = $res[35];
                    $time = $res[24];
                } else {
                    $date = $res[21];
                    $duration = $res[26];
                    $status = $res[35];
                    $time = $res[22];
                }
            } else if ($lengthPh == 12) {
                $duration = $res[25];
                $status = $res[34];
                $date = $res[20];
                $time = $res[21];
            } else if ($lengthPh == 10) {
                $duration = $res[27];
                $status = $res[36];
                $date = $res[22];
                $time = $res[23];
            } else {
                $status = '0';
            }
            $cyear = date('Y');
            $cday = date('d');
            $cmonth = date('m');
            $check_format = $cday . '/' . $cmonth;
            $db_frmt_dt = date('Y-m-d ' . $time);
//            $check_format = '19/05';
            $date = preg_replace('/\s+/', ' ', $date);
            $check_format = preg_replace('/\s+/', ' ', $check_format);
            if ($date == $check_format) {
                if ($ext != '') {
                    $sql = "SELECT emp_id FROM `tbl_callcenter` WHERE `communication_phone`=$ext";
                    $rep_id = help::getscalar($sql);
                    if ($rep_id == '') {
                        $rep_id = '';
                    }
                    if ((strpos($status, 'U') !== false) || (strpos($status, 'R') !== false)) {
                        $status = str_replace('*', '', $status);
                        if (strpos($status, 'U') !== false) {
                            $status1 = 1;
                        } else if (strpos($status, 'R') !== false) {
                            $status1 = 2;
                        }
//                        $sql = "INSERT INTO `tbl_callList`(`call_slno`,`extension`, `phone`, `date_time`, `duration`, `status`,`Rep_Id`)
//                                VALUES ('$sl_no','$ext','$phone','$db_frmt_dt','$duration','$status1','$rep_id')";
                        $sql = "CALL insert_pnr_cron('1','$sl_no','$ext','$phone','$db_frmt_dt','$duration','$status1','$rep_id','0')";
//                        echo $res[0] . '-->' . $phone . '->' . $status . '->' . $duration . '<br>';
                        if (help::execute($sql)) {
                            echo 'Success<br>';
                        } else {
                            echo 'failed<br>';
                        }
                    }
                    $status = str_replace('*', '', $status);
                    if (strpos($status, 'S') !== false) {
                        $phone1 = $phone;
                        $status2 = 3;
                        $db_frmt_dt = date('Y-m-d ' . $time);
//                        $sql = "INSERT INTO `tbl_callList`(`call_slno`,`extension`, `phone`, `date_time`, `duration`, `status`,`Rep_Id`)
//                                VALUES ('$sl_no','$ext','$phone1','$db_frmt_dt','$duration','$status2','$rep_id')";
                        $sql = "CALL insert_pnr_cron('1','$sl_no','$ext','$phone1','$db_frmt_dt','$duration','$status2','$rep_id','0')";
                        if (help::execute($sql)) {
                            echo 'Success S =>>>>>><br>';
                        } else {
                            echo 'failed S<br>';
                        }
                    }
                } else {
                    echo $res[0] . '-->' . $phone . '->' . $status . '------------------>' . $duration . '<br>';
                }
            }
        }
//        file_get_contents('http://yatrachef.ddns.net/clearmyfile.php');
        $url = 'http://yatrachef.ddns.net/clearmyfile.php';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//  curl_setopt($ch,CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 35000);
        $output = curl_exec($ch);
        curl_close($ch);
    }

    public function actionSingleQueue() {

        $sql = "call READ_ALL(3,0)";
        $list = help::readAll($sql);
        $sql = "SELECT value FROM settings WHERE id=9";
        $extra_time = help::getScalar($sql);
        $subhead1 = $subhead2 = $subhead3 = $subhead4 = $subhead5 = $subhead6 = $subhead7 = FALSE;
        if ($list == NULL) {
            echo '<table border="1"><tr><td style="color:red;background:black;font-size:18px;">No Orders on Today and Tomarrow</td>';
            echo '</tr>';
            die;
        }
        echo '<style>.subhead{height: 23px;
background: black;
color: white;
padding: 3px;
text-align: left;}</style>';
        echo '<table border="1"><tr>';
        echo '<td  class="td1 nb">Order ID</td>
                <td class="td2 nb">STA</td>
                <td class="td2 nb">ETA</td>
                <td class="td2 nb">IAT</td>
                <td class="td6 nb">Reach<br>(Min.)</td>
                <td class="td4 nb" style="color: white;">Name</td>
                <td class="td6 nb">Train</td>
                <td class="td7 nb"  style="color: white;">Restaurant<br>(Station)</td>
                <td class="td8 nb">Payment</td>';
        echo '</tr>';
        $subhead1 = $subhead2 = $subhead3 = $subhead4 = $subhead5 = $subhead6 = $subhead7 = FALSE;
        foreach ($list as $row) {
            $actuval = strtotime($row['expected_arrival']);
            $actuval = date("Y-m-d H:i:00", $actuval);
            $lead_time = $row['lead_time'];
            $lead_time = $lead_time + $extra_time; //mintus
            $oid = $row['orderId'];
            $lead_dt = date('Y-m-d H:i:00', strtotime($actuval . ' - ' . $lead_time . ' min'));
            $MIN = $this->ConvertMinutes($x = date('Y-m-d H:i:00'), $y = $lead_dt);
//echo $MIN.'==>'.$oid.'<br>';

            $leadArray[$oid] = $MIN;
        }
        asort($leadArray);
        foreach ($leadArray as $test => $key) {
            $sql = "call READ_ALL(4,$test)";
            $data = help::read($sql);
//            print_r($data);

            $oid = $data['orderId'];
            $cust_id = $data['customerId'];
            $station_id = $data['station'];
            $sql = "SELECT name,phone_no,train_no FROM tbl_journey WHERE cust_id='$cust_id'";
            $journey = help::read($sql);
            $sql = "SELECT station_name FROM tbl_stations WHERE id='$station_id'";
            $station = help::getscalar($sql);
            $sql1 = "SELECT sms_id,success FROM `tbl_sms_data` WHERE `cust_id`=$cust_id AND type=1";
            $sms1 = help::read($sql1);
            $s1succ = $sms1['success'];
            $s1gid = $sms1['sms_id'];
            $sql2 = "SELECT sms_id,success FROM `tbl_sms_data` WHERE `oid`=$oid AND type=2";
            $sms2 = help::read($sql2);
            $s2succ = $sms2['success'];
            $s2gid = $sms2['sms_id'];

            $sheduled = strtotime($data['real_day_time']);
            $sheduled = date("d-m-Y H:i:s", $sheduled);
            $sheduledSp = explode(' ', $sheduled); //date and time sheduled time
            $actuval = strtotime($data['expected_arrival']);
            $actuval = date("d-m-Y H:i:s", $actuval);
            $actuvalSp = explode(' ', $actuval);
            $rest_name = explode('_', $data['rest_name']);
            $rest_name = $rest_name[0];

            if ($data['our_exp_time'] == 0) {
                $ourExpTime[0] = '';
                $ourExpTime[1] = '';
                $Exptitle = '';
            } else {
                $ourExpTime = explode(' ', $data['our_exp_time']);
                $Expminutes = $this->ConvertMinutes($x = date('d-m-Y H:i:00'), $y = $data['our_exp_time']);
                $Exptitle = 'Train ' . $data['trainDelay'] . ',Distance ' . $data['distance'] . ' kms,Delay Updated By ' . $data['DelayUpdate'] . ',Reched by ' . $Expminutes . ' Min.';
            }

            if ($data['special_order'] == 1) {
                $specialOrderStyle = 'background: rgb(114, 26, 117);color: white;';
            } else {
                $specialOrderStyle = '';
            }
            if ($data['splOption1'] == 1) {
                $specialOrderStyle1 = 'background: yellow;color: white;';
            } else {
                $specialOrderStyle1 = '';
            }
            if ($data['splOption2'] == 2) {
                $specialOrderStyle2 = 'background: pink;color: black;';
            } else {
                $specialOrderStyle2 = '';
            }
//            --------
            if ($data['payment_type'] == 'Online_Payment') {
                $sql = "SELECT transaction_id,transaction_status FROM tbl_payment WHERE cust_id='$cust_id'";
                $tran = help::read($sql);
                if ($tran != NULL) {
                    if (($tran['transaction_id'] == '') || ($tran['transaction_status'] == 'FAILED')) {

                        echo '<style>
                        .OrderId1' . $oid . '{
                         display:none;
                        }
                           </style>';
                    }
                } else {
                    echo '<style>
                        .OrderId1' . $oid . '{
                         display:none;
                        }
                           </style>';
                }
            }
            if ($data['nottify'] == '2') {
                echo '<style>
                        .OrderId1' . $oid . '{
                         background:rgba(82, 82, 82, 0.67);
                        }
                           </style>';
            }

            if ($s1gid != 0) {
                if ($s1succ == 1) {
                    $td4Rstyle = "color:rgb(15, 199, 59)";
                } else {
                    $td4Rstyle = "color:red";
                }
            } else {
                $td4Rstyle = '';
            }
            if ($s2gid != 0) {
                if ($s2succ == 1) {
                    $td4RRstyle = "color:rgb(15, 199, 59)";
                } else {
                    $td4RRstyle = "color:red";
                }
            } else {
                $td4RRstyle = '';
            }
//            --------------------color code--------------------
            if ($key >= 60) {
                if (!$subhead7) {
                    echo '<tr style="border:none;"><td class="subhead" colspan="9" style="background:none;border:none;height: 11px;"></td></tr>';
                    echo '<tr><td class="subhead" colspan="9">60-</td></tr>';
                    $subhead7 = TRUE;
                }
                echo '<style>
                        #STA' . $oid . ',#ETA' . $oid . '{ background:lightgreen ;color:black;}
                      </style>';
            }
            if (($key <= 60) && ($key >= 45)) {
                if (!$subhead6) {
                    echo '<tr style="border:none;"><td class="subhead" colspan="9" style="background:none;border:none;height: 11px;"></td></tr>';
                    echo '<tr><td class="subhead" colspan="9">LT+45 To 60min.</td></tr>';
                    $subhead6 = TRUE;
                }
                echo '<style>
                        #STA' . $oid . ',#ETA' . $oid . '{ background:pink ;color:black;}
                      </style>';
            }
            if (($key <= 45) && ($key >= 30)) {
                if (!$subhead5) {
                    echo '<tr style="border:none;"><td class="subhead" colspan="9" style="background:none;border:none;height: 11px;"></td></tr>';
                    echo '<tr><td class="subhead" colspan="9">LT+30 To 45min.</td></tr>';
                    $subhead5 = TRUE;
                }
                echo '<style>
                        #STA' . $oid . ',#ETA' . $oid . '{ background:lightblue ;color:black;}
                      </style>';
            }
            if (($key <= 30) && ($key >= 15)) {
                if (!$subhead4) {
                    echo '<tr style="border:none;"><td class="subhead" colspan="9" style="background:none;border:none;height: 11px;"></td></tr>';
                    echo '<tr><td class="subhead" colspan="9">LT+15 To 30min.</td></tr>';
                    $subhead4 = TRUE;
                }
                echo '<style>
                        #STA' . $oid . ',#ETA' . $oid . '{ background:yellow ;color:black;}
                      </style>';
            }
            if (($key <= 15) && ($key >= 0)) {
                if (!$subhead3) {
                    echo '<tr style="border:none;"><td class="subhead" colspan="9" style="background:none;border:none;height: 11px;"></td></tr>';
                    echo '<tr><td class="subhead" colspan="9">LT To 15min.</td></tr>';
                    $subhead3 = TRUE;
                }
                echo '<style>
                        #STA' . $oid . ',#ETA' . $oid . '{ background:lightsalmon ;color:black;}
                      </style>';
            }
            if ($key <= 0) {
//            -----------------st-----------Processing----------
                if ($data['processing'] == 1) {
//                ,#td2n' . $data['orderId'] . ',#td1n' . $data['orderId'] . '
                    echo '<style>
                                                 #STA' . $data['orderId'] . ',#ETA' . $data['orderId'] . '{
                                                     background:orange !important;color:black !important;
                                        }
                                                                           </style>';
                } else if ($data['orderPassedRest'] == 1) {
                    echo '<style>
                                                 #STA' . $data['orderId'] . ',#ETA' . $data['orderId'] . '{
                                                     background:orange !important;color:black !important;
                                    }
                                                                           </style>';
                } else if ($data['orderConfirmRest'] == 1) {
                    echo '<style>
                                                 #STA' . $data['orderId'] . ',#ETA' . $data['orderId'] . '{
                                                     background:orange !important;color:black !important;
                                }
                                                       </style>';
                }
//            ------------------end--------------------
                if (!$subhead1) {
                    echo '<tr style="border:none;"><td class="subhead" colspan="9" style="background:none;border:none;height: 11px;"></td></tr>';
                    echo '<tr><td class="subhead" colspan="9">Lead Time</td></tr>';
                    $subhead1 = TRUE;
                }
                echo '<style>
                        #STA' . $oid . ',#ETA' . $oid . '{background: rgb(247, 48, 48);color:white;}
                      </style>';
            }

//            --------------------color code end---------------
            $minutes = $this->ConvertMinutes($x = date('d-m-Y H:i:00'), $y = $actuval);
            if ($data['train_status'] == 1) {
                $train_data = '<img src="' . Yii::app()->request->baseUrl . '/assets/FrontEnd/img/reached.png" style="width:30px;height:30px;position: absolute;margin: 0 0 0 -11px;" />';
                $fieldTitle = 'Train Reached';
            } else {
                $train_data = $minutes;
                $fieldTitle = 'Train ' . $data['trainDelay'] . ',Distance ' . $data['distance'] . ' kms';
            }
            echo '<tr class="OrderId1' . $oid . '" style="cursor:pointer;">';
            echo '<td id="td2n' . $oid . '" Onclick="window.location.href = \'' . $this->createUrl('/order/details/id') . '/' . $oid . '\';"><a style="color:black;" href="' . $this->createUrl('/order/details/id') . '/' . $oid . '">' . $oid . '</a></td>';
            echo '<td class="td2" id="STA' . $oid . '" Onclick="window.location.href = \'' . $this->createUrl('/order/details/id') . '/' . $oid . '\';"><span style="font-weight:bold;">' . $sheduledSp[1] . '</span><br><span style="font-size:14px;">' . $sheduledSp[0] . '</span></td>';
            echo '<td class="td2" id="ETA' . $oid . '" title="" Onclick="window.location.href = \'' . $this->createUrl('/order/details/id') . '/' . $oid . '\';"><span style="font-weight:bold;">' . $actuvalSp[1] . '</span><br><span style="font-size:14px;">' . $actuvalSp[0] . '</span></td>';
            if ($ourExpTime[0] != 0) {
                $ourExpet_FrmtChang = strtotime($ourExpTime[0]);
                $ourExpet_FrmtChang = date("d-m-Y", $ourExpet_FrmtChang);
            } else {
                $ourExpet_FrmtChang = '';
            }
            echo '<td class="td2" id="ITA' . $oid . '" title="' . $Exptitle . '" Onclick="window.location.href = \'' . $this->createUrl('/order/details/id') . '/' . $oid . '\';"><span style="font-weight:bold;">' . $ourExpTime[1] . '</span><br><span style="font-size:14px;">' . $ourExpet_FrmtChang . '</span></td>';


            echo '<td style="font-weight:bold;" class="td6" title="' . $fieldTitle . '" Onclick="window.location.href = \'' . $this->createUrl('/order/details/id') . '/' . $oid . '\';">' . $train_data . '</td>';
            echo '<td class="td4" style="' . @$td4Rstyle . '" Onclick="window.location.href = \'' . $this->createUrl('/order/details/id') . '/' . $oid . '\';"><span style="font-weight:bold;">' . $journey['name'] . '</span><br><span style="font-size:14px;">' . $journey['phone_no'] . '</span><span style="float: right;padding: 1px;border: 1px solid white;background: white;"></span></td>';

            echo '<td class="td6"><span  class="trainspace" Onclick="window.location.href = \'' . $this->createUrl('/order/details/id') . '/' . $oid . '\';">' . $journey['train_no'] . '</span></td>';



            echo '<td class="td7" style="' . @$td4RRstyle . '" Onclick="window.location.href = \'' . $this->createUrl('/order/details/id') . '/' . $oid . '\';"><span style="font-weight:bold;">' . $rest_name . '</span><br><span style="font-size:14px;">' . $station . '</span>';
            echo '<span style="float: right;padding: 1px;border: 1px solid white;background: white;"></span></td>';


            echo '<td class="td8" style="padding:0;' . @$specialOrderStyle . @$specialOrderStyle1 . $specialOrderStyle2 . '"><a style="color:black;" href="' . $this->createUrl('/order/details/id') . '/' . $oid . '" target="_blank"><span class="cpayment">';
            if ($data['payment_type'] == 'Online_Payment') {
                echo 'Online';
            } else if ($data['payment_type'] == 'cod') {
                echo 'COD';
            } else {
                echo $data['payment_type'];
            };
            echo '<br>';
            if ($data['verify_customer_display'] == 1) {
                echo '<span style="color:green;font-weight:bold;"><img class="cVerification" src="' . Yii::app()->request->baseUrl . '/assets/FrontEnd/img/customer_verified.png"/></span>';
            } else {
                echo '<span style="color:red;font-weight:bold;"><img class="cVerification" src="' . Yii::app()->request->baseUrl . '/assets/FrontEnd/img/customer_not_verified.png"/></span>';
            }
            echo '</span></a></td>';
//            echo '<td>'. $data['lead_time'] . '</td>';
//             . $key . '-'
            echo '</tr>';
        }


        echo '</table>';
    }

    public function actionCheckSMSbalance() {
        $url2 = file_get_contents("http://sapteleservices.com/SMS_API/balanceinfo.php?username=yatra2&password=12345");
        $result1 = explode('T-', $url2);
        $result1 = explode('P-', $result1[1]);
        $balance1 = $result1[0];
        $url = file_get_contents("http://sapteleservices.in/SMS_API/balanceinfo.php?username=yatra2&password=123456");
        $result = explode('-', $url);
        $result = explode('Promotional Credits', $result[1]);
        $result = explode('<br>', $result[0]);
        $balance = $result[0];
        

        $html = '<table border="1" width="50%"><tr><td>SAP.in</td><td>' . $balance . '<td></tr>'
                . ' <tr><td>SAP.com</td><td>' . $balance1 . '<td></tr></table><div>'
                . '<br>Change SMS Gateway<hr>'
                . '<a style="    background: green;
    color: white;
    padding: 2px 6px;
    margin: 8px 11px;" href="https://cc.yatrachef.com/index.php/manage/Smsgateway/sel/1">SAP.in</a>'
                . '<a style="    background: green;
    color: white;
    padding: 2px 6px;
    margin: 8px 11px;" href="https://cc.yatrachef.com/index.php/manage/Smsgateway/sel/2">Route sms</a>'
                . '<a style="    background: green;
    color: white;
    padding: 2px 6px;
    margin: 8px 11px;" href="https://cc.yatrachef.com/index.php/manage/Smsgateway/sel/3">RY sms</a>'
                . '<a style="    background: green;
    color: white;
    padding: 2px 6px;
    margin: 8px 11px;" href="https://cc.yatrachef.com/index.php/manage/Smsgateway/sel/4">SAP.com</a>'
                . '</div><div><br><a href="https://cc.yatrachef.com/index.php/url/CheckSMSbalance">Resend Mail</a></div>';

//        echo $x = help::Mail_Attachment('SMS BALANCE REMINDER', $html, 'akhil.tm@yatrachef.com', $from = 'support@yatrachef.com', $title = 'YatraChef', $cc, $attach = $temp, $path = '');


        $temp[0] = '';
        $cc[0] = 'akhil.tm@yatrachef.com';
        $date = date('d-m-Y');
//        $balance = 505;
        if ((($balance >= 8000) && ($balance < 10000)) || ($balance1 >= 8000) && ($balance1 < 10000)) {
            echo 'CASE 1 ok<br>';
            $guid = help::SMSAPI(3, 9567025021, 'SMS balance low SAP.in : ' . $balance . ', SAP.com : ' . $balance1);
            $guid = help::SMSAPI(3, 9633500719, 'SMS balance low SAP.in : ' . $balance . ', SAP.com : ' . $balance1);
            $x = help::Mail_Attachment('SMS BALANCE REMINDER ' . $date, $html, 'rameez@yatrachef.com', $from = 'support@yatrachef.com', $title = 'YatraChef', $cc, $attach = $temp, $path = '');
        } else if ((($balance >= 900) && ($balance < 1000)) || (($balance1 >= 900) && ($balance1 < 1000))) {
            echo 'CASE 2 ok<br>';
            $guid = help::SMSAPI(3, 9567025021, 'SMS balance low SAP.in : ' . $balance . ', SAP.com : ' . $balance1);
            $guid = help::SMSAPI(3, 9633500719, 'SMS balance low SAP.in : ' . $balance . ', SAP.com : ' . $balance1);
            $x = help::Mail_Attachment('SMS BALANCE REMINDER ' . $date, $html, 'rameez@yatrachef.com', $from = 'support@yatrachef.com', $title = 'YatraChef', $cc, $attach = $temp, $path = '');
        } else if (($balance >= 10) && ($balance < 20)) {
            
        } else {
            echo 'Empty Query';
        }
    }

    public function actionAutoMessage() {

        $sql = "SELECT o.id as orderId,o.cust_id,o.expected_arrival,o.payment_type,r.lead_time
            FROM tbl_order_table o
            INNER JOIN tbl_restaurant r ON r.id=o.res_id
            WHERE o.order_status='1' AND (DATE(real_day_time)=CURDATE())
            AND o.verify_customer_display='1'";
//        echo '<pre>';
//        $sql = "call select_auto_messages()";
        $list = help::readAll($sql);
        if ($list != NULL) {
            $sql = "SELECT value FROM settings WHERE id=9";
            $extra_time = help::getScalar($sql);
            foreach ($list as $row) {
                if ($row['payment_type'] == 'Online_Payment') {
                    $sql = "SELECT cust_id,transaction_id,transaction_status FROM tbl_payment WHERE cust_id='$row[cust_id]'";
                    $tran = help::read($sql);
                    if ($tran != NULL) {
                        if (($tran['transaction_id'] != '') && ($tran['transaction_status'] != 'FAILED')) {
                            $actuval = strtotime($row['expected_arrival']);
                            $actuval = date("Y-m-d H:i:00", $actuval);
                            $lead_time = $row['lead_time'];
                            $lead_time = $lead_time + $extra_time; //mintus
                            $lead_dt = date('Y-m-d H:i:00', strtotime($actuval . ' - ' . $lead_time . ' min'));
                            $oid = $row['orderId'];
                            $MIN = $this->ConvertMinutes($x = date('Y-m-d H:i:00'), $y = $lead_dt);
                            $leadArray[$oid] = $MIN;
                            $smsRes15[$oid] = $row['expected_arrival'];
                        }
                    }
                } else {
                    $oid = $row['orderId'];
                    $actuval = strtotime($row['expected_arrival']);
                    $actuval = date("Y-m-d H:i:00", $actuval);
                    $lead_time = $row['lead_time'];
                    $lead_time = $lead_time + $extra_time; //mintus
                    $lead_dt = date('Y-m-d H:i:00', strtotime($actuval . ' - ' . $lead_time . ' min'));
                    $MIN = $this->ConvertMinutes($x = date('Y-m-d H:i:00'), $y = $lead_dt);
                    $leadArray[$oid] = $MIN;
                    $smsRes15[$oid] = $row['expected_arrival'];
                }
            }
//            print_r($leadArray);die;
            asort($leadArray);
            foreach ($leadArray as $test => $key) {
                $sql = "SELECT cust_id FROM tbl_order_table WHERE id='$test'";
                $cust_id = help::getscalar($sql);
                $oid = $test;
                if (($key <= 15) && ($key >= 0)) {
//                echo '--15--';
                    $this->FetchingSMS($oid = $test, $cust_id);
                }
                if ($key <= 0) {
//                echo $oid.'--'.$key.'<br>';
                    $this->FetchingSMS($oid, $cust_id);
                }
            }
        } else {
            echo 'Empty Query..';
        }
    }

    public function FetchingSMS($oid, $cust_id) {
        $sql = "SELECT success,oid  FROM `tbl_sms_dataTemp` WHERE `oid` = '$oid' AND type='2' AND success='1' AND AutoMessage=0";
        $smsCheck = help::read($sql);
        if ($smsCheck == NULL) {
            $Auto = $this->CreateMessage($oid);
            $SMSmessege = $Auto['message'];
            $SMSphone = $Auto['phone'];
            $sql = "SELECT date_time,AutoMcount,sms_id,attempt  FROM `tbl_sms_dataTemp` WHERE `oid` = '$oid' AND cust_id='$cust_id' AND massage='$SMSmessege'  AND AutoMessage='0'";
            $findSmsSent = help::read($sql);
            if ($findSmsSent != NULL) {
//                        print_r($findSmsSent);
                $cdateNow = date('Y-m-d H:i:00');
                $dateTime = $findSmsSent['date_time'];
                $autoCount = $findSmsSent['AutoMcount'];
                $sms_id = $findSmsSent['sms_id'];
                $attempt = $findSmsSent['attempt'];
                $autoCount = $autoCount + 1;
                $sql = "UPDATE tbl_sms_dataTemp SET date_time='$cdateNow',AutoMcount='$autoCount' WHERE `oid` = '$oid' AND cust_id='$cust_id' AND massage='$SMSmessege'";
                if (help::execute($sql)) {
//                    ------checking delivery status--------
                    $sms_id = str_replace(" ", "", $sms_id);
//                    try {
                    $url = 'sapteleservices.in';
                    $http_code = 'http://';
                    $website_down = $this->is_website_down($url, $http_code);
                    if ($website_down) {
                        echo "Website is down!";
                        die;
                    }

                    $url = file_get_contents("http://sapteleservices.in/getdelivery/yatra2/123456/" . $sms_id);


                    $result = explode('~', $url);
                    $temp1 = $result[1];
                    $temp2 = $result[0];
                    $m1 = explode(',', @$result[0]);
                    $m1 = explode('Dear', @$m1[0]);
                    $result[4] = strip_tags($result[4]);
                    $result[5] = $result[2];
                    $dstatus = $result[2] . '~' . $result[3] . '~' . $result[4] . '~' . $result[5];
                    if (($result[5] == '1') || ($result[5] == '5')) {
                        $Sstatus = 1;
                    } else if ($result[5] == '') {
                        $Sstatus = 2;
                    } else {
                        $Sstatus = 2;
                    }
//                    -----------ending--------------
                    if ($Sstatus == 1) {
                        $sql = "UPDATE tbl_sms_dataTemp SET status = '$dstatus',success = '$Sstatus' WHERE oid=$oid AND sms_id=$sms_id AND type=2";
                        if (help::execute($sql)) {
                            echo 'Updated Delivery Status  ' . $oid . '<br>';
                        }
                    } else {
//enable resent
                        $SendingStatus = $this->SendSMS($oid, $cust_id, $SMSmessege, $SMSphone, $type = 2, $sms_id, $attempt);
                        echo 'RESEND SMS ' . $oid . '=>' . $SendingStatus . 'Attempt->>' . $attempt . '<br>';
                    }
//                    } catch (Exception $ex) {
//                        $SendingStatus = $this->SendSMS($oid, $cust_id, $SMSmessege, $SMSphone, $type = 2);
//                        echo 'RESEND SMS ' . $oid . '=>' . $SendingStatus . '<br>';
//                    }
                }
            } else {
                $SendingStatus = $this->SendSMS($oid, $cust_id, $SMSmessege, $SMSphone, $type = 1);
                echo 'SMS SENDING ' . $oid . '=>' . $SendingStatus . 'Attempt->>' . $attempt . '<br>';
            }
        } else {
            echo 'Empty Rows  ' . $oid . '<br>';
        }
    }

    public function SendSMS($oid, $cust_id, $SMSmessege, $SMSphone, $type, $sms_id = 0, $attempt = 0, $contactType = 1, $SType = 2) {
//       $SMSphone1 = '8089090020';
        $sql = "SELECT value FROM settings WHERE id=8";
        $active = help::getScalar($sql);
        if ($active == 0) {
//            $SMSphone1 = '8089090020';
            $SMSphone1 = '9633500719';
//            if ($attempt != '3') {
            if (($attempt <= '1') && ($attempt >= '0')) {
                $sql = "SELECT value FROM `settings` WHERE id=5";
                $sms_api_type = help::getScalar($sql);

                $guid = help::SMSAPI($sms_api_type, $SMSphone1, $SMSmessege);
                $api_type = $sms_api_type - 1;
//$api_type not used here
            } else {
                $guid = 00001;
            }

            $cdatet = date('Y-m-d H:i:s');
            if ($type == 1) {
                $sql = "INSERT INTO `tbl_sms_dataTemp`(`cust_id`,`oid`, `sms_id`, `date_time`, `attempt`,`massage`, `phone`,`type`,`contact_type`,`AutoSent`)
                        VALUES ('$cust_id','$oid','$guid','$cdatet','1','$SMSmessege','$SMSphone','$SType','$contactType','1')";

                if (help::execute($sql)) {
                    return 1;
                } else {
                    return 0;
                }
            } else if ($type == 2) {
                $attempt = $attempt + 1;
                $sql = "UPDATE `tbl_sms_dataTemp` SET `cust_id`='$cust_id', `sms_id`='$sms_id', `date_time`='$cdatet', `attempt`='$attempt',`massage`='$SMSmessege',`phone`='$SMSphone' WHERE oid=$oid and type=2";
                if (help::execute($sql)) {
                    return 1;
                } else {
                    return 0;
                }
            }
        } else {
            echo '<br>-----------------------------------------<br><span style="color:red">SMS disabled</span><br><br>-----------------------------------------<br>';
        }
    }

    public function CreateMessage($oid) {
        $currentDay = date('2014-09-09');
        $sql = "SELECT o.id,o.cust_id,o.expected_arrival,o.payment_type,o.present_total,o.AutoContact,j.name,j.phone_no,j.train_no,j.train_name,j.coach_no,j.seat_no,s.station_name,r.rest_name,r.contact_name1,r.contact_no1,r.contact_name2,r.contact_no2
                FROM tbl_order_table o
                INNER JOIN tbl_restaurant r ON r.id=o.res_id
                INNER JOIN tbl_stations s ON s.id=o.station
                INNER JOIN tbl_journey j ON j.cust_id=o.cust_id
                WHERE o.id='$oid'";
        $data = help::read($sql);

        if ($data != NULL) {
            if ($data['AutoContact'] == 1) {
                $resPhone = $data['contact_no1'];
                $contact_name1 = $data['contact_name1'];
            } else if ($data['AutoContact'] == 2) {
                $resPhone = $data['contact_no2'];
                $contact_name1 = $data['contact_name2'];
            } else {
                echo 'error';
                die;
            }

            $dt = explode(' ', $data['expected_arrival']);
            $train_name = $data['train_name'];
            $train_no = $data['train_no'];
            $station_name = $data['station_name'];
            $Deldate = $dt[0];
            $DelTime = $dt[1];
            $oid = $data['id'];
            $name = $data['name'];
            $phone_no = $data['phone_no'];
            $coach = $data['coach_no'];
            $seat = $data['seat_no'];
            $total = $data['present_total'];
            $sql = "SELECT `item_name`,`item_price`,`item_quantity` FROM `tbl_order_table2` WHERE `order_id`=$data[id]";
            $menu = help::readAll($sql);
            $message = "Dear $contact_name1 Order Details from YatraChef.$train_name, $train_no at $station_name on $Deldate at STA $DelTime Order ID $oid,Customer: $name, $phone_no,$coach/$seat, Order :";
            foreach ($menu as $menus) {
                $message .= $menus['item_name'] . '-' . $menus['item_quantity'] . ',';
            }
            $message .= "Amount to be collected :$total.If you have any queries please contact me on 8089090020.";

            if ($data['payment_type'] == 'Online_Payment') {
                $sql = "SELECT transaction_status FROM tbl_payment WHERE cust_id=$data[cust_id]";
                $tstatus = help::getScalar($sql);
            } else if ($data['payment_type'] == 'cod') {

                $resPhone = str_replace(" ", "", $resPhone);
                $resPhone . '<br>';
            }
//            $message='TEST SMS Dear'.$contact_name1;
            $params = array('message' => $message, 'phone' => $resPhone);
            return $params;
        } else {
            $params = array('message' => 0, 'phone' => 0);
            return $params;
        }
    }

    public function ConvertMinutes($x, $y) {
        $time1 = strtotime($x);
        $time2 = strtotime($y);
        $diff1 = $time2 - $time1;

//        echo 'Time 1: ' . date('H:i:s', $time1) . '<br>';
//        echo 'Time 2: ' . date('H:i:s', $time2) . '<br>';
//        echo $diff1 . '<br>';
        return $minutes = ($diff1 / (60));
    }

    public function actionTempAutoMessage() {

        $currentDay = date('2014-09-09');
        $sql = "SELECT o.id,o.cust_id,o.expected_arrival,o.payment_type,o.present_total,j.name,j.phone_no,j.train_no,j.train_name,j.coach_no,j.seat_no,s.station_name,r.rest_name,r.contact_name1,r.contact_no1
                FROM tbl_order_table o
                INNER JOIN tbl_restaurant r ON r.id=o.res_id
                INNER JOIN tbl_stations s ON s.id=o.station
                INNER JOIN tbl_journey j ON j.cust_id=o.cust_id
                WHERE DATE(o.expected_arrival)='$currentDay' AND o.train_status<>1";
        $data = help::readAll($sql);
        echo '<pre>';
        foreach ($data as $row) {
            $resPhone = $row['contact_no1'];
            $dt = explode(' ', $row['expected_arrival']);
            $sql = "SELECT `item_name`,`item_price`,`item_quantity` FROM `tbl_order_table2` WHERE `order_id`=$row[id]";
            $menu = help::readAll($sql);
            $message = "Dear $row[contact_name1] Order Details from YatraChef.$row[train_name], $row[train_no] at $row[station_name] on $dt[0] at STA $dt[1] Order ID $row[id],Customer: $row[name], $row[phone_no],$row[coach_no]/$row[seat_no], Order :";
            foreach ($menu as $menus) {
                $message .= $menus['item_name'] . '-' . $menus['item_quantity'] . ',';
            }
            $message .= "Amount to be collected :$row[present_total].If you have any queries please contact me on 8089090020.";
//echo $message . '<br><br>';
//.$row['payment_type'];
            if ($row['payment_type'] == 'Online_Payment') {
                $sql = "SELECT transaction_status FROM tbl_payment WHERE cust_id=$row[cust_id]";
                $tstatus = help::getScalar($sql);
//                echo '==>'.$resPhone.'<br>';
            } else if ($row['payment_type'] == 'cod') {
//                 echo $message.'<br>';
                $resPhone = str_replace(" ", "", $resPhone);
                echo $resPhone . '<br>';
            }
        }
    }

    public function actionGetSms_Report() {
        $status = array();
        $x = implode(',', $_POST);
//        $test = @$_POST['sMessageId'] . ',' . @$_POST['sMobileNo'];
//        $sql = "INSERT INTO `TEST`(`Error`,`header`) VALUES ('$test','$x')";
//        help::execute($sql);
//        if (help::execute($sql)) {
//            $status['status'] = 200;
//            $status['value'] = 'success';
//            echo json_encode($status);
//        } else {
//            $status['status'] = 201;
//            $status['value'] = 'sms id not received';
//            echo json_encode($status);
//        }
//        die;
        if (isset($_POST['sMessageId'])) {




//            mail('akhil.tm@yatrachef.com', 'sms report call', $x, 'akhil.tm@yatrachef.com', '-f akhiltm2@gmail.com');
            $post_sms_id = str_replace(' ', '', $_POST['sMessageId']);
            $sql = "SELECT sms_id,id FROM `tbl_sms_data` WHERE Api_Used='1' AND sms_id<>'0' AND success<>'1' AND sms_id LIKE '%$post_sms_id%'";
            $list = help::readAll($sql);
            if ($list != NULL) {
                foreach ($list as $row) {
                    $smsid = str_replace(' ', '', $row['sms_id']);
                    $cStatus = str_replace(' ', '', $_POST['sStatus']);
                    if ($cStatus == 'DELIVRD') {
                        $status = '1~' . $_POST['dtSubmit'] . '~' . $_POST['dtDone'] . '~0';
                        $success = 1;
                    } else if ($cStatus == 'UNDELIV') {
                        $status = '2~' . $_POST['dtSubmit'] . '~' . $_POST['dtDone'] . '~1';
                        $success = 2;
                    } else {
                        $status = '2~' . $_POST['dtSubmit'] . '~' . $_POST['dtDone'] . '~1';
                        $success = 3;
                    }

                    $updat = "UPDATE `tbl_sms_data` SET status='$status',success='$success' WHERE id='$row[id]'";
                    if (help::execute($updat)) {
                        $status['status'] = 200;
                        $status['value'] = 'success';
                        echo json_encode($status);
//                        $test = $_POST['sMobileNo'] . ',' . $post_sms_id . ',' . $row['id'];
//                        $sql = "INSERT INTO `TEST`(`Error`,`header`) VALUES ('$test','$_POST[dtDone]')";
//                        help::execute($sql);
                    }
                }
            } else {
                $status['status'] = 202;
                $status['value'] = 'sms id not matched with our database';
                echo json_encode($status);
            }
        } else {
            $status['status'] = 201;
            $status['value'] = 'sms id not received';
            echo json_encode($status);
        }
    }

    public function actionMsg() {
        $current_time = date('H:i');
        if ((strtotime($current_time) >= strtotime('05:00')) && (strtotime($current_time) <= strtotime('23:50'))) {
            
        } else {
            echo 'OFF';
            die;
        }
        echo '<pre>';
        $dtTem = date('Y-m-d');
        $sql = "SELECT * FROM `tbl_sms_data` WHERE sms_id<>0 AND success<>1 AND DATE(date_time)=CURDATE() AND (Api_Used='0' OR Api_Used='3')";
        $order = help::readAll($sql);
        if ($order != NULL) {
            foreach ($order as $row) {
                $api_type = $row['Api_Used'];
                if ($row['sms_id'] != '0') {
                    if ($row['success'] != '1') {
//check delivery and update status
                        $attempt = $row['attempt'];
                        $cust = $row['oid'];
                        $sid = $row['id'];
                        $x = $this->updateRS($row['sms_id'], $attempt, $cust, $sid, $api_type, $row['contact_type']);
                        echo 'update' . $cust . '<br>';
                        echo '(1)';
                    } else if ($row['success'] != '0') {

                        $exp = explode('~', $row['status']);
                        $exp = $exp[3];
                        if ($row['success'] == '1') {
                            die;
                        }
                        echo '(2)';
                        if (($row['success'] != '1') && ($exp == '1')) {
                            echo '(3)';
                            $attempt = $row['attempt'];
                            $attempt = $attempt + 1;
                            $cust = $row['oid'];
                            $x = $this->updateRS($row['sms_id'], $attempt, $cust, $sid, $api_type, $row['contact_type']);
                            if (($x != 'S') || ($x == '1')) {
                                echo '(4)';
//resend ,success failed
                                if (($attempt == 5) || ($attempt == 6)) {
                                    $id = str_replace(" ", "", $row['sms_id']);
                                    $msg = $row['massage'];
                                    @$phone = $row['phone'];
                                    $url = "http://sapteleservices.in/SMS_API/sendsms.php?username=yatra2&password=123456&mobile=" . $phone . "&sendername=YTCHEF&message=" . $msg . "&routetype=1";
                                    $url = preg_replace("/ /", "%20", $url);
//                                    $smsapi = file_get_contents($url);
//                                    $smsapi = explode('GUID:', $smsapi);
//                                    $guidr = $smsapi[1];
//                                    $guidr = explode(',', $guidr);
//                                    $guidr = $guidr[0];
//                                    $guid = 276+$attempt;
                                    mail('akhiltm2@gmail.com', 'resend initiated', '' . $guid . '=' . $attempt . '=' . $cust . '', 'akhiltm2@gmail.com', '-f akhiltm2@gmail.com');
                                    $guidr = rand(1, 2000);
                                    $guidr = str_replace(' ', '', $guidr);
                                    $sqlNew = "UPDATE `tbl_sms_data` SET `sms_id`='$row[sms_id]',`attempt`='$attempt',`resend_id`='$guidr' WHERE `id`=$sid AND oid=$cust";
                                    if (help::execute($sqlNew)) {
                                        echo 'resend' . $cust . ' sm ' . $guidr;
                                    } else {
                                        echo 'resend failed' . $cust . ' sm ' . $guidr;
                                    }
                                } else {
                                    echo 'failed' . $attempt;
                                }
                            } else {
                                echo 'else';
                            }
// $attempt = $attempt + 1;
                        }
                    } else {
                        echo 'nthg';
                    }
                } else {
                    echo 'nthng';
                }
            }
        } else {
            echo 'empty query';
        }
    }

    public function updateRS($guid = 0, $attempt = 0, $cust = 0, $sid = 0, $api_type = 0, $contact_type = 0) {
        $id = str_replace(" ", "", $guid);

//        $url = 'sapteleservices.in';
//        $http_code = 'http://';
//        $website_down = $this->is_website_down($url, $http_code);
//        if ($website_down) {
//            echo "Website is down!";
//            die;
//        }
        if ($api_type == 0) {
            $url = "http://sapteleservices.in/getdelivery/yatra2/123456/" . $id;
            $url_domain = 'sapteleservices.in';
        } elseif ($api_type == 3) {
            $url = "http://sapteleservices.com/getdelivery/yatra2/12345/" . $id;
            $url_domain = 'sapteleservices.com';
        } else {
            die;
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
        }


        $http_code = 'http://';
        $website_down = $this->is_website_down($url_domain, $http_code);
        if ($website_down) {
            echo "Website is down!";
            die;
        }

        $result = explode('~', $response);
//recheck again
        $result = explode('~', $response);
        $result[4] = strip_tags($result[4]);
        echo $result[5] = $result[2];
        if ((($result[5] == 1) || ($result[5] == 5)) && ($result[5] != '')) {
//        if (($result[5] == '1') || ($result[5] == '5')) {
            $status = 'S';
            $stat = 1;
        } else if ($result[5] == '') {
            $status = 2;
            $stat = 2;
        } else {
            $status = $result[5];
            $stat = 2;
        }

//        if ($stat == 1) {
//            $sql = "UPDATE tbl_order_table SET orderPassedRest=1 WHERE id=$cust";
//            if (help::execute($sql)) {
//                $this->VendorEmail($cust);
//                $msg = 'Enable Order passed to restaurants ,when sms is deliverd to the rest.';
//                $this->createtag($msg, $id = $cust, $type = 'Enable Order Passed to Restaurants,When SMS delivered to restaurants');
//            $msg = 'SMS delivered to vendor (contact ' . $contact_type . ')';
//            $this->createtag($msg, $id = $cust, $type = 'SMS delivered ');
//            }
//        }
        $updateMsg = $result[2] . '~' . $result[3] . '~' . $result[4] . '~' . $result[5];
        $sql = "UPDATE `tbl_sms_data` SET `success`='$stat' ,`status`= '$updateMsg',`attempt`='$attempt' WHERE `oid`=$cust AND id=$sid";


        if (help::execute($sql)) {
            if ($stat == 1) {
                $msg = 'SMS delivered to vendor (contact ' . $contact_type . ')';
                $this->createtag($msg, $id = $cust, $type = 'SMS delivered ');
            }
            return $status;
        } else {
            return $status;
        }
    }

    public function VendorEmail($id) {
        $sql = "SELECT o.vendor_op_mail,r.ry_is_preferred_vendor,j.coach_no,j.seat_no,j.name,j.train_no,j.phone_no,j.phone_no2,j.train_name,o.hotel_total,o.tax,o.discounted,o.delivery_charge,o.adjusted,o.present_total,o.id,o.res_id,o.ordering_time,o.expected_arrival,o.cust_id,o.payment_type,s.station_name,r.rest_name,r.contact_name1,r.email as rmail FROM tbl_order_table o
                INNER JOIN tbl_journey j ON j.cust_id=o.cust_id
                INNER JOIN tbl_restaurant r ON r.id=o.res_id
                INNER JOIN tbl_stations s ON s.id=o.station
                WHERE o.id=$id";
        $data = help::read($sql);
        if ($data['vendor_op_mail'] != 1) {
            $sql = "SELECT `item_name`,`item_price`,`item_quantity` FROM `tbl_order_table2` WHERE `order_id`=$data[id]";
            $menu = help::readAll($sql);
            //echo $content;
            $email = $data['rmail'];
            $subject = 'New order request #' . $data['id'];
            $to = $email;
//            $to = "akhil.tm@yatrachef.com";
            $mail = 1;
            $msg = 'Invoice sent to vendor(' . $email . ') by System';
            $this->createtag($msg, $id, $type = 'Invoice email sent vendor');
            help::execute("UPDATE tbl_order_table SET vendor_op_mail='1' WHERE id='$id'");
            if ($data['ry_is_preferred_vendor'] == 1) {
                $res_id = $data['res_id'];
                $response = file_get_contents("http://api.railyatri.in/ecomm/notification/vendor/pass-to-rest.json?vendor_id=$res_id&order_id=$id");
                $this->createtag($msg = 'Send Vendor app nottification.', $id, $type = 'Sending RY Vendor app nottification.');
            }
//        $this->createtag($msg, $id, $event = 'Invoice email sent vendor (Auto)', $data['res_id']);
            $this->layout = 'none';
            $this->render('vendor_invoice', array('data' => $data, 'items' => $menu, 'remail' => $to, 'subject' => $subject, 'mail' => $mail));
        }
    }

    public static function createtag($msg, $id, $type = 0) {
        $cdate = date('Y-m-d H:i:s');
        $sql = "INSERT into tbl_tagging(message,tagged_from,tagged_by,category,events,event_time,type,order_id)
                VALUES('$msg','-2','-2','5','$type','$cdate','1','$id')";
        if (help::execute($sql)) {
            return 1;
        } else {
            return 0;
        }
    }

    public function createtag2($msg, $id, $type = 0, $category = 0, $thread_type = 1) { //add feild in tbl_tagging,and comment in category
        $loginType = 0;
        $loginId = 0;
        $cdate = date('Y-m-d H:i:s');
        $type = str_replace("'", "=!>", $type);
        $sql = "INSERT into tbl_tagging(message,tagged_from,tagged_by,category,events,event_time,type,ticket_id,thread_type)
                VALUES('$msg','$loginType','$loginId','$category','$type','$cdate','1','$id','$thread_type')";
        if (help::execute($sql)) {
            return 1;
        } else {
            return 0;
        }
    }

    public function actionhtmltopdf($link = 0) {

        $content = "
        <page>
            <h1>Exemple d'utilisation</h1>
            <br>
            Ceci est un <b>exemple d'utilisation</b>
            de <a href='http://html2pdf.fr/'>HTML2PDF</a>.<br>
        </page>";

        require_once(dirname(dirname(__FILE__)) . '/../assets/html2pdf/html2pdf.class.php');

        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        $html2pdf->WriteHTML($content);
        $html2pdf->Output('exemple.pdf');
    }

    public function actionMenuUpload() {
        $this->redirect(array('url/menuInput'));
        echo "Menu upload has been temporarily disabled";
        die;
        if ($_FILES != NULL) {
            $ms = 0;
//          $allowedExts = array("gif", "jpeg", "jpg", "png","csv");
            $allowedExts = array('application/vnd.ms-excel', 'text/plain', 'text/csv', 'text/tsv');
            $temp = explode(".", $_FILES["file"]["name"]);
            $extension = end($temp);
            $path = dirname(dirname(__FILE__)) . '/../assets/AddMenu/';
            if ((isset($_POST['hotelid'])) && (isset($_FILES["file"]["name"]))) {
//            if ((($_FILES["file"]["type"] == "text/csv") || ($_FILES["file"]["type"] == "text/plain") || ($_FILES["file"]["type"] == "application/vnd.ms-excel")) && ($_FILES["file"]["size"] < 20000) && in_array($extension, $allowedExts)) {
                if ($_FILES["file"]["error"] > 0) {
                    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
                } else {
//                    echo "Upload: " . $_FILES["file"]["name"] . "<br>";
//                    echo "Type: " . $_FILES["file"]["type"] . "<br>";
//                    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
//                    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
                    unlink($path . $_FILES["file"]["name"]);
                    if (file_exists($path . $_FILES["file"]["name"])) {
                        $ms = $_FILES["file"]["name"] . " already exists. ";
                        $this->redirect($this->createUrl('/url/MenuUpload?error=' . $ms));
                    } else {
                        move_uploaded_file($_FILES["file"]["tmp_name"], $path . $_FILES["file"]["name"]);
                        $ms = "Saved " . $_FILES["file"]["name"];
                        $x = $this->AddMenu($res_id = $_POST['hotelid'], $fileName = $_FILES["file"]["name"]);

//                        $x=1;
//                        if ($x == 1) {
//                            $this->redirect($this->createUrl('/url/MenuUpload?msg=Menu Uploaded&error=' . $ms));
//                        } else {
//                            $this->redirect($this->createUrl('/url/MenuUpload?msg=Menu Uploading failed'));
//                        }
                    }
                }
//            } else {
//                echo "Invalid file";
//            }
            }
        }
        $sql = "SELECT id, rest_name FROM  `tbl_restaurant` order by id desc ";
        $hotel = help::readAll($sql);
        $this->layout = 'homePage';
        if (isset($x)) {
            $this->render('upload', array('hlist' => $hotel, 'summary' => $x));
        } else {
            $this->render('upload', array('hlist' => $hotel));
        }
    }

    public function actionmenuUpload_Spl() {

//        echo "Menu upload has been temporarily disabled";die;

        if ($_FILES != NULL) {
            $ms = 0;
//          $allowedExts = array("gif", "jpeg", "jpg", "png","csv");
            $allowedExts = array('application/vnd.ms-excel', 'text/plain', 'text/csv', 'text/tsv');
            $temp = explode(".", $_FILES["file"]["name"]);
            $extension = end($temp);
            $path = dirname(dirname(__FILE__)) . '/../assets/AddMenu/';
            if ((isset($_POST['hotelid'])) && (isset($_FILES["file"]["name"]))) {
//            if ((($_FILES["file"]["type"] == "text/csv") || ($_FILES["file"]["type"] == "text/plain") || ($_FILES["file"]["type"] == "application/vnd.ms-excel")) && ($_FILES["file"]["size"] < 20000) && in_array($extension, $allowedExts)) {
                if ($_FILES["file"]["error"] > 0) {
                    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
                } else {
//                    echo "Upload: " . $_FILES["file"]["name"] . "<br>";
//                    echo "Type: " . $_FILES["file"]["type"] . "<br>";
//                    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
//                    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
                    unlink($path . $_FILES["file"]["name"]);
                    if (file_exists($path . $_FILES["file"]["name"])) {
                        $ms = $_FILES["file"]["name"] . " already exists. ";
                        $this->redirect($this->createUrl('/url/menuUpload_Spl?error=' . $ms));
                    } else {
                        move_uploaded_file($_FILES["file"]["tmp_name"], $path . $_FILES["file"]["name"]);
                        $ms = "Saved " . $_FILES["file"]["name"];
                        $x = $this->AddMenu_Spl($res_id = $_POST['hotelid'], $fileName = $_FILES["file"]["name"]);

//                        $x=1;
//                        if ($x == 1) {
//                            $this->redirect($this->createUrl('/url/MenuUpload?msg=Menu Uploaded&error=' . $ms));
//                        } else {
//                            $this->redirect($this->createUrl('/url/MenuUpload?msg=Menu Uploading failed'));
//                        }
                    }
                }
//            } else {
//                echo "Invalid file";
//            }
            }
        }
        $sql = "SELECT id, rest_name FROM  `tbl_restaurant` order by id desc ";
        $hotel = help::readAll($sql);

        $this->layout = 'homePage';
        if (isset($x)) {

            $login_name = $_SESSION['sesname'];
            $loginid = $_SESSION['sesid'];
            $now = date('Y-m-d H:i:s');

            $hid = $_POST['hotelid'];
            $sql = "SELECT `rest_name` FROM `tbl_restaurant` WHERE `id`='$hid'";
            $rest_name = help::getScalar($sql);
            $rest_name = $rest_name . '(' . $hid . ')';

            $sql = "INSERT INTO `tbl_activities`(`emp_id`, `emp_name`, `date_time`, `title`, `message`) VALUES ('$loginid','$login_name','$now','Menu Uploaded','Menu uploaded for restaurant $rest_name')";
            help::execute($sql);

            $this->render('upload_spl', array('hlist' => $hotel, 'summary' => $x));
        } else {
            $this->render('upload_spl', array('hlist' => $hotel));
        }
    }

    public function AddMenu_Spl($res_id = 0, $fileName = 0) {

        $sql = "SELECT client_id,vendor_gst,`revenue` FROM tbl_restaurant WHERE id=$res_id";
        $r = help::read($sql);

        $client = $r['client_id'];
        $product_margin = $r['revenue'];
        $vendor_gst = $r['vendor_gst'];
        $yc_gst = 18;


        $category = "23,24,29,40,20,10,39,21,0,41,15,36";
        $sql6 = "UPDATE `tbl_restaurant` SET `categories`='$category' where `id`=$res_id";
        help::execute($sql6);

//      $path = Yii::getPathOfAlias('webroot') . '/tbl_menu.csv';
        $path = dirname(dirname(__FILE__)) . '/../assets/AddMenu/' . $fileName;

        if (file_exists($path)) {
            $csvFile = $path;
            $csv = $this->actionTest($csvFile);
            array_shift($csv);

            $count = count($csv);
            $data = array();
            $arr = array();
            for ($i = 0; $i < $count; $i++) {

                $client_id = @$client;
                $item_name = @$csv[$i][1];
                $menu_price = @$csv[$i][4];
                $rest_tray_price = @$csv[$i][5];
                $ycmarkup = @$csv[$i][6];
                $item_image_url = @$csv[$i][7];
                $content = @$csv[$i][2];
                $description = @$csv[$i][3];
                $type = @$csv[$i][8];
                $category = @$csv[$i][9];
                $breakfast = @$csv[$i][10];
                $lunch = @$csv[$i][11];
                $dinner = @$csv[$i][12];
                $addons = @$csv[$i][13];
                $ry_category = @$csv[$i][14];
                $display = @$csv[$i][15];
                $home_page_image = @$csv[$i][16];



                if ($item_name != '') {

                    if ($ry_category == '') {
                        echo 'Check menu upoad format';
                        die;
                    }

                    $special = 0;
                    $RY_avl = 1;
                    $status = 1;
                    $parcel = 0;
                    $qty = 1;

                    $sql14 = "SELECT `id` FROM `tbl_merchandise` WHERE `category`=5";
                    $merch_id = help::getScalar($sql14);

                    $jaket_id = $merch_id;
                    $freebie_id = $merch_id;
                    $mealkit_id = $merch_id;
                    $yctray_id = $merch_id;

//                $menu_price=$menu_price-($menu_price*($vendor_gst/100));
                    $pm_amount = ($menu_price) * ($product_margin / 100);
                    $vendor_gst_amt = ($menu_price - $pm_amount) * ($vendor_gst / 100);
                    $yc_gst_amt = $ycmarkup * ($yc_gst / 100);
                    $price = ($menu_price - $pm_amount); //cost price;

                    $company_margin = $ycmarkup;
                    $price_cart = $price + $company_margin + $yc_gst_amt + $vendor_gst_amt;
                    $price_cart_temp = $price_cart;
                    $price_cart = ceil($price_cart);
                    $yc_round_off_amt = $price_cart - $price_cart_temp;

                    //calc before GST
                    //
//                $pm_amount = ($menu_price - $rest_tray_price) * ($product_margin / 100);
//                $service_tax_amt = ($menu_price - $rest_tray_price - $pm_amount) * ($service_tax / 100);
//                $vat_amt = ($menu_price - $rest_tray_price - $pm_amount) * ($vat / 100);
//                $price = ($menu_price - $rest_tray_price - $pm_amount) + ($service_tax_amt + $vat_amt); //cost priceecho '<br>';
//
//                $company_margin = $jacket_price + $freebie_price + $mealkit_price + $yctray_price + $ycmarkup;
//                $price_cart = $price + $company_margin + $parcel;
//                $price_cart_temp = $price_cart;
//                $price_cart = ceil($price_cart);
//                $yc_round_off_amt = $price_cart - $price_cart_temp;

                    $jacket_price = 0;
                    $freebie_price = 0;
                    $mealkit_price = 0;
                    $yctray_price = 0;


                    $sql5 = "INSERT INTO `tbl_menu`( `res_id`, `client_id`, `item_name`, `item_name_user`, `breakfast`, `lunch`, `dinner`, `special_item`, `price`,
                    `menu_price`, `price_cart`, `rest_tray_price`, `vendor_gst_amount`, `yc_gst_amount`, `tray_id`, `jacket_id`, `meal_kit_id`, `freebie_id`,
                    `yc_markup`,`yc_round_off_amt`,`product_margin`, `company_margin`, `parcel_charge`, `quantity`, `type`, `category`, `description`, `status`,`content`,`item_image_url`,`railyatri_availability`,`addons`, `ry_category`, `display`, `home_page_image`)
                    VALUES ('$res_id','$client_id','$item_name','','$breakfast','$lunch','$dinner','$special','$price',
                    '$menu_price','$price_cart','$rest_tray_price','$vendor_gst_amt','$yc_gst_amt','$yctray_id','$jaket_id','$mealkit_id','$freebie_id',
                    '$ycmarkup','$yc_round_off_amt','$product_margin','$company_margin','$parcel','$qty','$type','$category','$description','$status',"
                            . "'$content','$item_image_url','$RY_avl','$addons','$ry_category','$display','$home_page_image')";


                    if (help::execute($sql5)) {
                        //                    echo 'success-' . $item_name . '<br>';
                        $arr[] = $item_name . '----success';
                        $true = 1;
                    } else {
                        //                    echo 'Failed-' . $item_name . '<br>';
                        $arr[] = $item_name . '----FAILED';
                        $true = 0;
                    }
                }
            }
            return $arr;
//            return $true;
        }
    }

    public function actionmenuUpload_Spl_update() {

        if ($_FILES != NULL) {
            $ms = 0;
//          $allowedExts = array("gif", "jpeg", "jpg", "png","csv");
            $allowedExts = array('application/vnd.ms-excel', 'text/plain', 'text/csv', 'text/tsv');
            $temp = explode(".", $_FILES["file"]["name"]);
            $extension = end($temp);
            $path = dirname(dirname(__FILE__)) . '/../assets/AddMenu/';
            if ((isset($_POST['hotelid'])) && (isset($_FILES["file"]["name"]))) {
//            if ((($_FILES["file"]["type"] == "text/csv") || ($_FILES["file"]["type"] == "text/plain") || ($_FILES["file"]["type"] == "application/vnd.ms-excel")) && ($_FILES["file"]["size"] < 20000) && in_array($extension, $allowedExts)) {
                if ($_FILES["file"]["error"] > 0) {
                    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
                } else {
//                    echo "Upload: " . $_FILES["file"]["name"] . "<br>";
//                    echo "Type: " . $_FILES["file"]["type"] . "<br>";
//                    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
//                    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
                    unlink($path . $_FILES["file"]["name"]);
                    if (file_exists($path . $_FILES["file"]["name"])) {
                        $ms = $_FILES["file"]["name"] . " already exists. ";
                        $this->redirect($this->createUrl('/url/menuUpload_Spl_update?error=' . $ms));
                    } else {
                        move_uploaded_file($_FILES["file"]["tmp_name"], $path . $_FILES["file"]["name"]);
                        $ms = "Saved " . $_FILES["file"]["name"];
                        $x = $this->AddMenu_Spl_update($res_id = $_POST['hotelid'], $fileName = $_FILES["file"]["name"]);

//                        $x=1;
//                        if ($x == 1) {
//                            $this->redirect($this->createUrl('/url/MenuUpload?msg=Menu Uploaded&error=' . $ms));
//                        } else {
//                            $this->redirect($this->createUrl('/url/MenuUpload?msg=Menu Uploading failed'));
//                        }
                    }
                }
//            } else {
//                echo "Invalid file";
//            }
            }
        }
        $sql = "SELECT id, rest_name FROM  `tbl_restaurant` order by id desc ";
        $hotel = help::readAll($sql);
        $this->layout = 'homePage';
        if (isset($x)) {
            $this->render('upload_spl_update', array('hlist' => $hotel, 'summary' => $x));
        } else {
            $this->render('upload_spl_update', array('hlist' => $hotel));
        }
    }

    public function AddMenu_Spl_update($res_id = 0, $fileName = 0) {

        $sql = "SELECT client_id,rest_service_tax,rest_vat,`revenue` FROM tbl_restaurant WHERE id=$res_id";
        $r = help::read($sql);
        $client = $r['client_id'];
        $service_tax = $r['rest_service_tax'];
        $vat = $r['rest_vat'];
        $product_margin = $r['revenue'];

        $category = "23,24,29,40,20,10,39,21,0,41,15,36";
        $sql6 = "UPDATE `tbl_restaurant` SET `categories`='$category' where `id`=$res_id";
        help::execute($sql6);


//      $path = Yii::getPathOfAlias('webroot') . '/tbl_menu.csv';
        $path = dirname(dirname(__FILE__)) . '/../assets/AddMenu/' . $fileName;
        if (file_exists($path)) {
            $csvFile = $path;
            $csv = $this->actionTest($csvFile);
            array_shift($csv);

            $count = count($csv);
            $data = array();
            $arr = array();
            for ($i = 0; $i < $count; $i++) {

                $client_id = @$client;
                $item_name = @$csv[$i][1];
                $menu_price = @$csv[$i][4];
                $rest_tray_price = @$csv[$i][5];
                $ycmarkup = @$csv[$i][6];
                $item_image_url = @$csv[$i][7];
                $content = @$csv[$i][2];
                $description = @$csv[$i][3];
                $type = @$csv[$i][8];
                $category = @$csv[$i][9];
                $breakfast = @$csv[$i][10];
                $lunch = @$csv[$i][11];
                $dinner = @$csv[$i][12];
                $addons = @$csv[$i][13];


                if ($item_name != '') {


                    $special = 0;
                    $RY_avl = 1;
                    $status = 1;
                    $parcel = 0;
                    $qty = 1;

                    $sql14 = "SELECT `id` FROM `tbl_merchandise` WHERE `category`=5";
                    $merch_id = help::getScalar($sql14);

                    $jaket_id = $merch_id;
                    $freebie_id = $merch_id;
                    $mealkit_id = $merch_id;
                    $yctray_id = $merch_id;

                    $pm_amount = ($menu_price - $rest_tray_price) * ($product_margin / 100);
                    $service_tax_amt = ($menu_price - $rest_tray_price - $pm_amount) * ($service_tax / 100);
                    $vat_amt = ($menu_price - $rest_tray_price - $pm_amount) * ($vat / 100);
                    $price = ($menu_price - $rest_tray_price - $pm_amount) + ($service_tax_amt + $vat_amt); //cost priceecho '<br>';


                    $jacket_price = 0;
                    $freebie_price = 0;
                    $mealkit_price = 0;
                    $yctray_price = 0;

                    $company_margin = $jacket_price + $freebie_price + $mealkit_price + $yctray_price + $ycmarkup;
                    $price_cart = $price + $company_margin + $parcel;
                    $price_cart_temp = $price_cart;
                    $price_cart = ceil($price_cart);
                    $yc_round_off_amt = $price_cart - $price_cart_temp;

//
//                        $sql5 = "INSERT INTO `tbl_menu`( `res_id`, `client_id`, `item_name`, `item_name_user`, `breakfast`, `lunch`, `dinner`, `special_item`, `price`,
//                        `menu_price`, `price_cart`, `rest_tray_price`, `service_tax_amount`, `vat_amount`, `tray_id`, `jacket_id`, `meal_kit_id`, `freebie_id`,
//                        `yc_markup`,`yc_round_off_amt`,`product_margin`, `company_margin`, `parcel_charge`, `quantity`, `type`, `category`, `description`, `status`,`content`,`item_image_url`,`railyatri_availability`,`addons`)
//                        VALUES ('$res_id','$client_id','$item_name','','$breakfast','$lunch','$dinner','$special','$price',
//                        '$menu_price','$price_cart','$rest_tray_price','$service_tax_amt','$vat_amt','$yctray_id','$jaket_id','$mealkit_id','$freebie_id',
//                        '$ycmarkup','$yc_round_off_amt','$product_margin','$company_margin','$parcel','$qty','$type','$category','$description','$status','$content','$item_image_url','$RY_avl','$addons')";

                    $sql5 = "UPDATE `tbl_menu` SET
                        `breakfast`='$breakfast',`lunch`='$lunch',`dinner`='$dinner',`special_item`='$special',
                        `price`='$price',`menu_price`='$menu_price',`price_cart`='$price_cart',`rest_tray_price`='$rest_tray_price',
                        `service_tax_amount`='$service_tax_amt',`vat_amount`='$vat_amt',`tray_id`='$yctray_id',`jacket_id`='$jaket_id',
                        `meal_kit_id`='$mealkit_id',`freebie_id`='$freebie_id',`yc_markup`='$ycmarkup',`yc_round_off_amt`='$yc_round_off_amt',
                        `product_margin`='$product_margin',`company_margin`='$company_margin',`parcel_charge`='$parcel',`quantity`='$qty',
                        `type`='$type',`category`='$category',`content`='$content',`description`='$description',
                        `item_image_url`='$item_image_url',`addons`='$addons' WHERE item_name like '$item_name' and res_id='$res_id' and railyatri_availability=1 ";

                    if (help::execute($sql5)) {
//                    echo 'success-' . $item_name . '<br>';
                        $arr[] = $item_name . '----success';
                        $true = 1;
                    } else {
//                    echo 'Failed-' . $item_name . '<br>';
                        $arr[] = $item_name . '----FAILED';
                        $true = 0;
                    }
                }
            }
            return $arr;
//            return $true;
        }
    }

    public function actionView() {
        if (isset($_POST['ok'])) {
//             echo '<pre>';
            $hid = $_POST['Hid'];
            $sql = "SELECT * FROM tbl_menu WHERE res_id=$hid";
            $data = help::readAll($sql);
            if ($data != NULL) {

//                print_r($data);
            } else {
                $data = '';
            }
        }
        $sql = "SELECT id, rest_name FROM  `tbl_restaurant` ";
        $hotel = help::readAll($sql);
        $this->layout = 'homePage';
        $this->render('view', array('data' => @$data, 'hlist' => $hotel));
    }

    public function actionadd_markup() {
        if (isset($_POST['ok'])) {
//             echo '<pre>';
            $hid = $_POST['Hid'];
            $sql = "SELECT * FROM tbl_menu WHERE res_id=$hid";
            $data = help::readAll($sql);
            if ($data != NULL) {

//                print_r($data);
            } else {
                $data = '';
            }
        }
        $sql = "SELECT id, rest_name FROM  `tbl_restaurant` ";
        $hotel = help::readAll($sql);
        $this->layout = 'homePage';
        $this->render('markup', array('data' => @$data, 'hlist' => $hotel));
    }

    public function actionMenuInput($hid = 0) {

        if (isset($_POST['ok'])) {

//            echo '<pre>';
//            print_r($_POST);
//            die;

            $hid = $_POST['Hid'];
            $count = $_POST['totalno'];
            $sql = "SELECT client_id,vendor_gst FROM tbl_restaurant WHERE id=$hid";
            $menu_cat_db = $_POST['categories'];
            $menu_categories = explode(',', $menu_cat_db);

            $r1 = help::read($sql);
            $client = $r1['client_id'];
            $vendor_gst = $r1['vendor_gst'];
            $yc_gst = 18;
            for ($i = 1; $i <= $count; $i++) {

                $item_name = $_POST['Name_' . $i];
                $item_name_user = $_POST['User_' . $i];
                $breakfast = $_POST['B_' . $i];
                $lunch = $_POST['L_' . $i];
                $dinner = $_POST['D_' . $i];
                $special = $_POST['S_' . $i];
                $RY_avl = $_POST['RY_' . $i];
                $product_margin = $_POST['PM_' . $i]; //PR MARGIN J
                $parcel = $_POST['Parcel_' . $i]; //PARCEL CH L
                $qty = $_POST['Qty_' . $i]; //QTY M
                $type = $_POST['Type_' . $i]; //TYPE VEG N
                $category = $_POST['Category_' . $i]; //CAT O
                $description = $_POST['Desc_' . $i]; //DESC P
                $status = 1; //STATUS Q
                $menu_price = $_POST['MPrice_' . $i]; //menu price
                $rest_tray_price = $_POST['Rest_tray_Price_' . $i];
                $service_tax = $_POST['Tax_' . $i];
                $vat = $_POST['Vat_' . $i];
                $ycmarkup = $_POST['YCmarkup_' . $i];

//                $jaket_id = $_POST['Jacketid_' . $i];
//                $freebie_id = $_POST['Freebie_' . $i];
//                $mealkit_id = $_POST['mealkit_' . $i];
//                $yctray_id = $_POST['yctray_' . $i];


                if (in_array($category, $menu_categories)) {
                    
                } else {
                    $menu_cat_db = $menu_cat_db . '' . $category . ',';
                    $sql6 = "UPDATE `tbl_restaurant` SET `categories`='$menu_cat_db' where `id`='$hid'";
                    help::execute($sql6);
                }


                $pm_amount = ($menu_price) * ($product_margin / 100);
                $price = ($menu_price - $pm_amount);
                $vendor_gst_amt = $price * ($vendor_gst / 100);
                $yc_gst_amt = $ycmarkup * ($yc_gst / 100);

                //cost price;

                $company_margin = $ycmarkup;
                $price_cart = $price + $company_margin + $yc_gst_amt + $vendor_gst_amt;
                $price_cart_temp = $price_cart;
                $price_cart = ceil($price_cart);
                $yc_round_off_amt = $price_cart - $price_cart_temp;

//                $sql = "INSERT INTO `tbl_menu`( `res_id`, `client_id`, `item_name`, `item_name_user`, `breakfast`, `lunch`, `dinner`,
//                            `special_item`, `price`, `price_cart`, `product_margin`, `company_margin`, `parcel_charge`,
//                            `quantity`, `type`, `category`, `description`, `status`)
//                        VALUES('$hid','$client','$a2','$a3','$a4','$a5','$a6',
//                            '$a7','$a8','$price_cart','$a9','$a10','$a11',
//                            '$a12','$a13','$a14','$a15','$a16')";

                $sql5 = "INSERT INTO `tbl_menu`( `res_id`, `client_id`, `item_name`, `item_name_user`, `breakfast`, `lunch`, `dinner`, `special_item`, `price`,`vendor_gst_amount`,`yc_gst_amount`,
                `menu_price`, `price_cart`, `rest_tray_price`, `service_tax_amount`, `vat_amount`, `tray_id`, `jacket_id`, `meal_kit_id`, `freebie_id`,
                `yc_markup`,`yc_round_off_amt`,`product_margin`, `company_margin`, `parcel_charge`, `quantity`, `type`, `category`, `description`, `status`,`railyatri_availability`)
                VALUES ('$hid','$client','$item_name','$item_name_user','$breakfast','$lunch','$dinner','$special','$price','$vendor_gst_amt',$yc_gst_amt,
                '$menu_price','$price_cart','$rest_tray_price','0','0','0','0','0','0',
                '$ycmarkup','$yc_round_off_amt','$product_margin','$company_margin','$parcel','$qty','$type','$category','$description','$status','$RY_avl')";

                if (help::execute($sql5)) {
                    echo 'success-' . $i . '<br>';
                    $true = 1;
                } else {
                    echo 'Failed-' . $i . '<br>';
                    $true = 0;
                }
            }
        }
        if ($hid != 0) {

            $sql = "SELECT r.rest_name,r.revenue,r.rest_service_tax,r.rest_vat,r.break_start,r.break_end,r.lunch_start,r.lunch_end,r.dinner_start,r.dinner_end,r.categories,s.station_name
            FROM tbl_restaurant r 
            inner join tbl_stations s
            on r.station_id=s.id
            WHERE r.id='$hid'";
            $rest = help::read($sql);

            $sql = "SELECT * FROM `tbl_menu_categories`";
            $cat = help::readAll($sql);
        }
        $sql = "SELECT id, rest_name FROM  `tbl_restaurant` ";
        $hotel = help::readAll($sql);

        $this->layout = 'homePage';
        $this->render('Enter', array('cat' => @$cat, 'hlist' => $hotel, 'rest' => @$rest));
    }

    public function AddMenu($res_id = 0, $fileName = 0) {
        $sql = "SELECT client_id,rest_service_tax,rest_vat,revenue as product_margin  FROM tbl_restaurant WHERE id=$res_id";
        $r = help::read($sql);
        $client = $r['client_id'];
        $service_tax = $r['rest_service_tax'];
        $vat = $r['rest_vat'];
        $product_margin = $r['product_margin'];

        $category = "10,11,14,15,17,18,19,20,21,23,24,29,31,32,33,34,36,38,39,40,41,42,43,44,45,46,48,49,50,52,54,55,56";

        $sql6 = "UPDATE `tbl_restaurant` SET `categories`='$category' where `id`=$res_id";
        help::execute($sql6);

//        $path = Yii::getPathOfAlias('webroot') . '/tbl_menu.csv';
        $path = dirname(dirname(__FILE__)) . '/../assets/AddMenu/' . $fileName;
        if (file_exists($path)) {
            $csvFile = $path;
            $csv = $this->actionTest($csvFile);
            array_shift($csv);
            $count = count($csv);
            $data = array();
            $arr = array();
            for ($i = 0; $i < $count; $i++) {

                $res_id = @$res_id;
                $client_id = @$client;

                $item_name = @$csv[$i][0];
                $menu_price = @$csv[$i][1];
                $ycmarkup = @$csv[$i][2];
                $parcel = 0;
                $type = @$csv[$i][3];
                $category = @$csv[$i][4];
                $description = @$csv[$i][5];
                $breakfast = @$csv[$i][6];
                $lunch = @$csv[$i][7];
                $dinner = @$csv[$i][8];
                $special = 0;
                $RY_avl = 0;
                $rest_tray_price = 0;
                $qty = 1;
                $status = 1;
                $jaket_id = 0;
                $freebie_id = 0;
                $mealkit_id = 0;
                $yctray_id = 0;


                $pm_amount = ($menu_price - $rest_tray_price) * ($product_margin / 100);
                $service_tax_amt = ($menu_price - $rest_tray_price - $pm_amount) * ($service_tax / 100);
                $vat_amt = ($menu_price - $rest_tray_price - $pm_amount) * ($vat / 100);
                $price = ($menu_price - $rest_tray_price - $pm_amount) + ($service_tax_amt + $vat_amt); //cost priceecho '<br>';

                $sql = "SELECT `price` FROM `tbl_merchandise` WHERE `id`=$jaket_id";
                $sql2 = "SELECT `price` FROM `tbl_merchandise` WHERE `id`=$freebie_id";
                $sql3 = "SELECT `price` FROM `tbl_merchandise` WHERE `id`=$mealkit_id";
                $sql4 = "SELECT `price` FROM `tbl_merchandise` WHERE `id`=$yctray_id";

                $jacket_price = help::getScalar($sql);
                $freebie_price = help::getScalar($sql2);
                $mealkit_price = help::getScalar($sql3);
                $yctray_price = help::getScalar($sql4);

                $company_margin = $jacket_price + $freebie_price + $mealkit_price + $yctray_price + $ycmarkup;
                $price_cart = $price + $company_margin + $parcel;
                $price_cart_temp = $price_cart;
                $price_cart = ceil($price_cart);
                $yc_round_off_amt = $price_cart - $price_cart_temp;

                if ($item_name != '') {
                    $sql5 = "INSERT INTO `tbl_menu`( `res_id`, `client_id`, `item_name`, `item_name_user`, `breakfast`, `lunch`, `dinner`, `special_item`, `price`,
                `menu_price`, `price_cart`, `rest_tray_price`, `service_tax_amount`, `vat_amount`, `tray_id`, `jacket_id`, `meal_kit_id`, `freebie_id`,
                `yc_markup`,`yc_round_off_amt`,`product_margin`, `company_margin`, `parcel_charge`, `quantity`, `type`, `category`, `description`, `status`,`content`,`item_image_url`,`railyatri_availability`)
                VALUES ('$res_id','$client_id','$item_name','','$breakfast','$lunch','$dinner','$special','$price',
                '$menu_price','$price_cart','$rest_tray_price','$service_tax_amt','$vat_amt','$yctray_id','$jaket_id','$mealkit_id','$freebie_id',
                '$ycmarkup','$yc_round_off_amt','$product_margin','$company_margin','$parcel','$qty','$type','$category','$description','$status','','','$RY_avl')";


                    if (help::execute($sql5)) {
//                    echo 'success-' . $item_name . '<br>';
                        $arr[] = $item_name . '----success';
                        $true = 1;
                    } else {
//                    echo 'Failed-' . $item_name . '<br>';
                        $arr[] = $item_name . '----FAILED';
                        $true = 0;
                    }
                }
            }
            return $arr;
//            return $true;
        }
    }

    public function AddMenu_old_used_till_21_11_2016_($res_id = 0, $fileName = 0) {
        $sql = "SELECT client_id,rest_service_tax,rest_vat FROM tbl_restaurant WHERE id=$res_id";
        $r = help::read($sql);
        $client = $r['client_id'];

        $category = "23,24,29,40,20,10,39,21,0,41,15,36";

        $sql6 = "UPDATE `tbl_restaurant` SET `categories`='$category' where `id`=$res_id";
        help::execute($sql6);

//        $path = Yii::getPathOfAlias('webroot') . '/tbl_menu.csv';
        $path = dirname(dirname(__FILE__)) . '/../assets/AddMenu/' . $fileName;
        if (file_exists($path)) {
            $csvFile = $path;
            $csv = $this->actionTest($csvFile);
            array_shift($csv);
            $count = count($csv);
            $data = array();
            $arr = array();
            for ($i = 0; $i < $count; $i++) {

                $res_id = @$res_id;
                $client_id = @$client;
                $menu_id = @$csv[$i][0];
                $item_name = @$csv[$i][1];
                $menu_price = @$csv[$i][2];
                $rest_tray_price = @$csv[$i][3];
                $ycmarkup = @$csv[$i][4];

                if ($menu_id != '') {

                    $sql2 = "SELECT * FROM `tbl_menu` WHERE id=$menu_id";
                    $rslt = help::read($sql2);

                    $content = $rslt['content'];
                    $item_image_url = $rslt['item_image_url'];
                    $breakfast = $rslt['breakfast'];
                    $lunch = $rslt['lunch'];
                    $dinner = $rslt['dinner'];
                    $special = $rslt['special_item'];
                    $RY_avl = $rslt['railyatri_availability'];
                    $product_margin = $rslt['product_margin'];
                    $parcel = $rslt['parcel_charge'];
                    $qty = $rslt['quantity'];
                    $type = $rslt['type'];
                    $category = $rslt['category'];
                    $description = $rslt['description'];
                    $content = $rslt['content'];
                    $status = 1;
                    $jaket_id = $rslt['jacket_id'];
                    $freebie_id = $rslt['freebie_id'];
                    $mealkit_id = $rslt['meal_kit_id'];
                    $yctray_id = $rslt['tray_id'];
                    $service_tax = $r['rest_service_tax'];
                    $vat = $r['rest_vat'];




                    $pm_amount = ($menu_price - $rest_tray_price) * ($product_margin / 100);
                    $service_tax_amt = ($menu_price - $rest_tray_price - $pm_amount) * ($service_tax / 100);
                    $vat_amt = ($menu_price - $rest_tray_price - $pm_amount) * ($vat / 100);
                    $price = ($menu_price - $rest_tray_price - $pm_amount) + ($service_tax_amt + $vat_amt); //cost priceecho '<br>';

                    $sql = "SELECT `price` FROM `tbl_merchandise` WHERE `id`=$jaket_id";
                    $sql2 = "SELECT `price` FROM `tbl_merchandise` WHERE `id`=$freebie_id";
                    $sql3 = "SELECT `price` FROM `tbl_merchandise` WHERE `id`=$mealkit_id";
                    $sql4 = "SELECT `price` FROM `tbl_merchandise` WHERE `id`=$yctray_id";

                    $jacket_price = help::getScalar($sql);
                    $freebie_price = help::getScalar($sql2);
                    $mealkit_price = help::getScalar($sql3);
                    $yctray_price = help::getScalar($sql4);

                    $company_margin = $jacket_price + $freebie_price + $mealkit_price + $yctray_price + $ycmarkup;
                    $price_cart = $price + $company_margin + $parcel;
                    $price_cart_temp = $price_cart;
                    $price_cart = ceil($price_cart);
                    $yc_round_off_amt = $price_cart - $price_cart_temp;


                    $sql5 = "INSERT INTO `tbl_menu`( `res_id`, `client_id`, `item_name`, `item_name_user`, `breakfast`, `lunch`, `dinner`, `special_item`, `price`,
                `menu_price`, `price_cart`, `rest_tray_price`, `service_tax_amount`, `vat_amount`, `tray_id`, `jacket_id`, `meal_kit_id`, `freebie_id`,
                `yc_markup`,`yc_round_off_amt`,`product_margin`, `company_margin`, `parcel_charge`, `quantity`, `type`, `category`, `description`, `status`,`content`,`item_image_url`,`railyatri_availability`)
                VALUES ('$res_id','$client_id','$item_name','','$breakfast','$lunch','$dinner','$special','$price',
                '$menu_price','$price_cart','$rest_tray_price','$service_tax_amt','$vat_amt','$yctray_id','$jaket_id','$mealkit_id','$freebie_id',
                '$ycmarkup','$yc_round_off_amt','$product_margin','$company_margin','$parcel','$qty','$type','$category','$description','$status','$content','$item_image_url','$RY_avl')";


                    if (help::execute($sql5)) {
//                    echo 'success-' . $item_name . '<br>';
                        $arr[] = $item_name . '----success';
                        $true = 1;
                    } else {
//                    echo 'Failed-' . $item_name . '<br>';
                        $arr[] = $item_name . '----FAILED';
                        $true = 0;
                    }
                }
            }
            return $arr;
//            return $true;
        }
    }

    public function actionPnrCron() {
        $this->layout = 'none';
        $current_time = date('H:i');
        if ((strtotime($current_time) <= strtotime('04:00')) && (strtotime($current_time) >= strtotime('23:00'))) {
            echo 'LOCK TIME';
            die;
        }


//        $ch = curl_init();
//        $url = $this->createUrl('/url/PnrCronTemp');
//        $url = 'https://cc.yatrachef.com/' . $url;
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
////  curl_setopt($ch,CURLOPT_HEADER, false);
//        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 35000); //35000
//        $output = curl_exec($ch);
//
//        curl_close($ch);


        $url = 'https://cc.yatrachef.com/index.php/url/PnrCronTemp';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 35000);
        $data = curl_exec($ch);
        $curl_errno = curl_errno($ch);
        $curl_error = curl_error($ch);
        curl_close($ch);

        if ($curl_errno > 0) {
            echo "cURL Error ($curl_errno): $curl_error\n";
        } else {
            echo "Data received: $data\n";
            print_r($data);
        }

        $x = file_get_contents('https://cc.yatrachef.com/index.php/automated/CustomerVerification');
        die;
    }

    public function actionPnrCronTemp1() {//new but somproblem : NOT USING NOW
//        $sql = "SELECT o.id,j.coach_no,j.seat_no,j.cust_id,j.pnr,j.train_no,j.cust_id,o.real_day_time,o.expected_arrival,o.station
//            FROM tbl_journey j
//            INNER JOIN tbl_order_table o ON o.cust_id= j.cust_id
//            WHERE o.real_day_time<>0 AND o.order_status=1
//            AND pnr<>' ' AND PNR<>'NA' AND DATE(o.real_day_time)=CURDATE() AND (j.agent_seat_confirm IS NULL) ORDER BY DATE(o.expected_arrival) DESC LIMIT 30"; //OR DATE(real_day_time)=CURDATE() + INTERVAL 1 DAY
////        $sql = "call select_pnr_cron()";
//        $data = help::readAll($sql);
////        echo '<pre>';
////        print_r($data);die;
//        $path = dirname(dirname(__FILE__)) . '/../assets/scrap/Indianrail.php';
//        include($path);
//        $Indianrail = new Indianrail();
//        $bookstatus = array();
//        $currentstatus = array();
//        echo '<pre>';
//        foreach ($data as $row) {
//            $doj = explode(' ', $row['real_day_time']);
//            $pnr = $row['pnr'];
//            $cust_id = $row['cust_id'];
//            $stationId = $row['station'];
//            $seat = str_replace(' ', '', $row['seat_no']);
//            $coach = str_replace(' ', '', $row['coach_no']);
//            $doj = str_replace(' ', '', $doj[0]);
//            $train = str_replace(' ', '', $row['train_no']);
////    -------------------------------------
//            $sql = "SELECT station_code FROM tbl_stations WHERE id=$stationId";
//            $sCode = str_replace(' ', '', help::getscalar($sql));
//            $filter = $this->pnrfilter($pnr, $Indianrail);
////            print_r($filter);die;
//            if ($filter['status'] != 2) {
//                $FCoach = $filter['coach'][0];
//                $FSeat = $filter['seat'][0];
//                $FQuota = $filter['seat'][0];
//                $Fchart = $filter['chartPrepare'];
//                $FDoj = $filter['newdoj'];
//                $FBooking = $filter['booking'];
//                $FCurrent = $filter['current'];
//                $FStatus = $filter['status'];
//                $FTrain = $filter['train_no'];
////                $path = Yii::getPathOfAlias('webroot') . '/assets/train/trains_list/' . $train . '.csv';
//                $path = '/var/www/vhosts/train_scrap/trains_list/' . $train . '.csv';
//                if (file_exists($path)) {
//                    $csvFile = $path;
//                    $csv = $this->actionTest($csvFile);
//
//                    foreach ($csv as $tdata) {
//                        if (@$tdata[2] == $sCode) {
//
//                            $currntDate = $tdata[9];
//                            if ($currntDate == 1) {
////                        $tdate=$doj;
//                                $newjDate = $FDoj;
//                            } elseif ($currntDate == 2) {
////  echo $cookies_tdate;die;
////                        $tdate = date('d-m-Y', strtotime($doj . ' + 1 day'));
//                                $newjDate = date('Y-m-d', strtotime($FDoj . ' + 1 day'));
//                            } elseif ($currntDate == 3) {
////                        $tdate = date('d-m-Y', strtotime($doj . ' + 2 day'));
//                                $newjDate = date('Y-m-d', strtotime($FDoj . ' + 2 day'));
//                            } elseif ($currntDate == 4) {
////                        $tdate = date('d-m-Y', strtotime($doj . ' + 3 day'));
//                                $newjDate = date('Y-m-d', strtotime($FDoj . ' + 3 day'));
//                            } elseif ($currntDate == 5) {
////                        $tdate = date('d-m-Y', strtotime($doj . ' + 4 day'));
//                                $newjDate = date('Y-m-d', strtotime($FDoj . ' + 4 day'));
//                            }
//                        }
//                    }
//
////            echo 'true-->'.$doj.'--'.$newjDate;
//                } else {
//                    echo 'file error';
//                }
////                $FBooking=str_replace(',', '-', $FBooking);
////                $FCurrent=str_replace(',', '-', $FCurrent);
//                $today = date('Y-m-d H:i:s');
//                if (($seat != $FSeat) || ($coach != $FCoach) || ($doj != $FDoj) || ($train != $FTrain)) {
//                    $sql1 = "SELECT id,train_no,confirm FROM `tbl_pnr_data` WHERE cust_id='$cust_id'";
//                    $result = help::read($sql1);
//                    if ($result == NULL) {
//                        $sql = "INSERT INTO `tbl_pnr_data`( `cust_id`, `pnr`,`train_no`, `seat`, `coach`, `journey_date`, `booking_status`, `current_status`, `match`,`confirm`,`update_time`)
//                                VALUES ('$cust_id','$pnr','$FTrain','$FSeat','$FCoach','$newjDate','$FBooking','$FCurrent','1','$Fchart','$today')";
////                        $sql = "call insert_pnr_cron('$cust_id','$FTrain','$FSeat','$FCoach','$newjDate','$FBooking','$FCurrent','1','$Fchart','$pnr')";
//                        if (help::execute($sql)) {
//                            echo '1 Insertion ' . $cust_id . '<br>';
//                        } else {
//                            echo '1 Insertion Failed  ' . $cust_id . '<br>';
//                        }
//                    } else {
//                        if ($result['confirm'] == 'N') {
//                            $sql = "UPDATE  `tbl_pnr_data` SET `train_no`='$FTrain', `seat`='$FSeat', `coach`='$FCoach', `journey_date`='$newjDate', `booking_status`='$FBooking', `current_status`='$FCurrent', `match`=1,`confirm` =  '$Fchart',update_time='$today' WHERE  `id` =  '$result[id]' AND  `cust_id` =  '$cust_id'";
////                            $sql = "call update_pnr_cron('$FTrain','$FSeat','$FCoach','$newjDate','$FBooking','$FCurrent','1','$Fchart','$result[id]','$cust_id')";
//                            if (help::execute($sql)) {
//                                echo $cust_id . ' update chart(' . $result['id'] . ')<br>';
//                            } else {
//                                echo $cust_id . ' chart failed<br>';
//                            }
//                        } else {
//                            echo $cust_id . ' nthng to update<br>';
//                        }
//                    }
//                } else {
////                    $sql = "INSERT INTO `tbl_pnr_data`( `cust_id`,`pnr`, `train_no`, `seat`, `coach`, `journey_date`, `booking_status`, `current_status`, `match`,`confirm`)
////                            VALUES ('$cust_id','$pnr','$tnum','$newSeat','$newCoach','$newjDate','$bookstatus[0]','$currentstatus[0]','0','$chartPrepare')";
////                    $sql = "SELECT id FROM tbl_pnr_data WHERE cust_id='$cust_id' AND train_no='$tnum' AND seat='$newSeat' AND coach='$newCoach' AND journey_date='$newjDate' AND booking_status=$bookstatus[0] AND current_status=$currentstatus[0] AND match='0' AND confirm='$chartPrepare'";
//                    $sql = "SELECT id FROM tbl_pnr_data WHERE cust_id='$cust_id' AND train_no='$FTrain' AND  journey_date=$newjDate AND booking_status='$FBooking' AND current_status='$FCurrent'  AND confirm='$Fchart'";
//                    $datacheckin = help::read($sql);
//                    if ($datacheckin['id'] != NULL) {
//                        echo 'already there<br>';
//                    } else {
//                        $sql = "INSERT INTO `tbl_pnr_data`( `cust_id`,`pnr`, `train_no`, `seat`, `coach`, `journey_date`, `booking_status`, `current_status`, `match`,`confirm`,`update_time`)
//                               VALUES ('$cust_id','$pnr','$FTrain','$FSeat','$FCoach','$newjDate','$FBooking','$FCurrent','1','$Fchart','$today')";
////                        $sql = "call insert_pnr_cron('$cust_id','$FTrain','$FSeat','$FCoach','$newjDate','$FBooking','$FCurrent','1','$Fchart','$pnr')";
//                        if (help::execute($sql)) {
//                            echo '2 Insertion ' . $cust_id . '<br>';
//                        } else {
//                            echo '2 Insertion Failed ' . $cust_id . '<br>';
//                        }
//                    }
//                }
////                --------------------
//            }
//        }
    }

    public function pnrfilter($pnr, $passengers, $chart) {
        if ($pnr != 0) {
            $inc = 0;
            $data->chart_prepared = $chart;
            foreach ($passengers as $row) {
                $bookstatus[$inc] = $row->booking_status;
                $currentstatus[$inc] = $row->current_status;
                $inc++;
            }
            $booksts = explode(',', $bookstatus[0]);
            $newCoach = $booksts[0];
            $newSeat = $booksts[1];
            $newSeat = str_replace(' ', '', $newSeat);
            $newCoach = str_replace(' ', '', $newCoach);


            if ($data->chart_prepared == 'Y') {

                $i = 0;
                foreach ($passengers as $book_status) {

                    $booking = $book_status->booking_status;
                    $current = $book_status->current_status;
                    if (strpos($current, ',') !== false) {

                        $bookExp = explode(',', $booking);
                        $sizeBook = sizeof($bookExp);
                        if ($sizeBook == 3) {
                            $coach[$i] = str_replace(' ', '', $bookExp[0]);
                            $seat[$i] = str_replace(' ', '', $bookExp[1]);
                            $quota[$i] = str_replace(' ', '', $bookExp[2]);
                            $status = 1;
                            $ask = 0;
                            $smiley = '';
                        } else if ($sizeBook == 2) {
//print_r($bookExp);
                            $bookExp[0] = str_replace(' ', '', $bookExp[0]);
                            $bookExp[1] = str_replace(' ', '', $bookExp[1]);
                            if ((strpos($bookExp[0], 'RAC') !== false) || (strpos($bookExp[0], 'W/L') !== false)) {
                                $curExp = explode(',', $current);
                                $sizeCus = sizeof($curExp);
                                if ($sizeCus == 3) {
                                    $coach[$i] = str_replace(' ', '', $curExp[0]);
                                    $seat[$i] = str_replace(' ', '', $curExp[1]);
                                    $quota[$i] = str_replace(' ', '', $curExp[2]);
                                    $status = 1;
                                    $ask = 0;
                                    $smiley = '';
                                } else if ($sizeBook == 2) {
                                    $coach[$i] = str_replace(' ', '', $curExp[0]);
                                    $seat[$i] = str_replace(' ', '', $curExp[1]);
                                    $quota[$i] = 0;
                                    $status = 1;
                                    $ask = 0;
                                    $smiley = '';
                                }
                            }
                        } else {
                            $coach[$i] = str_replace(' ', '', $bookExp[0]);
                            $seat[$i] = str_replace(' ', '', $bookExp[1]);
                            $quota[$i] = 0;
                            $status = 1;
                            $ask = 0;
                            $smiley = '';
                        }
                    } else {
                        if ($current == 'Can/Mod') { //1111111111111111111111111111111111111  6133622349
                            $bookExp = explode(',', $booking);
                            $sizeBook = sizeof($bookExp);
                            if ($sizeBook == 3) {
                                $coach[$i] = str_replace(' ', '', $bookExp[0]);
                                $seat[$i] = str_replace(' ', '', $bookExp[1]);
                                $quota[$i] = str_replace(' ', '', $bookExp[2]);
                                $status = 1;
                                $ask = 0;
                                $smiley = '';
                            } else {
                                $coach[$i] = str_replace(' ', '', $bookExp[0]);
                                $seat[$i] = str_replace(' ', '', $bookExp[1]);
                                $quota[$i] = 0;
                                $status = 1;
                                $ask = 0;
                                $smiley = '';
                            }
                        } else if ($current[0] == 'R') {

                            $bookExp = explode(',', $booking);

                            $sizeBook = sizeof($bookExp);

                            if ($sizeBook == 3) {

                                $coach[$i] = str_replace(' ', '', $bookExp[0]);
                                $seat[$i] = str_replace(' ', '', $bookExp[1]);
                                $quota[$i] = str_replace(' ', '', $bookExp[2]);
                                $status = 1;
                                $ask = 0;
                                $smiley = '';
                            } else {
                                $current = ltrim($current, 'R');
                                $curExp = explode(' ', $current);
                                $coach[$i] = str_replace(' ', '', $curExp[0]);
                                $seat[$i] = str_replace(' ', '', $curExp[3]);
                                $quota[$i] = 0;
                                $status = 1;
                                $ask = 0;
                                $smiley = '';
                            }
                        } else {

                            $status = 0;
                            $ask = 1;
                            $smiley = '';
                        }
                    }
                    $i++;
                }
            } else if ($data->chart_prepared == 'N') {
                $i = 0;
                foreach ($passengers as $book_status) {
                    $booking = $book_status->booking_status;
                    $current = $book_status->current_status;
//                        print_r($current);die;

                    if ($current == 'CNF') {
//                            echo '2dd';die;
                        $bookExp = explode(',', $booking);
                        $sizeBook = sizeof($bookExp);
                        if ($sizeBook == 3) {
//                                echo '1';die;
                            $coach[$i] = str_replace(' ', '', $bookExp[0]);
                            $seat[$i] = str_replace(' ', '', $bookExp[1]);
                            $quota[$i] = str_replace(' ', '', $bookExp[2]);
                            $status = 1;
                            $ask = 0;
                            $smiley = 'happy';
                        } else if ($sizeBook == 2) {
//                                echo '2';die;
                            if (strpos($bookExp[0], 'CNF') !== false) {
                                $coach[$i] = 0;
                                $seat[$i] = 0;
                                $quota[$i] = 0;
                                $status = 1;
                                $ask = 1;
                                $smiley = '';
                            }
                        } else {
//                                echo '3';die;
                            $coach[$i] = str_replace(' ', '', $bookExp[0]);
                            $seat[$i] = str_replace(' ', '', $bookExp[1]);
                            $quota[$i] = 0;
                            $status = 1;
                            $ask = 1;
                            $smiley = '';
                        }
                    } else if ($current == 'Confirmed') {
//                                      echo 'zzzd';die;
                        $bookExp = explode(',', $booking);
                        $sizeBook = sizeof($bookExp);
//print_r($bookExp);
                        if ((strpos($bookExp[0], 'RAC') !== false) || (strpos($bookExp[0], 'W/L') !== false)) {
                            $coach[$i] = 0;
                            $seat[$i] = 0;
                            $quota[$i] = 0;
                            $status = 1;
                            $ask = 0;
                            $smiley = 'happy';
                        } else {
//normal number
                        }
                    } else if ($current == 'Can/Mod') {

                        $bookExp = explode(',', $booking);
//$sizeBook = sizeof($bookExp);
//print_r($bookExp);
                        if ((strpos($bookExp[0], 'W/L') !== false) || (strpos($bookExp[0], 'GNWL') !== false)) {
                            $coach[$i] = 0;
                            $seat[$i] = 0;
                            $quota[$i] = 0;
                            $status = 0;
                            $ask = 1;
                            $smiley = '';
                        }
                        if ((strpos($bookExp[0], 'RAC') !== false)) {
                            $coach[$i] = 0;
                            $seat[$i] = 0;
                            $quota[$i] = 0;
                            $status = 0;
                            $ask = 1;
                            $smiley = '';
                        } else {

                            $coach[$i] = 0;
                            $seat[$i] = 0;
                            $quota[$i] = 0;
                            $status = '';
                            $ask = '';
                            $smiley = '';
                        }
                    } else {


                        if (strpos($current, 'W/L') !== false) {

                            $bookExp = explode(',', $booking);
                            $sizeBook = sizeof($bookExp);
                            if (strpos($bookExp[0], 'W/L') !== false) {
                                $coach[$i] = 0;
                                $seat[$i] = 0;
                                $quota[$i] = 0;
                                $status = 0;
                                $ask = 1;
                                $smiley = '';
                            }
                        } else if (strpos($current, 'RAC') !== false) {
                            $bookExp = explode(',', $booking);
                            $sizeBook = sizeof($bookExp);
                            if (strpos($bookExp[0], 'RAC') !== false) {
                                $coach[$i] = 0;
                                $seat[$i] = 0;
                                $quota[$i] = 0;
                                $status = 0;
                                $ask = 1;
                                $smiley = '';
                            } else {
                                $coach[$i] = 0;
                                $seat[$i] = 0;
                                $quota[$i] = 0;
                                $status = 0;
                                $ask = 1;
                                $smiley = '';
                            }
                        }
                    }
                    $i++;
                }
            } else {
                print_r($data);
            }

            $val = array('coach' => $coach, 'seat' => $seat, 'quota' => $quota, 'chartPrepare' => $data->chart_prepared, 'status' => $status);
//                print_r($val);die;
            return $val;
        }
    }

    public function actionPnrCronTemp($id = 0) { //working   //for time setting
//        ini_set('max_execution_time', 150);
        $now = date('Y-m-d H:i:s');

//        $sql = "SELECT j.coach_no,j.seat_no,j.cust_id,j.pnr,j.train_no,j.cust_id,o.real_day_time,o.station,j.agent_seat_confirm FROM tbl_journey j
//                INNER JOIN tbl_order_table o ON o.cust_id= j.cust_id WHERE o.real_day_time<>0 AND o.order_status=1
//                AND pnr<>' ' AND PNR<>'NA' AND PNR<>'0' AND DATE(expected_arrival)=CURDATE() AND TIME('$now')<=TIME(expected_arrival) AND j.agent_seat_confirm IS NULL GROUP BY  j.cust_id
//ORDER BY `o`.`real_day_time`  ASC
//LIMIT 20";
        $sql = "SELECT j.coach_no,j.seat_no,j.cust_id,j.pnr,j.train_no,o.real_day_time,o.station,j.agent_seat_confirm,`p`.`match`
            FROM tbl_journey j
            LEFT JOIN tbl_order_table o ON o.cust_id= j.cust_id 
            LEFT JOIN tbl_pnr_data p ON p.cust_id= j.cust_id 
            WHERE o.order_status=1
                AND j.pnr<>' ' AND j.pnr<>'0' AND j.pnr<>'null' AND j.pnr<>'NA' AND DATE(o.real_day_time)=CURDATE() 
                AND j.agent_seat_confirm IS NULL AND ( `p`.`match` IS NULL OR `p`.`match`=0 )
				GROUP BY  j.cust_id
               ORDER BY `p`.`update_time`  ASC limit 25";  //`p`.`match`!=1 OR 
//        echo '<pre>';
//        $sql = "call select_pnr_cron()";
        $data = help::readAll($sql);
//        print_r($data);die;
        $bookstatus = array();
        $currentstatus = array();
        echo count($data) . '<br>';
//        foreach ($data as $row) {
//            print_r($row);
//            echo '<hr>';
//        }
//        die;
//        $path = dirname(dirname(__FILE__)) . '/../assets/scrap/IndianrailLocation.php';
//        include($path);
        foreach ($data as $row) {
//            if ($row['cust_id'] != '57658' && ($row['cust_id'] != '57669')) {
//            echo '<pre>';
//             print_r($row['cust_id']);
            $doj = explode(' ', $row['real_day_time']);
            $seat = $row['seat_no'];
            $coach = $row['coach_no'];
            $doj = $doj[0];
            $pnr = $row['pnr'];
            $train = $row['train_no'];
            $cust_id = $row['cust_id'];
            $stationId = $row['station'];
//            }
//            $i++;
//    -------------------------------------
            $seat = str_replace(' ', '', $seat);
            $coach = str_replace(' ', '', $coach);
            $doj = str_replace(' ', '', $doj);
            $train = str_replace(' ', '', $train);

//            $x = $Indianrail->checkPnrStatus($pnr);
//            $x = $this->etrain($pnr);
            $x = $this->Railyatri($pnr);
//                $x = $this->RailwayAPI($pnr);

            $sql = "SELECT station_code FROM tbl_stations WHERE id=$stationId";
            $sCode = help::getscalar($sql);
            $sCode = str_replace(' ', '', $sCode);
//        $train=12625;
            $newjDate = 0;
//            $path = Yii::getPathOfAlias('webroot') . '/assets/train/trains_list/' . $train . '.csv';
            $path = '/var/www/vhosts/train_scrap/trains_list/' . $train . '.csv';


//            print_r($x);die;
            if ($x->response_code == 200) {
                $newdoj = $x->doj;
                $tnum = $x->train_num;
                $chartPrepare = $x->chart_prepared;
                $inc = 0;
                $sdfhk = $this->pnrfilter($pnr, $passengers = $x->passengers, $chart = $chartPrepare);
                $newCoach = $sdfhk['coach'][0];
                $newSeat = $sdfhk['seat'][0];
                foreach ($x->passengers as $row) {
                    $bookstatus[$inc] = $row->booking_status;
                    $currentstatus[$inc] = $row->current_status;
                    $inc++;
                }

                $booksts = explode(',', $bookstatus[0]);

                $newdoj = str_replace(' ', '', $newdoj);


//           ------------------------------------
                if (file_exists($path)) {
                    $csvFile = $path;
                    $csv = $this->actionTest($csvFile);

                    foreach ($csv as $tdata) {
                        if ($tdata[2] == $sCode) {

                            $currntDate = $tdata[9];
                            if ($currntDate == 1) {
//                        $tdate=$doj;
                                $newjDate = $newdoj;
                            } elseif ($currntDate == 2) {
//  echo $cookies_tdate;die;
//                        $tdate = date('d-m-Y', strtotime($doj . ' + 1 day'));
                                $newjDate = date('Y-m-d', strtotime($newdoj . ' + 1 day'));
                            } elseif ($currntDate == 3) {
//                        $tdate = date('d-m-Y', strtotime($doj . ' + 2 day'));
                                $newjDate = date('Y-m-d', strtotime($newdoj . ' + 2 day'));
                            } elseif ($currntDate == 4) {
//                        $tdate = date('d-m-Y', strtotime($doj . ' + 3 day'));
                                $newjDate = date('Y-m-d', strtotime($newdoj . ' + 3 day'));
                            } elseif ($currntDate == 5) {
//                        $tdate = date('d-m-Y', strtotime($doj . ' + 4 day'));
                                $newjDate = date('Y-m-d', strtotime($newdoj . ' + 4 day'));
                            }
                        }
                    }
                } else {
                    echo 'file error';
                }

//---------------update---------------

                if (($seat != $newSeat) || ($coach != $newCoach) || ($doj != $newjDate) || ($train != $tnum)) {
                    $sql1 = "SELECT id,train_no,confirm FROM `tbl_pnr_data` WHERE cust_id='$cust_id'";
                    $result = help::read($sql1);
                    if ($result == NULL) {


                        $sql = "INSERT INTO `tbl_pnr_data`( `cust_id`, `train_no`, `seat`, `coach`, `journey_date`, `booking_status`, `current_status`, `match`,`confirm`,`update_time`)
                            VALUES ('$cust_id','$tnum','$newSeat','$newCoach','$newjDate','$bookstatus[0]','$currentstatus[0]','1','$chartPrepare','$now')";
//                        $sql = "call insert_pnr_cron('$cust_id','$tnum','$newSeat','$newCoach','$newjDate','$bookstatus[0]','$currentstatus[0]','1','$chartPrepare')";
                        if (help::execute($sql)) {
                            echo 'Insertion1 ' . $cust_id . '<br>';
                        } else {
                            echo 'Insertion2 Failed  ' . $cust_id . '<br>';
                        }
                    } else {
//                    echo 'Alredy UPdated  '.$cust_id.'-->'.$result['confirm'].'<br>';
//                        echo $result['id'];
                        if ($result['confirm'] == 'N') {
                            $sql = "UPDATE  `tbl_pnr_data` SET `train_no`='$tnum', `seat`='$newSeat', `coach`='$newCoach', `journey_date`='$newjDate', `booking_status`='$bookstatus[0]', `current_status`='$currentstatus[0]', `match`=1,`confirm` =  '$chartPrepare',`update_time`='$now' WHERE  `id` =  '$result[id]' AND  `cust_id` =  '$cust_id'";
//                            $sql = "call update_pnr_cron('$tnum','$newSeat','$newCoach','$newjDate','$bookstatus[0]','$currentstatus[0]','1','$chartPrepare','$result[id]','$cust_id')";
                            if (help::execute($sql)) {
                                echo $cust_id . ' update chart(' . $result[id] . ')';
                            } else {
                                echo $cust_id . ' chart failed';
                            }
                        } else {
                            echo $cust_id . ' nthng to update1';
                        }
                    }
                } else {

                    echo 'trues';
//                    $sql = "INSERT INTO `tbl_pnr_data`( `cust_id`, `train_no`, `seat`, `coach`, `journey_date`, `booking_status`, `current_status`, `match`,`confirm`)
//                            VALUES ('$cust_id','$tnum','$newSeat','$newCoach','$newjDate','$bookstatus[0]','$currentstatus[0]','0','$chartPrepare')";
//                    $sql = "SELECT id FROM tbl_pnr_data WHERE cust_id='$cust_id' AND train_no='$tnum' AND seat='$newSeat' AND coach='$newCoach' AND journey_date='$newjDate' AND booking_status=$bookstatus[0] AND current_status=$currentstatus[0] AND match='0' AND confirm='$chartPrepare'";
                    $sql = "SELECT id FROM tbl_pnr_data WHERE cust_id='$cust_id' AND train_no='$tnum' AND  journey_date='$newjDate' AND booking_status='$bookstatus[0]' AND current_status='$currentstatus[0]'  AND confirm='$chartPrepare'";

                    echo '<br>';
                    $datacheckin = help::read($sql);
                    if ($datacheckin['id'] != NULL) {
                        echo 'already there<br>' . $cust_id;
                    } else {
                        $sql = "INSERT INTO `tbl_pnr_data`( `cust_id`, `train_no`, `seat`, `coach`, `journey_date`, `booking_status`, `current_status`, `match`,`confirm`,`update_time`)
                           VALUES ('$cust_id','$tnum','$newSeat','$newCoach','$newjDate','$bookstatus[0]','$currentstatus[0]','0','$chartPrepare','$now')";
//                        $sql = "call insert_pnr_cron('$cust_id','$tnum','$newSeat','$newCoach','$newjDate','$bookstatus[0]','$currentstatus[0]','0','$chartPrepare')";
                        if (help::execute($sql)) {
                            echo 'Insertion3 ' . $cust_id . '<br>';
                        } else {
                            echo 'Insertion4 Failed ' . $cust_id . '<br>';
                        }
                    }
                }

//    ----------------end---------------------
            } else {
                echo 'ELSE__' . $cust_id;
            }
//            }
            echo '<br>';
        }
    }

    public function actionLiveTrainStatus() {
        $sel = help::checkalive(47);

        $ch = curl_init();
        if ($sel == 0) {
            $url = $this->createUrl('/url/LiveTrainStatusTemp');
            $url = 'https://cc.yatrachef.com' . $url;
        } else if ($sel == 1) {
            $url = $this->createUrl('/test/LiveTrainStatusTemp');
            $url = 'https://cc.yatrachef.com' . $url;
        }else{
            echo 'STOPPED';die;
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//  curl_setopt($ch,CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 120000); //100000
        $output = curl_exec($ch);

        curl_close($ch);
        print_r($output);
        die;


        $ch = curl_init();
        $url = $this->createUrl('/url/LiveTrainStatusTemp');
        $url = 'https://cc.yatrachef.com' . $url;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//  curl_setopt($ch,CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 95000);
        $output = curl_exec($ch);

        curl_close($ch);
        print_r($output);
//        $this->FindNewOrder();
    }

    public function actionLiveTrainStatusTemp() {//for timout setting
//        help::mail('TEST','Cron TESTING','akhiltm2@gmail.com');
        echo $current_time = date('H:i');
        if ((strtotime($current_time) >= strtotime('05:00')) && (strtotime($current_time) <= strtotime('23:00'))) {
            echo 'true';

            $mail = 1;
            ini_set('max_execution_time', 150);
            echo $timz1 = date('H:i:s') . '<br>'; //die;
            echo '<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />';
            $path = dirname(dirname(__FILE__)) . '/../assets/scrap/liveStatus.php';
            include($path);
            echo '<pre>';
            $Livestatus = new Livestatus();
//        $sql = "SELECT o.DelayUpdate,o.our_exp_time,o.real_day_time,o.train_status,j.train_no,s.station_code,o.id,o.expected_arrival,o.trainDelay,o.distance,o.last_updated
//                FROM tbl_order_table o
//              INNER JOIN tbl_journey j ON j.cust_id=o.cust_id
//              INNER JOIN tbl_stations s ON s.id=o.station
//                WHERE DATE(o.real_day_time)=CURDATE() AND o.order_status=1 AND o.train_status<>1 AND o.id=13472";
//            $sql = "SELECT o.eta_last_updated,o.DelayUpdate,o.our_exp_time,o.real_day_time,o.train_status,j.train_no,s.station_code,o.id,o.expected_arrival,o.trainDelay,o.distance,o.last_updated 
//                FROM tbl_order_table o
//              INNER JOIN tbl_journey j ON j.cust_id=o.cust_id
//              INNER JOIN tbl_stations s ON s.id=o.station
//                WHERE DATE(o.real_day_time)=CURDATE() AND o.order_status=1 AND o.train_status<>1 ORDER BY o.eta_last_updated ASC limit 2;";
            $sql = "call CRON_MODULE(1)";
            $data = help::readAll($sql);
            if ($data != NULL) {
//        print_r($data);die;
                $mis_count = 1;
                foreach ($data as $row) {
                    $oid = $row['id'];
                    $currentDay = date("d-m-Y", strtotime($row['real_day_time']));
                    $train = $row['train_no'];
                    $trCount = strlen($train);
                    if ($trCount == 4) {
                        $train = '0' . $train;
                    } else if ($trCount == 3) {
                        $train = '00' . $train;
                    }
                    $code = $row['station_code'];
                    $train . '- ' . $code . '--';
                    $result = $Livestatus->fetch($train, $code, $dayType = 1);

//                    print_r($result);
//                    die;
//                    $result = $Livestatus->ryapi($train, $row['station_code'], $dayType = 1);
//                    if ($result->response_code == 400) {
//                        return 0;
//                    }
//                    if ($result->success == 1) {
//   echo '<pre>';
//                    print_r($result);
//                    die;
                    $result->exp_arrival = preg_replace('/\s+/', ' ', $result->exp_arrival);

//           -----------------------------data Fetching end-----------------------------------
///////////////////////////////////////////////////////////////////////
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
                        @$apiDate = date("d-m-Y", strtotime($apiDate));
                        @$apiDate2 = $year5 . '-' . $month5 . '-' . $date5 . ' ' . $tim;
                        if ((strpos($date5, 'Train Source') !== false) || (strpos($date5, 'TrainSource') !== false)) {
                            @$deliveryX = explode(' ', $row['real_day_time']);
                            @$apiDate = date("d-m-Y", strtotime($deliveryX[0]));
                            @$apiDate2 = $row['real_day_time'];
                        }
                    } else {
                        $apiDate = 0;
                    }

                    if ($result->exp_arrival == '0') {//act arrival
                        @$arrival_type = 1; //act
                        @$expected_arrival = 0;
                        if (strpos($result->act_arrival, 'Train Source') !== false) {
//                if ($result->act_arrival == ' Train Source') {
//echo 'Train Source';
                            $actual_arrival = $apiDate2;
                        } else {//when date and time showing
                            @$sexp = explode(' ', $result->act_arrival);
                            @$act_arr = explode('-', $result->act_arrival);

//                    print_r($result->act_arrival); die;
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
//                if ($result->exp_arrival == ' Waiting for update ') {
//echo $expected_arrival = $row['expected_arrival'];
                            if ($row['expected_arrival'] == 0) {
                                $expected_arrival = $row['real_day_time'];
                            } else {
                                $expected_arrival = $row['expected_arrival'];
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
                        if (strpos($result->exp_arrival, 'Cancelled for your Station') !== false) {
                            @$expected_arrival = $row['real_day_time'];
                            $sql = "UPDATE tbl_order_table SET nottify='2' WHERE id=$oid";
                            help::execute($sql);
                        }
                    }

//            ---------------------------
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

//$distance = trim($kms[1], " (");
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
                    } else {
                        $lastUpdated = 0;
                    }
//            ---------------------------

                    $delay_arr = str_replace(' ', '', $result->delay_arrival) . '<br>';
                    if ($actual_arrival != 0) {

                        if (strpos($result->act_arrival, 'Train Source') !== false) {
                            $status1 = '2';
                        } else {
                            $status1 = '1';
                        }
                    } else {
                        $status1 = '2';
                    }
                    if ($train_status == ' to go') {
                        $status2 = '2'; //not reached
                    } else if ($train_status == ' ahead') { //$result->last_location
                        $status2 = '1'; //reached
                    } else {
                        $status2 = '5'; //delay or something
                    }
                    if (($status1 == '1') || ($status2 == '1')) {//&& old value
                        $status = '1';
                    } else {
                        $status = '2';
                    }


                    if (((strpos($result->last_location, 'Arrived at') !== false) && (strpos($result->last_location, $result->station_name) !== false)) || ((strpos($result->last_location, 'ahead of') !== false) && (strpos($result->last_location, $result->station_name) !== false))) {
                        $new_train_status = 1;
                    } else if ((strpos($result->last_location, 'Departed from') !== false) && (strpos($result->last_location, $result->station_name) !== false)) {
                        $new_train_status = 1;
                    } else if ((strpos($result->last_location, ' ahead') !== false)) {
                        $new_train_status = 1;
                    } else {
                        $new_train_status = 2;
                    }
                    if (($status1 == '1') || ($new_train_status == '1')) {
                        $new_train_status = 1;
                    } else {
                        $new_train_status = 2;
                    }
//                    echo $result->last_location . '<hr>' . $status . '----' . $new_train_status;
//                    die;
//            $status='1';
                    $delay = $result->delay_arrival;
                    if ($expected_arrival == 0) {
                        $arrival = $actual_arrival;
                    } else if ($actual_arrival == 0) {
                        $arrival = $expected_arrival;
                    }



                    if ($distance == 0) {
                        $distance = $row['distance'];
                    }
                    if ($lastUpdated == 0) {
                        $lastUpdated = $row['last_updated'];
                    }
                    $oid = $row['id'];
                    if ($delayUpdate != 0) {
                        $year3 = explode('-', $result->date);
                        $year3 = $year3[2]; //3
                        $year3 = str_replace(' ', '', $year3);
                        $our_exp_time = $this->actionCalcTrainExpTime($year = $year3, $delayUpdate, $delayTime = $delay, $kms = $distance);
                        if ($our_exp_time <= $row['real_day_time']) {
//                        echo $our_exp_time.'--'.$row['real_day_time'].'===>'.$oid.'<br>';
                            $our_exp_time = $row['real_day_time'];
                        } else {
                            $our_exp_time = $our_exp_time;
                        }
                    } else {
                        if ($status != '1') {
                            $our_exp_time = $row['real_day_time'];
                        } else {
                            $our_exp_time = $row['our_exp_time'];
                        }
                    }

//--------------disable cron for some time interval-----------
                    $set1 = date('d-m-Y 11:00:00');
                    $set2 = date('d-m-Y 04:00:00');
                    $current = date('d-m-Y H:i:s');
                    if (($current >= $set1) && ($current <= $set2)) {
                        echo 'Cron Disabled';
                    } else {


//----------------end---------------------------------------



                        $apiDate = str_replace(' ', '', $apiDate);
//echo $oid.'--'.$apiDate.'--'.$currentDay . '<br>';
//                echo $actual_arrival.'<br>';
//                 echo $arrival.'<br>';
//                 echo $train .'-'.$code.'<br>';
                        $arrival = preg_replace('/\s+/', ' ', $arrival);
                        $arrival = str_replace('*', '', $arrival);
                        $xz = explode(' ', $arrival);
                        $newTime = date("H:i:s", strtotime($xz[1]));
                        $arrival = $xz[0] . ' ' . $newTime;
//                        echo $sql = "call UPDATE_ALL('$arrival','$delay','$distance','$lastUpdated','$status','$arrival_type','$delayUpdate','$our_exp_time','$oid',1)";
//                 echo '<br>'.$apiDate . '--date mis--' . $currentDay . '<br>';die;
//                        die;
                        if ($apiDate == $currentDay) {
//                    echo $sql = "UPDATE tbl_order_table SET expected_arrival='$arrival',trainDelay='$delay',distance='$distance',last_updated='$lastUpdated',train_status='$status',train_arrival_type='$arrival_type',DelayUpdate='$delayUpdate',our_exp_time='$our_exp_time' WHERE id=$oid";
//                    echo '<br>';

                            $now_exact = date('Y-m-d H:i:s');
                            if ($status == 1) {
                                $lastUpdated = $now_exact;
                            }
                            echo $sql = "call UPDATE_ALL('$arrival','$delay','$distance','$lastUpdated','$new_train_status','$arrival_type','$delayUpdate','$our_exp_time','$row[id]',1,'$now_exact')"; //$status
//                            die;
                            echo $arrival;
                            echo 'Success<br>';
                            if (help::execute($sql)) {
                                $current_time = date('Y-m-d H:i:s');
                                help::execute("UPDATE settings SET Comments='$current_time' WHERE id='21'");
                                if (!isset($result->last_location)) {
                                    $result->last_location = NULL;
                                }
                                $Last_ETA = help::getscalar("SELECT ETA FROM `tbl_eta_history` WHERE Order_Id='$row[id]' ORDER BY created_at DESC limit 1");
                                if ((strtotime($Last_ETA) != strtotime($arrival)) || ($new_train_status == 1)) {
                                    $result->last_location = str_replace("'", "\'", $result->last_location);
                                    $sql = "INSERT INTO `tbl_eta_history`(`Station`,`Order_Id`, `STA`, `ETA`, `Delay`, `Last_Location`, `Last_Updation`, `Train`, `Created_At`,`train_status`,`act_arrival`, `exp_arrival`,`out_status`,`new_status`) "
                                            . " VALUES ('$row[station_code]','$row[id]','$row[real_day_time]','$arrival','$delay','$result->last_location','$lastUpdated','$train','$now_exact','$train_status','$result->act_arrival','$result->exp_arrival','$status','$new_train_status')";
                                    help::execute($sql);
                                }
                                echo 'updated->' . $oid . '-<br>';
                            } else {
                                echo 'failed->' . $oid . '-<br>';
                            }

                            $date1 = date('Y-m-d', strtotime($arrival));
                            $date2 = date('Y-m-d', strtotime($row['real_day_time']));
                            $diff = date_diff(date_create($date1), date_create($date2));
                            if ($diff->format("%a") != 0) {
                                $sql = "UPDATE tbl_order_table SET issue_status='4' WHERE id='$oid'";
                                help::execute($sql);
                            }
                        } else {
//                    echo $apiDate.'<br>';
//                    echo $oid . 'date mismatch';
                            echo 'FAIL<br>';
                            echo $apiDate . '--date mis--' . $currentDay . '--<br>';
                            $mail = 1;

                            $mis_count++;
                        }
                    }
//                        die;
//                    }
////////////////////////////////////////////////////////////////////////
                }
                if (($mail == 1) && ($mis_count >= 3)) {
//                echo $mis_count.'-----44444444444444';
//                    help::Mail('Live Status Not working', $content = '<html><div>Live Train Status Not working..mis match</div></html>', $to = 'akhil.tm@yatrachef.com');
//help::Mail('Live Status Not working', $content='<html><div>Live Train Status Not working..mis match</div></html>', $to='rameez@yatrachef.com');
                }
            } else {
                echo 'NULL';
            }
            echo '<br>' . $time2 = date('H:i:s');
        } else {
            echo 'cron off at this time';
        }
//       echo $new_queue=file_get_contents("http://api.yatrachef.com/live/index.php/Cron/CreateQueue");
    }

//    public function actionLiveTrainStatus() {
//
//        echo '<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />';
//        $path = dirname(dirname(__FILE__)) . '/../assets/scrap/liveStatus.php';
//        include($path);
//        echo '<pre>';
//        $Livestatus = new Livestatus();
//        $sql = "SELECT o.DelayUpdate,o.our_exp_time,o.real_day_time,o.train_status,j.train_no,s.station_code,o.id,o.expected_arrival,o.trainDelay,o.distance,o.last_updated FROM tbl_order_table o
//              INNER JOIN tbl_journey j ON j.cust_id=o.cust_id
//              INNER JOIN tbl_stations s ON s.id=o.station
//                WHERE DATE(o.real_day_time)=CURDATE() AND o.order_status=1 AND o.train_status<>1";
//        $data = help::readAll($sql);
//        foreach ($data as $row) {
//            $currentDay = date("d-m-Y", strtotime($row['real_day_time']));
//            $train = $row['train_no'];
//            $trCount = strlen($train);
//            if ($trCount == 4) {
//                $train = '0' . $train;
//            }
//            $code = $row['station_code'];
//            set_time_limit(10);
//            $result = $Livestatus->fetch($train, $code, $dayType = 1);
//            if ($result->sch_arrival) {
//                $act_arr = explode('-', $result->sch_arrival);
//                $year5 = explode('-', $result->date);
//                $year5 = $year5[2];
//                $date5 = $act_arr[0];
//                $date5 = trim($date5, ' ');
//                $month5 = $act_arr[1];
//                $month5 = date('m', strtotime($month5));
//                $apiDate = $date5 . '-' . $month5 . '-' . $year5;
//                $apiDate2 = $year5 . '-' . $month5 . '-' . $date5;
//            } else {
//                $apiDate = 0;
//            }
//
//            if ($result->exp_arrival == '0') {//act arrival
//                $arrival_type = 1; //act
//                $expected_arrival = 0;
//                if ($result->act_arrival == ' Train Source') {
//                    //echo 'Train Source';
//                    $actual_arrival = $apiDate2;
////                            $row['expected_arrival'];
////                    $row['expected_arrival'];
////                    $actual_arrival = $row['real_day_time'];
//                } else {//when date and time showing
//                    $sexp = explode(' ', $result->act_arrival);
//                    $act_arr = explode('-', $sexp[1]);
//                    $time = $sexp[2];
//                    $year = explode('-', $result->date);
//                    $year = $year[2];
//                    $date = $act_arr[0];
//                    $month = $act_arr[1];
//                    $month = date('m', strtotime($month));
//                    $actual_arrival = $year . '-' . $month . '-' . $date . ' ' . $time;
//                }
//            } else {//exp arrival
//                $arrival_type = 2; //exp arrival
//                $actual_arrival = 0;
////                echo $result->exp_arrival;
//                if (strpos($result->exp_arrival, 'blink') !== false) {
//                    $evalue = explode('blink', $result->exp_arrival);
//                    $result->exp_arrival = $evalue[0];
//                }
////                echo '--'.$result->exp_arrival.'--';die;
//                if ($result->exp_arrival == ' Waiting for update ') {
//                    $expected_arrival = $row['expected_arrival'];
//                } else {
//                    if (strpos($result->exp_arrival, 'blink') !== false) {
//                        $evalue = explode('blink', $result->exp_arrival);
////                        print_r($evalue[0]);
//                        $year2 = explode('-', $result->date);
//                        $year2 = $year2[2];
//
//                        $sexp2 = explode(' ', $result->exp_arrival);
//                        $ext_arr = explode('-', $sexp2[1]);
//                        $time2 = $sexp2[2];
//
//                        $date2 = $ext_arr[0];
//                        $month2 = $ext_arr[1];
//                        $month2 = date('m', strtotime($month2));
//                        $expected_arrival = $year2 . '-' . $month2 . '-' . $date2 . ' ' . $time2;
//                    } else {
//                        $year2 = explode('-', $result->date);
//                        $year2 = $year2[2];
//
//                        $sexp2 = explode(' ', $result->exp_arrival);
//                        $ext_arr = explode('-', $sexp2[1]);
//                        $time2 = $sexp2[2];
//
//                        $date2 = $ext_arr[0];
//                        $month2 = $ext_arr[1];
//                        $month2 = date('m', strtotime($month2));
//                        $expected_arrival = $year2 . '-' . $month2 . '-' . $date2 . ' ' . $time2;
//                    }
//                }
//            }
//
//            //            ---------------------------
////            echo $result->last_location;
//            if (strpos($result->last_location, 'Kms') !== false) {
//                $distance1 = explode('Kms', $result->last_location);
//                $train_status = $distance1[1];
//                $train_status = trim($train_status, '.)');
//                $status = trim($distance1[1], ".)");
//                $kms = explode('(', $distance1[0]);
//                $wcount = count($kms);
//                $wcount2 = $wcount - 2;
//                $wcount = $wcount - 1;
//
//                $distance = $kms[$wcount];
//
//
//                $delayUpdate = $kms[$wcount2];
//                $delayUpdate = explode('at', $delayUpdate);
//                $delayUpdate = $delayUpdate[1];
//
//                //$distance = trim($kms[1], " (");
//            } else {
//                $distance = 0;
//                $train_status = 0;
//                $delayUpdate = 0;
//            }
//
//
////            ---------------------------
//
//            if (isset($result->lastUpdate)) {
//                $lastUpdated = $result->lastUpdate;
//                $lastUpdated = preg_replace('/\s+/', ' ', $lastUpdated);
//                $lastUpdated = explode(' ', $lastUpdated);
//                $lastUpdated = $lastUpdated[0] . ' ' . $lastUpdated[1];
//            } else {
//                $lastUpdated = 0;
//            }
////            ---------------------------
////            echo $expected_arrival . '<br>';
////            echo $actual_arrival . '<br>';
////
////            echo $arrival_type . '<br>';
//            $delay_arr = str_replace(' ', '', $result->delay_arrival) . '<br>';
////            echo $train_status. '<br>';
////            echo $lastUpdated;
////            if ($distance != 0) {
////                $x12 = explode('(', $distance1[0]);
////                $stncode = explode(')', $x12[1]);
////                $stncode = $stncode[0];
////
////                $stnStatus = explode(' ', $distance1[0]);
////                $stnStatus = $stnStatus[1];
////
////
////                if ($code == $stncode) {
////                    echo 'true' . $code . '---' . $stncode . '-';
////                } else {
////                    echo 'false' . $code . '---' . $stncode . '-';
////                }
////                //            echo $stncode.'-->'.$stnStatus.'-->';
////            }
////            echo $actual_arrival;
//
//            if ($actual_arrival != 0) {
//                $status1 = '1';
//            } else {
//                $status1 = '2';
//            }
//            if ($train_status == ' to go') {
//                $status2 = '2'; //not reached
//            } else if ($train_status == ' ahead') {
//                $status2 = '1'; //reached
//            } else {
//                $status2 = '5'; //delay or something
//            }
//
//            if (($status1 == '1') || ($status2 == '1')) {//&& old value
//                $status = '1';
//            } else {
//                $status = '2';
//            }
////            $status='1';
//            $delay = $result->delay_arrival;
////            ---------------------------
//
//            if ($expected_arrival == 0) {
//                $arrival = $actual_arrival;
//            } else if ($actual_arrival == 0) {
//                $arrival = $expected_arrival;
//            }
////            if ($delay_arr == 0) {
////                $delay = $row['trainDelay'];
////            }else{
////                $delay=$delay_arr;
////            }
//
//            if ($distance == 0) {
//                $distance = $row['distance'];
//            }
//            if ($lastUpdated == 0) {
//                $lastUpdated = $row['last_updated'];
//            }
//            $oid = $row['id'];
////            print_r($row);
////            $row['expected_arrival'];
////            $row['trainDelay'];
////            $row['distance'];
////            $row['last_updated'];
//
//            if ($delayUpdate != 0) {
//                $year3 = explode('-', $result->date);
//                $year3 = $year3[2];
//                $our_exp_time = $this->actionCalcTrainExpTime($year = $year3, $delayUpdate, $delayTime = $delay, $kms = $distance);
//                //echo $our_exp_time.'--'.$oid.'<br>';
////                if($oid=='3372'){
////                   echo $our_exp_time;
////                }
////                echo $oid.'--'.$our_exp_time . '<br>';
//                if ($our_exp_time <= $row['real_day_time']) {
////                        echo $our_exp_time.'--'.$row['real_day_time'].'===>'.$oid.'<br>';
//                    $our_exp_time = $row['real_day_time'];
//                } else {
//                    $our_exp_time = $our_exp_time;
//                }
//
//                //print_r($x);
//            } else {
////                echo '555';
////                echo $status;
//                if ($status != '1') {
//                    $our_exp_time = $row['real_day_time'];
//                } else {
//                    $our_exp_time = $row['our_exp_time'];
//                }
//            }
//
////--------------disable cron for some time interval-----------
//            $set1 = date('d-m-Y 11:00:00');
//            $set2 = date('d-m-Y 04:00:00');
//            $current = date('d-m-Y H:i:s');
//            if (($current >= $set1) && ($current <= $set2)) {
//                echo 'Cron Disabled';
//            } else {
//
////                if ($row['train_status'] == '1') {
////                    $arrival = $row['expected_arrival'];
////                    $delay = $row['trainDelay'];
////                    $distance = $row['distance'];
////                    $our_exp_time = $row['our_exp_time'];
//////                            $our_exp_time=$row['real_day_time'];
////                    $delayUpdate = $row['DelayUpdate'];
////                }
////----------------end---------------------------------------
////                    echo '<br>';
////                echo $oid.'--'.$status.'--'.$our_exp_time . '<br>';
//                if ($apiDate == $currentDay) {
//                    $sql = "UPDATE tbl_order_table SET expected_arrival='$arrival',trainDelay='$delay',distance='$distance',last_updated='$lastUpdated',train_status='$status',train_arrival_type='$arrival_type',DelayUpdate='$delayUpdate',our_exp_time='$our_exp_time' WHERE id=$oid";
////                    echo '<br>';
//                    if (help::execute($sql)) {
//                        echo 'updated->' . $oid . '-<br>';
//                    } else {
//                        echo 'failed->' . $oid . '-<br>';
//                    }
//                } else {
//                    //echo $apiDate.'--date mis--'.$currentDay.'<br>';
//                }
//            }
//
//
////            die;
//        }
//
////        mail('akhilappu.tm@gmail.com','cron live status','true','info@yatrachef.com','-f info@yatrachef.com');
//    }

    public function actionCalcTrainExpTime($year, $DelayUpdate, $delayTime, $kms) {
//        echo $year.'<br>';
//        echo $DelayUpdate.'<br>';
//        echo $delayTime.'<br>';
//        echo $kms.'<br>';
//        $year = '2014';
//        $DelayUpdate = ' 10-Jul 00:00 ';
//        $delayTime = '02:18';
//        $kms = 123;

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

    public function actionTest($csvFile) {
        $file_handle = fopen($csvFile, 'r');
        while (!feof($file_handle)) {
            $line_of_text[] = fgetcsv($file_handle, 1024);
        }
        fclose($file_handle);
        return $line_of_text;
    }

    public function actionChangePrice() {
        $sql = "UPDATE tbl_menu SET price_cart=(price+(price*(company_margin/100)))";
        if (help::execute($sql)) {
            echo 'Sucessfully Updated';
        } else {
            echo 'Failed Updation';
        }
    }

    public function actionSMStoRestbefore15() {
        echo 'sdfdsf';
    }

    public function is_website_down($url, &$http_code) {
//initialize curl
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($handle, CURLOPT_HEADER, true);
        curl_setopt($handle, CURLOPT_NOBODY, true);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
//invoke curl to check the page return
        $response = curl_exec($handle);

//optional: you may get the http status code for custom implementation
        $http_code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        if ($http_code == 404) {
//TODO
        }

//close the curl handle
        curl_close($handle);
//return the status to caller
        if ($response)
            return false;
        else
            return true;
    }

    public function RailwayAPI($pnr) {
        error_reporting(0);
//        $path = dirname(dirname(__FILE__)) . '/../assets/scrap/IndianrailLocation.php';
//        include($path);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 20000);
        curl_setopt($ch, CURLOPT_URL, "http://api.railwayapi.com/pnr_status/pnr/$pnr/apikey/80242/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($data);
        if (($data->response_code != 200) || ($data->train_num != '')) {
            $stdClass = NULL;
            $stdClass = new stdClass();
            $stdClass->pnr = $pnr;
            $stdClass->response_code = 200;
            $stdClass->train_num = $data->train_num;
            $stdClass->train_name = $data->train_name;
            $stdClass->from_station->code = $data->from_station->code;
            if (IndianrailLocation::getLocationName($data->from_station->code) != '') {
                $from_name = IndianrailLocation::getLocationName($data->from_station->code);
            } else {
                $from_name = '';
            }
            $stdClass->from_station->name = $from_name;
            $stdClass->to_station->code = $data->to_station->code;
            if (IndianrailLocation::getLocationName($data->to_station->code) != '') {
                $to_name = IndianrailLocation::getLocationName($data->to_station->code);
            } else {
                $to_name = '';
            }
            $stdClass->to_station->name = $to_name;

            $stdClass->boarding_point->code = $data->boarding_point->code;
            if (IndianrailLocation::getLocationName($data->boarding_point->code) != '') {
                $boarding_point = IndianrailLocation::getLocationName($data->boarding_point->code);
            } else {
                $boarding_point = '';
            }
            $stdClass->boarding_point->name = $boarding_point;
            $stdClass->reservation_upto->code = $data->reservation_upto->code;
            if (IndianrailLocation::getLocationName($data->reservation_upto->code) != '') {
                $reservation_upto = IndianrailLocation::getLocationName($data->reservation_upto->code);
            } else {
                $reservation_upto = '';
            }
            $stdClass->reservation_upto->name = $reservation_upto;
            $stdClass->doj = $data->doj;
            $stdClass->class = $data->class;
            $length1 = sizeof($data->passengers);
            $stdClass->no_of_passengers = $length1;
            for ($i = 1; $i <= $length1; $i++) {
                $j = ($i - 1);
                $stdClass->passengers[$i]->sr = $i;
                $stdClass->passengers[$i]->booking_status = $data->passengers[$j]->booking_status;
                $stdClass->passengers[$i]->current_status = $data->passengers[$j]->current_status;
            }
            $stdClass->chart_prepared = $data->chart_prepared;
            return $stdClass;
        } else {
            $stdClass->response_code = 400;
            $stdClass->error = 'System Error1';
            $stdClass->pnr = $pnr;
            return $stdClass;
        }
    }

    public function etrain($pnr) {
        $path = dirname(dirname(__FILE__)) . '/../assets/scrap/IndianrailLocation.php';
        include($path);
        error_reporting(0);
//        $pnr = @$pnrCode;
        $stdClass = new stdClass();
        $stdClass->pnr = $pnr;
        $stdClass->response_code = 200;
        $data = 'pnr=' . $pnr . '&loc=html>body>table>tbody>tr>td:eq(1)>table>tbody>tr:eq(1)>td>div:eq(3)>table>tbody>tr>td:eq(2)>a';
        $url = "http://etrain.info/ajax.php?q=pnr&v=2.4.2.1";
        $ch = curl_init();
        $randomIp = sprintf("%s.%s.%s.%s", rand(1, 255), rand(1, 255), rand(1, 255), rand(1, 255));
        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("REMOTE_ADDR: $randomIp", "User-Agent:Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36"));
//    curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36');
        curl_setopt($ch, CURLOPT_REFERER, "http://etrain.info/in");
        $data = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($data);
        if (isset($data->data)) {
            $data = $data->data;
        } else {
            $stdClass->response_code = 400;
            $stdClass->error = 'System Error1';
            $stdClass->pnr = $pnr;
            return $stdClass;
//            print_r($stdClass);
            die;
        }
        $dom = new DOMDocument();
        $dom->loadHTML($data);

        $xpath = new DOMXpath($dom);
        $journeyDetail = $xpath->query("//td");
        $booking = $xpath->query("//tr[@class = 'even dborder']//td[@colspan='2']");
        $current = $xpath->query("//tr[@class = 'even dborder']//td[@colspan='3']");

        $sub = 0;


        $temp = trim($journeyDetail->item($sub + 4)->textContent);
        if (preg_match('/^\d+$/', $temp)) {
//             echo 'inte';
        } else {
            $sub++;
        }

        $stdClass->train_num = trim($journeyDetail->item($sub + 4)->textContent);
        $stdClass->train_name = trim($journeyDetail->item($sub + 10)->textContent);
        $stdClass->from_station->code = trim($journeyDetail->item($sub + 6)->textContent);
        IndianrailLocation::getLocationName($stdClass->from_station->code);

        if (IndianrailLocation::getLocationName($stdClass->from_station->code) != '') {
            $from_name = IndianrailLocation::getLocationName($stdClass->from_station->code);
        } else {
            $from_name = '';
        }
        $stdClass->from_station->name = $from_name;
        $stdClass->to_station->code = trim($journeyDetail->item($sub + 8)->textContent);
        if (IndianrailLocation::getLocationName($stdClass->to_station->code) != '') {
            $to_name = IndianrailLocation::getLocationName($stdClass->to_station->code);
        } else {
            $to_name = '';
        }
        $stdClass->to_station->name = $to_name;

        $stdClass->boarding_point->code = trim($journeyDetail->item($sub + 12)->textContent);
        if (IndianrailLocation::getLocationName($stdClass->boarding_point->code) != '') {
            $boarding_point = IndianrailLocation::getLocationName($stdClass->boarding_point->code);
        } else {
            $boarding_point = '';
        }
        $stdClass->boarding_point->name = $boarding_point;
        $stdClass->reservation_upto->code = trim($journeyDetail->item($sub + 14)->textContent);
        if (IndianrailLocation::getLocationName($stdClass->reservation_upto->code) != '') {
            $reservation_upto = IndianrailLocation::getLocationName($stdClass->reservation_upto->code);
        } else {
            $reservation_upto = '';
        }
        $stdClass->reservation_upto->name = $reservation_upto;
        $stdClass->doj = trim($journeyDetail->item($sub + 16)->textContent);
        $stdClass->doj = str_replace(' ', '', $stdClass->doj);
        $stdClass->class = trim($journeyDetail->item($sub + 18)->textContent);

        $stdClass->no_of_passengers = $length1 = $booking->length;
        $stdClass->no_of_passengers = $stdClass->no_of_passengers - 1;
        for ($i = 1; $i < $length1; $i++) {
            $x = trim($booking->item($i)->textContent);
            $y = trim($current->item(($i - 1))->textContent);
            $wor = 'Passenger ' . $i;
            $x = explode($wor, $x);
            $stdClass->passengers[$i]->sr = $i;
            $stdClass->passengers[$i]->booking_status = $x[0];
            $stdClass->passengers[$i]->current_status = $y;
        }
        $temp = $journeyDetail->length - 3;

        $chart = trim($journeyDetail->item(($temp))->textContent);


        if (strpos($chart, 'Charting Status') !== false) {
// echo 'true';
            $chart = str_replace(' ', '', $chart);
            $chart = explode('ChartingStatus:', $chart);
            if ($chart[1] == 'CHARTNOTPREPARED') {
                $stdClass->chart_prepared = 'N';
            } else if ($chart[1] == 'CHARTPREPARED') {
                $stdClass->chart_prepared = 'Y';
            }
        } else {
            $stdClass->response_code = 400;
            $stdClass->error = 'System Error1';
            $stdClass->pnr = $pnr;
        }
        return $stdClass;
//        print_r($stdClass);
        die;
    }

    public function actionMenuDesc() {
        $sql = "SELECT description,id FROM `tbl_menu` WHERE `description` NOT LIKE '%<p>%' AND `description` <>''
ORDER BY `tbl_menu`.`description`  ASC";
        $x = help::readAll($sql);
        foreach ($x as $row) {
            $id = $row['id'];
            $desc = mysql_real_escape_string('<p>' . $row['description'] . '</p>');
            $sql = "UPDATE tbl_menu SET description ='$desc' where id='$id'";
            if (help::execute($sql)) {
                echo 'true ' . $id . '<br>';
            } else {
                echo 'fail' . $id . '<br>';
            }
        }
        echo '<pre>';
//        print_r($x);
    }

}
