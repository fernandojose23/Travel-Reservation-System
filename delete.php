<?php
session_start();
include 'mysql_connect.php';

  
    $id = $_GET['locationID'];

    $sql = "DELETE FROM locations WHERE location_id=$id";

    if (mysqli_query($conn, $sql)) {
        
        // unlink($movie['picture']);
        header('Refresh: 1; URL=index.php');
        $_SESSION['status_delete'] = "delete";
    } else {
        echo "location not Deleted" . mysqli_error($conn);
        echo '<meta http-equiv="refresh" content="1;index.php" >';
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
</head>
<body></body>
<script src="js/sweetalert2.js"></script>
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
            title: 'Record Successfully Deleted!'
            })
        </script>
        <?php
        unset($_SESSION['status_delete']);
    }
    ?>
</body>
</html>