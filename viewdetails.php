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

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
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
if (isset($_GET['locationID'])) {
    $id = $_GET['locationID'];
    $sql = "SELECT * FROM  locations WHERE location_id=".$id;
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {

        $location = mysqli_fetch_assoc($result);
    }
}
if(isset($_POST["submitReservation"])){

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $day = $_POST['day'];
    $person = $_POST['person'];
    $acco = $_POST['acco'];
    $place = $location['place'];
   

  

    
        $sql = "INSERT INTO reservationlist SET 
            fullname='$fullname',
            email = '$email',
            phone='$phone',
            day='$day',
            person='$person',
            acco='$acco',
            place='$place';";
    
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

if(isset($_POST["updateLocation"])){

    $id = $_GET['locationID'];
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

    if (move_uploaded_file($temp, $directory)) {
        $sql = "UPDATE locations SET 
            picture='$directory',
            title = '$titles',
            place='$place',
            rate='$rate',
            amount='$amount',
            link='$location_link',
            descriptions='$descriptions',
            charge='$charge',
            schedule_date='$dob',
            discount='$discounts'
            WHERE location_id=".$id;

        if (mysqli_query($conn, $sql)) {
            header('Refresh: 1; URL=viewdetails.php?locationID=' . $id);
            $_SESSION['status_update'] = "success";
            unlink($location['picture']);  
        } else {
            echo mysqli_error($conn);
            echo '<script>';
            echo "alert('Error Occur!');" . mysqli_error($conn);
            echo '</script>';
        }
    }

}

if (isset($_POST['delete_location'])) {
    $id = $_GET['locationID'];

    $sql = "DELETE FROM locations WHERE location_id=$id";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['status_delete'] = "delete";
        header('Refresh: 1; URL=index.php');
        unlink($location['picture']);
    } else {
        echo "location not Deleted" . mysqli_error($conn);
        echo '<meta http-equiv="refresh" content="1;index.php" >';
    }
}

