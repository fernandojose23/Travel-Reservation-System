<?php
session_start();
//removing all session data
if (isset($_POST['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    unset($_SESSION['is_admin']);
    header('Location:index.php');
}
