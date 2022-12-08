<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
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
if (isset($_GET['locationID'])) {
    $id = $_GET['locationID'];
    $sql = "SELECT * FROM  locations WHERE location_id=".$id;
    $res = mysqli_query($conn, $sql);
    if (mysqli_num_rows($res) > 0) {

        $location = mysqli_fetch_assoc($res);
        
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
                        <p class="card-text">Php <?php echo $english_format_number = number_format($location['amount']); ?></p>

                        <?php
                            if($location['is_package'] == 1){
                                echo '<p class="card-text">Date: '.$location['schedule_date'].' </p>
                                <p class="card-text">Discount: '.$location['discount'].'% </p></br>';
                            }

                        ?>

                        <p class="card-text"><?php echo $location['descriptions']; ?></p>
                        <a href="#" class="pe-auto" data-toggle="modal" data-target="#videoModal"><button class="btn btn-light"><i class="bi bi-play-btn-fill text-danger"></i> Watch Video</button></a>
                    </div>
                </div>
            </div>
        <div class="container my-5 border p-5"> 
            <div class="card-header mb-5">
                Please Fill Up for Reservation<span class="text-danger">*</span>
            </div>
            <p id='message' class="text-danger"></p>
            <form method="POST" >
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="fullname">Fullname</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" onInput="getValue()" required>
                        <h6 id="fullname_validate" class="errorstyle"></h6>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="Email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" onInput="getValue()" required>
                        <h6 id="email_validate" class="errorstyle"></h6>
                    </div>
                </div>
                <div class="form-group">
                        <label for="phone">Phone No.</label>
                        <input type="number" class="form-control" id="phone" name="phone" onInput="getValue()">
                </div>
                <div class="form-row">
                    
                    <div class="form-group col-md-4">
                    <label for="person">No. of Person</label>
                                <input type="number" class="form-control" id="person" name="person" onKeyup="getValue()" required>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="acco">Accommodation</label>
                                <select class="custom-select" id="acco" name="acco" onChange="getValue()" required>
                                    <option selected>Choose...</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                    
                                </select>
                    </div>
                </div>
                <div class="form-group">      
                </div>
                <div class="form-group">
                    <label for="person">Amount: <?php echo $location['amount']; ?></label> 
            
        </div>
            
             
        </form>
        <div>
            <button class="btn btn-danger" id="button" ><i class="bi bi-send-fill"></i> Add Reservation</button>
            <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i class="bi bi-eye-fill"></i> View Summary</button>
       
        </div>
       
            <div class="collapse" id="collapseExample">
                <div class="card card-body mt-5">
                    <h5 class="card-title">Location: <?php echo $location['place']; ?></h5>
                    <p class="card-text">Fullname: <span id="result"></span></p>
                    <p class="card-text">Email: <span id="result2"></span></p>
                    <p class="card-text">Phone Number: <span id="result3"></span></p>
                    <!-- <p class="card-text">No. of Days: <span id="result4"></p> -->
                    <p class="card-text">Quantity: <span id="result5"></p>
                    <p class="card-text">Accomodation: <span id="result6"></p> 
                    <p class="card-text">Sub-Total: <span id="result7"></p>
                    <hr>
                    <p class="card-text">Charged if have a Accomodation: <span id="result8"></p>
                    <p class="card-text">Total: <span id="result10"></p>
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

    <?php
    include 'footer.php'
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
             Swal.fire(
            'Thank You for Your Reservation!',
            'Please Check Your Email for More Information!',
            'success'
            )

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
    
    <script>
        var clicked = false;
       
        document.getElementById('button').onclick = function() {
            var clicked = true;

            
            let name = document.getElementById("fullname");
            let txtValue = name.value;
            let result = document.getElementById("result");
            result.innerText = txtValue;
            let email = document.getElementById("email");
            let txtValue2 = email.value;
            let result2 = document.getElementById("result2");
            result2.innerText = txtValue2;
            let phone = document.getElementById("phone");
            let txtValue3 = phone.value;
            let result3 = document.getElementById("result3");
            result3.innerText = txtValue3;
            let person = document.getElementById("person");
            let txtValue5 = person.value; 
            let result5 = document.getElementById("result5");
            result5.innerText = txtValue5;
            let acco = document.getElementById("acco");
            let txtValue6 = acco.value; 
            let result6 = document.getElementById("result6");
            result6.innerText = txtValue6;
            let result7 = document.getElementById("result7");
            result7.innerText = txtValue5*<?php echo $location['amount']; ?>;
            let chargeTotal = txtValue5*<?php echo $location['amount']; ?>;
            if(txtValue6 == "yes"){
                let charge;
                charge = <?php echo $location['charge']; ?>
                
                let result8 = document.getElementById("result8");
                result8.innerText = charge;

                let result10 = document.getElementById("result10");
                result10.innerText = chargeTotal+charge;

            }else{
                let charge;
                charge = 0;
                
                let result8 = document.getElementById("result8");
                result8.innerText = charge;
                
                let result10 = document.getElementById("result10");
                result10.innerText = chargeTotal+charge;
            }
            if(txtValue == "" || txtValue2 == "" || txtValue3 == "" || txtValue5 == "" || txtValue6 == ""){
                 $("#message").html("Please fill in the Blank!");
            }
            else{
                var getTotal = result10.innerText;
                var discount =  <?php echo $location['discount']; ?> / 100;
                var afterDiscount = (getTotal * discount);
                var id = <?php echo $location['location_id']; ?>
               
                window.location.href = "addReservationPackage.php?locationID="+id+"&discount="+afterDiscount+"&total="+getTotal+"&chargedTotal="+result8.innerText+"&name="+txtValue+"&email="+txtValue2+"&phone="+txtValue3+"&person="+txtValue5+"&acco="+txtValue6;

            }  
                }
        function getValue(){
            let name = document.getElementById("fullname");
            let txtValue = name.value;
            let result = document.getElementById("result");
            result.innerText = txtValue;
            let email = document.getElementById("email");
            let txtValue2 = email.value;
            let result2 = document.getElementById("result2");
            result2.innerText = txtValue2;
            let phone = document.getElementById("phone");
            let txtValue3 = phone.value;
            let result3 = document.getElementById("result3");
            result3.innerText = txtValue3;
            let person = document.getElementById("person");
            let txtValue5 = person.value; 
            let result5 = document.getElementById("result5");
            result5.innerText = txtValue5;
            let acco = document.getElementById("acco");
            let txtValue6 = acco.value; 
            let result6 = document.getElementById("result6");
            result6.innerText = txtValue6;
            let result7 = document.getElementById("result7");
            result7.innerText = txtValue5*<?php echo $location['amount']; ?>;
            let chargeTotal = txtValue5*<?php echo $location['amount']; ?>;
            if(txtValue6 == "yes"){
                let charge;
                charge = <?php echo $location['charge']; ?>
                
                let result8 = document.getElementById("result8");
                result8.innerText = charge;

                let result10 = document.getElementById("result10");
                result10.innerText = chargeTotal+charge;

            }else{
                let charge;
                charge = 0;
                
                let result8 = document.getElementById("result8");
                result8.innerText = charge;
                
                let result10 = document.getElementById("result10");
                result10.innerText = chargeTotal+charge;
            } 
        }
    </script>
</body>
<script type="text/javascript" src="js/validation.js"></script>
<script>
    $(document).ready(function(){
        $(".close").click(function(){
            $("#videoModal").empty();
        });
    });
</script>
</html>