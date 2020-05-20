<?php

//Connection to DB
include 'include/db.php';

$departments = $db->query("select * from department");
$departments->setFetchMode(PDO::FETCH_ASSOC);
$department = $departments->fetchAll();

$degrees = $db->query("select * from degree");
$degrees->setFetchMode(PDO::FETCH_ASSOC);
$degree = $degrees->fetchAll();

if(isset($_POST["save"])){
    $teacher_firstname = $_POST["teacher_firstname"];
    $teacher_lastname = $_POST["teacher_lastname"];
    $teacher_middlename = $_POST["teacher_middlename"];
    $teacher_department = $_POST["teacher_department"];
    $teacher_degree = $_POST["teacher_degree"];
    $teacher_experience = $_POST["teacher_experience"];
    $teacher_email = $_POST["teacher_email"];

    $tmp_name = $_FILES["image"]["tmp_name"];
    $image = $_FILES["image"]["name"];
    $dir = "image/";

    @move_uploaded_file($tmp_name, $dir.$image);

    $statement = $db->query("SELECT * FROM user WHERE email = '$teacher_email'");
    $teacher = $statement->fetch();


    if(!$teacher){
        $db->query("INSERT INTO user(email, password, role_id) VALUES('$teacher_email','1234',2)");
        $users = $db->query("SELECT * FROM user WHERE email = '$teacher_email'");
        $user = $users->fetch();
        $user_id = $user["user_id"];

        $statements2 = $db->query("SELECT * FROM department WHERE department_name = '$teacher_department'");
        $statements2->setFetchMode(PDO::FETCH_ASSOC);
        $statement2 = $statements2->fetch();
        $department_id = $statement2["department_id"];

        $statements3 = $db->query("SELECT * FROM degree WHERE degree_name = '$teacher_degree'");
        $statements3->setFetchMode(PDO::FETCH_ASSOC);
        $statement3 = $statements3->fetch();
        $degree_id = $statement3["degree_id"];

        $db->query("INSERT INTO user_info (first_name, last_name, middle_name, experience, image, user_id, degree_id, department_id)
            VALUES('$teacher_firstname','$teacher_lastname','$teacher_middlename', $teacher_experience, '$image', $user_id, $degree_id, $department_id)");
            header("Location: teacher-list.php");

    }
    else{
        $error = "A user with this email already exists!";
    }
}


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

                    <p>Firt name:</p>
                    <input type="text" name="teacher_firstname" value="">

                    <p>Last name:</p>
                    <input type="text" name="teacher_lastname" value="">

                    <p>Middle name:</p>
                    <input type="text" name="teacher_middlename" value="">

                    <p>Department:</p>
                    <select name="teacher_department">
                        <?php foreach ($department as $item):?>
                            <option><?php echo $item['department_name']; ?></option>
                        <?php endforeach;?>
                    </select>

                    <p>Academic degree:</p>
                    <select name="teacher_degree">
                        <?php foreach ($degree as $item):?>
                            <option><?php echo $item['degree_name']; ?></option>
                        <?php endforeach;?>
                    </select>

                    <p>Experience(year): </p>
                    <input type="number" name="teacher_experience">

                    <p>Email: </p>
                    <input type="email" name="teacher_email" required>

                    <p>Photo: </p>
                    <input type="file" name="image">

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


