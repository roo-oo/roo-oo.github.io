<?php

//Connection to DB
include 'include/db.php';

$email = $_SESSION["email"];
$user_id = $_SESSION["user"];

$statement2 = $db->query("SELECT * FROM user, user_info, department, degree WHERE user_info.user_id = $user_id and user_info.user_id = user.user_id and user_info.department_id = department.department_id and user_info.degree_id = degree.degree_id");
$user_info = $statement2->fetch();

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <?php include "include/head.php"; ?>
</head>
<body>

<div id="wrapper">

    <?php include "include/header.php"; ?>

    <?php include "include/nav.php"; ?>

</div>

<section>

    <div id="work_space">

        <div id="t_content" style="margin-top:-1.5em; padding-left: 0;">

            <?php include "profile-left-box.php"; ?>

            <div id="right_box">

                <div id="identify_image">
                    <img src="image/<?php echo $user_info["image"]; ?>">
                </div>

                <div id="identify_info">
                    <p>Full name: <a><?php echo $user_info["first_name"]. " ". $user_info["last_name"]. " ". $user_info["middle_name"]; ?></a></p>
                    <p>Department: <a><?php echo $user_info["department_name"]; ?></a></p>
                    <p>Academic degree: <a><?php echo $user_info["degree_name"]; ?></a></p>
                    <p>Experience(year): <a><?php echo $user_info["experience"]; ?></a></p>
                    <p>Email: <a><?php echo $user_info["email"]; ?></a></p>
                </div>


                    <button id="info_edit"><a href="identity-edit.php"><i class="fa fa-edit"></i>Edit personal data</a></button>

            </div>

        </div>

    </div>

</section>

<?php include "include/footer.php"; ?>

</body>
</html>

