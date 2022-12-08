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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escape</title>
    <link rel="icon" href ="images/logo2.png" class="icon">
    <?php
    include "link.php";
    ?>
    <link rel="stylesheet" href="css/index.css">
</head>
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
                <li class="nav-item active">
                    <a class="nav-link" href="#">Package</a>
                </li>
                <li class="nav-item">
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
    <div class="container-fluid" style="margin-top: 15vh">
        <h3>Tour Packages with Fixed Departure Dates.</h3>
    </div>
    <div class="container-fluid" style="margin-top: 5vh">
        <div class="row row-cols-1 row-cols-md-4">
              <?php
                $sql = "SELECT * FROM  locations WHERE is_package=1";
                $res = mysqli_query($conn, $sql);
                if(mysqli_num_rows($res) > 0){
                    while ($row = mysqli_fetch_assoc($res)) {?>
                    <div class="col mb-4" >
                        <div class="card h-100" >
                            <img src="<?php echo $row['picture']; ?>" class="card-img-top" alt="..." style="height: 25vh; object-fit: cover;">
                            <div class="card-body">
                                <b><p class="card-title"><?php echo $row['title']; ?></p></b>
                                <p class="card-title"><?php echo $row['place']; ?></p>
                                <p class="card-text">Rate: <?php echo $row['rate']; ?></p>
                                <p class="card-text">Date: <?php  
                                                        $date = date_create($row['schedule_date']);
                                                        $year = date_format($date, 'M. d, y');
                                                        echo $year;?></p>
                                <p class="card-text">Discount: <?php echo $row['discount']; ?>%</p>
                                <p class="card-text" style="color: green"><b><i class="bi bi-tags"></i> <?php echo $english_format_number = number_format($row['amount']); ?></b> </p>
                            </div>
                             <?php
                                if (isset($_SESSION['is_admin'])) {
                                    if ($_SESSION['is_admin'] == 1) { ?>   
                                   <?php }
                                }
                                ?>
                                <?php
                                if (isset($_SESSION['is_admin'])) {
                                    if ($_SESSION['is_admin'] == 1) { ?>
                                      
                                       <a href="<?php echo 'viewdetails.php?locationID=' . $row['location_id']; ?>" class="btn btn-primary">View Details</a>
                                       
                                   <?php }
                                }
                                ?>
                            <?php
                                if (isset($_SESSION['is_admin']) == 0) {?>
                                    <a href="<?php echo 'location_package.php?locationID=' . $row['location_id']; ?>" class="btn btn-warning text-white">Book Now</a>      
                              <?php  }

                                ?>
                        </div>
                        
                    </div>

                   <?php     
                    }
                }

                ?>
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
    <script src="js/sweetalert2.js"></script>
    <?php
    if(isset($_SESSION['status_login']) && $_SESSION['status_login'] != ''){
        ?>
        <script>
             const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
            })
            Toast.fire({
            icon: 'success',
            title: 'Successfuly Login!'
            })

        </script>
        <?php
        unset($_SESSION['status_login']);
    }
    if(isset($_SESSION['status']) && $_SESSION['status'] != ''){
        ?>
        <script>
            const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
            })
            Toast.fire({
            icon: 'error',
            title: 'Login Field!'
            })

        </script>
        <?php
        unset($_SESSION['status']);
    }
    if(isset($_SESSION['status_success']) ){
        ?>
        <script>
             const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
            })
            Toast.fire({
            icon: 'success',
            title: 'Record Successfuly Added!'
            })

        </script>
        <?php
        unset($_SESSION['status_success']);
    }
    
    if(isset($_SESSION['status_error']) && $_SESSION['status_error'] != ''){
        ?>
        <script>
            Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
           
            })

        </script>
        <?php
        unset($_SESSION['status_error']);
    }
    ?>
</body>
</html>