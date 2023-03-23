<?php
    //Get data
    $rank1_obj = $_POST['rank1_obj'];
    $rank2_obj = $_POST['rank2_obj'];
    $rank3_obj = $_POST['rank3_obj'];

    if ($rank1_obj != null){
        echo 'Received obj1: ' . $rank1_obj;
    }
    if ($rank2_obj != null){
        echo 'Received obj2: ' . $rank2_obj;
    }
    if ($rank3_obj != null){
        echo 'Received obj3: ' . $rank3_obj;
    }

    // $servername = "g49server.ddns.net"; // Replace with your server name
    // $username = "tsm_public"; // Replace with your MySQL username
    // $password = ""; // Replace with your MySQL password
    // $dbname = "bk_opnsrc_hac"; // Replace with your MySQL database name
    // $port = "3306";

    // $conn = mysqli_connect($servername, $username, $password, $dbname, $port);
    // if (!$conn) {
    //     die("Connection failed: " . mysqli_connect_error());
    // }

    // // Log the connection information
    // $log_data = "Connected to MySQL database on $servername:$port as $username\n";


    // //Get table details
    // $sql_details = "SELECT * FROM details";
    // $result_details = mysqli_query($conn, $sql_details);

    // if ($result_details && mysqli_num_rows($result_details) > 0) {
    //     // output data of each row
    //     while($row_details = mysqli_fetch_assoc($result_details)) {
    //         // echo json_encode($row_details);
    //     }
    // } else {
    //     // echo "0 result_details";
    // }


    // // Get table city_details
    // $sql_city_details = "SELECT * FROM city_details";
    // $result_city_details = mysqli_query($conn, $sql_city_details);

    // if ($result_city_details && mysqli_num_rows($result_city_details) > 0) {
    //     // output data of each row
    //     while($row_city_details = mysqli_fetch_assoc($result_city_details)) {
    //         echo json_encode($row_city_details);
    //     }
    // } else {
    //     echo "0 result_city_details";
    // }
    

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