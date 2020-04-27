<?php

//require DB Class
require_once('class.db.php');

$DB = new DB_CLASS();


if( isset($_POST['form']) ) {
    $venue          = json_decode($_POST['form']);
    $venue_name     = $venue[0]->value;
    $venue_address  = $venue[1]->value;
    $latitude       = $venue[2]->value;
    $longitude      = $venue[3]->value;
    $place_type     = $venue[4]->value;
    
    if( !isset($_FILES['logoFile'])) {
        die('logo_missing');
    }
    
    $target_dir  = "../uploads/";
    $logoName    = md5(rand(1, 200)) . "." . strtolower(pathinfo($_FILES['logoFile']['name'], PATHINFO_EXTENSION));
    $target_file = $target_dir . $logoName;
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    $check = getimagesize($_FILES["logoFile"]["tmp_name"]);

    if($check == false) {
        die('not_supported');
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["logoFile"]["size"] > 500000) {
        die('large_file');
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
        die('not_supported');
        $uploadOk = 0;
    }

    // if everything is ok, try to upload file
    if( $uploadOk == 1) {
            if ( move_uploaded_file($_FILES["logoFile"]["tmp_name"], $target_file) ) {
        } else die('error');
         
    }
    $DB->insertVenue($venue_name, $venue_address, $latitude, $longitude, '', '', $place_type, $logoName);
}

//get all markers withn boundaries
if( isset($_POST['getMarkers']) ) {
    $polygon    = json_decode($_POST['getMarkers']);
    $bounds   = [
      'x'   => [$polygon->northLng, $polygon->southLng],
      'y'   => [$polygon->northLat, $polygon->southLat]
    ];
    $points_polygon = count($bounds['x']) - 1;
    
    //get markers from database
    $conn = $DB->connection();
    $sql = "SELECT id, name, address, latitude, longitude, queue_time, hr_min, place_type, logo FROM places WHERE (latitude > {$bounds['y'][1]} AND latitude < {$bounds['y'][0]} AND longitude > {$bounds['x'][1]} AND longitude < {$bounds['x'][0]})";
    $markers = [];
    $i = 0;
    
    foreach ($conn->query($sql) as $row) {
        $id = $row['id'];
        $name = $row['name'];
        $address = $row['address'];
        $queueTime = $row['queue_time'];
        $hr_min = $row['hr_min'];
        $place_type = $row['place_type'];
        $logo = $row['logo'];
        $lat = $row['latitude'];
        $lng = $row['longitude'];
        //check if the point inside the polygon
          $markers[$i]['id'] = $id;
          $markers[$i]['name'] = $name;
          $markers[$i]['address'] = $address;
          $markers[$i]['queue_time'] = $queueTime;
          $markers[$i]['hr_min'] = $hr_min;
          $markers[$i]['place_type'] = $place_type;
          $markers[$i]['lat'] = $lat;
          $markers[$i]['lng'] = $lng;
          $markers[$i]['logo'] = $logo;
        $i++;
    }
    echo json_encode($markers);
    $conn->close();
}

//get marker info
if( isset($_POST['markerInfo']) ) {
    $ID  = intval($_POST['markerInfo']);
    $INF = $DB->getVenue($ID);
    $RES = "";
    if($INF->num_rows > 0) {
        while($row = $INF->fetch_assoc()) {
            if($row['hr_min'] == "MIN") $row['queue_time'] = intval($row['queue_time']);
            echo json_encode($row);
            break;
        }
    } else{
        return "error";
    }
    
}


//update marker info
if( isset($_POST['updateVenue']) ){
    $newData = json_decode($_POST['updateVenue']);
    $venue_name     = $newData[0]->value;
    $venue_address  = $newData[1]->value;
    $latitude       = $newData[2]->value;
    $longitude      = $newData[3]->value;
    $place_Type     = $newData[4]->value;
    
    if( !isset($_POST['markerID']) ) {
        die('no_id');
    }
    if(isset($_FILES['update_logoFile'])) $newLogo = $_FILES['update_logoFile'];
    
    if(isset($newLogo)) {
        $target_dir  = "../uploads/";
        $logoName    = md5(rand(1, 200)) . "." . strtolower(pathinfo($_FILES['update_logoFile']['name'], PATHINFO_EXTENSION));
        $target_file = $target_dir . $logoName;
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        $check = getimagesize($_FILES["update_logoFile"]["tmp_name"]);

        if($check == false) {
            die('not_supported');
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["update_logoFile"]["size"] > 500000) {
            die('large_file');
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
            die('not_supported');
            $uploadOk = 0;
        }
        
        // if everything is ok, try to upload file
        if( $uploadOk == 1) {
                if ( move_uploaded_file($_FILES["update_logoFile"]["tmp_name"], $target_file) ) {
            } else die('error');

        }
        echo $DB->updateVenue($_POST['markerID'], $venue_name, $venue_address, $latitude, $longitude, $place_Type, $logoName);
        return;
    }
    echo $DB->updateVenue($_POST['markerID'], $venue_name, $venue_address, $latitude, $longitude, $place_Type);
}

//update Queue Time
if( isset($_POST['queueID']) ) {
    $ID        = $_POST['queueID'];
    $queueTime = floatval($_POST['queueTime']);
    $queueType = $_POST['hr_min'];
    
    if( $queueTime == 0) {
        die("error_value");
    }
    
    if( $queueType !== "MIN" && $queueType !== "HR") {
        die('error_queue');
    }
    
    $DB->updateQueue($ID, $queueTime, $queueType);
}

//get listings
if( isset($_POST['listings']) ) {
    $order = $_POST['sortOrder'];
    $lat   = $_POST['latitude'];
    $lng   = $_POST['longitude'];
    $results = $DB->getListings($order, $lat, $lng);
    
    print_r($results);
}

//update position
if( isset($_POST['updatePosition']) ) {
    $inf = $_POST['updatePosition'];
    $ID  = $inf['ID'];
    $lat = $inf['latitude'];
    $lng = $inf['longitude'];
    $DB->updatePosition($ID, $lat, $lng);
}

$password = $DB->getPassword();

if( isset($_POST['removeVenue']) ) {
    $password = $DB->getPassword();
    $inf = $_POST['removeVenue'];
    $ID  = $inf['ID'];
    $pass = $inf['password'];
    
    if($password !== $pass) {
        die('wrong_pass');
    }
    
    $DB->RemoveVenue($ID);
}