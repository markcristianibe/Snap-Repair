<?php
// include("../connection/db_connection.php");
session_start();


/* ------------------- Login ----------------- */
if(isset($_POST["login"])){
    $username = $_POST["username"];
    $password = $_POST["password"];

    // $sql = "select * from tbl_users where USERNAME = '$username' and PASSWORD = '$password'";
    // $result = mysqli_query($conn, $sql);

    if ($username == 'admin' && $password == 'admin')
    {
        $_SESSION["USERNAME"] = $username;
                
        // recordLog($conn, "Signed In: " . $row["Username"]);
        header("location: ../../"); 
    }
    else
    {
        $_SESSION['login_error'] = "true";
        header("location: ../../"); 
    }
    mysqli_close();
}
/* ------------------------------------------- */


/* ----------------- Logout ------------------ */
if(isset($_GET["action"])){
    if($_GET["action"] == "logout"){
        unset($_SESSION["USERNAME"]);
        unset($_COOKIE["USERNAME"]);
        header("location: ../../");
    }
}
?>