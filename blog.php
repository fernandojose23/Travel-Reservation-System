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

if(isset($_POST["submitBlog"])){
   
    $blog_title = $_POST['blog_title'];
    $blog_titles = str_replace("'","\'",$blog_title);
    $publisher = $_POST['publisher'];
    $date_published = $_POST['date_published'];
    $blog_description = $_POST['blog_description'];
    $article = str_replace("'","\'",$blog_description);

    $date = date_create();
    $stamp = date_format($date, "Y");
    $temp = $_FILES['myfile']['tmp_name'];
    $directory = "images/" . $stamp . $_FILES['myfile']['name'];

    if (move_uploaded_file($temp, $directory)) {
        $sql = "INSERT INTO blog SET 
            images='$directory',
            blog_title = '$blog_titles',
            publisher='$publisher',
            date_published='$date_published',
            blog_description='$article';";

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
if (isset($_POST['deleteRecord']) && isset($_POST['deleteIDInput'])) {
    $id = $_POST['deleteIDInput'];
    if ($id == "") {
        echo "<p>Plese fill id </p>";
    } else {
        $sql = "DELETE FROM blog WHERE blog_id=$id";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['status_delete'] = "delete";
        } else {
            echo "Error occured!" . mysqli_error($conn);
            header('Refresh: 1; URL=reservationlist.php');
        }
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
</head>
<?php
    include "link.php";
    ?>
<link rel="stylesheet" href="css/bootstrap.css">
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
                <li class="nav-item ">
                    <a class="nav-link" href="index.php">Home</a>
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
                <li class="nav-item active">
                    <a class="nav-link " href="">Blog</a>
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
        <h3>Hi!, Welcome to Our Blog.</h3>
        <?php
            if (isset($_SESSION['is_admin'])) {
                if ($_SESSION['is_admin'] == 1) {
                    echo '<button type="submit"  class="btn btn-primary " data-toggle="modal" data-target="#AddnewBlog">Add New Blog</button></br>';
                    
                }
            }
        ?>
    </div>
    <div class="container-fluid" style="margin-top: 2%">
        <div>
        <?php
                $sql = "SELECT * FROM  blog ";
                $res = mysqli_query($conn, $sql);
                if(mysqli_num_rows($res) > 0){
                    while ($row = mysqli_fetch_assoc($res)) {?>
                    <div class="card mb-3" style="max-width: 900vw;">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                            <img src="<?php echo $row['images']; ?>"  class="card-img" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    
                                    <h5 class="card-title"><?php echo $row['blog_title']; ?></h5>
                                    <p align="justify" class="card-text"><?php echo $row['blog_description']; ?></p>
                                    <p class="card-text"><small class="text-muted">Published: <?php echo $row['publisher']; ?><br>Date: <?php echo $row['date_published']; ?></small> </p>
                                    <?php
                                        if (isset($_SESSION['is_admin'])) {
                                            if ($_SESSION['is_admin'] == 1) { ?>
                                            
                                            <button type="button" data-toggle="modal" onclick="setID(<?php echo $row['blog_id']; ?>)" data-target="#cancelReservation" class="btn btn-danger">
                                                    <span>delete</span>
                                                </button>                                    
                                        <?php }
                                        }
                                        ?>
                                </div>
                            </div>
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

    <div class="container-fluid ">
        <!-- Modal Form -->
        <div class="modal fade" id="AddnewBlog" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" >
            <div class="modal-content">
                <!-- Login Form -->
                <form action="" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h1 class="modal-title" style="font-weight: 400;">Add Blog</h1>
                    <i data-bs-dismiss="modal" aria-label="Close"></i>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="myfile">Image<span class="text-danger"> *</span></label>
                        <!-- <input type="file" name="img_upload"/> -->
                        <input type="file" class="fil" id="myfile"  name="myfile" accept="image/*" onchange="loadFile(event)" required/>
                    </div>
                    <div class="mb-3">
                        <label for="blog_title">Title of Location<span class="text-danger"> *</span></label>
                        <input type="text" name="blog_title" class="form-control" id="blog_title" placeholder="Enter Title of Location" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="publisher">Publisher<span class="text-danger"> *</span></label>
                        <input type="text" name="publisher" class="form-control" id="publisher" placeholder="Enter Publisher" required>
                    </div>
                    <div class="mb-3">
                        <label for="date_published">Date of Published<span class="text-danger"> *</span></label>
                        <input type="date" name="date_published" class="form-control" id="date_published" placeholder="Enter Date of Published" required>
                    </div>
                    <div class="mb-3">
                        <label for="blog_description">Description<span class="text-danger"> *</span></label>
                        <textarea class="form-control " rows="5" id="blog_description" name="blog_description" minlength="30" maxlength="1000" required></textarea>
                    </div>        
                </div>
                <div class="modal-footer pt-4 ">                  
                    <button type="submit" name = "submitBlog" class="btn mx-auto w-100 btn-primary" >Submit</button>
                </div>
                
            </form>
            </div>
        </div>
        </div>
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
                        <button type="submit" name="deleteRecord" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    include 'footer.php';
    
    ?>
    <script src="js/sweetalert2.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous"></script>

    <script>
        function setID(id) {
            $("#delID").text("Are you sure you want to Delete this record. ID:" + id);
            $("#deleteIDInput").val(id);
        }
    </script>
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