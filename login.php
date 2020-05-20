<?php

//Connection to DB
include 'include/db.php';
$email = false;
$error = false;
//IS BUTTON
if(isset($_POST["submit"])){

    //TAKE DATA
    $email = $_POST["email"];
    $password = ($_POST["password"]);
//    $password = md5($_POST["password"]);


    //QUERY TO DB
    $statement = $db->query("SELECT * FROM user WHERE email = '$email' AND password = '$password'");

    $statement->setFetchMode(PDO::FETCH_ASSOC);

    //CREATE SESSION
    $user = $statement->fetch();
    $a = $user["user_id"];
    if($user && $password=="1234"){
        $_SESSION["user"] = $user["user_id"];
        $_SESSION["email"] = $user["email"];
        $statement2 = $db->query("SELECT * FROM user_info, department, degree WHERE user_info.user_id = $a and user_info.department_id = department.department_id and user_info.degree_id = degree.degree_id");
        $user_info = $statement2->fetch();
        $_SESSION["first_name"] = $user_info["first_name"];
        $_SESSION["last_name"] = $user_info["last_name"];
        $_SESSION["middle_name"] = $user_info["middle_name"];
        $_SESSION["experience"] = $user_info["experience"];
        $_SESSION["department"] = $user_info["department_name"];
        $_SESSION["degree"] = $user_info["degree_name"];
        $_SESSION["image"] = $user_info["image"];
        header("Location: identity-edit.php");
    }
    elseif ($user && $password!="1234"){
        $_SESSION["user"] = $user["user_id"];
        $_SESSION["email"] = $user["email"];
        $statement2 = $db->query("SELECT * FROM user_info, department, degree WHERE user_info.user_id = $a and user_info.department_id = department.department_id and user_info.degree_id = degree.degree_id");
        $user_info = $statement2->fetch();
        $_SESSION["first_name"] = $user_info["first_name"];
        $_SESSION["last_name"] = $user_info["last_name"];
        $_SESSION["middle_name"] = $user_info["middle_name"];
        $_SESSION["experience"] = $user_info["experience"];
        $_SESSION["department"] = $user_info["department_name"];
        $_SESSION["degree"] = $user_info["degree_name"];
        $_SESSION["image"] = $user_info["image"];
        header("Location: index.php");
    }
    else{
        $error = "Invalid Email or password";
    }

}
?>



<!DOCTYPE html>
<html>
<head>
    <?php include "include/head.php"; ?>
</head>
<body>


<?php include "include/header.php"; ?>




<div class="form">
    <h1>science.iitu.kz</h1>
    <p style="color:red"><b><?php echo $error; ?></b></p>
    <form method="POST">
        <input type="text" name="email" placeholder="Email" value="" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="submit">Login</button>
    </form>
</div>

<?php include "include/footer.php"; ?>
</body>
</html>