$discount = array("None", "2", "3", "4", "5");
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
        include 'link.php';
    ?>
    <link rel="stylesheet" href="css/bootstrap.css">
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
                <li class="nav-item active">
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
    <div class="container-fluid rounded" style="margin-top: 12vh">
        <div class="card mb-3 mt-2">
            <img src="<?php echo $location['picture']; ?>" class="card-img-top" alt="..." style="height: 51vh; object-fit: cover;">
            <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                
                </div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $location['title']; ?></h5>
                        <p class="card-text"><?php echo $location['rate']; ?>/ 10</p>
                        <p class="card-text">Php <?php echo $location['amount']; ?></p>
                        <?php
                            if($location['is_package'] == 1){
                                echo '<p class="card-text">Date: '.$location['schedule_date'].' </p>
                                <p class="card-text">Discount: '.$location['discount'].'</p></br>';
                            }

                        ?>
                        <p class="card-text"><?php echo $location['descriptions']; ?></p>
                        <a href="#" class="pe-auto" data-toggle="modal" data-target="#videoModal"><button class="btn btn-light"><i class="bi bi-play-btn-fill text-danger"></i> Watch Video</button></a>
                        <button class="btn btn-success" data-toggle="modal" data-target="#updateModal"><i class='bx bxs-edit-alt'></i> Update</button>
                        <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal"><i class='bx bx-trash'></i> Delete</button>
                        
                    </div>
                </div>
            </div>
   
    </div>
    

    <div class="modal fade" id="videoModal" >
        <div class="modal-dialog modal-lg">

            <div class="modal-content" style="color: black">
                <form action="" method="POST">
                    <!-- Modal Header -->
                    <div class="modal-header ">
                        <h5 class="modal-title"><?php echo $location['title']; ?></h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body d-flex justify-content-center">

                        <iframe id="video" width="853" height="480" src="<?php echo $location['link']; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <!-- Modal footer -->
                    <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                    </div> -->
                </form>
            </div>
        </div>
    </div>

    <div class="container-fluid ">
        <!-- Modal Form -->
        <div class="modal fade" id="updateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" >
            <div class="modal-content">
                
                <form action="" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h1 class="modal-title" style="font-weight: 400;">Update Location</h1>
                    <i data-bs-dismiss="modal" aria-label="Close"></i>
                </div>
                <div class="modal-body">
                    
                    <div class="mb-3">
                        <label for="myfile">Image<span class="text-danger"> *</span></label>
                        <!-- <input type="file" name="img_upload"/> -->
                        <img class="card-img-top movie_input_img" id="output" src="<?php echo $location['picture']; ?>" alt="Card image" style="width: 100%; height: auto; ">
                        <input type="file" class="fil mt-2" id="myfile" name="myfile" accept="image/*" onchange="loadFile(event)" required/>
                    </div>
                    <div class="mb-3">
                        <label for="title">Title of Location<span class="text-danger"> *</span></label>
                        <input type="text" name="title" class="form-control" id="title" value="<?php echo $location['title']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="place">Place<span class="text-danger"> *</span></label>
                        <input type="text" name="place" class="form-control" id="place" value="<?php echo $location['place']; ?>" required>
                    </div>
                     <div class="mb-3">
                        <label for="rate">Rate<span class="text-danger"> *</span></label>
                        <input type="text" name="rate" class="form-control" id="rate" value="<?php echo $location['rate']; ?>" required>
                         <h6 id="rate_validate" class="errorstyle"></h6>
                    </div>
                    <div class="mb-3">
                        <label for="amount">Amount<span class="text-danger"> *</span></label>
                        <input type="text" name="amount" class="form-control" id="amount" value="<?php echo $location['amount']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="charge">Charge<span class="text-danger"> *</span></label>
                        <input type="text" name="charge" class="form-control" id="charge" value="<?php echo $location['charge']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="date">Date<span class="text-danger"> *</span></label>
                        <input type="date" name="date" class="form-control" id="date" value="<?php echo $location['schedule_date']; ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="discount">Discount<span class="text-danger"> *</span></label>
                        <select class="custom-select" id="discount" name="discount">
                            
                                                    
                                                    <?php
                                                    foreach ($discount as $val) {
                                                        if ($val == $location['discount']) {
                                                            echo ' <option selected>' . $val . '</option>';
                                                        } else {
                                                            echo ' <option>' . $val . '</option>';
                                                        }
                                                    }


                                                    ?>

                        </select>
                    </div>
                     
                    
                    <div class="mb-3">
                        <label for="location_link">Location link video<span class="text-danger"> *</span></label>
                        <input type="url" class="form-control form_input" value="<?php echo $location['link']; ?>" id="location_link" name="location_link"  required>
                        <h6 id="trailer_link_validate" class="errorstyle"></h6>
                    </div>
                    <div class="mb-3">
                        <label for="description">Description<span class="text-danger"> *</span></label>
                        <textarea class="form-control " rows="5" id="description" name="description" minlength="30" maxlength="5000" required><?php echo $location['descriptions']; ?></textarea>
                        <!-- <input type="text" name="description" class="form-control" id="description" placeholder="Enter Description" required> -->
                    </div>

                    
                    
                </div>
                <div class="modal-footer pt-4 ">                  
                    <button type="submit" name = "updateLocation" class="btn mx-auto w-100 btn-primary" >Submit</button>
                </div>
                
            </form>
            </div>
        </div>
        </div>
    </div>


    <div id="deleteModal" class="modal fade" role="dialog">
        <div class="modal-dialog " style="color: black">
            <form method="POST" action="">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title ">Delete Location</h4>
                    </div>
                    <div class="modal-body">
                        <h6>Are you sure you want to delete this record?</h6>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="delete_location" class="btn btn-danger">Delete</button>
                    </div>
                   
                </div>
            </form>
        </div>
    </div>

    

    <div class="container-fluid ">
        <!-- Modal Form -->
        <div class="modal fade" id="ModalForm" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" >
            <div class="modal-content">
                <!-- Login Form -->
                <form action="" method="POST" >
                <div class="modal-header">
                    <h1 class="modal-title" style="font-weight: 400;">Login</h1>
                    <i data-bs-dismiss="modal" aria-label="Close"></i>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="Username">Username<span class="text-danger"> *</span></label>
                        <input type="text" name="username" class="form-control" id="Username" placeholder="Enter Username">
                    </div>

                    <div class="mb-3">
                        <label for="Password">Password<span class="text-danger"> *</span></label>
                        <input type="password" name="password" class="form-control" id="Password" placeholder="Enter Password">
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

    
   
    <div style="margin-top: 9.7vh">
        <?php
            include 'footer.php'
        ?>
    </div>
   

    

</body>
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
     if(isset($_SESSION['status_delete']) && $_SESSION['status_delete'] != ''){
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
            title: 'Record Successfully Deleted!'
            })
        </script>
        <?php
        unset($_SESSION['status_delete']);
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
    }

    // $(document).ready(function(){
    //     $(".close").click(function(){
    //         $("#videoModal").empty();
    //     });
    // });
</script>
</html>