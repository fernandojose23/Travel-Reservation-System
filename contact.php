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
if (isset($_POST['submitMail'])) {

	require 'includes/PHPMailer.php';
	require 'includes/SMTP.php';
	require 'includes/Exception.php';

     $body = '  <body>
                    <div>
                        <h2 class="">Hello, ' . $_POST['fullname'] . ' ' . ' </h2>
                    </div>
                    <div  style="margin-left:20px;">
                        <p class="">We truly value your feedback and the time you took to evaluate our system performance.</br> Your suggestions were worthwhile and we hope to be able to use them to improve our performance.</p>
                    </div>
                    <div  style="margin-left:20px;">
                        <p class="">Sincerely:</p>
                        <p class="">Escape.co.</p>
                    </div>
                </body>';
//Create instance of PHPMailer
	$mail = new PHPMailer();
//Set mailer to use smtp
	$mail->isSMTP();
//Define smtp host
	$mail->Host = "smtp.gmail.com";
//Enable smtp authentication
	$mail->SMTPAuth = true;
//Set smtp encryption type (ssl/tls)
	$mail->SMTPSecure = "tls";
//Port to connect smtp
	$mail->Port = "587";
//Set gmail username
	$mail->Username = "escape.mefej@gmail.com";
//Set gmail password
	$mail->Password = "poittlwyedtlkuua";
//Email subject
	$mail->Subject = "FeedBack";
//Set sender email
	$mail->setFrom('escape.mefej@gmail.com');
//Enable HTML
	$mail->isHTML(true);
//Attachment
	// $mail->addAttachment('img/attachment.png');
//Email body
	$mail->Body = $body;
//Add recipient
	$mail->addAddress($_POST['email']);
    // $mail->addAddress('fernandojoselopez70@gmail.com');
//Finally send email
	if ( $mail->Send() ) {
		echo "Email Sent..!";
        $_SESSION['status_success'] = "success";
	}else{
		echo 'Message could not be sent. Mailer Error: '[$mail->ErrorInfo];
	}
//Closing smtp connection
	$mail->smtpClose();
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
<link rel="stylesheet" href="css/bootstrap.css">
    
    <!-- Style -->
<link rel="stylesheet" href="css/contact.css">

    <style>
      .unselectable {
        -webkit-user-select: none;
        -webkit-touch-callout: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }
    </style>
<body style="background-color: #ffff;" class="unselectable">

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
                <li class="nav-item ">
                    <a class="nav-link" href="about.php">About</a>
                </li>
                <li class="nav-item active">
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
    <div class="content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                

                <div class="row justify-content-center">
                    <div class="col-md-6" style="color: black">
                    
                    <h3 class="heading mb-4" >Let's talk about everything!</h3>
                    <p>If you have any concerns please state your reason. We will get you back our response at the earliest!</p>

                    <p><img src="images/undraw-contact.svg" alt="Image" class="img-fluid"></p>


                    </div>
                    <div class="col-md-6">
                    
                    <form class="mb-5" method="POST">
                        <div class="row">
                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control form" name="fullname" id="name" placeholder="Your name" required>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control form" name="email" id="email" placeholder="Email" required>
                        </div>
                        </div>
                        <!-- <div class="row">
                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject">
                        </div>
                        </div> -->
                        <div class="row">
                        <div class="col-md-12 form-group">
                            <textarea class="form-control form" name="message" id="message" cols="30" rows="7" placeholder="Write your message"></textarea>
                        </div>
                        </div>  
                        <div class="row">
                        <div class="col-12">
                            <input type="submit" value="Send Message" class="btn btn-primary rounded-0 py-2 px-4" name="submitMail">
                        </div>
                        </div>
                    </form>

                    <div id="form-message-warning mt-4"></div> 
                    <div id="form-message-success">
                        Your message was sent, thank you!
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>  
    </div>
    
    

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/main.js"></script>

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



   <div style="margin-top: 33vh">
        <?php
            include 'footer.php'
        ?>
    </div>
     <script src="js/sweetalert2.js"></script>
    <?php
    if(isset($_SESSION['status_success']) && $_SESSION['status_success'] != ''){
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
            title: 'Email Send! Thank You.'
            })

        </script>
        <?php
        unset($_SESSION['status_success']);
    }
    ?>

</body>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (() => {
        'use strict';

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation');

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms).forEach((form) => {
            form.addEventListener('submit', (event) => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
            }, false);
        });
        })();
    </script>

    <script>
      $(document).ready(function() {
          $("body").on("contextmenu", function(e) {
              return false;
            });
        });
    </script>


</html>