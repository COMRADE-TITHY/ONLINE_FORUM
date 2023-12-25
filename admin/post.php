<?php
require __DIR__ . '/auth.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | Posts</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">


    <script>

        function selectChildCheckboxes(element) {
            var isChecked = element.checked;
            var parentRow = element.parentElement.parentElement;
            var childCheckboxes = parentRow.querySelectorAll('.child-checkbox');
            for (var i = 0; i < childCheckboxes.length; i++) {
                childCheckboxes[i].checked = isChecked;

            }
        }

    </script>
</head>

<body class="hold-transition sidebar-mini">
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
                            <h1>Posts</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Posts</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>




            <!-- Main content -->
            <form method="post" action="deletePost.php">
                <section class="content">
                    <div class="row">

                        <!-- /.col -->
                        <div class="col-md-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Posts</h3>

                                    <div class="card-tools">
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control" placeholder="Search Post">
                                            <div class="input-group-append">
                                                <div class="btn btn-primary">
                                                    <i class="fas fa-search"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-tools -->
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                    <div class="mailbox-controls">
                                        <!-- Check all button -->
                                        <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i
                                                class="far fa-square"></i>
                                        </button>
                                        <div class="btn-group">
                                            <button type="submit" class="btn btn-default btn-sm" name="delete">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                            <button type="button" class="btn btn-default btn-sm">
                                                <i class="fas fa-reply"></i>
                                            </button>
                                            <button type="button" class="btn btn-default btn-sm">
                                                <i class="fas fa-share"></i>
                                            </button>
                                        </div>
                                        <!-- /.btn-group -->
                                        <button type="button" class="btn btn-default btn-sm">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                        <div class="float-right">
                                            1-50/200
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-sm">
                                                    <i class="fas fa-chevron-left"></i>
                                                </button>
                                                <button type="button" class="btn btn-default btn-sm">
                                                    <i class="fas fa-chevron-right"></i>
                                                </button>
                                            </div>
                                            <!-- /.btn-group -->
                                        </div>
                                        <!-- /.float-right -->
                                    </div>
                                    <div class="table-responsive mailbox-messages">
                                        
                                                <?php
                                                $threadQuery = "SELECT * FROM `threads`";
                                                $threadResult = mysqli_query($conn, $threadQuery);
                                                echo "<table  class='table table-hover table-striped'>";
                                                echo"<thead>
                                                <th></th>
                                               </thead>";
                                               echo"<tbody>";
                                                while ($threadRow = mysqli_fetch_assoc($threadResult)) {
                                                    $threadId = $threadRow["thread_id"];
                                                    $threadTitle = $threadRow["thread_title"];
                                                    $threadDesc = $threadRow["thread_desc"];
                                                    $threadUserId = $threadRow["thread_user_id"];
                                                    $created = $threadRow["timestamp"];

                                                    $userQuery ="SELECT * FROM `users` WHERE sno=$threadUserId";
                                                    $userResult = mysqli_query($conn, $userQuery);
                                                    $userRow = mysqli_fetch_assoc($userResult);
                                                    echo "<tr>";
                                                    echo "<td><input type='checkbox' onclick='selectChildCheckboxes(this);' class='parent-checkbox' name='selected_threads[]' value='$threadId'></td>";
                                                    echo "<td class='mailbox-star'><a href='#'><i class='fas fa-star text-warning'></i></a></td>";
                                                    echo "<td class='mailbox-name'><a href='#' class='ban' type='button' data-toggle='modal'
                                                    data-target='#modal-user-ban' id='". $userRow['sno'] ."'>".$userRow['user_email']."</a></td>";
                                                    echo "<td>";
                                                    echo "<b>$threadTitle</b><p>$threadDesc</p>";


                                                    $commentQuery = "SELECT * FROM `comments` WHERE `comments`.thread_id=$threadId";
                                                    $commentResult = mysqli_query($conn, $commentQuery);
                                                    echo "<table class='table table-hover table-striped'>";
                                                    while ($commentRow = mysqli_fetch_assoc($commentResult)) {
                                                        $commentId = $commentRow["comment_id"];
                                                        $commentContent = $commentRow["comment_content"];
                                                        $commentBy = $commentRow["comment_by"];
                                                        $commentTime = $commentRow["comment_time"];

                                                        $userQuery2 ="SELECT * FROM `users` WHERE sno=$commentBy";
                                                        $userResult2 = mysqli_query($conn, $userQuery2);
                                                        $userRow2 = mysqli_fetch_assoc($userResult2);
                                                        echo "<tr>";
                                                        echo "<td><input type='checkbox' class='child-checkbox' name='selected_comments[]' value='$commentId'></td>";
                                                        echo "<td class='mailbox-star'><a href='#'><i class='fas fa-star text-warning'></i></a></td>";
                                                        echo "<td class='mailbox-name'><a href='#'class='ban' type='button' data-toggle='modal'
                                                        data-target='#modal-user-ban' id='". $userRow2['sno'] ."'>".$userRow2['user_email']."</a></td>";
                                                        echo "<td>$commentContent</td>";
                                                        echo "<td class='mailbox-date'>$commentTime</td>";
                                                        echo "</tr>";
                                                    }
                                                    echo "</table>";
                                                    echo "</td>";
                                                    echo "<td class='mailbox-date'>$created</td>";
                                                    echo "</tr>";
                                                }
                                                echo "</tbody>";
                                                echo "</table>";

                                                ?>
                                            
                                        <!-- /.table -->
                                    </div>
                                    <!-- /.mail-box-messages -->
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer p-0">
                                    <div class="mailbox-controls">
                                        <!-- Check all button -->
                                        <button type="button" class="btn btn-default btn-sm checkbox-toggle">
                                            <i class="far fa-square"></i>
                                        </button>
                                        <div class="btn-group">
                                            <button type="submit" class="btn btn-default btn-sm" name="delete">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                            <button type="button" class="btn btn-default btn-sm">
                                                <i class="fas fa-reply"></i>
                                            </button>
                                            <button type="button" class="btn btn-default btn-sm">
                                                <i class="fas fa-share"></i>
                                            </button>
                                        </div>
                                        <!-- /.btn-group -->
                                        <button type="button" class="btn btn-default btn-sm">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                        <div class="float-right">
                                            1-50/200
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-sm">
                                                    <i class="fas fa-chevron-left"></i>
                                                </button>
                                                <button type="button" class="btn btn-default btn-sm">
                                                    <i class="fas fa-chevron-right"></i>
                                                </button>
                                            </div>
                                            <!-- /.btn-group -->
                                        </div>
                                        <!-- /.float-right -->
                                    </div>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </section>
            </form>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php include 'footer.php'; ?>

        <div class="modal fade" id="modal-user-ban">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body" id="modal-user-content">
                    <form action="userBan.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="ban_id" id="ban_id">
                       
                            <div>
                                <button type="submit" class="btn  btn-danger btn-block" name="ban"><b>Ban</b></button>
                                <button type="submit"  class="btn btn-primary btn-block" name="unban"><b>Unban</b></button>
                            </div>
                            
                      
                    </form>
                </div>

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
    <!-- Page specific script -->
    <script>
         bans = document.getElementsByClassName('ban');
        Array.from(bans).forEach(element => {
            element.addEventListener("click", (e) => {
                ban_id.value = e.target.id;
                console.log(ban_id);
            });
        });

    </script>
    <script>
          deletes = document.getElementsByName('delete');
            Array.from(deletes).forEach((element) => {
                element.addEventListener("click", (e) => {
                    console.log("delete",);
                    sno = e.target.id.substr(1,);
                    if (confirm("Are you sure you want to delete this note!")) {
                        console.log("yes");
                    }
                    else {
                        console.log("no");
                    }

                })
            })

        $(function () {
            //Enable check and uncheck all functionality
            $('.checkbox-toggle').click(function () {
                var clicks = $(this).data('clicks')
                if (clicks) {
                    //Uncheck all checkboxes
                    $('.mailbox-messages input[type=\'checkbox\']').prop('checked', false)
                    $('.checkbox-toggle .far.fa-check-square').removeClass('fa-check-square').addClass('fa-square')
                } else {
                    //Check all checkboxes
                    $('.mailbox-messages input[type=\'checkbox\']').prop('checked', true)
                    $('.checkbox-toggle .far.fa-square').removeClass('fa-square').addClass('fa-check-square')
                }
                $(this).data('clicks', !clicks)
            })

            //Handle starring for font awesome
            $('.mailbox-star').click(function (e) {
                e.preventDefault()
                //detect type
                var $this = $(this).find('a > i')
                var fa = $this.hasClass('fa')

                //Switch states
                if (fa) {
                    $this.toggleClass('fa-star')
                    $this.toggleClass('fa-star-o')
                }
            })
        })
    </script>
</body>

</html>
