<?php

//Connection to DB
include 'include/db.php';

$department_id = $_GET['department'];

$enterts = $db->query("select * from user_info, user, degree, department
where user_info.user_id = user.user_id and user_info.degree_id = degree.degree_id and user_info.department_id = department.department_id and department.department_id = $department_id
order by user_info.first_name, user_info.last_name, user_info.middle_name");

$enterts->setFetchMode(PDO::FETCH_ASSOC);
$entert = $enterts->fetchAll();

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

        <div id="topic">
            <h2>DEPARTMENT OF INFORMATION SYSTEMS</h2>
            <h4>FACULTY MEMBERS</h4>
        </div>

        <div id="t_content">
            <?php foreach ($entert as $item): ?>
            <div class="t_img">

                    <a href="profile.php?<?php echo "search=".$item["user_id"]; ?>"><img src="image/<?php echo $item["image"]; ?>"></a>
                    <br>
                    <a class="t_name" href="profile.php<?php echo "id=".$item["user_id"]; ?>"><?php echo strtoupper($item["first_name"]. " ". $item["last_name"]. " ". $item["middle_name"]); ?></a>
                    <br>
                    <a class="t_degree"><?php echo $item["degree_name"]; ?></a>

            </div>
            <?php endforeach;?>
        </div>
    </div>

</section>

<?php include "include/footer.php"; ?>

</body>
</html>
