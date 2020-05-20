<?php
include 'include/db.php';

    $user_id = $_GET['search'];

$profile = $db->query("select * from user_info, user, degree, department
where user_info.user_id = user.user_id and user_info.degree_id = degree.degree_id and user_info.department_id = department.department_id and user.user_id = $user_id");
$profile->setFetchMode(PDO::FETCH_ASSOC);

$typies = $db->query("select * from work_type");
$typies->setFetchMode(PDO::FETCH_ASSOC);
$type = $typies->fetchAll();

$subtypies = $db->query("select * from work_subtype");
$subtypies->setFetchMode(PDO::FETCH_ASSOC);
$subtype = $subtypies->fetchAll();

//SEARCH
$work_type = false;
$work_subtype = false;
$first_date = false;
$last_date = false;

include 'search.php';

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

        <div id="topic" style="height: 50px;">
            <h2> TEACHER PROFILE </h2>
        </div>

        <div id="t_content">

            <?php foreach ($profile as $item): ?>
            <div id="profile_image">
                <img src="image/<?php echo $item["image"]; ?>">
            </div>


            <div id="profile_info">

                <p>Full name: <a><?php echo $item["first_name"]. " ". $item["last_name"]. " ". $item["middle_name"]; ?></a></p>
                <p>Department: <a><?php echo $item["department_name"]; ?></a></p>
                <p>Academic degree: <a><?php echo $item["degree_name"]; ?></a></p>
                <p>Experience: <a><?php echo $item["experience"]; ?></a></p>
                <p>Email: <a><?php echo $item["email"]; ?></a></p>

            </div>
            <?php endforeach;?>

        </div>

        <div id="topic" style="height: 50px; margin-top: 3em; border-radius: 10px 10px 0 0;">
            <h4> LIST OF SCIENTIFIC AND METHODOLOGICAL WORKS OF THE TEACHER </h4>
        </div>


        <div id="t_work" style="padding-bottom: 2em;">
            <form method="get" action="profile.php">
            <label>WORK TYPE:</label>
            <br>
            <select id="work_type" name="work_type">
                <option><?php echo $work_type ?></option>
                <option></option>
                <?php foreach ($type as $item): ?>
                <option><?php echo $item["type_name"]; ?></option>
                <?php endforeach;?>
            </select>

            <select id="work_type" name="work_subtype">
                <option><?php echo $work_subtype ?></option>
                <option></option>
                <?php foreach ($subtype as $item): ?>
                    <option><?php echo $item["subtype_name"]; ?></option>
                <?php endforeach;?>
            </select>


            <br>
            <label>DATE OF PUBLICATION</label>
            <input id="work_period" type="date" value="<?php echo $first_date ?>" name="first_date"> -
            <input id="work_period" type="date" value="<?php echo $last_date ?>" name="last_date">
            <button name="search" value="<?php echo $user_id?>">Search</button>
</form>
            <?php $n = 1; foreach($work as $value): ?>
            <p>
                <?php echo  $n.'. '.$value["work_name"]; $n = $n+1; ?>
                <a href="file/<?php echo $value["file_name"]; ?>" download><i class="fa fa-download" style="color: cornflowerblue; font-size: 22px; font-weight: bold;"></i></a>
            </p>
            <?php endforeach; ?>
        </div>


    </div>

</section>

<?php include "include/footer.php"; ?>

</body>
</html>
