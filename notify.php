<?php
function notify( $type, $forUser, $entityID ){   
include("partials/_dbconnect.php");
$sql = "SELECT `notificationID` FROM `notification` WHERE `forUser`='" . $forUser . "' AND `entityID`=" . $entityID . " AND `type`='" . $type . "';";   
$result = mysqli_query($conn, $sql);
if( $result->num_rows > 0 ){   
    $sql = "UPDATE `notification` SET `read`=0, `time`=NOW() WHERE `forUser`='" . $forUser . "' AND `entityID`=" . $entityID . " AND `type`='" . $type . "';";   
 }   
else{  
    $sql = "INSERT INTO `notification`( `type`, `forUser`, `entityID` ) VALUES( '" . $type . "','" . $forUser . "'," . $entityID . " );";   
}  


} 
?>