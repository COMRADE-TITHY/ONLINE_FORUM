<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iDiscuss | Coding Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <style>
        #categories {
            min-height: 433px;
        }
    </style>
</head>

<body>
    <?php include 'partials/_dbconnect.php'; ?>
    <?php include 'partials/_header.php'; ?>

   
    <div class="container my-5">
        <div class="d-flex justify-content-between my-2">
            <h2>Top Questions<span class="badge bg-primary mx-1">New</span></h2>
            <a href="askQuestion.php" class="btn btn-primary" style="height: fit-content;">Ask Question</a>
        </div>
        <div class="d-flex flex-row-reverse my-3">
            <div class="p-2 border border-secondary-subtle">Month</div>
            <div class="p-2 border border-secondary-subtle">Week</div>
            <a href="#categories" class="link-underline link-underline-opacity-0 p-2 border border-secondary-subtle">Browse Categories</a>
        </div>
        <hr>
        <?php
        $sql = "SELECT * FROM `threads` ORDER BY `timestamp` DESC LIMIT 50";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $threadId = $row["thread_id"];
                $threadTitle = $row["thread_title"];
                $threadDesc = $row["thread_desc"];
                $thread_user_id = $row["thread_user_id"];
                $threadDate = $row["timestamp"];

                $sql2 = "SELECT * FROM `users` WHERE `sno`='$thread_user_id'";
                $result2 = mysqli_query($conn, $sql2);
                $row2 = mysqli_fetch_assoc($result2);
                $threadOwner = $row2["user_email"];

                echo "<div class='mb-2 item' ><div class='mx-2'><a href='main.php?id=$threadId' class='link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover'><b>$threadTitle</b></a><br><p>$threadDesc</p></div>
            <div class='mx-2 '><small><a href='userProfile.php?cid=" . $thread_user_id . "' class='link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover'>$threadOwner</a> asked $threadDate</small></div></div><hr>";
            }
        } else {
            echo "<div class='jumbotron jumbotron-fluid '>
            <div class='container '>
              <h1 class='display-4'>No  posts found</h1>
              <p class='lead'>Be the first person to ask a question</p>
            </div>
          </div>";
        }
        ?>
    </div>

    <!-- Catagory Container  -->
    <div class="container my-4" id="categories">
        <h2 class="text-center my-4"> iDiscuss - Browse Categories</h2>
        <div class="row my-4">

            <!-- Fetch all the categories and use a for loop to iterate through categories -->
            <?php
            $sql = "SELECT * FROM `categories`";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['category_id'];
                $cat = $row['category_name'];
                $desc = $row['category_description'];
                $filename = $row['file_id'];
                echo '<div class="col-md-4 my-2">
                        <div class="card " style="width: 18rem;">
                            <img src="/forum/admin/image/' . $filename . '" class="card-img-top" alt="category-image" style="width: 18rem;height: 13rem;">
                            <div class="card-body ">
                                <h5 class="card-title"><a href="threadlist.php?catid=' . $id . '" style="text-decoration: none;">' . $cat . '</a></h5>
                                <p class="card-text">' . substr($desc, 0, 50) . '...</p>
                                <a href="threadlist.php?catid=' . $id . '" class="btn btn-primary">View Threads</a>
                            </div>
                        </div>
                    </div>';
            }
            ?>
        </div>
    </div>


    <?php include 'partials/_footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>

</body>

</html>