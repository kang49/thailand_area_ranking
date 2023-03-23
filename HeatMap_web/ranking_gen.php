<?php
    //Get data
    $rank1_obj = $_GET['rank1_obj'];
    $rank2_obj = $_GET['rank2_obj'];
    $rank3_obj = $_GET['rank3_obj'];

    if ($rank1_obj != null){
        echo 'Received obj1: ' . $rank1_obj;
    }
    if ($rank2_obj != null){
        echo 'Received obj2: ' . $rank2_obj;
    }
    if ($rank3_obj != null){
        echo 'Received obj3: ' . $rank3_obj;
    }

    $servername = "8.8.8.6"; // Replace with your server name
    $username = "tsm_public"; // Replace with your MySQL username
    $password = ""; // Replace with your MySQL password
    $dbname = "bk_opnsrc_hac"; // Replace with your MySQL database name
    $port = "3306";

    $conn = mysqli_connect($servername, $username, $password, $dbname, $port);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Log the connection information
    $log_data = "Connected to MySQL database on $servername:$port as $username\n";


    $sql = "SELECT locations,restaurant_value FROM details";
    $result = mysqli_query($conn, $sql);
    $arlocations = array();

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            array_push($arlocations,array(
                $row['locations'],$row['restaurant_value']
            ));
        }
    } else {
        echo "0 results";
    }

    // echo json_encode($arlocations);
?>