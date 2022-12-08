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

if(isset($_POST["submitLocation"])){
   
    $title = $_POST['title'];
    $titles = str_replace("'","\'",$title);
    $place = $_POST['place'];
    $rate = $_POST['rate'];
    $amount = $_POST['amount'];
    $location_link = $_POST['location_link'];
    $description = stripslashes($_POST['description']);
    $descriptions = str_replace("'","\'",$description);
    $charge = $_POST['charge'];

    $date = date_create();
    $stamp = date_format($date, "Y");
    $temp = $_FILES['myfile']['tmp_name'];
    $directory = "images/" . $stamp . $_FILES['myfile']['name'];

    $dob = date('Y-m-d', strtotime($_POST['date']));
    $discounts = $_POST['discount'];
    $isPackage = $_POST['package'];

    if (move_uploaded_file($temp, $directory)) {
        $sql = "INSERT INTO locations SET 
            picture='$directory',
            title = '$titles',
            place='$place',
            rate='$rate',
            amount='$amount',
            link='$location_link',
            descriptions='$descriptions',
            charge='$charge',
            schedule_date='$dob',
            discount='$discounts',
            is_package='$isPackage';";
            
    if (mysqli_query($conn, $sql)) {
            $_SESSION['status_success'] = "success";
            unset($_POST['submitLocation']);
            
        } else {
            echo mysqli_error($conn);
            echo '<script>';
            echo "alert('Error Occur!');" . mysqli_error($conn);
            echo '</script>';
        }
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

<body> 

    <div class="nav-wrapper">
       <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand mt-1" href="index.php"><h4>ESCAPE.mɘ</h4></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
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
                            if ($_SESSION['is_admin'] == 1 || $_SESSION['is_admin'] == 0) {
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
    
    <div class="container-fluid" >
        <div class="card text-white" style="margin-top: 14vh;">
        <img src="images/background.png" class="card-img" alt="..." style="height: 70vh;  object-fit:cover; ">
        </video>
        
        <div class="carousel-caption d-none d-md-block">
        <h4 class="card-title" style="font-weight: 500;">“One’s destination is never a place, but a new way of seeing things.”</h4>
      </div>
    </div>
    </div>
    <div class="container-fluid ">
        
        <div class=" py-2" style="margin-top: 2vh;">
            <h3>  Best Location</h3>
                    <?php
                    if (isset($_SESSION['is_admin'])) {
                        if ($_SESSION['is_admin'] == 1) {
                            echo '<button type="submit"  class="btn btn-primary " data-toggle="modal" data-target="#AddnewLocation">Add Travel Location</button></br>';       
                        }
                    }
                    ?>
        </div>
    </div>

    <div class="container-fluid" style="margin-top: 1vh">
        <div class="row row-cols-1 row-cols-md-4" >
            
                <?php
                $sql = "SELECT * FROM  locations WHERE is_package=0";
                $res = mysqli_query($conn, $sql);
                if(mysqli_num_rows($res) > 0){
                    while ($row = mysqli_fetch_assoc($res)) {?>
                    <div class="col mb-4" >
                        <div class="card h-100" >
                            <img src="<?php echo $row['picture']; ?>" class="card-img-top" alt="..." style="height: 25vh; object-fit: cover;">
                            <div class="card-body">
                                <b><p class="card-title"> <?php echo $row['title']; ?></p></b>
                                <p class="card-title"><?php echo $row['place']; ?></p>
                                <p class="card-title"><i class="bi bi-calendar-check text-danger"></i> <?php  
                                                        $date = date_create($row['schedule_date']);
                                                        $year = date_format($date, 'M. d, y');
                                                        echo $year;?></p>
                                <p class="card-text"><span id="boot-icon" class="bi bi-star-fill" style=" color: rgb(243, 156, 18);"></span> <?php echo $row['rate']; ?></p>
                                <p class="card-text" style="color: green"><b><i class="bi bi-tags"></i> <?php echo $english_format_number = number_format($row['amount']);?></b> </p>
                            </div>
                            <?php
                                if (isset($_SESSION['is_admin'])) {
                                    if ($_SESSION['is_admin'] == 1) { ?>
                                      
                                       <a href="<?php echo 'viewdetails.php?locationID=' . $row['location_id']; ?>" class="btn btn-primary">View Details</a>
                                       
                                   <?php }
                                }
                                ?>
                            <?php
                                if (isset($_SESSION['is_admin']) == 0) {?>
                                 <?php 
                                 if($row['is_package']==1){?>
                                    <a href="<?php echo 'location_package.php?locationID=' . $row['location_id']; ?>" class="btn btn-warning text-white">Book Now</a>

                                 <?php
                                 }else{?>
                                     <a href="<?php echo 'location_details.php?locationID=' . $row['location_id']; ?>" class="btn btn-warning text-white">Book Now</a>
                                 <?php }
                                 
                                 ?>     
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
        <div class="modal fade" id="AddnewLocation" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" >
                <div class="modal-content">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h1 class="modal-title" style="font-weight: 400;">Add New Location</h1>
                            <i data-bs-dismiss="modal" aria-label="Close"></i>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="package">Package or Not?<span class="text-danger"> *</span></label>
                                <select class="form-control" name="package" id="package" onchange="disableDiscount(this)">
                                    <option value="" selected>Please Choose...</option>
                                    <option value="1">Package</option>
                                    <option value="0">Not Package</option>   
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="myfile">Image<span class="text-danger"> *</span></label>
                                <img class="card-img-top movie_input_img" id="output" src="images/default_image.png" alt="Card image" style="width: 100%; height: auto; ">
                                <input type="file" class="form-control" id="myfile"  name="myfile" accept="image/*" onchange="loadFile(event)" required/>
                            </div>
                            <div class="mb-3">
                                <label for="title">Title of Location<span class="text-danger"> *</span></label>
                                <input type="text" name="title" class="form-control" id="title" placeholder="Enter Name of Location" required>
                                <h6 id="title_validate" class="errorstyle"></h6>
                            </div>
                            <div class="mb-3">
                                <label for="place">Place<span class="text-danger"> *</span></label>
                                <input type="text" name="place" class="form-control" id="place" placeholder="Enter Place" required>
                            </div>
                            <div class="mb-3">
                                <label for="rate">Rate<span class="text-danger"> *</span></label>
                                <input type="text" name="rate" class="form-control" id="rate" placeholder="Enter Rate" required>
                                <h6 id="rate_validate" class="errorstyle"></h6>
                            </div>
                            <div class="mb-3">
                                <label for="amount">Amount<span class="text-danger"> *</span></label>
                                <input type="text" name="amount" class="form-control" id="amount" placeholder="Enter Amount" required>
                            </div>
                            <div class="mb-3">
                                <label for="charge">Charge for accommodation<span class="text-danger"> *</span></label>
                                <input type="text" name="charge" class="form-control" id="charge" placeholder="Enter Charge" required>
                            </div>
                            <div class="mb-3">
                                <label for="date">Date<span class="text-danger"> *</span></label>
                                <input type="date" name="date" class="form-control" id="date" required>
                            </div>
                            <div class="mb-3">
                                <label for="discount">Discount (if package)<span class="text-danger"> *</span></label>
                                <select class="form-control" name="discount" id="discount" required>
                                    <option value="" selected>Please Select Discount if package</option>
                                    <option value="0">None</option>
                                    <option value="2">2%</option>
                                    <option value="3">3%</option>
                                    <option value="4">4%</option>
                                    <option value="5">5%</option>
                                </select>
                            </div>
                            <div class="form-group ">
                                                    <label class="col-form-label" for="">Location link video<span class="text-danger"> *</span></label>
                                                        <input type="url" class="form-control form_input" placeholder="Enter Video link" id="trailer_link" name="location_link"  required>
                                                        <h6 id="trailer_link_validate" class="errorstyle"></h6>
                                                </div>
                            <div class="mb-3">
                                <label for="description">Description<span class="text-danger"> *</span></label>
                                <textarea class="form-control " rows="5" id="description" name="description" minlength="30" maxlength="5000" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer pt-4 ">                  
                            <button type="submit" name = "submitLocation" class="btn mx-auto w-100 btn-primary" >Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Login-->
    <div class="container-fluid ">
        <div class="modal fade" id="ModalForm" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" >
            <div class="modal-content">
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

   <!-- /// -->
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
    if(isset($_SESSION['status_update']) && $_SESSION['status_update'] != ''){
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
            title: 'Record Successfully Updated!'
            })
        </script>
        <?php
        unset($_SESSION['status_update']);
    }
    ?>
    <script>
    var loadFile = function(event) {
        var image = document.getElementById('output');
        image.src = URL.createObjectURL(event.target.files[0]);
        image.setAttribute("class", "out");
    };
    
    </script>
</body>
    <script type="text/javascript" src="js/validation.js"></script>
</html>