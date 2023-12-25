<?php
function timeAgo($datetime){

$now=new DateTime();
$date=new DateTime($datetime);
$interval=$now->diff($date);

if($interval->y > 0){
    return $interval->format("%y years ago");
}elseif($interval->m > 0){
    return $interval->format("%m months ago");
}elseif($interval->d > 0){
    return $interval->format("%d days ago");
}elseif($interval->h > 0){
    return $interval->format("%h hours ago");
}elseif($interval->i > 0){
    return $interval->format("%i minutes ago");
}else{
    return "Just Now";
}
}

// function timeAgo($datetime, $full = false) {
//     $now = new DateTime;
//     $ago = new DateTime($datetime);
//     $diff = $now->diff($ago);

//     $diff->w = floor($diff->d / 7);
//     $diff->d -= $diff->w * 7;

//     $string = array(
//         'y' => 'year',
//         'm' => 'month',
//         'w' => 'week',
//         'd' => 'day',
//         'h' => 'hour',
//         'i' => 'minute',
//         's' => 'second',
//     );
//     foreach ($string as $k => &$v) {
//         if ($diff->$k) {
//             $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
//         } else {
//             unset($string[$k]);
//         }
//     }

//     if (!$full) $string = array_slice($string, 0, 1);
//     return $string ? implode(', ', $string) . ' ago' : 'just now';
// }



?>