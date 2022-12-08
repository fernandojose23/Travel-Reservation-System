<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
include 'mysql_connect.php';

if (isset($_GET['locationID'])) {
    $id = $_GET['locationID'];
    $sql = "SELECT * FROM  locations WHERE location_id=".$id;
    $res = mysqli_query($conn, $sql);
    if (mysqli_num_rows($res) > 0) {

        $location = mysqli_fetch_assoc($res);
    }
}

    $fullname = $_GET['name'];
    $email = $_GET['email'];
    $phone = $_GET['phone'];
    $person = $_GET['person'];
    $acco = $_GET['acco'];
    $charged = $_GET['chargedTotal'];
    $totals = $_GET['total'];
    $place = $location['place'];
    $amount = $location['amount'];
    $discounted = $_GET['discount'];
    $sched_date = $location['schedule_date'];
    $discount= $location['discount'];

    $discount_amount = $totals - $discounted;
    $ciphering = "AES-128-CTR";
    $option = 0;
    $encryption_iv = '1234567890123456';
    $encryption_key = "info";
    $encryption = openssl_encrypt($fullname,$ciphering,$encryption_key,$option,$encryption_iv);

    $masterkeyhash = openssl_digest('master_passphrase','sha512');
    $email_encrypt = openssl_encrypt($email, 'AES-128-ECB', $masterkeyhash);
    // $masterkeyhash = openssl_digest('master_passphrase','sha512');
    $phone_encrypt = openssl_encrypt($phone, 'AES-128-ECB', $masterkeyhash);

    $sql = "INSERT INTO reservationlist SET 
            fullname='$encryption',
            email = '$email_encrypt',
            phone='$phone_encrypt',
            person='$person',
            acco='$acco',
            place='$place',
            charged='$charged',
            totals='$totals',
            discount_amount='$discount_amount';";
 
    if (mysqli_query($conn, $sql)) {
            $_SESSION['status_success'] = "success";
            // unset($_POST['submitLocation']);
            // header('Refresh: 2; URL=index.php');
            
        } else {
            echo mysqli_error($conn);
            echo '<script>';
            echo "alert('Error Occur!');" . mysqli_error($conn);
            echo '</script>';
        }
    
    require 'includes/PHPMailer.php';
	require 'includes/SMTP.php';
	require 'includes/Exception.php';

     $body = '  <body>
                    <div>
                        <h2 class="">Hello, ' . $fullname . ' ' . ' </h2>
                    </div>
                    <div  style="margin-left:20px;">
                        <p class="">Thank You for your Reservation.</p>
                        <h4>Summary:</h4></br>
                        <h5>Destination: '.$place.'</h5></br>
                        <h5>Number of Person: '.$person.'</h5></br>
                        <h5>Accomodation: '.$acco.'</h5></br>
                        <h5>Charged for Accomodation: '.$charged.'</h5></br>
                        <h5>Sub Amount: '.$totals.'</h5></br>
                        <h5>Discount: '.$discount.'%</h5></br>
                        <h5>Date of Arrival: '.$sched_date.'</h5></br>
                        <h5>Total Amount: '.$discount_amount.'</h5></br>
                    </div>
                    <div  style="margin-left:20px;">
                        <p class="">Sincerely:</p>
                        <p class="">Escape.me.</p>
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
        $mail->Subject = "Reservation Details";
    //Set sender email
        $mail->setFrom('aaaaescape.mefej@gmail.com');
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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escape</title>
    <link rel="icon" href ="images/logo2.png" class="icon">
</head>
    <?php
        include 'link.php';
    ?>

<!-- <link rel="stylesheet" href="css/style3.css"> -->
<style>
    

.ticket {
  font-family: sans-serif;

  background-repeat: no-repeat;
  background-position: top;
  background-size: 100%;
  background-color: #04030C;
  width: 700px;
  height: 340px;
  border-radius: 15px;
  -webkit-filter: drop-shadow(1px 1px 3px rgba(0, 0, 0, 0.3));
            filter: drop-shadow(1px 1px 3px rgba(0, 0, 0, 0.3)); 
  display: block;
  margin: 10% auto auto auto;
  color: #fff;
}

.date {
  margin: 15px;
  -webkit-filter: drop-shadow(1px 1px 3px rgba(0, 0, 0, 0.3));
            filter: drop-shadow(1px 1px 3px rgba(0, 0, 0, 0.3)); 
}

