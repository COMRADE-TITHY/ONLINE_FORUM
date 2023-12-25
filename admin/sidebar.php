<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../index.php" class="brand-link">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">iDiscuss</span>
    </a>
    <?php
    if (isset($_SESSION['admin_loggedin']) && $_SESSION['admin_loggedin'] == true) {
        ?>
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <?php if ($_SESSION['admin_image_id'] == "") {
                        echo '<img src="../img/userdefault.png" class="img-circle elevation-2" alt="User Image" style="height: 2.1rem;width: 2.1rem;">';
                    } elseif($_SESSION['admin_image_id'] != "") { ?>
                        <img src="<?= 'image/' . $_SESSION['admin_image_id'] ?>" class="img-circle elevation-2" alt="User Image" style="height: 2.1rem;width: 2.1rem;">
                    <?php } ?>
                </div>
                <div class="info">
                    <a href="#" class="d-block" type="button" data-toggle="modal" data-target="#modal-sm">
                        <?php echo $_SESSION['admin_username']; ?>
                    </a>
                </div>
            </div>
        <?php } ?>
        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="./index.php" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Forum Dashboard </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Categories
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">


                        <li class="nav-item">
                            <a href="category.php" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Categories</p>
                            </a>
                        </li>
                        


                    </ul>
                </li>
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Users
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">


                        <li class="nav-item">
                            <a href="user.php" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Users</p>
                            </a>
                        </li>



                    </ul>
                </li>
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            Posts
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">


                        <li class="nav-item">
                            <a href="post.php" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Post</p>
                            </a>
                        </li>



                    </ul>
                </li>
            </ul>

        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<?php
$user_id = $_SESSION['admin_sno'];
include '../partials/_dbconnect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // update the record
    $name = $_POST['name'];
    $bio = $_POST['bio'];
    $filename = $_FILES['image_id']['name'];
    $tempname = $_FILES['image_id']['tmp_name'];
    $destination = 'image/' . $filename;
    move_uploaded_file($tempname, $destination);


    //sql query to be executed
    $sql1 = "UPDATE  `admin` SET `name` = '$name' , `bio`='$bio',`image_id`='$filename' WHERE `admin`.`admin_id` = '$user_id'";
    $result1 = mysqli_query($conn, $sql1) or die("failed");
    if ($result1) {
        // echo "We updated the record Successfully";
        $update = true;
    } else {
        echo "We could not update the record Successfully";
    }

    $sql = "select * from admin where admin_id = '$user_id' limit 1";
    $result = mysqli_query($conn, $sql) or die("failed");
    $row = mysqli_fetch_assoc($result);
}
$sql = "select * from admin where admin_id = '$user_id' limit 1";
$result = mysqli_query($conn, $sql) or die("failed");
$row = mysqli_fetch_assoc($result);
?>
<div class="modal fade" id="modal-sm">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <?php if ($row['image_id'] == "") {
                                echo '<img src="../img/userdefault.png" class="profile-user-img img-fluid img-circle" alt="User profile picture" style="height: 120px;width: 120px;">';
                            } else { ?>
                                <img class="profile-user-img img-fluid img-circle" src="<?= 'image/' . $row['image_id'] ?>"
                                    alt="User profile picture" style="height: 120px;width: 120px;">
                            <?php } ?>
                        </div>

                        <h3 class="profile-username text-center">
                            <?php echo $row['name'] ?>
                        </h3>

                        <p class="text-muted text-center">
                            <?php echo $row['bio'] ?>
                        </p>

                        <a href="#" class="btn btn-primary btn-block " type="button" data-toggle="modal"
                            data-target="#modal-default"><b>Edit
                                Profile</b></a>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Profile</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="<?= $_SERVER["REQUEST_URI"] ?>" method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name"
                                    value="<?= $row['name'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="bio">Bio</label>
                                <input type="text" class="form-control" id="bio" name="bio" placeholder="bio"
                                    value="<?= $row['bio'] ?>">
                            </div>
                            <div class="form-group my-4">
                                <label for="file_id">Image</label><br>
                                <input type="hidden" id="max_file_size" name="max_file_size" value="100000">
                                <input onchange="upload_check()" accept="image/*" type="file" class="form-control"
                                    id="image_id" name="image_id">
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<script>
    function upload_check() {
        var upl = document.getElementById("file_idEdit");
        var max = document.getElementById("max_file_size").value;
        if (upl.files[0].size > max) {
            alert("File is too big! File-size Limit :100kb");
            upl.value = "";
        }
    };
</script>