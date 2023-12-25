<?php
session_start();

echo '<nav class="navbar navbar-dark navbar-expand-lg bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/forum"><b style="color: #069906;">iDiscuss</b></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/forum">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/forum/about.php">About</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Top Categories
                        </a>
                        <ul class="dropdown-menu">';

                        $sql= "SELECT `category_name`,`category_id` FROM `categories` LIMIT 3";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<li><a class="dropdown-item" href="threadlist.php?catid='.$row['category_id'].'">'.$row['category_name'].'</a></li>';
                            
                        }
                    echo  '</ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="/forum/contact.php">Contact</a>
                    </li>
                </ul> ';
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true) {
    
                       echo     ' <form class="d-flex" role="search" action="search.php" method="get">
                                <button class="mt-1 mx-2" type="submit" style="background-color: inherit;
                                border: none;"><img src="forum/../img/search.png" width="30px" height="30px"></button>
                                <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search"> ';
                                if($_SESSION['file_id']==""){
                                    echo '<a href="/forum/userProfile.php" class="mx-2"><img src="forum/../img/userdefault.png" width="40px" style="border: 2px solid green;border-radius: 50%;"></a>';
                                }
                                else{
                                   echo '<a href="/forum/userProfile.php" class="mx-2"><img src="partials/image/'. $_SESSION['file_id'] .'" width="40px" height="40px"; style="border: 2px solid green;border-radius: 50%;"></a>';
                                }
                                echo '<a  href="partials/_logout.php" class=" mt-1 ml-2" ><img src="forum/../img/logout.png" width="30px" height="30px"></a>
                                </form>';
                }
                else{
                    echo '<div class="mx-2">
                        <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
                        <button class="btn btn-outline-success " data-bs-toggle="modal" data-bs-target="#signupModal">SignUp</button>
                        </div>
                        <form class="d-flex" role="search" action="search.php" method="get">
                        <button class="mt-1 mx-2" type="submit" style="background-color: inherit;
                        border: none;"><img src="forum/../img/search.png" width="30px" height="30px"></button>
                        <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
                </form>';
            }
       echo' </div>
    </div>
</nav>';

include 'partials/_loginModal.php';
include 'partials/_signupModal.php';

if (isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "true") {
    echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
    <strong>Success!</strong> You can now login
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}
// else {
//     echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
//         <strong>Error!</strong> ' . $showError . '
//         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
//         </div>';

// }

?>
