<?php
include('../inc.php');
$pk=$_REQUEST['ID'];
/*$name= htmlspecialchars($_REQUEST['name']);
$address= htmlspecialchars($_REQUEST['address']);
$phone= htmlspecialchars($_REQUEST['Phone']);
$password= htmlspecialchars($_REQUEST['Password']);*/

$sql="DELETE FROM `customer_info` WHERE `customer_id`='".$pk."'";
$result=mysqli_query($db,$sql);
print $msg=($result)? 1:0;
?>