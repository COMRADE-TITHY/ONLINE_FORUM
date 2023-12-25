<?php
$delete = false;
if ($delete == true) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
<strong>yeah! </strong> Your thread has been deleted successfully 
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iDiscuss | Coding Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">



    <style>
        #ques {
            min-height: 433px;
        }
    </style>
</head>

<body>
    <?php include 'partials/_dbconnect.php'; ?>
    <?php include 'partials/_header.php'; ?>
    <?php
    $id = $_GET['catid'];
    $sql = "SELECT * FROM `categories` WHERE category_id=$id";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $catname = $row['category_name'];
        $catdesc = $row['category_description'];

    }

    ?>
    <?php
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == 'POST') {
        //INSERT THREAD  INTO DB
        $th_title = addslashes($_POST['title']);
        $th_desc = addslashes($_POST['desc']);

        $th_title = str_replace("<", "&lt", $th_title);
        $th_title = str_replace(">", "&gt", $th_title);

        $th_desc = str_replace("<", "&lt", $th_desc);
        $th_desc = str_replace(">", "&gt", $th_desc);

        if (isset($_POST['submit']) && $_POST['randcheck'] == $_SESSION['rand'] && $th_title != "") {
            $sno = $_POST['sno'];
            $sql = "INSERT INTO `threads`(`thread_title`,`thread_desc`,`thread_cat_id`,`thread_user_id`,`timestamp`) VALUES ('$th_title','$th_desc','$id','$sno',current_timestamp())";
            $result = mysqli_query($conn, $sql);
            $showAlert = true;
            if ($showAlert) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success! </strong> Your thread has been added! Please wait for community to respond
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
            }
        }

    }
    ?>


    <!-- Catagory Container  -->
    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4">Welcome to
                <?php echo $catname; ?> Forums
            </h1>
            <p class="lead">
                <?php echo $catdesc; ?>
            </p>
            <hr class="my-4">
            <p>this is a peer to peer forum for sharing knowledge with each other.</p>
            <p class="lead">
                <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
            </p>
        </div>
    </div>


    <?php

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

        if ($_SESSION['is_banned'] == 0) {



            echo '<div class="container">
        <h1 class="py-2">Start a Discussion</h1>

        <form action="' . $_SERVER["REQUEST_URI"] . '" method="post">';
            $rand = rand();
            $_SESSION['rand'] = $rand;
            ?>
            <?php
            echo '<div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Problem Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">Keep your title as crisp and short as possible</div>
            </div>
            <input type="hidden" name="sno" value="' . $_SESSION["sno"] . '">
            <input type="hidden" value="' . $rand . '" name="randcheck">
            <div class="form-group">
                <label for="floatingTextarea2">Elaborate Your Concern</label>
                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-success ">Submit</button>
        </form>
    </div>';
        } else if ($_SESSION['is_banned'] == 1) {
            echo '<div class="container">
            <p class="lead">Your ID has banned...You can not be able to post</p>
        </div>
        ';
        }
    } else {
        echo '<div class="container">
        <h1 class="py-2">Start a Discussion</h1>
        <p class="lead">You are not logged in... Please login to be able to start a Discussion</p>
    </div>
    ';
    }
    ?>



    <div class="container mb-5" id="ques">
        <h1 class="py-2">Browse Questions</h1>
        <?php
        $id = $_GET['catid'];
        $sql = "SELECT * FROM `threads` WHERE thread_cat_id=$id";
        $result = mysqli_query($conn, $sql);
        $noResult = true;
        while ($row = mysqli_fetch_assoc($result)) {
            $noResult = false;
            $id = $row['thread_id'];
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thread_time = $row['timestamp'];
            $thread_user_id = $row['thread_user_id'];
            $sql2 = "SELECT * FROM `users` WHERE `sno`='$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);




            echo '<div class="media my-3" >';
            if ($row2['file_id'] == "") {
                echo '<a href="userProfile.php?id=' . $thread_user_id . '"><img src="img/userdefault.png" width="54px"   height="54px" style="border: 2px solid purple;border-radius: 50%; margin-right: 15px;"></a>';
            } else {
                echo '<a href="userProfile.php?id=' . $thread_user_id . '"><img src="partials/image/' . $row2['file_id'] . '" width="54px" height="54px" style="border: 2px solid purple;border-radius: 50%; margin-right: 15px;"></a>';
            }
            echo '<div class="media-body">' .
                '<h5 class="mt-0"><a class="text-dark" href="thread.php?threadid=' . $id . '">' . $title . '</a></h5>
                                ' . $desc . '</div>' . '<div class="font-weight-bold my-0">Asked by:' . $row2['user_email'] . ' at ' . $thread_time . '</div>' .
                '</div>';
            
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['sno'] == $thread_user_id && $_SESSION['is_banned'] == 0) {

                echo "<div><a href='partials/_handleEditThread.php?threadid=$id' type='button' class='edit ' target='_blank'>Edit</a> 
                <a href='#' type='button' class='delete ' id=" . $row['thread_id'] . " >Delete</a></div>
                ";
            }

        }

        if ($noResult) {
            echo '<div class="jumbotron jumbotron-fluid ">
            <div class="container ">
              <h1 class="display-4">No Threads Found</h1>
              <p class="lead">Be the first person to ask a question</p>
            </div>
          </div>';
        }
        ?>
    </div>
    <?php include 'partials/_handleDeleteThread.php'; ?>


    <!--Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Delete this post</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="partials/_handleDeleteThread.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="thread_del_id" id="thread_del_id" class="delete_thread">
                        <b>Are you sure you want to delete this post?</b>
                    </div>
                    <div class="modal-footer d-block mr-auto">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="delete">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include 'partials/_footer.php'; ?>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>

    <script>
        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach(element => {
            element.addEventListener("click", (e) => {
                //console.log("delete",);
                thread_del_id.value = e.target.id;
                console.log(thread_del_id);
                $('#deleteModal').modal('toggle');
            })
        })

    </script>


</body>


</html>