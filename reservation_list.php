<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
include 'mysql_connect.php';

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM login
      WHERE username = '$username'
      AND password = '$password'";

    $res = mysqli_query($conn, $sql);
    if (mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);
        $_SESSION['user'] = $username;
        $_SESSION['is_admin'] = $row['is_admin'];
        

        $_SESSION['status_login'] = "success";
        if ($row['is_admin'] == 1) {    
            $_SESSION['status_login'] = "success";
        } else {
            header("location:index.php");
            $_SESSION['status_login'] = "success";
        }
       
    } else {
        $_SESSION['status'] = "error";
    }
}
if (isset($_POST['deleteRecord']) && isset($_POST['deleteIDInput'])) {
    $id = $_POST['deleteIDInput'];
    if ($id == "") {
        echo "<p>Plese fill id </p>";
    } else {
        $sql = "UPDATE reservationlist SET is_cancel=0 WHERE  reservation_id='$id' ";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['status_delete'] = "delete";
        } else {
            echo "Error occured!" . mysqli_error($conn);
            header('Refresh: 1; URL=reservationlist.php');
        }
    }

    $sql = "SELECT * FROM  reservationlist WHERE reservation_id=".$id;

    $res = mysqli_query($conn, $sql);
    if (mysqli_num_rows($res) > 0) {

        $reservation = mysqli_fetch_assoc($res);
    }
    $masterkeyhash = openssl_digest('master_passphrase','sha512');
    $email_decrypt = openssl_decrypt($reservation['email'], 'AES-128-ECB', $masterkeyhash);
    $email = $email_decrypt;

    $ciphering = "AES-128-CTR";
    $option = 0;
    $decryption_key = "info";
    $decryption_iv = '1234567890123456';
    $decryption = openssl_decrypt($reservation['fullname'],$ciphering,$decryption_key,$option,$decryption_iv);
    $fullname = $decryption;
    require 'includes/PHPMailer.php';
	require 'includes/SMTP.php';
	require 'includes/Exception.php';

     $body = '  <body>
                    <div>
                        <h2 class="">Hello, ' . $fullname . ' ' . ' </h2>
                    </div>
                    <div  style="margin-left:20px;">
                        <p class="">I would Like to Inform You that Your Reservation was cancelled.</p>
                        <h4>Summary:</h4></br>
                        <h5>Destination: '.$reservation['place'].'</h5></br>
                        
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
        $mail->Subject = "Cancell Reservation";
    //Set sender email
        $mail->setFrom('escape.mefej@gmail.com');
//Enable HTML
	$mail->isHTML(true);
//Attachment
	// $mail->addAttachment('img/attachment.png');
//Email body
	$mail->Body = $body;
//Add recipient
	$mail->addAddress($email);
    // $mail->addAddress('fernandojoselopez70@gmail.com');
//Finally send email
	if ( $mail->Send() ) {
		// echo "Reservation Sent..!";
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escape</title>
    <link rel="icon" href ="images/logo2.png" class="icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
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
                <li class="nav-item active">
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
    <div class="container-fluid" style="margin-top: 15vh">
        <table class="table  table-striped">
        <thead class="thead-dark">
            <tr>
            <th scope="col">#</th>
            <th scope="col">Fullname</th>
            <th scope="col">Email</th>
            <th scope="col">Phone Number</th>
            <th scope="col">Location</th>
            <th scope="col">Number of Person</th>
            <th scope="col">Accommodation</th>
            <th scope="col">Charged</th>
            <th scope="col">Amount</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $sql = "SELECT * FROM reservationlist WHERE  is_cancel=1;";
                $res = mysqli_query($conn, $sql);
                if(mysqli_num_rows($res) > 0){
                    while ($row = mysqli_fetch_assoc($res)) {?>
                    <tr>
                    <th scope="row"><?php echo $row['reservation_id']; ?></th>
                    <td>
                    <?php 
                        
                        $ciphering = "AES-128-CTR";
                        $option = 0;
                        $decryption_key = "info";
                        $decryption_iv = '1234567890123456';
                        
                        $decryption = openssl_decrypt($row['fullname'],$ciphering,$decryption_key,$option,$decryption_iv);

                        echo $fullname = $decryption;
                    ?>
                    </td>
                    <td>
                        <?php 
                             
                            $masterkeyhash = openssl_digest('master_passphrase','sha512');
                            $email_decrypt = openssl_decrypt($row['email'], 'AES-128-ECB', $masterkeyhash);
                            echo $email_decrypt;
                        ?>
                    </td>
                    <td>
                        <?php 
                          
                            $masterkeyhash = openssl_digest('master_passphrase','sha512');
                            $phone_decrypt = openssl_decrypt($row['phone'], 'AES-128-ECB', $masterkeyhash);
                            echo $phone_decrypt;
                        ?>
                    </td>
                    <td><?php echo $row['place']; ?></td>  
                    <td><?php echo $row['person']; ?></td>
                    <td><?php echo $row['acco']; ?></td>
                    <td><?php echo $row['charged']; ?></td>
                    <td><?php echo $row['totals']; ?></td>
                    <td><button type="button" data-toggle="modal" onclick="setID(<?php echo $row['reservation_id']; ?>)" data-target="#cancelReservation" class="btn btn-danger">
                                            <span>Cancel</span>
                                        </button></td>
                    </tr>
                   <?php     
                    }
                }

                ?>
            
            
        </tbody>
    </table>
    </div>

    <div class="modal fade" id="cancelReservation">
        <div class="modal-dialog">

            <div class="modal-content" style="color: black">
                <form action="" method="POST">
                    <!-- Modal Header -->
                    <div class="modal-header ">
                        <h4 class="modal-title"> Cancel Reservation</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" class="form-control" placeholder="Enter id" id="deleteIDInput" name="deleteIDInput" required>
                        </div>

                        <p id="delID"></p>

                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="deleteRecord" class="btn btn-danger">Cancel Reservation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</body>
<script src="js/sweetalert2.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous"></script>

<script>
    function setID(id) {
        $("#delID").text("Are you sure you want to Cancel this record. ID:" + id);
        $("#deleteIDInput").val(id);
    }
</script>
<?php
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
            title: 'Record Successfully Cancelled!'
            })
        </script>
        <?php
        unset($_SESSION['status_delete']);
    }
?>


</html>