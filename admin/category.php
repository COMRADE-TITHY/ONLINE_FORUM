<?php
require __DIR__ . '/auth.php';

include('../partials/_function.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | Categories</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">

</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <?php include 'navbar.php'; ?>
        <?php include 'sidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Categories</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Categories</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <section>
                <div class="mb-2">
                    <div class="col-sm-12">
                        <a href="categoryAdd.php" class="btn btn-success">
                            <i class="fas fa-plus-circle nav-icon"></i>
                            <b>&nbsp;Add new category</b>
                        </a>
                    </div>
                </div>
            </section>
            <!-- Main content -->
            <section class="content">

                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Categories</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-1">
                        <table class="table table-striped projects" id="myTable">
                            <thead>
                                <tr>
                                    <th style="width: 1%">
                                        #
                                    </th>
                                    <th style="width: 20%">
                                        Category Name
                                    </th>
                                    <th style="width: 30%">
                                        Category Image
                                    </th>
                                    <th>
                                        Category Desc
                                    </th>
                                    <th style="width: 8%" class="text-center">
                                        Posts
                                    </th>
                                    <th style="width: 20%">
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include '../partials/_dbconnect.php';
                                $sql = "SELECT `categories`.category_id,`categories`.category_name,`categories`.category_description,`categories`.file_id,`categories`.created, COUNT(`threads`.thread_id) AS thread_count FROM `categories` LEFT JOIN `threads` ON `categories`.category_id=`threads`.thread_cat_id GROUP BY `categories`.category_id,`categories`.category_name,`categories`.category_description,`categories`.file_id,`categories`.created";
                                $result = mysqli_query($conn, $sql);
                                $sno = 0;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $sno = $sno + 1;
                                    $catname = $row["category_name"];
                                    $catdesc = $row["category_description"];
                                    $created = $row["created"];
                                    $filename = $row["file_id"];
                                    $threadCount = $row["thread_count"];

                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $sno; ?>
                                        </td>
                                        <td>
                                            <a>
                                                <?php echo $catname; ?>
                                            </a>
                                            <br />
                                            <small>
                                                <?php echo $created; ?>
                                            </small>
                                        </td>
                                        <td>
                                            <img src="<?= 'image/' . $filename ?>" style="width: 7rem;height: 5rem;"
                                                alt="Category Image">
                                        </td>
                                        <td class="project_progress">
                                            <small>
                                                <?php echo substr($catdesc, 0, 50) . "..."; ?>
                                            </small>
                                        </td>
                                        <td class="project-state">
                                            <span class="badge badge-success">
                                                <?php echo $threadCount; ?>
                                            </span>
                                        </td>
                                        <td class="project-actions text-right">
                                            <a class="btn btn-primary btn-sm view" href="#" type="button"
                                                data-toggle="modal" data-target="#modal-view"
                                                id="<?= $row['category_id'] ?>">
                                                <i class="fas fa-folder">
                                                </i>
                                                View
                                            </a>
                                            <a class="btn btn-info btn-sm edit" href="#" type="button" data-toggle="modal"
                                                data-target="#modal-edit" id="<?= $row['category_id'] ?>">
                                                <i class="fas fa-pencil-alt">
                                                </i>
                                                Edit
                                            </a>
                                            <a class="btn btn-danger btn-sm delete" href="#" type="button"
                                                data-toggle="modal" data-target="#modal-delete"
                                                id="<?= $row['category_id'] ?>">
                                                <i class="fas fa-trash">
                                                </i>
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <?php include 'footer.php'; ?>




        <div class="modal fade" id="modal-view">
            <div class="modal-dialog">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h4 class="modal-title">View Category</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modal-category-content">
                        <!-- <form action="fetchCategoryData.php" id="categoryDataForm" method="post"
                            enctype="multipart/form-data">
                            <input type="text" name="category_id" id="category_id" value="">
                        </form> -->
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->


        <div class="modal fade" id="modal-edit">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Edit Category</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="categoryEdit.php" method="post" enctype="multipart/form-data">
                                <div class="card-body">
                                    <input type="hidden" name="category_id" id="category_id">
                                    <div class="form-group">
                                        <label for="category_name">Category Name</label>
                                        <input type="text" class="form-control" id="category_name" name="category_name"
                                            placeholder="Enter category name">
                                    </div>
                                    <div class="form-group">
                                        <label for="category_description">Category Description</label>
                                        <input type="text" class="form-control" id="category_description"
                                            name="category_description" placeholder="category description">
                                    </div>
                                    <div class="form-group my-4">
                                        <label for="file_id">Category Image</label><br>
                                        <input type="hidden" id="max_file_size" name="max_file_size" value="100000">
                                        <input onchange="upload_check()" accept="image/*" type="file"
                                            class="form-control" id="file_id" name="file_id">
                                    </div>

                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" name="btn_post" class="btn btn-primary">Save Changes</button>
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



        <div class="modal fade" id="modal-delete">
            <div class="modal-dialog">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Category</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="categoryDelete.php" method="post">
                        <div class="modal-body">
                            <input type="hidden" name="category_del_id" id="category_del_id">
                            <p>Are you sure you want delete this category?</p>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                            <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
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
    <script src="https://code.jquery.com/jquery-3.7.0.js"
        integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

    <script>
        // For Pagination
        //let table = new DataTable('#myTable');
        $(document).ready(function () {
            $('#myTable').DataTable();
        });

    </script>
    <script>
        var modal = document.getElementById('modal-view');
        var viewCategoryButtons = document.querySelectorAll('.view');
        viewCategoryButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var categoryId = button.getAttribute('id');

                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'fetchCategoryData.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        var modalContent = document.getElementById('modal-category-content');
                        modalContent.innerHTML = '<img src="image/' + response.fileId + '" style="width: -moz-available;height: -moz-available;"><h3>' + response.categoryName + '</h3>' + '<p>' + response.categoryDesc + '</p>';
                        modal.style.display = "block";
                    }
                };
                xhr.send('id=' + categoryId);
                console.log(categoryId);
                // var category_id=document.getElementById('category_id');
                // category_id.value=categoryId;
                // document.getElementById('categoryDataForm').submit();

            });
        });



        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach(element => {
            element.addEventListener("click", (e) => {
                //tr = e.target.parentNode.parentNode;
                category_name = e.target.parentNode.parentNode.parentNode.parentNode.getElementsByTagName("a")[0].innerText;
                category_description = e.target.parentNode.parentNode.parentNode.getElementsByTagName("td")[3].innerText;
                console.log(category_name);
                console.log(category_description);
                category_name.value = category_name;
                category_description.value = category_description;
                category_id.value = e.target.id;
                console.log(category_id);
            })
        })
        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach(element => {
            element.addEventListener("click", (e) => {
                category_del_id.value = e.target.id;
                console.log(category_del_id);
            })
        })




    </script>
</body>

</html>