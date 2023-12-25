<?php
session_start();
$update = false;
//Connecting to the Database
include '_dbconnect.php';
$user_id = $_SESSION['sno'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['btn_post'])) {
        // update the record
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $about = $_POST['about'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $country = $_POST['country'];
        $facebook = $_POST['facebook'];
        $twitter = $_POST['twitter'];
        $insta = $_POST['insta'];
        $linkedin = $_POST['linkedin'];
        $filename = $_FILES['file_id']['name'];
        $tempname = $_FILES['file_id']['tmp_name'];
        $destination = 'image/' . $filename;
        move_uploaded_file($tempname, $destination);


        //sql query to be executed
        $sql1 = "UPDATE  `users` SET `name` = '$name' , `surname`='$surname',`about`='$about',`city`='$city',`state`='$state',`country`='$country',`facebook`='$facebook',`twitter`='$twitter',`insta`='$insta',`linkedin`='$linkedin',`file_id`='$filename' WHERE `users`.`sno` = '$user_id'";
        $result1 = mysqli_query($conn, $sql1) or die("failed");
        if ($result1) {
            // echo "We updated the record Successfully";
            $update = true;
        } else {
            echo "We could not update the record Successfully";
        }

        $sql = "select * from users where sno = '$user_id' limit 1";
        $result = mysqli_query($conn, $sql) or die("failed");
        $row = mysqli_fetch_assoc($result);
    }
}
$sql = "select * from users where sno = '$user_id' limit 1";
$result = mysqli_query($conn, $sql) or die("failed");
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iDiscuss | Edit Profile</title>
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
    <?php
    if ($update) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Sucess!</strong> Your note has been updated successfully.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
    }
    ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="container rounded bg-white mt-5 mb-5">
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                        <img class="rounded-circle mt-5" style="border:2px solid purple" width="150px" height="150px"
                            src="<?= 'image/' . $row['file_id'] ?>">
                        <input type="hidden" id="max_file_size" name="max_file_size" value="100000000">
                        <label for="file_id">
                            <img src="../img/add.png"
                                style=" float:right ;width:20px ; height:20px;margin-top: -12px;margin-bottom: 12px;">
                        </label>
                        <input onchange="upload_check()" accept="image/*" type="file" id="file_id" name="file_id"
                            value="<?= 'image/' . $row['file_id'] ?>">
                        <span class="font-weight-bold">
                            <?php echo $row['name'] . '_' . $row['surname']; ?>
                        </span><span class="text-black-50">
                            <?php echo $row['user_email']; ?>
                        </span><span> </span>
                    </div>
                </div>
                <div class="col-md-5 border-right">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Profile Settings</h4>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6"><label class="labels">Name</label><input type="text"
                                    class="form-control" id="name" name="name" autocomplete="off"
                                    pattern="[A-Za-z\s]{3,32}" required placeholder="name" value="<?= $row['name'] ?>">
                            </div>

                            <div class="col-md-6"><label class="labels">Surname</label><input type="text"
                                    class="form-control" id="surname" name="surname" autocomplete="off"
                                    pattern="[A-Za-z\s]{3,32}" required placeholder="surname"
                                    value="<?= $row['surname'] ?>"></div>
                        </div>
                        <div class="row mt-3">


                            <div class="col-md-12"><label class="labels">About</label><input type="text"
                                    class="form-control" id="about" name="about" rows="3" required
                                    placeholder="enter somthing about you..." value="<?= $row['about'] ?>"></input>
                            </div>

                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6"><label class="labels">Country</label><input type="text" id="country"
                                    name="country" class="form-control" required placeholder="country"
                                    value="<?= $row['country'] ?>"></div>

                            <div class="col-md-6"><label class="labels">State</label><input type="text" id="state"
                                    name="state" class="form-control" required placeholder="state"
                                    value="<?= $row['state'] ?>"></div>

                            <div class="col-md-12"><label class="labels">City</label><input type="text" id="city"
                                    name="city" class="form-control" required placeholder="city"
                                    value="<?= $row['city'] ?>"></div>
                        </div>
                        <div class="mt-5 text-center"><button class="btn btn-primary profile-button" name="btn_post"
                                type="submit">Save Profile</button></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center experience"><span>Edit
                                Contact Info</span><span class="border px-3 p-1 add-experience"><i
                                    class="fa fa-plus"></i>&nbsp;Update</span></div><br>
                        <div class="col-md-12"><label class="labels">Facebook URL</label><input type="text"
                                class="form-control" name="facebook" id="facebook" placeholder="enter--url"
                                value="<?= $row['facebook'] ?>"></div>

                        <div class="col-md-12"><label class="labels">Twitter URL</label><input type="text"
                                class="form-control" name="twitter" id="twitter" placeholder="enter--url"
                                value="<?= $row['twitter'] ?>"></div>

                        <div class="col-md-12"><label class="labels">Instagram URL</label><input type="text"
                                class="form-control" name="insta" id="insta" placeholder="enter--url"
                                value="<?= $row['insta'] ?>"></div>

                        <div class="col-md-12"><label class="labels">LinkedIn URL</label><input type="text"
                                class="form-control" name="linkedin" id="linkedin" placeholder="enter--url"
                                value="<?= $row['linkedin'] ?>"></div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
        function upload_check() {
            var upl = document.getElementById("file_id");
            var max = document.getElementById("max_file_size").value;
            if (upl.files[0].size > max) {
                alert("File is too big! File-size Limit :10000kb");
                upl.value = "";
            }
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>

</html>