<?php

//Connection to DB
include 'include/db.php';

$user_id = $_GET['id'];
$department = $_SESSION["department"];

$teachers = $db->query("select * from user, user_info, department, degree
                                where user.user_id = user_info.user_id and user_info.department_id = department.department_id and user_info.degree_id = degree.degree_id and department.department_name = '$department' and user.user_id = $user_id");
$teacher = $teachers->fetch();
$dt = $teacher['department_name'];
$dg = $teacher['degree_name'];

if(isset($_POST["save"])){

    $teacher_firstname = false;
    $teacher_lastname = false;
    $teacher_middlename = false;
    $teacher_experience = false;
    $teacher_department = false;
    $teacher_degree = false;

    $teacher_firstname = $_POST["teacher_firstname"];
    $teacher_lastname = $_POST["teacher_lastname"];
    $teacher_middlename = $_POST["teacher_middlename"];
    $teacher_experience = $_POST["teacher_experience"];
    $teacher_department = $_POST["teacher_department"];
    $teacher_degree = $_POST["teacher_degree"];

    if($_FILES["image"]["tmp_name"] == ""){
        $image = $teacher["image"];
    }
    else{
        $image = $_FILES["image"]["name"];
        $tmp_name = $_FILES["image"]["tmp_name"];
        $dir = "image/";
        move_uploaded_file($tmp_name, $dir.$image);
    }

        $statement = $db->query(
            "
				UPDATE user_info
				SET first_name = '$teacher_firstname' , last_name = '$teacher_lastname' , middle_name = '$teacher_middlename' , experience = $teacher_experience, image = '$image',
				department_id = (SELECT department_id from department WHERE department_name = '$teacher_department'),
				degree_id = (SELECT degree_id from degree WHERE degree_name = '$teacher_degree')
				WHERE user_id = $user_id
			"
        );
        header("Location: teacher-list.php");
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
                <form method="POST" enctype="multipart/form-data">

                    <p>Firt name:</p>
                    <input type="text" name="teacher_firstname" value="<?php echo $teacher['first_name'] ?>">

                    <p>Last name:</p>
                    <input type="text" name="teacher_lastname" value="<?php echo $teacher['last_name'] ?>">

                    <p>Middle name:</p>
                    <input type="text" name="teacher_middlename" value="<?php echo $teacher['middle_name'] ?>">

                    <p>Department:</p>
                    <select name="teacher_department">
                        <option><?php echo $teacher['department_name']; ?></option>
                        <?php foreach ($department as $item):?>
                            <option><?php echo $item['department_name']; ?></option>
                        <?php endforeach;?>
                    </select>

                    <p>Academic degree:</p>
                    <select name="teacher_degree">
                        <option><?php echo $teacher['degree_name']; ?></option>
                        <?php foreach ($degree as $item):?>
                            <option><?php echo $item['degree_name']; ?></option>
                        <?php endforeach;?>
                    </select>

                    <p>Experience(year): </p>
                    <input type="number" name="teacher_experience" value = <?php echo $teacher["experience"];?>>

                    <p>Email: </p>
                    <input type="email" name="teacher_email" value=<?php echo $teacher['email']; ?> readonly style="border-style: dashed">

                    <p>Photo: </p>
                    <input type="file" name="image" value=<?php echo $teacher["image"];?>>

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


