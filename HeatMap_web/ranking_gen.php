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
    

    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    //Get table details
    $sql_details = "SELECT * FROM details ORDER BY `details`.`locations` ASC LIMIT 1000";
    $result_details = mysqli_query($conn, $sql_details);

    //create lists for column in details
    $locations_list = array();
    $slum_list = array();
    $currents_price_list = array();
    $pb_trans_value_list = array();
    $future_price_list = array();
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
            // array_push($future_price_lsit, $row_details['future_price']);
            // array_push($travel_conven_list, $row_details['travel_conven']);
            array_push($restaurant_value_list, $row_details['restaurant_value']);
            // array_push($elctric_stats_list, $row_details['elctric_stats']);
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
    $percent_slum_list = array_combine($locations_list, $percent_slum_list); //รวม locations กัับ percent


    //currents_price
    foreach ($currents_price_list as &$value) { //จัดการค่่า null และค่า 0
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
    $percent_currents_price_list = array_combine($locations_list, $percent_currents_price_list); //รวม locations กัับ percent


    //pb_trans_value
    foreach ($pb_trans_value_list as &$value) { //จัดการค่่า null และค่า 0
        if ($value == 0) {
            $value = -1;
        } elseif ($value == null) {
            $value = -1;
        }
    }

    $max_pb_trans_value = max($pb_trans_value_list);

    // คำนวณค่าเปอร์เซ็นต์ของแต่ละตัวใน array โดยนำค่าสูงสุดมาเป็น 100%
    $percent_pb_trans_value_list = array();
    foreach ($pb_trans_value_list as $value) {
        $percent_pb_trans_value = $value / $max_pb_trans_value * 100;
        array_push($percent_pb_trans_value_list, $percent_pb_trans_value);
    }
    foreach ($percent_pb_trans_value_list as &$value) { //Limit floating points
        $value = round($value, 3);
    }
    $percent_pb_trans_value_list = array_combine($locations_list, $percent_pb_trans_value_list); //รวม locations กัับ percent



    //future_price
    // foreach ($future_price_list as &$value) { //จัดการค่่า null และค่า 0
    //     if ($value == 0) {
    //         $value = -1;
    //     } elseif ($value == null) {
    //         $value = -1;
    //     }
    // }print_r($future_price_list)

    // $max_future_price = max($future_price_list);

    // // คำนวณค่าเปอร์เซ็นต์ของแต่ละตัวใน array โดยนำค่าสูงสุดมาเป็น 100%
    // $percent_future_price_list = array();
    // foreach ($future_price_list as $value) {
    //     $percent_future_price = $value / $max_future_price * 100;
    //     array_push($percent_future_price_list, $percent_future_price);
    // }
    // foreach ($percent_future_price_list as &$value) { //Limit floating points
    //     $value = round($value, 3);
    // }
    // $percent_future_price_list = array_combine($locations_list, $percent_future_price_list); //รวม locations กัับ percent




    //travel_conven
    // foreach ($travel_conven_list as &$value) { //จัดการค่่า null และค่า 0
    //     if ($value == 0) {
    //         $value = -1;
    //     } elseif ($value == null) {
    //         $value = -1;
    //     }
    // }

    // $max_travel_conven = max($travel_conven_list);

    // // คำนวณค่าเปอร์เซ็นต์ของแต่ละตัวใน array โดยนำค่าสูงสุดมาเป็น 100%
    // $percent_travel_conven_list = array();
    // foreach ($travel_conven_list as $value) {
    //     $percent_travel_conven = $value / $max_travel_conven * 100;
    //     array_push($percent_travel_conven_list, $percent_travel_conven);
    // }
    // foreach ($percent_travel_conven_list as &$value) { //Limit floating points
    //     $value = round($value, 3);
    // }
    // $percent_travel_conven_list = array_combine($locations_list, $percent_travel_conven_list); //รวม locations กัับ percent




    //restaurant_value
    foreach ($restaurant_value_list as &$value) { //จัดการค่่า null และค่า 0
        if ($value == 0) {
            $value = -1;
        } elseif ($value == null) {
            $value = -1;
        }
    }

    $max_restaurant_value = max($restaurant_value_list);

    // คำนวณค่าเปอร์เซ็นต์ของแต่ละตัวใน array โดยนำค่าสูงสุดมาเป็น 100%
    $percent_restaurant_value_list = array();
    foreach ($restaurant_value_list as $value) {
        $percent_restaurant_value = $value / $max_restaurant_value * 100;
        array_push($percent_restaurant_value_list, $percent_restaurant_value);
    }
    foreach ($percent_restaurant_value_list as &$value) { //Limit floating points
        $value = round($value, 3);
    }
    $percent_restaurant_value_list = array_combine($locations_list, $percent_restaurant_value_list); //รวม locations กัับ percent





    //elctric_stats
    // foreach ($elctric_stats_list as &$value) { //จัดการค่่า null และค่า 0
    //     if ($value == 0) {
    //         $value = -1;
    //     } elseif ($value == null) {
    //         $value = -1;
    //     }
    // }

    // $max_elctric_stats = max($elctric_stats_list);

    // // คำนวณค่าเปอร์เซ็นต์ของแต่ละตัวใน array โดยนำค่าสูงสุดมาเป็น 100%
    // $percent_elctric_stats_list = array();
    // foreach ($elctric_stats_list as $value) {
    //     $percent_elctric_stats = $value / $max_elctric_stats * 100;
    //     array_push($percent_elctric_stats_list, $percent_elctric_stats);
    // }
    // foreach ($percent_elctric_stats_list as &$value) { //Limit floating points
    //     $value = round($value, 3);
    // }
    // $percent_elctric_stats_list = array_combine($locations_list, $percent_elctric_stats_list); //รวม locations กัับ percent



    // //water_stats
    foreach ($water_stats_list as &$value) { //จัดการค่่า null และค่า 0
        if ($value == 0) {
            $value = -1;
        } elseif ($value == null) {
            $value = -1;
        }
    }

    $max_water_stats = max($water_stats_list);

    // คำนวณค่าเปอร์เซ็นต์ของแต่ละตัวใน array โดยนำค่าสูงสุดมาเป็น 100%
    $percent_water_stats_list = array();
    foreach ($water_stats_list as $value) {
        $percent_water_stats = $value / $max_water_stats * 100;
        array_push($percent_water_stats_list, $percent_water_stats);
    }
    foreach ($percent_water_stats_list as &$value) { //Limit floating points
        $value = round($value, 3);
    }
    $percent_water_stats_list = array_combine($locations_list, $percent_water_stats_list); //รวม locations กัับ percent




    //clean_stats
    foreach ($clean_stats_list as &$value) { //จัดการค่่า null และค่า 0
        if ($value == 0) {
            $value = -1;
        } elseif ($value == null) {
            $value = -1;
        }
    }

    $max_clean_stats = max($clean_stats_list);

    // คำนวณค่าเปอร์เซ็นต์ของแต่ละตัวใน array โดยนำค่าสูงสุดมาเป็น 100%
    $percent_clean_stats_list = array();
    foreach ($clean_stats_list as $value) {
        $percent_clean_stats = $value / $max_clean_stats * 100;
        array_push($percent_clean_stats_list, $percent_clean_stats);
    }
    foreach ($percent_clean_stats_list as &$value) { //Limit floating points
        $value = round($value, 3);
    }
    $percent_clean_stats_list = array_combine($locations_list, $percent_clean_stats_list); //รวม locations กัับ percent




    //walkway_stats
    foreach ($walkway_stats_list as &$value) { //จัดการค่่า null และค่า 0
        if ($value == 0) {
            $value = -1;
        } elseif ($value == null) {
            $value = -1;
        }
    }

    $max_walkway_stats = max($walkway_stats_list);

    // คำนวณค่าเปอร์เซ็นต์ของแต่ละตัวใน array โดยนำค่าสูงสุดมาเป็น 100%
    $percent_walkway_stats_list = array();
    foreach ($walkway_stats_list as $value) {
        $percent_walkway_stats = $value / $max_walkway_stats * 100;
        array_push($percent_walkway_stats_list, $percent_walkway_stats);
    }
    foreach ($percent_walkway_stats_list as &$value) { //Limit floating points
        $value = round($value, 3);
    }
    $percent_walkway_stats_list = array_combine($locations_list, $percent_walkway_stats_list); //รวม locations กัับ percent



    //earthquake
    foreach ($earthquake_list as &$value) { //จัดการค่่า null และค่า 0
        if ($value == 0) {
            $value = -1;
        } elseif ($value == null) {
            $value = -1;
        }
    }

    $max_earthquake = max($earthquake_list);

    // คำนวณค่าเปอร์เซ็นต์ของแต่ละตัวใน array โดยนำค่าสูงสุดมาเป็น 100%
    $percent_earthquake_list = array();
    foreach ($earthquake_list as $value) {
        $percent_earthquake = $value / $max_earthquake * 100;
        array_push($percent_earthquake_list, $percent_earthquake);
    }
    foreach ($percent_earthquake_list as &$value) { //Limit floating points
        $value = round($value, 3);
    }
    $percent_earthquake_list = array_combine($locations_list, $percent_earthquake_list); //รวม locations กัับ percent



    //school_value
    foreach ($school_value_list as &$value) { //จัดการค่่า null และค่า 0
        if ($value == 0) {
            $value = -1;
        } elseif ($value == null) {
            $value = -1;
        }
    }

    $max_school_value = max($school_value_list);

    // คำนวณค่าเปอร์เซ็นต์ของแต่ละตัวใน array โดยนำค่าสูงสุดมาเป็น 100%
    $percent_school_value_list = array();
    foreach ($school_value_list as $value) {
        $percent_school_value = $value / $max_school_value * 100;
        array_push($percent_school_value_list, $percent_school_value);
    }
    foreach ($percent_school_value_list as &$value) { //Limit floating points
        $value = round($value, 3);
    }
    $percent_school_value_list = array_combine($locations_list, $percent_school_value_list); //รวม locations กัับ percent




    //university_value
    foreach ($university_value_list as &$value) { //จัดการค่่า null และค่า 0
        if ($value == 0) {
            $value = -1;
        } elseif ($value == null) {
            $value = -1;
        }
    }

    $max_university_value = max($university_value_list);

    // คำนวณค่าเปอร์เซ็นต์ของแต่ละตัวใน array โดยนำค่าสูงสุดมาเป็น 100%
    $percent_university_value_list = array();
    foreach ($university_value_list as $value) {
        $percent_university_value = $value / $max_university_value * 100;
        array_push($percent_university_value_list, $percent_university_value);
    }
    foreach ($percent_university_value_list as &$value) { //Limit floating points
        $value = round($value, 3);
    }
    $percent_university_value_list = array_combine($locations_list, $percent_university_value_list); //รวม locations กัับ percent

  
  
  
  
  
  
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    // Get table city_details
    $sql_city_details = "SELECT * FROM city_details ORDER BY `city_details`.`name` ASC LIMIT 5";
    $result_city_details = mysqli_query($conn, $sql_city_details);

    if ($result_city_details && mysqli_num_rows($result_city_details) > 0) {
        // output data of each row
        while($row_city_details = mysqli_fetch_assoc($result_city_details)) {
            // echo json_encode($row_city_details, JSON_UNESCAPED_UNICODE);

        }
    } else {
        echo "0 result_city_details";
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