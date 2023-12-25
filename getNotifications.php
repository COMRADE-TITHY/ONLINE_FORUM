<?php
include("partials/_dbconnect.php");  
$reset = (int) $_GET[ "reset" ]; // either 1 or 0 ( true and false )  
  
$username = "user1"; // the user who's notifications we will be loading  
  
if( $reset === 1 ){  
$sql = "SELECT * FROM `notification` WHERE `forUser`='" . $username . "' ORDER BY `time` DESC LIMIT 10;";  
setcookie( "loadedNotifications", "10", time() + 86400, "/" ); // store the cookie holding the amount of loaded notifications  
}  
else{  
$loadedNots=(int) $_COOKIE[ "loadedNotifications" ]; // get the amount of previously loaded notifications  
$sql = "SELECT * FROM `notification` WHERE `forUser`='" . $username . "' ORDER BY `time` DESC LIMIT " . $loadedNots . " 10;";  
$loadedNots = (string)( $loadedNots + 10 ); // calculate how many notifications have been loaded after query  
setcookie( "loadedNotifications", $loadedNots, time() + 86400, "/" ); // update cookie with new value  
}  
  
$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
  
$notifications = array(); // declare an array to store the fetched notifications  
  
if( mysqli_num_rows($result) > 0 ){   
    while ($row = mysqli_fetch_assoc($result)) {
        $notifications[] = array( "id" => $row[ "notificationID" ], "type" => $row[ "type" ], "entityID" => $row[ "entityID" ], "read" => $row[ "read" ], "text" => "" );  
}  
}   
else{  
// no more notifications  
}  
  
/*  
* now we need to find the activity that relates to the notification  
* and create a text message that will be displayed to the user  
* containing the users who are responsible for that particular activity  
*/  
  
for( $i = 0; $i < count( $notifications ); $i++ ){  
$sql = ""; // reset query string each time loop runs  
  
// use different code for each type of notification ( ie. comments or ratings )  
switch( $notifications[ $i ][ "type" ] ){  
case "comment":  
$sql = "SELECT `comment_by` FROM `comments` WHERE `thread_id`=" . $notifications[ $i ][ "entityID" ] . ";";  
$result = mysqli_query($conn, $sql);
/*  
   * For this example we want a maximum of two names in the notification text  
   * if there are more than 2, then we'll include those as a number  
 */  
if( mysqli_num_rows($result) === 1 ){  
$row = mysqli_fetch_assoc($result);  
$name = $row[ "comment_by" ];  
$notifications[ $i ][ "text" ] = $name . " commented on your post";  
}  
elseif( mysqli_num_rows($result) === 2 ){  
$row = mysqli_fetch_assoc($result);  
$name1 = $row[ "comment_by" ]; // fetch first name  
$row = mysqli_fetch_assoc($result);  
$name2 = $row[ "comment_by" ]; // fetch second name  
$notifications[ $i ][ "text" ] = $name1 . " and " . $name2 . " commented on your post";  
}  
elseif( mysqli_num_rows($result) > 2 )
{
$total = mysqli_num_rows($result) - 2;//fetch the number of users who commented minus the two names we will use
$row = mysqli_fetch_assoc($result);  
$name1 = $row[ "comment_by" ]; // fetch first name  
$row = mysqli_fetch_assoc($result);  
$name2 = $row[ "comment_by" ]; // fetch second name  
$notifications[ $i ][ "text" ] = $name1 . ", " . $name2 . " and " . $total . " others commented on your post";  
}  
break;  
// other cases to suit your needs  
}  
}  
  
echo( json_encode( $notifications ) ); // convert array to JSON text  

?>
<script>
function getNotifications( reset ){  
var xmlhttp = new XMLHttpRequest();  
xmlhttp.onreadystatechange = function() {  
if ( xmlhttp.readyState === 4 && xmlhttp.status === 200 ) {  
var response = xmlhttp.responseText;  
var notifications=JSON.parse( response ); // create JSON object from response  
  
for( var i = 0 ; i < notifications.length ; i++ ){  
var notificationID = notifications[ i ].id;  
var entityID = notifications[ i ].entityID;  
var text = notifications[ i ].text;  
var type = notifications[ i ].type;  
var read = notifications[ i ].read;  
  
// add notification into your HTML here  
}  
}  
}  
xmlhttp.open("GET", "getNotifications.php?reset=" + reset, true);  
xmlhttp.send();  
}
</script>