.date .day{
  font-size: 80px;
  float: left;
}

.date .month-and-time {
  float: left;
  margin: 15px 0 0 0;
  font-weight: bold;
}

.artist {
  font-size: 25px;
  margin: 10px 100px 0 40px;
  float: left;
  font-weight: bold;
  -webkit-filter: drop-shadow(1px 1px 3px rgba(0, 0, 0, 0.3));
            filter: drop-shadow(1px 1px 3px rgba(0, 0, 0, 0.3)); 
}

.location {
  float: left;
  margin: 130px 0 0 0;
  font-size: 25px;
  font-weight: bold;
  -webkit-filter: drop-shadow(1px 1px 3px rgba(0, 0, 0, 0.3));
            filter: drop-shadow(1px 1px 3px rgba(0, 0, 0, 0.3)); 
}

.location::before {
  background-image: url(images/code.png);
  border-radius: 2px;
  
  background-size: 110px 110px;
  margin-top: -6vh;
  width: 110px; 
  height: 110px;
  content:"";
  display: inline-block;
  /* float: left; */
  position: absolute;
  left: -160px;
  /* bottom: 1px; */
  -webkit-filter: drop-shadow(1px 1px 3px rgba(0, 0, 0, 0.3));
            filter: drop-shadow(1px 1px 3px rgba(0, 0, 0, 0.3)); 
}

.rip {
  border-right: 5px #ffffff dashed;
  height: 340px;
  position: absolute;
  top: 0;
  left: 530px;
}

.cta .buy {
  position: absolute;
  top: 135px;
  right: 15px;
  display: block;
  font-size: 12px;
  font-weight: bold;
  background-color: #436ea5;
  padding: 10px 20px;
  border-radius: 25px;
  color: #fff;
  text-decoration: none;
  -webkit-transform: rotate(-90deg);
        -ms-transform: rotate(-90deg);
            transform: rotate(-90deg);
  -webkit-filter: drop-shadow(1px 1px 3px rgba(0, 0, 0, 0.3));
            filter: drop-shadow(1px 1px 3px rgba(0, 0, 0, 0.3)); 
}

.small {
  font-weight: 200;
}

.ticket-1 {
    /* background-image: url(images/Cinderella.jpg); */
    background-size: cover;

    
}

</style>

<body >
    
    <div id='printMe'>
        <div class="ticket ticket-1" style="background-image: url('<?php echo $location['picture']; ?>');
                                        background-size:     cover; 
                                        background-repeat:   no-repeat;
                                        background-position: center center;
                                        background-color: #000000;
                                        opacity: 0.9; ">
  
            <div class="date">
                <span class="day"><?php $date = date_create($location['schedule_date']);
                                                            $day = date_format($date, "d");
                                                            echo $day; ?></span>
                <span class="month-and-time"><?php $date = date_create($location['schedule_date']);
                                                            $month = date_format($date, "M");
                                                            $monthC = strtoupper($month);
                                                            echo $monthC; ?></br></span>
            </div>

            <div class="artist" >
                <span class="name"><?php echo $location['place']; ?></span>
                </br>
                <span class="live small" style="font-size: 20px">Sub-Total: <?php echo $english_format_number = number_format($totals); ?></span>
                </br>
                <span class="live small" style="font-size: 20px">Discount: <?php echo $discount; ?>%</span>
                
            </div>

            <div class="location" style="margin-left: 12vw;">
                <span><?php echo $_GET['name']; ?></span>
                </br>
                <span class="small"><span><b>Price: </b><?php  $amount = $totals - $discounted; echo $english_format_number = number_format($amount) ?></span>
            </div>

            <div class="rip">
            </div>
            
            <div class="cta">
                <button class="buy" href="#" onclick="printDiv('printMe')">GRAB A TICKET</button>
            </div>

            </div>
        </div>
    </div>
    <div class="container-fluid" style="justify-content: center; align-item: center; display: flex; margin-top: 3vh">
        <a href="index.php"><button class="btn btn-primary" style=""><i class="bi bi-house-door-fill"></i> Back to Homepage.</button></a>
    </div>
    <script>
    function printDiv(printMe){
			var printContents = document.getElementById(printMe).innerHTML;
			var originalContents = document.body.innerHTML;

			document.body.innerHTML = printContents;

			window.print();
            

			document.body.innerHTML = originalContents;

		}
    </script>
    <script src="js/sweetalert2.js"></script>
    <?php
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
    ?>
</body>

</html>