<?php 
if(isset($_GET['uid'])){
    include "config.php";
    $uid = $_GET['uid'];

    
    // Update Data Into table

    mysqli_query($db,"UPDATE register SET status = 'Approved' WHERE id='".$uid."'" );
    
    $FetchEmail = mysqli_query($db,"SELECT email FROM register WHERE id= '".$uid."'");
    //Associative Array
    $data = mysqli_fetch_assoc($FetchEmail);
    $email = $data['email'];
    $subject = "Panel Assigned";
    $msg = "Testing";
    $sender = "talibmari123@gmail.com";

    // Send Mail TO User
    mail($email,$subject,$msg,$sender);
    echo "<script>
        alert('Account Approved');
        location.assign('index.php');
    </script>";
}

if(isset($_POST['addProduct'])){
    $pImg = $_FILES['pImg']['name'];
    $pSize = $_FILES['pImg']['size'];
    $tmp_name = $_FILES['pImg']['tmp_name'];
    $location = "Images/".$pImg;
    $pExtension = pathinfo($pImg,PATHINFO_EXTENSION);

    if($pSize <= 10000000){
        if($pExtension == "png" OR $pExtension == "jpg" OR $pExtension == "jfif"){
            // Move Selected File Into Folder
            if(move_uploaded_file($tmp_name,$location)){
                
                // Insert Data Into Stock Table
                $pName = $_POST['pName'];
                $pDescription = $_POST['pDescription'];
                $pQuantity = $_POST['pQuantity'];
                $pPrice = $_POST['pPrice'];
                $pCategory = $_POST['pCategory'];

                include "config.php";

                $Insert = mysqli_query($db,"INSERT INTO stock (p_name,p_description,p_quantity,p_price,p_category,p_image)VALUES('$pName','$pDescription','$pQuantity','$pPrice','$pCategory','$location')");

                echo "<script>
                alert('Stock Added');
                location.assign('index.php');
            </script>";

            }else{
                echo "<script>
            alert('File Not Uploaded');
            location.assign('index.php');
        </script>";
            }
        }else{
            echo "<script>
            alert('Upload Only Picture Format');
            location.assign('index.php');
        </script>";
        }

    }else{
        echo "<script>
            alert('Upload Less Than 2MB File');
            location.assign('index.php');
        </script>";
    }




}


if(isset($_POST['addCategory'])){
    include "config.php";
    $category_name = $_POST['category_name'];

    $fetch = mysqli_query($db,"SELECT cat_name FROM category WHERE cat_name = '$category_name'");
   
    if($isDataExists = mysqli_num_rows($fetch) >0 ){
        
        echo "<script>
        alert('Category Already Exists');
        location.assign('index.php');
        </script>";        

    }else{
        $insert = mysqli_query($db,"INSERT INTO category (cat_name)VALUES('$category_name')");

            echo "<script>
                    alert('Category Added');
                    location.assign('index.php');
                </script>";
        
    }
   
}


?>