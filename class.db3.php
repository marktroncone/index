<?php
require_once('class.api.php');
class DB_CLASS {
    
    //hostname
    private $servername = "localhost";
    
    //username
    private $username   = "linetime_db";
    
    //password
    private $password   = "WVvkf,_rRVg7";
    
    //DB Name
    private $dbName     = "linetime_db";
    
    /*
     * Connect to Mysql Database
     * @return connection object
    **/
    public function connection() {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbName);

        // Check connection
        if ($conn->connect_error) {
            return "Connection failed: " . $conn->connect_error;
        }
        
        return $conn;
    }
    
    public function insertVenue(
        $n = '',
        $a  = '',
        $la = 0,
        $lo = 0,
        $q  = 0,
        $h  = '',
        $p  = '',
        $l  = ''
    ) {
        $conn = $this->connection();
        $stmt = $conn->prepare("INSERT INTO places (name, address, latitude, longitude, queue_time, hr_min, place_type, logo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssisss", $n, $a, $la, $lo, $q, $h, $p, $l);
        $stmt->execute();
        $last_id = $conn->insert_id;
        $currentTime = gmdate("Y-m-d H:i:s", time());
        $sql = "UPDATE places SET added_time=now(), updated_time={$currentTime} WHERE id={$last_id}";
        if ($conn->query($sql) === TRUE) {
            echo "success";
        }
        $stmt->close();
        $conn->close();
    }
    
    public function getVenue($ID) {
        $conn = $this->connection();
        
        $sql = "SELECT * FROM places WHERE ID = {$ID}";
        $result = $conn->query($sql);
        $conn->close();
        return $result;
    }
    public function updateVenue($ID, $name, $address, $lat, $lng, $place_type, $logo = "") {
        $conn = $this->connection();
        $currentTime = gmdate("Y-m-d H:i:s", time());
        if($logo !== "") {
            $sql = "UPDATE places SET name='{$name}', address='{$address}', logo='{$logo}', place_type='{$place_type}', updated_time='{$currentTime}' WHERE id={$ID}";
        } else {
             $sql = "UPDATE places SET name='{$name}', address='{$address}', latitude='{$lat}', longitude='{$lng}', place_type='{$place_type}', updated_time='{$currentTime}' WHERE id={$ID}";           
        }
        if ($conn->query($sql) === TRUE) {
            $conn->close();
            echo "success";
        }
    }
    
    public function updateQueue($ID, $queue, $hr) {
        $conn = $this->connection();
        $currentTime = gmdate("Y-m-d H:i:s", time());
        $sql = "UPDATE places SET queue_time='{$queue}', hr_min='{$hr}', updated_time='{$currentTime}' WHERE id={$ID}";
        if ($conn->query($sql) === TRUE) {
            $conn->close();
            echo "success";
        }
    }
    
    public function getListings($order, $lat, $lng) {
        $conn = $this->connection();
        $API  = new API();
        $listings = [];
        if($order == "shortest") {
            $order = "DESC";
        } else {
            $order = "ASC";
        }
        $sql  = "SELECT * FROM places ORDER BY updated_time DESC;";
        $i = 0;
        foreach ($conn->query($sql) as $row) {
            if( $API->distance($lat, $lng, $row['latitude'], $row['longitude']) < 150 ){
                foreach($row as $key => $value ){
                    $listings[$i][$key] = $value;
                }
                $i++;               
            }

        }
        $conn->close();
        return json_encode($listings);
    }
    
    public function updatePosition($ID, $lat, $lng) {
        $conn = $this->connection();
        $lat  = floatval($lat);
        $lng  = floatval($lng);
        $sql  = "UPDATE places SET latitude='{$lat}', longitude='{$lng}' WHERE id={$ID}";
        if ($conn->query($sql) === TRUE) {
            $conn->close();
            echo "success";
        }
    }
    
    public function getPassword() {
        $conn = $this->connection();
        $sql  = "SELECT password FROM admin WHERE username = 'mark' ";
        foreach ($conn->query($sql) as $row) {
            $conn->close();
            return $row['password'];
        }
    }
    
    public function RemoveVenue($ID) {
        $conn = $this->connection();
        $sql  = "DELETE FROM places WHERE id={$ID}";
        if ($conn->query($sql) === TRUE) {
            $conn->close();
            echo "success";
        }
    }
    
}