<?php
    header('Content-type: text/plain; charset=utf-8');

    //Get data
    $rank1_obj = json_decode($_POST['rank1_obj'], true);
    $rank2_obj = json_decode($_POST['rank2_obj'], true);
    $rank3_obj = json_decode($_POST['rank3_obj'], true);


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
    $electric_stats_list = array();
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
            // array_push($electric_stats_list, $row_details['electric_stats']);
            array_push($water_stats_list, $row_details['water_stats']);
            array_push($clean_stats_list, $row_details['clean_stats']);
            array_push($walkway_stats_list, $row_details['walkway_stats']);
            array_push($earthquake_list, $row_details['earthquake']);
            array_push($school_value_list, $row_details['school_value']);
            array_push($university_value_list, $row_details['university_value']);

            // echo json_encode($row_details, JSON_UNESCAPED_UNICODE);
        }
    } else {
        echo "0 result_details";
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
    $percent_slum_list_int = array_map(function($value) {
        return number_format($value, 3);
    },  array_values($percent_slum_list));

  
    

    //currents_price
    foreach ($currents_price_list as &$value) { //จัดการค่่า null และค่า 0
        if ($value == 0) {
            $value = 0;
        } elseif ($value == null) {
            $value = 0;
        }
    }

    // หาค่าสูงสุดใน array currents_price_list
    $max_currents_price = max($currents_price_list);

    // คำนวณค่าเปอร์เซ็นต์ของแต่ละตัวใน array โดยนำค่าสูงสุดมาเป็น 100%
    $percent_currents_price_list = array();
    foreach ($currents_price_list as $value) {
        $percent_currents_price = $value / $max_currents_price * 100;

        $percent_currents_price = 100 - $percent_currents_price; //กลับค่า % ยิ่งแพงยิ่งไม่ดี

        array_push($percent_currents_price_list, $percent_currents_price);
    }
    foreach ($percent_currents_price_list as &$value) { //Limit floating points
        $value = round($value, 3);
    }
    $percent_currents_price_list = array_combine($locations_list, $percent_currents_price_list); //รวม locations กัับ percent
    $percent_currents_price_list_int = array_map(function($value) {
        return number_format($value, 3);
    },  array_values($percent_currents_price_list));




    //pb_trans_value
    foreach ($pb_trans_value_list as &$value) { //จัดการค่่า null และค่า 0
        if ($value == 0) {
            $value = 0;
        } elseif ($value == null) {
            $value = 0;
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
    $percent_pb_trans_value_list_int = array_map(function($value) {
        return number_format($value, 3);
    },  array_values($percent_pb_trans_value_list));



    //future_price
    // foreach ($future_price_list as &$value) { //จัดการค่่า null และค่า 0
    //     if ($value == 0) {
    //         $value = 0;
    //     } elseif ($value == null) {
    //         $value = 0;
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
    // $percent_future_price_list_int = array_map(function($value) {
    //     return number_format($value, 3);
    // },  array_values($percent_future_price_list));




    //travel_conven
    // foreach ($travel_conven_list as &$value) { //จัดการค่่า null และค่า 0
    //     if ($value == 0) {
    //         $value = 0;
    //     } elseif ($value == null) {
    //         $value = 0;
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
    // $percent_travel_conven_list_int = array_map(function($value) {
    //     return number_format($value, 3);
    // },  array_values($percent_travel_conven_list));





    //restaurant_value
    foreach ($restaurant_value_list as &$value) { //จัดการค่่า null และค่า 0
        if ($value == 0) {
            $value = 0;
        } elseif ($value == null) {
            $value = 0;
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
    $percent_restaurant_value_list_int = array_map(function($value) {
        return number_format($value, 3);
    },  array_values($percent_restaurant_value_list));






    //electric_stats
    // foreach ($electric_stats_list as &$value) { //จัดการค่่า null และค่า 0
    //     if ($value == 0) {
    //         $value = 0;
    //     } elseif ($value == null) {
    //         $value = 0;
    //     }
    // }

    // $max_electric_stats = max($electric_stats_list);

    // // คำนวณค่าเปอร์เซ็นต์ของแต่ละตัวใน array โดยนำค่าสูงสุดมาเป็น 100%
    // $percent_electric_stats_list = array();
    // foreach ($electric_stats_list as $value) {
    //     $percent_electric_stats = $value / $max_electric_stats * 100;
    //     array_push($percent_electric_stats_list, $percent_electric_stats);
    // }
    // foreach ($percent_electric_stats_list as &$value) { //Limit floating points
    //     $value = round($value, 3);
    // }
    // $percent_electric_stats_list = array_combine($locations_list, $percent_electric_stats_list); //รวม locations กัับ percent
    // $percent_electric_stats_list_int = array_map(function($value) {
    //     return number_format($value, 3);
    // },  array_values($percent_electric_stats_list));    




    // //water_stats
    foreach ($water_stats_list as &$value) { //จัดการค่่า null และค่า 0
        if ($value == 0) {
            $value = 0;
        } elseif ($value == null) {
            $value = 0;
        }
    }

    $max_water_stats = max($water_stats_list);

    // คำนวณค่าเปอร์เซ็นต์ของแต่ละตัวใน array โดยนำค่าสูงสุดมาเป็น 100%
    $percent_water_stats_list = array();
    foreach ($water_stats_list as $value) {
        $percent_water_stats = $value / $max_water_stats * 100;

        $percent_water_stats = 100 - $percent_water_stats; //กลับค่า % ยิ่งปัญหาน้ำเยอะยิ่งไม่ดี

        array_push($percent_water_stats_list, $percent_water_stats);
    }
    foreach ($percent_water_stats_list as &$value) { //Limit floating points
        $value = round($value, 3);
    }
    $percent_water_stats_list = array_combine($locations_list, $percent_water_stats_list); //รวม locations กัับ percent
    $percent_water_stats_list_int = array_map(function($value) {
        return number_format($value, 3);
    },  array_values($percent_water_stats_list));




    //clean_stats
    foreach ($clean_stats_list as &$value) { //จัดการค่่า null และค่า 0
        if ($value == 0) {
            $value = 0;
        } elseif ($value == null) {
            $value = 0;
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
    $percent_clean_stats_list_int = array_map(function($value) {
        return number_format($value, 3);
    },  array_values($percent_clean_stats_list));




    //walkway_stats
    foreach ($walkway_stats_list as &$value) { //จัดการค่่า null และค่า 0
        if ($value == 0) {
            $value = 0;
        } elseif ($value == null) {
            $value = 0;
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
    $percent_walkway_stats_list_int = array_map(function($value) {
        return number_format($value, 3);
    },  array_values($percent_walkway_stats_list));




    //earthquake
    foreach ($earthquake_list as &$value) { //จัดการค่่า null และค่า 0
        if ($value == 0) {
            $value = 0;
        } elseif ($value == null) {
            $value = 0;
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
    $percent_earthquake_list_int = array_map(function($value) {
        return number_format($value, 3);
    },  array_values($percent_earthquake_list));



    //school_value
    foreach ($school_value_list as &$value) { //จัดการค่่า null และค่า 0
        if ($value == 0) {
            $value = 0;
        } elseif ($value == null) {
            $value = 0;
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
    $percent_school_value_list_int = array_map(function($value) {
        return number_format($value, 3);
    },  array_values($percent_school_value_list));




    //university_value
    foreach ($university_value_list as &$value) { //จัดการค่่า null และค่า 0
        if ($value == 0) {
            $value = 0;
        } elseif ($value == null) {
            $value = 0;
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
    $percent_university_value_list_int = array_map(function($value) {
        return number_format($value, 3);
    },  array_values($percent_university_value_list));
  
  
  
  
  
  
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    // Get table city_details
    $sql_city_details = "SELECT * FROM city_details ORDER BY `city_details`.`name` ASC LIMIT 1000";
    $result_city_details = mysqli_query($conn, $sql_city_details);

    //create lists for column in city_details
    $name_list = array();
    $airport_status_list = array();
    $temp_avg_list = array();
    $sea_status_list = array();
    $flood_stats_list = array();
    $tourist_stats_list = array();
    $employment_stats_list = array();
    $citizen_income_avg_list = array();

    if ($result_city_details && mysqli_num_rows($result_city_details) > 0) {
        // output data of each row
        while($row_city_details = mysqli_fetch_assoc($result_city_details)) {
            array_push($name_list, $row_city_details['name']);
            array_push($airport_status_list, $row_city_details['airport_status']);
            array_push($temp_avg_list, $row_city_details['temp_avg']);
            array_push($sea_status_list, $row_city_details['sea_status']);
            // array_push($flood_stats_list, $row_city_details['flood_stats']);
            // array_push($tourist_stats_list, $row_city_details['tourist_stats']);
            // array_push($employment_stats_list, $row_city_details['employment_stats']);
            array_push($citizen_income_avg_list, $row_city_details['citizen_income_avg']);

            // echo json_encode($row_city_details, JSON_UNESCAPED_UNICODE);

        }
    } else {
        echo "0 result_city_details";
    }



    //คำนวณทุก column ที่มีให้เป็น % โดย locations ที่ column ที่มากที่สุดเป็น 100%

    // details column to %

    //airport_status
    foreach ($airport_status_list as &$value) { //จัดการค่่า null และค่า 0
        if ($value == 0) {
            $value = 0;
        } elseif ($value == null) {
            $value = 0;
        }
    }

    $max_airport_status = max($airport_status_list);

    // คำนวณค่าเปอร์เซ็นต์ของแต่ละตัวใน array โดยนำค่าสูงสุดมาเป็น 100%
    $percent_airport_status_list = array();
    foreach ($airport_status_list as $value) {
        $percent_airport_status = $value / $max_airport_status * 100;
        array_push($percent_airport_status_list, $percent_airport_status);
    }
    foreach ($percent_airport_status_list as &$value) { //Limit floating points
        $value = round($value, 3);
    }
    $percent_airport_status_list = array_combine($name_list, $percent_airport_status_list); //รวม locations กัับ percent  
    $percent_airport_status_list_int = array_map(function($value) {
        return number_format($value, 3);
    },  array_values($percent_airport_status_list));





    //temp_avg
    foreach ($temp_avg_list as &$value) { //จัดการค่่า null และค่า 0
        if ($value == 0) {
            $value = 0;
        } elseif ($value == null) {
            $value = 0;
        }
    }

    $max_temp_avg = max($temp_avg_list);

    // คำนวณค่าเปอร์เซ็นต์ของแต่ละตัวใน array โดยนำค่าสูงสุดมาเป็น 100%
    $percent_temp_avg_list = array();
    foreach ($temp_avg_list as $value) {
        $percent_temp_avg = $value / $max_temp_avg * 100;

        $percent_temp_avg = 100 - $percent_temp_avg; //กลับค่า % ยิ่งอากาศเย็นยิ่งดี

        array_push($percent_temp_avg_list, $percent_temp_avg);
    }
    foreach ($percent_temp_avg_list as &$value) { //Limit floating points
        $value = round($value, 3);
    }
    $percent_temp_avg_list = array_combine($name_list, $percent_temp_avg_list); //รวม locations กัับ percent  
    $percent_temp_avg_list_int = array_map(function($value) {
        return number_format($value, 3);
    },  array_values($percent_temp_avg_list));



    //sea_status
    foreach ($sea_status_list as &$value) { //จัดการค่่า null และค่า 0
        if ($value == 0) {
            $value = 0;
        } elseif ($value == null) {
            $value = 0;
        }
    }

    $max_sea_status = max($sea_status_list);

    // คำนวณค่าเปอร์เซ็นต์ของแต่ละตัวใน array โดยนำค่าสูงสุดมาเป็น 100%
    $percent_sea_status_list = array();
    foreach ($sea_status_list as $value) {
        $percent_sea_status = $value / $max_sea_status * 100;
        array_push($percent_sea_status_list, $percent_sea_status);
    }
    foreach ($percent_sea_status_list as &$value) { //Limit floating points
        $value = round($value, 3);
    }
    $percent_sea_status_list = array_combine($name_list, $percent_sea_status_list); //รวม locations กัับ percent
    $percent_sea_status_list_int = array_map(function($value) {
        return number_format($value, 3);
    },  array_values($percent_sea_status_list));




    // //flood_stats
    // foreach ($flood_stats_list as &$value) { //จัดการค่่า null และค่า 0
    //     if ($value == 0) {
    //         $value = 0;
    //     } elseif ($value == null) {
    //         $value = 0;
    //     }
    // }

    // $max_flood_stats = max($flood_stats_list);

    // // คำนวณค่าเปอร์เซ็นต์ของแต่ละตัวใน array โดยนำค่าสูงสุดมาเป็น 100%
    // $percent_flood_stats_list = array();
    // foreach ($flood_stats_list as $value) {
    //     $percent_flood_stats = $value / $max_flood_stats * 100;
    //     array_push($percent_flood_stats_list, $percent_flood_stats);
    // }
    // foreach ($percent_flood_stats_list as &$value) { //Limit floating points
    //     $value = round($value, 3);
    // }
    // $percent_flood_stats_list = array_combine($name_list, $percent_flood_stats_list); //รวม locations กัับ percent
    // $percent_flood_stats_list_int = array_map(function($value) {
    //     return number_format($value, 3);
    // },  array_values($percent_flood_stats_list));




    // //tourist_stats
    // foreach ($tourist_stats_list as &$value) { //จัดการค่่า null และค่า 0
    //     if ($value == 0) {
    //         $value = 0;
    //     } elseif ($value == null) {
    //         $value = 0;
    //     }
    // }

    // $max_tourist_stats = max($tourist_stats_list);

    // // คำนวณค่าเปอร์เซ็นต์ของแต่ละตัวใน array โดยนำค่าสูงสุดมาเป็น 100%
    // $percent_tourist_stats = array();
    // foreach ($tourist_stats_list as $value) {
    //     $percent_tourist_stats = $value / $max_tourist_stats * 100;
    //     array_push($percent_tourist_stats_list, $percent_tourist_stats);
    // }
    // foreach ($percent_tourist_stats_list as &$value) { //Limit floating points
    //     $value = round($value, 3);
    // }
    // $percent_tourist_stats_list = array_combine($name_list, $percent_tourist_stats_list); //รวม locations กัับ percent
    // $percent_tourist_stats_list_int = array_map(function($value) {
    //     return number_format($value, 3);
    // },  array_values($percent_tourist_stats_list));




    // //employment_stats
    // foreach ($employment_stats_list as &$value) { //จัดการค่่า null และค่า 0
    //     if ($value == 0) {
    //         $value = 0;
    //     } elseif ($value == null) {
    //         $value = 0;
    //     }
    // }

    // $max_employment_stats = max($employment_stats_list);

    // // คำนวณค่าเปอร์เซ็นต์ของแต่ละตัวใน array โดยนำค่าสูงสุดมาเป็น 100%
    // $percent_employment_stats_list = array();
    // foreach ($employment_stats_list as $value) {
    //     $percent_employment_stats = $value / $max_employment_stats * 100;
    //     array_push($percent_employment_stats_list, $percent_employment_stats);
    // }
    // foreach ($percent_employment_stats_list as &$value) { //Limit floating points
    //     $value = round($value, 3);
    // }
    // $percent_employment_stats_list = array_combine($name_list, $percent_employment_stats_list); //รวม locations กัับ percent
    // $percent_employment_stats_list_int = array_map(function($value) {
    //     return number_format($value, 3);
    // },  array_values($percent_employment_stats_list));




    //citizen_income_avg
    foreach ($citizen_income_avg_list as &$value) { //จัดการค่่า null และค่า 0
        if ($value == 0) {
            $value = 0;
        } elseif ($value == null) {
            $value = 0;
        }
    }

    $max_citizen_income_avg = max($citizen_income_avg_list);

    // คำนวณค่าเปอร์เซ็นต์ของแต่ละตัวใน array โดยนำค่าสูงสุดมาเป็น 100%
    $percent_citizen_income_avg_list = array();
    foreach ($citizen_income_avg_list as $value) {
        $percent_citizen_income_avg = $value / $max_citizen_income_avg * 100;
        array_push($percent_citizen_income_avg_list, $percent_citizen_income_avg);
    }
    foreach ($percent_citizen_income_avg_list as &$value) { //Limit floating points
        $value = round($value, 3);
    }
    $percent_citizen_income_avg_list = array_combine($name_list, $percent_citizen_income_avg_list); //รวม locations กัับ percent
    $percent_citizen_income_avg_list_int = array_map(function($value) {
        return number_format($value, 3);
    },  array_values($percent_citizen_income_avg_list));


    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    // RANK1_________________
    if (!empty($rank1_obj)) {
        $rank1_obj_select = array();
        $map_obj = array(
            'slum' => $percent_slum_list_int,
            'pb_trans_value' => $percent_pb_trans_value_list_int,
            'restaurant_value' => $percent_restaurant_value_list_int,
        );

        foreach ($rank1_obj as $char) {
            array_push($rank1_obj_select, $map_obj[$char]);
        }

        $locations_percent_sum_rank1 = array_reduce($rank1_obj_select, function ($carry, $arr) {
            return array_map(function ($rank1_obj, $rank1_obj_select) {
                return $rank1_obj + $rank1_obj_select;
            }, $carry, $arr);
        }, array_fill(0, count($rank1_obj_select), 0));

        $locations_percent_max_percent = max($locations_percent_sum_rank1); // หาค่าสูงสุดใน array
        $percent_sum = 0;
        foreach ($locations_percent_sum_rank1 as &$value) {
            $value = round($value / $locations_percent_max_percent * 100, 3); // คำนวณค่าเปอร์เซ็นต์และเปลี่ยนเป็นทศนิยม 3 ตำแหน่ง
            $percent_sum += $value; // บวกเพื่อหาผลรวมของเปอร์เซ็นต์ทั้งหมด
            $value = round($value * 10, 3); // Rank 1 * 10
        }
        // locations_percent_sum_rank1  RANK1 result
    }


    // RANK2_________________
    if (!empty($rank2_obj)) {
        $rank2_obj_select = array();
        $map_obj = array(
            'slum' => $percent_slum_list_int,
            'pb_trans_value' => $percent_pb_trans_value_list_int,
            'restaurant_value' => $percent_restaurant_value_list_int,
        );

        foreach ($rank2_obj as $char) {
            array_push($rank2_obj_select, $map_obj[$char]);
        }

        $locations_percent_sum_rank2 = array_reduce($rank2_obj_select, function ($carry, $arr) {
            return array_map(function ($rank2_obj, $rank2_obj_select) {
                return $rank2_obj + $rank2_obj_select;
            }, $carry, $arr);
        }, array_fill(0, count($rank2_obj_select), 0));

        $locations_percent_max_percent = max($locations_percent_sum_rank2); // หาค่าสูงสุดใน array
        $percent_sum = 0;
        foreach ($locations_percent_sum_rank2 as &$value) {
            $value = round($value / $locations_percent_max_percent * 100, 3); // คำนวณค่าเปอร์เซ็นต์และเปลี่ยนเป็นทศนิยม 3 ตำแหน่ง
            $percent_sum += $value; // บวกเพื่อหาผลรวมของเปอร์เซ็นต์ทั้งหมด
            $value = round($value * 6, 3); // Rank 2 * 6
        }
        // locations_percent_sum_rank2  RANK2 result
    }


    // RANK3_________________
    if (!empty($rank3_obj)) {
        $rank3_obj_select = array();
        $map_obj = array(
            'slum' => $percent_slum_list_int,
            'pb_trans_value' => $percent_pb_trans_value_list_int,
            'restaurant_value' => $percent_restaurant_value_list_int,
        );

        foreach ($rank3_obj as $char) {
            array_push($rank3_obj_select, $map_obj[$char]);
        }

        $locations_percent_sum_rank3 = array_reduce($rank3_obj_select, function ($carry, $arr) {
            return array_map(function ($rank3_obj, $rank3_obj_select) {
                return $rank3_obj + $rank3_obj_select;
            }, $carry, $arr);
        }, array_fill(0, count($rank3_obj_select), 0));

        $locations_percent_max_percent = max($locations_percent_sum_rank3); // หาค่าสูงสุดใน array
        $percent_sum = 0;
        foreach ($locations_percent_sum_rank3 as &$value) {
            $value = round($value / $locations_percent_max_percent * 100, 3); // คำนวณค่าเปอร์เซ็นต์และเปลี่ยนเป็นทศนิยม 3 ตำแหน่ง
            $percent_sum += $value; // บวกเพื่อหาผลรวมของเปอร์เซ็นต์ทั้งหมด
            $value = round($value * 3, 3); // Rank 3 * 3
        }
        // locations_percent_sum_rank3  RANK3 result
    }


    //RESULT+++++++++++++++++++++++++++++++++++++++++++++
    if (empty($rank1_obj)) {
        if (empty($rank2_obj)) {
            if (empty($rank3_obj)) {
                print('Noting'); // 0 0 0
            }
        }
    }
    if (!empty($rank1_obj)) {
        if (!empty($rank2_obj)) {
            if (!empty($rank3_obj)) {
            $result_sum_locations = array_map(function($a, $b, $c) {
                return array_sum([$a, $b, $c]);
            }, $locations_percent_sum_rank1, $locations_percent_sum_rank2, $locations_percent_sum_rank3);
            $max_value = max($result_sum_locations);
            $result_sum_locations = array_map(function($value) use ($max_value) {
                return ($value / $max_value) * 100;
            }, $result_sum_locations);
            
            print_r($result_sum_locations); // 1 1 1
            }
            else {
                $result_sum_locations = array_map(function($a, $b) {
                    return array_sum([$a, $b]);
                }, $locations_percent_sum_rank1, $locations_percent_sum_rank2);
                $max_value = max($result_sum_locations);
                $result_sum_locations = array_map(function($value) use ($max_value) {
                    return ($value / $max_value) * 100;
                }, $result_sum_locations);
                
                print_r($result_sum_locations); // 1 1 0
            }
        }
        elseif (!empty($rank3_obj)) {
            $result_sum_locations = array_map(function($a, $c) {
                return array_sum([$a, $c]);
            }, $locations_percent_sum_rank1, $locations_percent_sum_rank3);
            $max_value = max($result_sum_locations);
            $result_sum_locations = array_map(function($value) use ($max_value) {
                return ($value / $max_value) * 100;
            }, $result_sum_locations);
            
            print_r($result_sum_locations); // 1 0 1
        }
        else {
            $result_sum_locations = array_map(function($a) {
                return array_sum([$a]);
            }, $locations_percent_sum_rank1);
            $max_value = max($result_sum_locations);
            $result_sum_locations = array_map(function($value) use ($max_value) {
                return ($value / $max_value) * 100;
            }, $result_sum_locations);
            
            print_r($result_sum_locations); // 1 0 0
        }
    }
    elseif (!empty($rank2_obj)) {
        if (!empty($rank3_obj)) {
            $result_sum_locations = array_map(function($b, $c) {
                return array_sum([$b, $c]);
            }, $locations_percent_sum_rank2, $locations_percent_sum_rank3);
            $max_value = max($result_sum_locations);
            $result_sum_locations = array_map(function($value) use ($max_value) {
                return ($value / $max_value) * 100;
            }, $result_sum_locations);
            
            print_r($result_sum_locations); // 0 1 1
        }
        else {
            $result_sum_locations = array_map(function($b) {
                return array_sum([$b]);
            }, $locations_percent_sum_rank2);
            $max_value = max($result_sum_locations);
            $result_sum_locations = array_map(function($value) use ($max_value) {
                return ($value / $max_value) * 100;
            }, $result_sum_locations);
            
            print_r($result_sum_locations); // 0 1 0
        }
    }
    else {
        if (!empty($rank3_obj)) {
            $result_sum_locations = array_map(function($c) {
                return array_sum([$c]);
            }, $locations_percent_sum_rank3);
            $max_value = max($result_sum_locations);
            $result_sum_locations = array_map(function($value) use ($max_value) {
                return ($value / $max_value) * 100;
            }, $result_sum_locations);
            
            print_r($result_sum_locations); // 0 0 1
        }
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