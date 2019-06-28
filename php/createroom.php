<?php
include './db.php';
error_reporting(E_ALL);

if (isset($_GET['name'])&&isset($_GET['pin'])) {
    $name = $_GET['name'];
    $pin = $_GET['pin'];
    $namequery = "SELECT `rname` FROM `saaslabs` WHERE `rname` LIKE '$name'";
    global $con;
    if ($row = mysqli_query($con, $namequery)) {
        if ($row->num_rows>0) {
            echo 'Name already taken';
        } else {
            $randno=rand(1000, 9999);
            $insert_query = "INSERT INTO `saaslabs`(rname,rpin,code) VALUES ('$name','$pin','$randno')";
            if ($row = mysqli_query($con, $insert_query)) {
                echo 'ROOM Created, please join using join room button';
            } else {
                echo 'query failed';
            }
        }
    } else {
        echo 'Somtething in database failed';
    }
}
