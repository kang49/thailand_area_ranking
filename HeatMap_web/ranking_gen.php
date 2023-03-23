<?php
    header('Content-type: text/plain; charset=utf-8');

    //Get data
    $rank1_obj = $_POST['rank1_obj'];
    $rank2_obj = $_POST['rank2_obj'];
    $rank3_obj = $_POST['rank3_obj'];

    // if ($rank1_obj != null){
    //     echo 'Received obj1: ' . $rank1_obj;
    // }
    // if ($rank2_obj != null){
    //     echo 'Received obj2: ' . $rank2_obj;
    // }
    // if ($rank3_obj != null){
    //     echo 'Received obj3: ' . $rank3_obj;
    // }

    $servername = "g49server.ddns.net"; // Replace with your server name
    $username = "tsm_public"; // Replace with your MySQL username
    $password = ""; // Replace with your MySQL password
    $dbname = "bk_opnsrc_hac"; // Replace with your MySQL database name
    $port = "3306";

    $conn = mysqli_connect($servername, $username, $password, $dbname, $port);
    mysqli_set_charset($conn, "utf8");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Log the connection information
    $log_data = "Connected to MySQL database on $servername:$port as $username\n";

    // Set character set
    mysqli_query($conn, "SET NAMES 'utf8'");

    //Get table details
    $sql_details = "SELECT * FROM details LIMIT 1000";
    $result_details = mysqli_query($conn, $sql_details);

    //create lists for column in details
    $locations_list = array();
    $slum_list = array();
    $currents_price_list = array();
    $pb_trans_value_list = array();
    $future_price_lsit = array();
    $travel_conven_list = array();
    $restaurant_value_list = array();
    $elctric_stats_list = array();
    $water_stats_list = array();
    $clean_stats_list = array();
    $walkway_stats_list = array();
    $earthquake_list = array();
    $school_value_list = array();
    $university_value_list = array();

    if ($result_details && mysqli_num_rows($result_details) > 0) {
        // output data of each row
        while($row_details = mysqli_fetch_assoc($result_details)) {
            array_push($locations_list, $row_details['locations']);
            array_push($slum_list, $row_details['slum']);
            array_push($currents_price_list, $row_details['currents_price']);
            array_push($pb_trans_value_list, $row_details['pb_trans_value']);
            array_push($future_price_lsit, $row_details['future_price']);
            array_push($travel_conven_list, $row_details['travel_conven']);
            array_push($restaurant_value_list, $row_details['restaurant_value']);
            array_push($elctric_stats_list, $row_details['elctric_stats']);
            array_push($water_stats_list, $row_details['water_stats']);
            array_push($clean_stats_list, $row_details['clean_stats']);
            array_push($walkway_stats_list, $row_details['walkway_stats']);
            array_push($earthquake_list, $row_details['earthquake']);
            array_push($school_value_list, $row_details['school_value']);
            array_push($university_value_list, $row_details['university_value']);

            // echo json_encode($row_details, JSON_UNESCAPED_UNICODE);
        }
    } else {
        // echo "0 result_details";
    }



    // Get table city_details
    $sql_city_details = "SELECT * FROM city_details LIMIT 5";
    $result_city_details = mysqli_query($conn, $sql_city_details);

    if ($result_city_details && mysqli_num_rows($result_city_details) > 0) {
        // output data of each row
        while($row_city_details = mysqli_fetch_assoc($result_city_details)) {
            // echo json_encode($row_city_details, JSON_UNESCAPED_UNICODE);

        }
    } else {
        echo "0 result_city_details";
    }


    //คำนวณทุก column ที่มีให้เป็น % โดย locations ที่ column ที่มากที่สุดเป็น 100%

    // details column to %

    //slum
    foreach ($slum_list as &$value) { //กลับค่า slum ยิ่งเยอะยิ่งไม่ดี
        if ($value == 0) {
            $value = 100;
        } else {
            $value = 2;
        }
    }
    // หาค่าสูงสุดใน array slum_list
    $max_slum = max($slum_list);

    // คำนวณค่าเปอร์เซ็นต์ของแต่ละตัวใน array โดยนำค่าสูงสุดมาเป็น 100%
    $percent_slum_list = array();
    foreach ($slum_list as $value) {
        $percent_slum = $value / $max_slum * 100;
        array_push($percent_slum_list, $percent_slum);
    }
    foreach ($percent_slum_list as &$value) { //Limit floating points
        $value = round($value, 3);
    }


    //currents_price
    foreach ($currents_price_list as &$value) { //กลับค่า slum ยิ่งเยอะยิ่งไม่ดี
        if ($value == 0) {
            $value = -1;
        } elseif ($value == null) {
            $value = -1;
        }
    }

    // หาค่าสูงสุดใน array currents_price_list
    $max_currents_price = max($currents_price_list);

    // คำนวณค่าเปอร์เซ็นต์ของแต่ละตัวใน array โดยนำค่าสูงสุดมาเป็น 100%
    $percent_currents_price_list = array();
    foreach ($currents_price_list as $value) {
        $percent_currents_price = $value / $max_currents_price * 100;
        array_push($percent_currents_price_list, $percent_currents_price);
    }
    foreach ($percent_currents_price_list as &$value) { //Limit floating points
        $value = round($value, 3);
    }


    // if (mysqli_num_rows($result_details) > 0) {
    //     // output data of each row
    //     while($row = mysqli_fetch_assoc($result_details)) {
    //         array_push($arlocations,array(
    //             $row['locations'],$row['restaurant_value']
    //         ));
    //     }
    // } else {
    //     echo "0 result_detailss";
    // }

    // echo json_encode($arlocations);
?>