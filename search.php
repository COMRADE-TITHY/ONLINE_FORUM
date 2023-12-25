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
        #maincontainer {
            min-height: 100vh;
        }
    </style>
</head>

<body>
    <?php include 'partials/_dbconnect.php'; ?>
    <?php include 'partials/_header.php'; ?>



    <!-- Search Results -->
    <div class="container my-3" id="maincontainer">
        <h1>Search results for <em>"
                <?php echo $_GET['search'] ?>"
            </em></h1>

        <?php
        $noResult = true;
        $query = $_GET["search"];
        $sql = "SELECT * FROM threads WHERE MATCH (thread_title,thread_desc) against ('$query')";
        $result = mysqli_query($conn, $sql) or die("failed");
        while ($row = mysqli_fetch_assoc($result)) {
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thread_id = $row['thread_id'];
            $url = "thread.php?threadid=" . $thread_id;
            $noResult=false;

            echo '<div class="result">
                    <h3><a href="' . $url . '" class="text-dark">' . $title . '</a></h3>
                    <p>' . $desc . '</p>
                </div>';
        }
        if ($noResult) {
            echo '<div class="jumbotron jumbotron-fluid ">
            <div class="container ">
              <h1 class="display-4">No Results Found</h1>
              <p class="lead">Suggestions:<ul>
                           <li> Make sure that all words are spelled correctly.</li>
                           <li> Try different keywords.</li>
                           <li> Try more general keywords.</li></ul>
              </p>
            </div>
          </div>';
        }

        ?>

    </div>

    <?php include 'partials/_footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>

</body>

</html>