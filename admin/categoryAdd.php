<?php
require __DIR__ . '/auth.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | Category Add</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            include '../partials/_dbconnect.php';

            $category_name = addslashes($_POST['category_name']);
            $category_description = addslashes($_POST['category_description']);

            $category_name = str_replace("<", "&lt", $category_name);
            $category_name = str_replace(">", "&gt", $category_name);

            $category_description = str_replace("<", "&lt", $category_description);
            $category_description = str_replace(">", "&gt", $category_description);


            $filename = $_FILES['file_id']['name'];
            $tempname = $_FILES['file_id']['tmp_name'];
            $destination = 'image/' . $filename;
            move_uploaded_file($tempname, $destination);
            $existSql = "SELECT * FROM `categories` WHERE `category_name`='$category_name'";
            $result = mysqli_query($conn, $existSql);
            $numRows = mysqli_num_rows($result);
            if ($numRows > 0) {
                $showError = "Category name already exists";
            } else {
                if (isset($_POST['btn_post']) && $category_name != "") {
                    $sql = "INSERT INTO `categories` (`category_name`,`category_description`,`file_id`) VALUES ('$category_name','$category_description','$filename')";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        //echo "The record has been inserted  successfully!";
                        $insert = true;
                    } else {

                        echo "The record was not  inserted successfully because of this error ---->" . mysqli_error($conn);
                    }
                    header("Location: category.php");
                }
            }
        }
        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="wrapper ">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Category Add</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Category Add</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content mx-5">
                <form action="categoryAdd.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">General</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Category Name</label>
                                        <input type="text" id="category_name" name="category_name" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="desc">Category Description</label>
                                        <textarea id="category_description" name="category_description"
                                            class="form-control" rows="4"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="file_id">Category Image</label>
                                        <input type="hidden" id="max_file_size" name="max_file_size" value="100000">
                                        <input onchange="upload_check()" type="file" accept="image/*" id="file_id"
                                            name="file_id" class="form-control">
                                    </div>
                                </div>

                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-10">
                            <a href="#" class="btn btn-secondary">Cancel</a>
                            <button type="submit" name="btn_post" class="btn btn-success float-right">Create new
                                Category</button>
                        </div>
                    </div>
                </form>
            </section>
            <!-- /.content -->
        </div>



    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
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
</body>

</html>