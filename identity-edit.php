<?php

//Connection to DB
include 'include/db.php';

$email = $_SESSION["email"];
$user_id = $_SESSION["user"];

$statement2 = $db->query("SELECT * FROM user, user_info, department, degree WHERE user_info.user_id = $user_id and user_info.user_id = user.user_id and user_info.department_id = department.department_id and user_info.degree_id = degree.degree_id");
$user_info = $statement2->fetch();
$dt = $user_info['department_name'];
$dg = $user_info['degree_name'];

if(isset($_POST["save"])){

    $teacher_firstname = false;
    $teacher_lastname = false;
    $teacher_middlename = false;
    $teacher_experience = false;
    $teacher_department = false;
    $teacher_degree = false;
    $error = false;

    $teacher_firstname = $_POST["teacher_firstname"];
    $teacher_lastname = $_POST["teacher_lastname"];
    $teacher_middlename = $_POST["teacher_middlename"];
    $teacher_experience = $_POST["teacher_experience"];
    $teacher_department = $_POST["teacher_department"];
    $teacher_degree = $_POST["teacher_degree"];
    $teacher_password = $_POST["teacher_password"];
    $teacher_password2= $_POST["teacher_password2"];

    if($_FILES["image"]["tmp_name"] == ""){
        $image = $user_info["image"];
    }
    else{
        $image = $_FILES["image"]["name"];
        $tmp_name = $_FILES["image"]["tmp_name"];
        $dir = "image/";
        move_uploaded_file($tmp_name, $dir.$image);
    }

    if(strlen($teacher_password)>0 or strlen($teacher_password2)>0){
        if(strval($teacher_password) == strval($teacher_password2)){
            $statement2 = $db->query(
                "
				UPDATE user
				SET password = '$teacher_password'
				WHERE user_id = $user_id
			");

            $statement = $db->query(
                "
				UPDATE user_info
				SET first_name = '$teacher_firstname' , last_name = '$teacher_lastname' , middle_name = '$teacher_middlename' , experience = $teacher_experience, image = '$image', 
				department_id = (SELECT department_id from department WHERE department_name = '$teacher_department'),
				degree_id = (SELECT degree_id from degree WHERE degree_name = '$teacher_degree')
				WHERE user_id = $user_id
			"
            );

            $_SESSION["user"] = $user_id;
            header("Location: identity.php");
        }
        else{
            $error = "Пароли не совпадают!";
        }
    }

    else{
        $statement = $db->query(
            "
				UPDATE user_info
				SET first_name = '$teacher_firstname' , last_name = '$teacher_lastname' , middle_name = '$teacher_middlename' , experience = $teacher_experience, image = '$image', 
				department_id = (SELECT department_id from department WHERE department_name = '$teacher_department'),
				degree_id = (SELECT degree_id from degree WHERE degree_name = '$teacher_degree')
				WHERE user_id = $user_id
			"
        );
        $_SESSION["user"] = $user_id;
        header("Location: identity.php");
    }
}

$departments = $db->query("select * from department where department_name <> '$dt'");
$departments->setFetchMode(PDO::FETCH_ASSOC);
$department = $departments->fetchAll();

$degrees = $db->query("select * from degree where degree_name <> '$dg'");
$degrees->setFetchMode(PDO::FETCH_ASSOC);
$degree = $degrees->fetchAll();


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


            <div id="edit_info">
                <p style="color:red"><b><?php echo $error; ?></b></p>
                <form method="POST" enctype="multipart/form-data">

                    <p>First name:</p>
                    <input type="text" name="teacher_firstname" value = <?php echo $user_info["first_name"]; ?>>

                    <p>Last name:</p>
                    <input type="text" name="teacher_lastname" value = <?php echo $user_info["last_name"]; ?>>

                    <p>Middle name:</p>
                    <input type="text" name="teacher_middlename" value = <?php echo $user_info['middle_name']; ?>>


                    <p>Department:</p>
                    <select name="teacher_department">
                        <option><?php echo $user_info['department_name']; ?></option>
                        <?php foreach ($department as $item):?>
                        <option><?php echo $item['department_name']; ?></option>
                        <?php endforeach;?>
                    </select>

                    <p>Academic degree:</p>
                    <select name="teacher_degree">
                        <option><?php echo $user_info['degree_name']; ?></option>
                        <?php foreach ($degree as $item):?>
                            <option><?php echo $item['degree_name']; ?></option>
                        <?php endforeach;?>
                    </select>

                    <p>Experience(year): </p>
                    <input type="number" name="teacher_experience" value = <?php echo $user_info["experience"];?> required>

                    <p>Email: </p>
                    <input type="email" name="teacher_email" value=<?php echo $user_info['email']; ?> readonly style="border-style: dashed">

                    <p>New password: </p>
                    <input type="password" name="teacher_password" value="">

                    <p>Repeat password: </p>
                    <input type="password" name="teacher_password2" value="">

                    <p>Photo: </p>
                    <input type="file" name="image" value = "<?php echo $user_info["image"]; ?>">

                    <button id="safe_edit" type="submit" name="save"><i class="fa fa-check"></i>Save a personal data</button>

                </form>


            </div>



            </div>

        </div>

    </div>

</section>

<?php include "include/footer.php"; ?>

</body>
</html>


