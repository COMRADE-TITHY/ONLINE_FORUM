<?php
session_start();
$user_id = $_SESSION['sno'];
$update = false;
include '_dbconnect.php';
$id = $_GET['threadid'];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['btn_post'])) {
        // update the record
        $thread_titleEdit = addslashes($_POST['thread_titleEdit']);
        $thread_descEdit = addslashes($_POST['thread_descEdit']);

        //sql query to be executed
        $sql1 = "UPDATE  `threads` SET `thread_title` = '$thread_titleEdit' , `thread_desc`='$thread_descEdit' WHERE threads.thread_id=$id";
        $result1 = mysqli_query($conn, $sql1) or die("failed" . mysqli_error($conn));
        if ($result1) {
            // echo "We updated the record Successfully";
            $update = true;
            if ($update) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your thread has been updated successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
            }
        } else {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Success!</strong> We could not update the record successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
        $sql = "select * from threads where threads.thread_id=$id limit 1";
        $result = mysqli_query($conn, $sql) or die("failed");
        $row = mysqli_fetch_assoc($result);
    }
}
$sql = "select * from threads where threads.thread_id=$id limit 1";
$result = mysqli_query($conn, $sql) or die("failed");
$row = mysqli_fetch_assoc($result);

$sql2 = "select * from users where users.sno =$user_id limit 1";
$result2 = mysqli_query($conn, $sql2) or die("failed");
$row2 = mysqli_fetch_assoc($result2);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iDiscuss | Edit Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    <style>
        body {
            background: rgb(99, 39, 120)
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #BA68C8
        }

        .profile-button {
            background: rgb(99, 39, 120);
            box-shadow: none;
            border: none
        }

        .profile-button:hover {
            background: #682773
        }

        .profile-button:focus {
            background: #682773;
            box-shadow: none
        }

        .profile-button:active {
            background: #682773;
            box-shadow: none
        }

        .back:hover {
            color: #682773;
            cursor: pointer
        }

        .labels {
            font-size: 11px
        }

        .add-experience:hover {
            background: #BA68C8;
            color: #fff;
            cursor: pointer;
            border: solid 1px #BA68C8
        }

        #file_id {
            display: none;
        }

        #add-icon {
            float: "right";
            width: "20px";
            height: "20px";
            margin-top: -30px;
        }
    </style>
</head>

<body>
    
    <form method="POST" enctype="multipart/form-data">
        <div class="container rounded bg-white mt-5 mb-5">
            <div class="row">
                <div class="col-md-5 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                        <img class="rounded-circle mt-5" style="border:2px solid purple" width="150px" height="150px"
                            src="<?= 'image/' . $row2['file_id'] ?>">
                        <span class="font-weight-bold">
                            <?php echo $row2['name'] . '_' . $row2['surname']; ?>
                        </span><span class="text-black-50">
                            <?php echo $row2['user_email']; ?>
                        </span><span> </span>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Edit Post</h4>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6"> <label for="thread_title" class="form-label">Problem Title</label>
                                <input type="text" class="form-control" id="thread_titleEdit" name="thread_titleEdit"
                                    autocomplete="off" value='<?= $row['thread_title'] ?>' />
                            </div>


                            <div class="col-md-6"><label for="thread_desc" class="form-label">Elaborate your
                                    Concern</label>
                                <input type="text" class="form-control" id="thread_descEdit" name="thread_descEdit"
                                    autocomplete="off" value='<?= $row['thread_desc'] ?>' />
                            </div>
                        </div>
                        <div class="mt-5 text-center"><button class="btn btn-primary profile-button" name="btn_post"
                                type="submit">Save
                                Post</button></div>
                    </div>
                </div>

            </div>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>

</html>