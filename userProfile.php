<?php
// session_start();

//Connecting to the Database
include 'partials/_dbconnect.php';
include 'partials/_header.php';
$user_id = $_GET['id'] ?? $_GET['cid'] ?? $_SESSION['sno'];

$sql = "select * from users where sno = '$user_id' limit 1";
$result = mysqli_query($conn, $sql) or die("failed");
$row = mysqli_fetch_assoc($result);





?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iDiscuss |User profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        .profile-head {
            transform: translateY(5rem)
        }

        .cover {
            background-image: url(https://images.unsplash.com/photo-1530305408560-82d13781b33a?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1352&q=80);
            background-size: cover;
            background-repeat: no-repeat
        }

        body {
            background: #654ea3;
            background: linear-gradient(to right, #e96443, #904e95);
            min-height: 100vh;
            overflow-x: hidden;
        }



        .effect {
            width: 100%;
            padding: 50px 0px 70px 0px;
            background-color: $basic-dark-color;


            letter-spacing: 3px;
        }

        &:nth-child(2) {
            margin-top: 50px;
        }

        &:nth-child(2n+1) {
            background-color: $basic-light-color;


        }

        .buttons {
            margin-top: 50px;
            display: flex;
            justify-content: center;
        }

        a {

            &:last-child {
                margin-right: 0px;
            }
        }



        .effect a {
            text-decoration: none !important;
            color: white;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            border-radius: 10px;
            font-size: 25px;
            overflow: hidden;
            position: relative;
        }

        .effect a i {
            position: relative;
            z-index: 3;
        }




        .effect .fb {
            background-color: #3b5998;
        }

        .effect .tw {
            background-color: #00aced;
        }


        .effect .insta {
            background-color: #bc2a8d;
        }

        .effect .in {
            background-color: #007bb6;
        }

        .effect.jaques {

            a {
                transition: border-top-left-radius 0.1s linear 0s, border-top-right-radius 0.1s linear 0.1s, border-bottom-right-radius 0.1s linear 0.2s, border-bottom-left-radius 0.1s linear 0.3s;

                &:hover {
                    border-radius: 50%;
                }
            }
        }
    </style>
</head>

<body>


    <div class="row py-5 px-4">
        <div class="col-md-5 mx-auto"> <!-- Profile widget -->
            <div class="bg-white shadow rounded overflow-hidden">
                <div class="px-4 pt-0 pb-4 cover">
                    <div class="media align-items-end profile-head">
                        <div class="profile mr-3">
                            <?php if ($row["file_id"] == "") {
                                echo ' <img
                                src="img/userdefault.png"
                                alt="..." width="130" height="130" class="rounded mb-2 img-thumbnail">';
                            } else { ?>
                                <img src="<?= 'partials/image/' . $row['file_id'] ?>" alt="..." width="130" height="130"
                                    class="rounded mb-2 img-thumbnail">
                            <?php } ?>
                            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['sno'] == $user_id ) {
                                if ( $_SESSION['is_banned']==0) {
                                    
                                    
                                    echo '<a href="partials/_editProfile.php" class="btn btn-outline-dark btn-sm btn-block" target="_blank">Edit
                                    profile</a>';
                                }elseif ( $_SESSION['is_banned']==1) {
                                   echo '<p>Your ID has banned...</p>';
                                }
                            } else {
                                echo '<a href="#" class="btn btn-outline-dark btn-sm btn-block">Follow</a>';
                            }
                            ?>

                        </div>

                        <div class="media-body mb-5 text-white">
                            <h4 class="mt-0 mb-0">
                                <?php echo $row['name'] . ' ' . $row['surname']; ?>
                            </h4>
                            <p class="small mb-4"> <i class="fas fa-map-marker-alt mr-2"></i>

                                <?php echo $row['user_email']; ?>

                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-light p-4 d-flex justify-content-end text-center">
                    <ul class="list-inline mb-0">
                        <?php 
                        include 'partials/_dbconnect.php';
                        $sql_threads="SELECT COUNT(*) AS thread_count FROM threads WHERE thread_user_id=$user_id";
                        $sql_comments="SELECT COUNT(*) AS comment_count FROM comments WHERE comment_by=$user_id";
                        $result_threads=mysqli_query($conn, $sql_threads) or die(mysqli_error($conn));
                        $result_comments=mysqli_query($conn, $sql_comments) or die(mysqli_error($conn));
                        $row_threads=mysqli_fetch_assoc($result_threads);
                        $row_comments=mysqli_fetch_assoc($result_comments);
                        $total_threads=$row_threads['thread_count'];
                        $total_comments=$row_comments['comment_count'];
                        $total_posts=($total_threads+$total_comments);
                        ?>
                        <li class="list-inline-item">
                            <h5 class="font-weight-bold mb-0 d-block"><?php echo $total_posts;?></h5><small class="text-muted"> <i
                                    class="fas fa-image mr-1"></i>Posts</small>
                        </li>
                        <li class="list-inline-item">
                            <h5 class="font-weight-bold mb-0 d-block">0</h5><small class="text-muted"> <i
                                    class="fas fa-user mr-1"></i>Followers</small>
                        </li>
                        <li class="list-inline-item">
                            <h5 class="font-weight-bold mb-0 d-block">0</h5><small class="text-muted"> <i
                                    class="fas fa-user mr-1"></i>Following</small>
                        </li>
                    </ul>
                </div>
                <div class="px-4 py-3">
                    <h5 class="mb-0">About</h5>
                    <div class="p-4 rounded shadow-sm bg-light">
                        <p class="font-italic mb-0">
                            <?php echo $row['about'] ?>
                        </p>
                        <p class="font-italic mb-0">
                            <?php echo $row['city'] . ', ' . $row['state'] . ', ' . $row['country']; ?>
                        </p>
                    </div>

                </div>
                <div class="py-4 px-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="mb-0">Recent posts</h5><a href="#" class="btn btn-link text-muted" type="button" id="showAllButton">Show all</a>
                    </div>
                    <div class="container my-3 py-2" style="background-color: antiquewhite;" id="itemContainer">
                        <?php
                        $threadQuery = "select * from threads where thread_user_id = '$user_id' order by timestamp desc";
                        $threadResult = mysqli_query($conn, $threadQuery) or die("failed");
                        while ($threadRow = mysqli_fetch_assoc($threadResult)) {
                            $threadId = $threadRow["thread_id"];
                            $threadTitle = $threadRow["thread_title"];
                            $threadDesc = $threadRow["thread_desc"];
                            $threadDate = $threadRow["timestamp"];
                            echo "<div class='mb-2 item' style='background-color: bisque;'><div class='mx-2'><a href='main.php?id=$threadId' class='text-dark'><b>$threadTitle</b></a><br><p>$threadDesc</p></div>
                            <div class='mx-2 '><small>$threadDate</small></div></div>";
                        }
                  
                       
                            
                      $commentQuery="select * from comments where comment_by = '$user_id'order by comment_time desc" ;
                            $commentResult=mysqli_query($conn, $commentQuery) or die("failed");
                            while($commentRow=mysqli_fetch_assoc($commentResult)){
                                $commentId = $commentRow["thread_id"];
                                $commentContent = $commentRow["comment_content"];
                                $commentDate = $commentRow["comment_time"];
                                echo"<div class='mb-2 item' style='background-color: bisque;'><div class='mx-2'><a href='main.php?cid=$commentId' class='text-dark'><p>$commentContent</p></a></div>
                                <div class='mx-2'><small>$commentDate</small></div></div>";
                            }
                            
                        ?>
                    </div>
                    <div>
                        <div class="effect jaques">
                            <div class="buttons">
                                <a href="<?= $row['facebook']?>" target="_blank" class="fb" title="Join us on Facebook"><i class="fa fa-facebook"
                                        aria-hidden="true"></i></a>
                                <a href="<?= $row['twitter']?>" target="_blank" class="tw" title="Join us on Twitter"><i class="fa fa-twitter"
                                        aria-hidden="true"></i></a>
                                <a href="<?= $row['insta']?>" target="_blank" class="insta" title="Join us on Instagram"><i class="fa fa-instagram"
                                        aria-hidden="true"></i></a>
                                <a href="<?= $row['linkedin']?>" target="_blank" class="in" title="Join us on Linked In"><i class="fa fa-linkedin"
                                        aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
            var itemContainer = document.getElementById('itemContainer');
            var showAllButton = document.getElementById('showAllButton');

            var items = itemContainer.querySelectorAll('.item');
            for (var i = 2; i < items.length; i++) {
                items[i].style.display = 'none';

            }
            showAllButton.addEventListener('click', function () {
                items.forEach(function (item) {
                    item.style.display = 'block';
                });
                showAllButton.style.display = 'none';
            });

        });


        </script>


</body>

</html>