<?php
require __DIR__ . '/auth.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | Users List</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        <?php include 'navbar.php'; ?>
        <?php include 'sidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Users List</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Users List</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Info boxes -->
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">CPU Traffic</span>
                                    <span class="info-box-number">
                                        10
                                        <small>%</small>
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-danger elevation-1"><i
                                        class="fas fa-user"></i></span>

                                        <?php
                                include '../partials/_dbconnect.php';

                                $user_ban_sql = "SELECT COUNT(*) AS ban_user_count FROM `users` WHERE is_banned=1";
                                $user_ban_result = mysqli_query($conn, $user_ban_sql);
                                $user_ban_row = mysqli_fetch_assoc($user_ban_result);
                                $total_ban_users= $user_ban_row["ban_user_count"];
                                ?>
                                <div class="info-box-content">
                                    <span class="info-box-text">Ban Users</span>
                                    <span class="info-box-number"><?php echo $total_ban_users;?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->

                        <!-- fix for small devices only -->
                        <div class="clearfix hidden-md-up"></div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-success elevation-1"><i
                                        class="fas fa-shopping-cart"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Sales</span>
                                    <span class="info-box-number">760</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                                <?php
                                include '../partials/_dbconnect.php';

                                $user_sql = "SELECT COUNT(*) AS user_count FROM `users`";
                                $user_result = mysqli_query($conn, $user_sql);
                                $user_row = mysqli_fetch_assoc($user_result);
                                $total_users= $user_row["user_count"];
                                ?>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Members</span>
                                    <span class="info-box-number"><?php echo $total_users;?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                    </div>



                    <div class="col-md-12">
                        <!-- USERS LIST -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Latest Members</h3>

                                <div class="card-tools">
                                    <span class="badge badge-danger">8 New Members</span>
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <ul class="users-list clearfix " id="itemContainer">
                                    <?php
                                    include '../partials/_dbconnect.php';

                                    $sql = "SELECT * FROM `users`";
                                    $result = mysqli_query($conn, $sql);
                                    $sno = 0;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $sno = $sno + 1;
                                        $username = $row["user_email"];
                                        $dateTime = $row['timestamp'];
                                        $date = date("d-F-Y", strtotime($dateTime));
                                        ?>
                                        <li style="width:10%" class="item">
                                            <?php if ($row["file_id"] == "") {
                                                echo "<img src='../img/userdefault.png ' alt='User Image'style='height: 60px;width: 60px;border: 2px solid purple;'>";
                                            } else { ?>
                                                <img src="<?= '../partials/image/' . $row['file_id'] ?>" alt="..."
                                                    style="height: 60px;width: 60px;border: 2px solid purple;">
                                            <?php } ?>
                                            <a class="users-list-name ban user" href="#" type="button" data-toggle="modal"
                                                data-target="#modal-user-ban" id="<?= $row['sno'] ?>">
                                                <?php echo $username; ?>
                                            </a>
                                            <span class="users-list-date">
                                                <?php echo $date; ?>
                                            </span>
                                        </li>
                                    <?php } ?>
                                </ul>
                                <!-- /.users-list -->
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer text-center">
                                <a href="#" type="button" id="showAllButton">View All Users</a>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                        <!--/.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

            </section>
        </div>
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <?php include 'footer.php'; ?>
    </div>
    <!-- ./wrapper -->




    <div class="modal fade" id="modal-user-ban">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body" id="modal-user-content">
                    <form action="userBan.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="ban_id" id="ban_id">

                        <div>
                            <button type="submit" class="btn  btn-danger btn-block" name="ban"><b>Ban</b></button>
                            <button type="submit" class="btn btn-primary btn-block" name="unban"><b>Unban</b></button>
                        </div>


                    </form>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->




    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.js"></script>

    <!-- PAGE PLUGINS -->
    <!-- jQuery Mapael -->
    <script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
    <script src="plugins/raphael/raphael.min.js"></script>
    <script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
    <script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
    <!-- ChartJS -->
    <script src="plugins/chart.js/Chart.min.js"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <!-- <script src="dist/js/pages/dashboard2.js"></script> -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var itemContainer = document.getElementById('itemContainer');
            var showAllButton = document.getElementById('showAllButton');

            var items = itemContainer.querySelectorAll('.item');
            for (var i = 10; i < items.length; i++) {
                items[i].style.display = 'none';

            }
            showAllButton.addEventListener('click', function () {
                items.forEach(function (item) {
                    item.style.display = 'block';
                });
                showAllButton.style.display = 'none';
            });

        });



        bans = document.getElementsByClassName('ban');
        Array.from(bans).forEach(element => {
            element.addEventListener("click", (e) => {
                ban_id.value = e.target.id;
                console.log(ban_id);
            });
        });

    </script>
</body>

</html>