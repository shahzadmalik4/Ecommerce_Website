<?php 
if(isset($_POST['register'])){
    include "config.php";
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $retypePassword = $_POST['retypePassword'];
    $role = 2;
    $status = "Pending";

    if($password == $retypePassword){
        // Insert Data Into Database
        mysqli_query($db,"INSERT INTO register (name,email,password,role,status)VALUES('".$name."','".$email."','".$password."','".$role."','".$status."')");

        ?>
        <script>
            location.assign("Register.php?error=Account Created Wait For Verfiy");
        </script>
        <?php


    }else{
        ?>
        <script>
            location.assign("Register.php?error=Password Not Matched");
        </script>
        <?php
    }
}

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    include "config.php";

    // Feth Email And Password From Database
    $fetch = mysqli_query($db,"SELECT * FROM register WHERE email='".$email."' AND password = '".$password."'");

    if($check = mysqli_num_rows($fetch) > 0){
        while($data = mysqli_fetch_assoc($fetch)){

            // Coding For Portals
            if($data['status'] == "Approved"){
                if($data['role'] == 1){
                        session_start();
                        $_SESSION['name'] = $data['name'];
                    echo "<script>
                            location.assign('Admin Panel/index.php');
                        </script>";        
                }else{
                    session_start();
                        $_SESSION['name'] = $data['name'];
                    echo "<script>
                            location.assign('User Panel/index.php');
                        </script>";
                }
            }else{
                echo "Wait For Account Apporval BY ADMIN";
            }
        }
    }else{
        echo "<script>
            alert('Please Create Account First');
            location.assign('index.php');
        </script>";
    }




}



?>