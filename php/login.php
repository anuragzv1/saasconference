<?php
error_reporting(E_ALL);
include './db.php';
if (isset($_GET['name'])&&isset($_GET['pin'])) {
    $name = $_GET['name'];
    $pin = $_GET['pin'];
    $namequery = "SELECT `id` ,`code` FROM `saaslabs` WHERE `rname` LIKE '$name' AND `rpin` LIKE '$pin'";
    global $con;
    if ($row = mysqli_query($con, $namequery)) {
        if ($row->num_rows>0) {
            session_start();
            while ($result = $row->fetch_assoc()) {
                $id =$result['id'];
                $randno=$result['code'];
                $_SESSION['id']=$id;
                $_SESSION['rname']=$name;
                $ar=array('true',$randno);
                echo json_encode($ar, JSON_FORCE_OBJECT);
            }
        } else {
            $ar=array('Wrong credentials');
            echo json_encode($ar, JSON_FORCE_OBJECT);
        }
    } else {
        $ar=array('Somtething in database failed');
        echo json_encode($ar, JSON_FORCE_OBJECT);
    }
}
