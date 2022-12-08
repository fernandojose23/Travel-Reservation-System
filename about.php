<?php
    session_start();

    include 'mysql_connect.php';

    if (isset($_POST['submit'])) {

        $username = $_POST['username'];
        $password = $_POST['password'];

        $ciphering = "AES-128-CTR";
        $option = 0;
        $encryption_iv = '1234567890123456';
        $encryption_key = "info";
        $encryption = openssl_encrypt($username,$ciphering,$encryption_key,$option,$encryption_iv);

        $ciphering = "AES-128-CTR";
        $option = 0;
        $encryption_iv = '1234567890123456';
        $encryption_key = "info";
        $encryption2 = openssl_encrypt($password,$ciphering,$encryption_key,$option,$encryption_iv);

        $sql = "SELECT * FROM login
        WHERE username = '$encryption'
        AND password = '$encryption2'";

        $res = mysqli_query($conn, $sql);
        if (mysqli_num_rows($res) == 1) {
            $row = mysqli_fetch_assoc($res);
            $_SESSION['user'] = $username;
            $_SESSION['is_admin'] = $row['is_admin'];
            
            $_SESSION['status_login'] = "success";
            if ($row['is_admin'] == 1) {    
                $_SESSION['status_login'] = "success";
                header("location:index.php#login");
            }
            else {
                header("location:index.php");
                $_SESSION['status_login'] = "success";
            }
        } else {
            $_SESSION['status'] = "error"; 
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Escape</title>
    <link rel="icon" href ="images/logo2.png" class="icon">
</head>
    <?php
        include "link.php";
    ?>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/about.css">

<body>

     <div class="nav-wrapper">
       <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand mt-1" href="index.php"><h4>ESCAPE.mɘ</h4></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                <li class="nav-item ">
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                     <?php
                        if (isset($_SESSION['is_admin'])) {
                            if ($_SESSION['is_admin'] == 1) {
                                echo '   <a class="nav-link" href="reservation_list.php">Reservation List</a>';
                            }
                        } else {
                            echo '';
                        }

                        ?>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="blog.php">Blog</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="package.php">Package</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>
                </ul>
                <div class="form-inline my-2 my-lg-0">               
                 <?php
                        if (isset($_SESSION['is_admin'])) {
                            if ($_SESSION['is_admin'] == 1) {
                                echo ' <a class="">
                                    <form action="logout.php" method="POST">
                                        <button type="submit" name="logout" class="btn my-1 mx-auto "  ><i class="bx bx-user-minus" ></i> Logout</button>
                                    </form>
                                </a>';
                                
                            }
                        } else {
                            echo '  <button type="button" class="btn my-1 mx-auto " data-bs-toggle="modal" data-bs-target="#ModalForm">
                                    <i class="bx bx-user"></i> Login
                                    </button>';
                                    
                        }
                        ?>
                </div>
            </div>
        </nav>
    </div>
    <div class="container">
        <div class="row justify-content-center ">
            <div class="col-md-12 d-flex justify-content-center mt-2">         
            </div>
        </div>
        <div class="section">
            <div class="container">
                <div class="content-section">
                    <div class="title">
                        <h1>About Us</h1>
                    </div>
                    <div class="content">
                        
                        <p align="justify" style="text-indent: 40px;">
                        Welcome to Escape, your one-stop brand for all things related to travel adventures. We're committed to providing you with the best possible travel experience, with a focus on securing your stay, providing you with comfort while traveling, and ensuring you have a fine experience.</br>

                        <p align="justify" style="text-indent: 40px;"> Escape was founded in 2022 by FJE, and has come a long way from its beginnings in Central Luzon State University. When FJE first started out, their passion for traveling and adventures drove them to start making their own website for travel, so that Escape can offer you the best travel booking agency. We now serve customers all over the country, and are thrilled that we're able to turn our passion into our own website.</p>

                        <p align="justify" style="text-indent: 40px;">We hope you like our offer and servers as much as we do. Please don't hesitate to contact us if you have any questions or comments.</br>

                        <p align="justify"> With respect, Escape</p>
                        
                    </div>
                </div>
                <div class="image-section">
                    <img src="images/logo2.png">
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid ">
        <!-- Modal Form -->
        <div class="modal fade" id="ModalForm" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" >
            <div class="modal-content">
                <!-- Login Form -->
            <form action="" method="POST" class="needs-validation" novalidate>
                <div class="modal-header">
                    <h1 class="modal-title" style="font-weight: 400;">Login</h1>
                    <i data-bs-dismiss="modal" aria-label="Close"></i>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="Username">Username<span class="text-danger"> *</span></label>
                        <input type="text" name="username" class="form-control" id="Username" placeholder="Enter Username" required>
                        <div class="invalid-feedback">Please Choose a Username.</div>
                    </div>
                    <div class="mb-3">
                        <label for="Password">Password<span class="text-danger"> *</span></label>
                        <input type="password" name="password" class="form-control" id="Password" placeholder="Enter Password" required>
                        <div class="invalid-feedback">Please Enter Password.</div>
                    </div>
                  
                </div>
                <div class="modal-footer pt-4 ">                  
                    <button type="submit" name = "submit" class="btn mx-auto w-100 btn-primary" >Login</button>
                </div>
                
            </form>
            </div>
        </div>
        </div>
    </div>

    <?php
    include 'footer.php';
    ?>

</body>
</html>