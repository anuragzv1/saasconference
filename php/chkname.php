<?php
include './db.php';
if (isset($_GET['name'])) {
    if (!empty($_GET['name'])) {
        $name = $_GET['name'];
        $namequery = "SELECT `rname` FROM `saaslabs` WHERE `rname` LIKE '$name'";
        global $con;
        if ($row = mysqli_query($con, $namequery)) {
            if ($row->num_rows>0) {
                echo 'Name already taken';
            } else {
                echo 'Name available';
            }
        } else {
            echo 'Somtething in database failed';
        }
    }
} else {
    echo 'name cannot be blank';
}
