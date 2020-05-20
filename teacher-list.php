<?php

//Connection to DB
include 'include/db.php';

$department = $_SESSION["department"];
$email = $_SESSION["email"];
$n = 1;

$teachers = $db->query("select * from user, user_info, department, degree
                                where user.user_id = user_info.user_id and user_info.department_id = department.department_id and user_info.degree_id = degree.degree_id and department.department_name = '$department' and user.email <> '$email'");
$teachers->setFetchMode(PDO::FETCH_ASSOC);
$teacher = $teachers->fetchAll();
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

            <div id="profile_works">

                <h4>СПИСОК ПРЕПОДАВАТЕЛЕЙ КАФЕДРЫ</h4>

                <table id="teachers_list">

                    <tr>
                        <th>
                            №
                        </th>
                        <th>
                            ИЗОБРАЖЕНИЕ
                        </th>
                        <th>
                            ФИО
                        </th>
                        <th>
                            АКАДЕМИЧЕСКАЯ СТЕПЕНЬ
                        </th>
                        <th>
                            СТАЖ РАБОТЫ
                        </th>
                        <th>
                            EMAIL
                        </th>
                        <th>
                            <a href="teacher-add.php"><i class="fa fa-plus"></i></a>
                        </th>
                    </tr>

                    <?php foreach ($teacher as $item):?>
                    <tr>
                        <td>
                            <?php echo $n ?>
                        </td>
                        <td>
                            <img src="image/<?php echo $item['image']; ?>">
                        </td>
                        <td>
                            <?php echo $item["first_name"]. " ". $item["last_name"]. " ". $item["middle_name"]; ?>
                        </td>
                        <td>
                            <?php echo $item['degree_name']; ?>
                        </td>
                        <td>
                            <?php echo $item['experience']; ?>
                        </td>
                        <td>
                            <?php echo $item['email']; ?>
                        </td>
                        <td>
                            <a href="teacher-edit.php?<?php echo "id=".$item["user_id"]; ?>"><i class="fa fa-edit"></i></a>
                            <br>
                            <a href="teacher-delete.php?<?php echo "id=".$item["user_id"]; ?>"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>

                    <?php $n = $n+1; ?>
                    <?php endforeach;?>

                </table>
            </div>

        </div>

    </div>

    </div>

</section>

<?php include "include/footer.php"; ?>

</body>
</html>



