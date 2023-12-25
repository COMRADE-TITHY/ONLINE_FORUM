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
        #categories {
            min-height: 433px;
        }
    </style>
</head>

<body>
    <?php include 'partials/_dbconnect.php'; ?>
    <?php include 'partials/_header.php'; ?>
    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        if ($_SESSION['is_banned'] == 0) {

            $isInsert=false;
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
                $userCategory = addslashes($_POST['category']);
                $sql = "SELECT category_id FROM `categories` WHERE MATCH (`category_name`) against ('$userCategory')";
                $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $categoryId = isset($row['category_id']) ? $row['category_id']: null;
                } else {
                    $insertCategorySql = "INSERT INTO `categories` (`category_name`) VALUES ('$userCategory')";
                    if (mysqli_query($conn, $insertCategorySql) === TRUE) {
                        $categoryId = $conn->insert_id;
                    } else {
                        echo "ERROR: " . $conn->error;
                    }
                }


                $postTitle = addslashes($_POST['title']);
                $postContent = htmlspecialchars($_POST['desc'],ENT_QUOTES,'UTF-8');
                $userId = $_SESSION['sno'];
                $insertPostSql = "INSERT INTO `threads` (`thread_title`,`thread_desc`,`thread_cat_id`,`thread_user_id`) VALUES ('$postTitle','$postContent','$categoryId','$userId')";
                if (mysqli_query($conn, $insertPostSql) === TRUE) {
                    // echo "Post Created Successfully";
                    $isInsert=true;
                    if ($isInsert) {
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Post Created Successfully.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
                    }
                } else {
                    echo "ERROR: " . $conn->error;
                }
            }
            ?>
            <div class="container">

                <h1 class="my-5">Ask a public question</h1>
                <div class="jumbotron jumbotron-fluid ">
                    <div class="container ">
                        <h1 class="display-4">Writing a good Question</h1>
                        <p class="lead">You are ready to ask a programming-related question and this form will help guide you
                            through the process</p>
                            <p class="lead">Steps:<ul>
                           <li> Summarize your problem in a one line title.</li>
                           <li> Desribe your problem in more detail.</li>
                           <li> Add category tags which help surface your question to members of the community.</li>
                           <li> Review your question and post it to the site.</li></ul>
                         </p>
                    </div>
                </div>
                <form action="askQuestion.php" method="post" class="container my-5">

                    <div class="mb-3">
                        <label for="title" class="form-label">Title <br><small>Be Specific and imagine you are asking a question to another person</small></label>
                        <input type="text" class="form-control" id="title" name="title"
                            placeholder="e.g.How to do pagination with ajax">
                    </div>
                    <div class="mb-3">
                        <label for="desc" class="form-label">Description <br><small>Introduce the problem and expand on what you put in the title</small></label>
                        <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category Tags <br><small>Add upto 2-3 tags to describe what your question is about</small></label>
                        <input type="text" class="form-control" id="category" name="category"
                            placeholder="e.g.(sql-server ajax)">
                    </div>
                    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                </form>
            </div>
            <?php
        } else if ($_SESSION['is_banned'] == 1) {
            echo '<div class="container">
        <p class="lead">Your ID has banned.. you can not be able to post</p>
    </div>
    ';
        }
    } else {
        echo '<div class="container">
            <h1 class="py-2">Post a Comment</h1>
            <p class="lead">You are not logged in... Please login to be able to post comments</p>
        </div>
        ';
    }
    ?>
    <?php include 'partials/_footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>

</body>

</html>