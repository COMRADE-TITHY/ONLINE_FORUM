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
            min-height: 485px;
        }
    </style>
</head>

<body>
    <?php include 'partials/_dbconnect.php'; ?>
    <?php include 'partials/_header.php'; ?>


    <div class="container mb-5" >
        <h1 class="py-2">Question</h1>
        <?php
        include("partials/_dbconnect.php");
        $id = $_GET['id'] ?? $_GET['cid'];
        $query = "SELECT * FROM threads WHERE thread_id=$id";
        $result = mysqli_query($conn, $query);
        $numRows=mysqli_num_rows($result);
        if($numRows> 0){
        while ($row = mysqli_fetch_array($result)) {
            $threadId = $row["thread_id"];
            $threadTitle = $row["thread_title"];
            $threadDesc = $row["thread_desc"];
            $threadTime = $row['timestamp'];
            $threadUserId = $row['thread_user_id'];
            $user_sql = "SELECT * FROM `users` WHERE `sno`='$threadUserId'";
            $user_result = mysqli_query($conn, $user_sql);
            $user_row = mysqli_fetch_assoc($user_result);


            echo '<div class="media my-3" >';
            if ($user_row['file_id'] == "") {
                echo '<a href="userProfile.php?id=' . $threadUserId . '"><img src="img/userdefault.png" width="54px"   height="54px" style="border: 2px solid purple;border-radius: 50%; margin-right: 15px;"></a>';
            } else {
                echo '<a href="userProfile.php?id=' . $threadUserId . '"><img src="partials/image/' . $user_row['file_id'] . '" width="54px" height="54px" style="border: 2px solid purple;border-radius: 50%; margin-right: 15px;"></a>';
            }
            echo '<div class="media-body">'.
                '<h5 class="mt-0"><a class="text-dark" href="thread.php?threadid=' . $id . '">' . $threadTitle . '</a></h5>
                    ' . $threadDesc . '</div>' . '<div class="font-weight-bold my-0">Asked by:' . $user_row['user_email'] . ' at ' . $threadTime . '</div>' .
                '</div>';
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['sno'] == $threadUserId && $_SESSION['is_banned'] == 0) {

                echo "<div><a href='partials/_handleEditThread.php?threadid=$threadId' type='button' class='edit ' target='_blank'>Edit</a> 
                <a href='#' type='button' class='deletethread' id=" . $row['thread_id'] . " >Delete</a></div>
                ";
            }
            echo '<h1 class="py-2">Discussions</h1>';
            $ans=0;
            $query1 = "SELECT * FROM comments WHERE thread_id=$id";
            $result1 = mysqli_query($conn, $query1);
            while ($row1 = mysqli_fetch_assoc($result1)) {
                $commentId = $row1["comment_id"];
                $commentContent = $row1["comment_content"];
                $commentTime = $row1['comment_time'];
                $commentBy = $row1['comment_by'];

                $user_sql2 = "SELECT * FROM `users` WHERE `sno`='$commentBy'";
                $user_result2 = mysqli_query($conn, $user_sql2);
                $user_row2 = mysqli_fetch_assoc($user_result2);
                $ans +=1;

                
                echo '<h5 class="py-2">Answer - '. $ans .'</h5>';
                echo '<div class="media my-3" >';
                if ($user_row2['file_id'] == "") {
                    echo '<a href="userProfile.php?cid=' . $commentBy . '" class="mx-2"><img src="img/userdefault.png" width="54px" height="54px" style="border: 2px solid purple;border-radius: 50%; margin-right: 15px;"></a>';
                } else {
                    echo '<a href="userProfile.php?cid=' . $commentBy . '" class="mx-2"><img src="partials/image/' . $user_row2['file_id'] . '" width="54px" height="54px" style="border: 2px solid purple;border-radius: 50%; margin-right: 15px;"> </a>';
                }
                echo ' <div class="media-body">
             <p class="font-weight-bold my-0">' . $user_row2['user_email'] . ' at ' . $commentTime . '</p> ' . $commentContent . ' </div> </div>';
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['sno'] == $commentBy && $_SESSION['is_banned'] == 0) {
                    echo "<div><a href='partials/_handleEditComment.php?commentid=$commentId' type='button' class='edit ' target='_blank'>Edit</a> 
           <a href='#' type='button' class='delete ' id=" . $row1['comment_id'] . " >Delete</a></div>
             ";
                }
            }
        }
    }
    else {
        echo '<div class="jumbotron jumbotron-fluid ">
        <div class="container ">
          <h1 class="display-4"> Thread has been deleted</h1>
          <p class="lead">Be the first person to ask a question</p>
        </div>
      </div>';    }
        ?>
    </div>
    <?php
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == 'POST') {
        //INSERT comment  INTO DB
        $comment = addslashes($_POST['comment']);
        $comment = str_replace("<", "&lt", $comment);
        $comment = str_replace(">", "&gt", $comment);
        if (isset($_POST['submit']) && $_POST['randcheck'] == $_SESSION['rand'] && $comment != "") {
            $sno = $_POST['sno'];
            $sql = "INSERT INTO `comments`(`comment_content`,`thread_id`,`comment_by`,`comment_time`) VALUES ('$comment','$id','$sno',current_timestamp())";
            $result = mysqli_query($conn, $sql);
            $showAlert = true;
            if ($showAlert) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your comment has been added successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
            }
        }

    }
    ?>
    <?php

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true ) {
        if ( $_SESSION['is_banned'] == 0) {
       

        echo '<div class="container" id="ques">
   <h1 class="py-2">Post a Comment</h1>

   <form action="' . $_SERVER['REQUEST_URI'] . '" method="post">';
        $rand = rand();
        $_SESSION['rand'] = $rand;
        ?>
        <?php
        echo '<div class="form-group">
           <label for="floatingTextarea2">Type your comment</label>
           <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
           <input type="hidden" name="sno" value="' . $_SESSION["sno"] . '">
           <input type="hidden" value="' . $rand . '" name="randcheck">
       </div>
       <button type="submit" name="submit" class="btn btn-success ">Post Comment</button>
   </form>
</div>';
} else if ( $_SESSION['is_banned']== 1) {
    echo '<div class="container">
    <p class="lead">Your ID has banned.. you can not be able to post</p>
</div>
';
}
    } else {
        echo '<div class="container" id="ques">
    <h1 class="py-2">Post a Comment</h1>
    <p class="lead">You are not logged in... Please login to be able to post comments</p>
</div>
';
    }
    ?>


 <!--Delete Modal -->
 <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Delete this post</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="partials/_handleDeleteComment.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="comment_del_id" id="comment_del_id" class="delete_thread">
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


     <!--Delete Modal -->
     <div class="modal fade" id="deleteModalthread" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
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
                console.log("delete",);
                comment_del_id.value= e.target.id;
                console.log(comment_del_id);
                $('#deleteModal').modal('toggle');
            })
        })
    </script>
    <script>
    deletes = document.getElementsByClassName('deletethread');
    Array.from(deletes).forEach(element => {
        element.addEventListener("click", (e) => {
            //console.log("delete",);
            thread_del_id.value=e.target.id;
            console.log(thread_del_id);
            $('#deleteModalthread').modal('toggle');
        })
    })

</script>


</body>


</html>