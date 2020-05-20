<?php

//Connection to DB
include 'include/db.php';

$work_id = $_GET['id'];
$user_id = $_SESSION["user"];

$works = $db->query("select * from work, work_type, work_subtype, work_kind, work_language, user_info
                                where work.type_id = work_type.type_id and work.subtype_id = work_subtype.subtype_id and work.kind_id = work_kind.kind_id 
                                and work.language_id = work_language.language_id and user_info.user_id = work.user_id and work.work_id = $work_id");
$work = $works->fetch();

$work_type = $work['type_name'];
$work_subtype = $work['subtype_name'];
$work_kind = $work['kind_name'];
$work_language = $work['language_name'];
$author_id = $work['user_id'];

$work_name = $work['work_name'];
$date_published = $work['date_published'];
$page_no = $work['page_no'];
$date_added = $work['date_added'];
$publisher_name = $work['publisher_name'];
$publisher_no = $work['publisher_no'];
$publisher_year = $work['publisher_year'];
$publisher_pages = $work['publisher_pages'];
$certificate_no = $work['certificate_no'];
$patent_no = $work['patent_no'];

$teachers = $db->query("select * from user, user_info where user.user_id = user_info.user_id and user_info.user_id <> $user_id and (user.role_id = 2 or user.role_id = 3) 
                                    order by user_info.first_name, user_info.last_name, user_info.middle_name");
$teachers->setFetchMode(PDO::FETCH_ASSOC);
$teacher = $teachers->fetchAll();

$typies = $db->query("select * from work_type where type_name <> '$work_type'");
$typies->setFetchMode(PDO::FETCH_ASSOC);
$type = $typies->fetchAll();

$subtypies = $db->query("select * from work_subtype where subtype_name <> '$work_subtype'");
$subtypies->setFetchMode(PDO::FETCH_ASSOC);
$subtype = $subtypies->fetchAll();

$kindes = $db->query("select * from work_kind where kind_name <> '$work_kind'");
$kindes->setFetchMode(PDO::FETCH_ASSOC);
$kind = $kindes->fetchAll();

$languages = $db->query("select * from work_language where language_name <> '$work_language'");
$languages->setFetchMode(PDO::FETCH_ASSOC);
$language = $languages->fetchAll();

if(isset($_POST["save"])){

    $work_name = $_POST["work_name"];
    $work_type = $_POST["work_type"];
    $work_kind = $_POST["work_kind"];
    $work_published = $_POST["work_published"];
    $page_no = $_POST["page_no"];
    $work_language = $_POST["work_language"];
    $publisher_name = $_POST["publisher_name"];
    $publisher_no = $_POST["publisher_no"];
    $publisher_year = $_POST["publisher_year"];
    $publisher_pages = $_POST["publisher_pages"];
    $certificate_no = $_POST["certificate_no"];
    $patent_no = $_POST["patent_no"];

    if($_FILES["work_file"]["tmp_name"] == ""){
        $work_file = $work["file_name"];
    }
    else{
        $work_file = $_FILES["work_file"]["name"];
        $tmp_name = $_FILES["work_file"]["tmp_name"];
        $dir = "file/";
        move_uploaded_file($tmp_name, $dir.$work_file);
    }

    $statements1 = $db->query(
        "
				SELECT * FROM work_type where type_name = '$work_type'
			"
    );
    $statement1 = $statements1->fetch();

    $statements3 = $db->query(
        "
				SELECT * FROM work_kind where kind_name = '$work_kind'
			"
    );
    $statement3 = $statements3->fetch();

    $statements4 = $db->query(
        "
				SELECT * FROM work_language where language_name = '$work_language'
			"
    );
    $statement4 = $statements4->fetch();

    $type_id = $statement1['type_id'];
    $kind_id = $statement3['kind_id'];
    $language_id = $statement4['language_id'];


    if($_POST["work_subtype"] != ""){
        $work_subtype = $_POST["work_subtype"];
        $statements2 = $db->query(
            "
				SELECT * FROM work_subtype where subtype_name = '$work_subtype'
			"
        );
        $statement2 = $statements2->fetch();
        $subtype_id = $statement2['subtype_id'];
    }
    else {
        $subtype_id = 127;
    }


    $statement = $db->query(
        "
				UPDATE work
				SET work_name = '$work_name', date_published = '$work_published', page_no = $page_no, publisher_name = '$publisher_name',
				publisher_no = '$publisher_no', publisher_year = '$publisher_year', publisher_pages = '$publisher_pages', certificate_no = '$certificate_no', 
				patent_no = '$patent_no', subtype_id = $subtype_id, type_id = $type_id, kind_id = $kind_id, language_id = $language_id, file_name = '$work_file'
				WHERE work_id = $work_id
			"
    );

    if (isset($_POST["coauthor"])) {

        $db->query("DELETE FROM coauthor WHERE work_id = $work_id");

        foreach ($_POST['coauthor'] as $coauthor):

            $coau = $db->query("SELECT * from user_info WHERE CONCAT(first_name, ' ', last_name, ' ', middle_name) = '$coauthor'");
            $co = $coau->fetch();

            $coauthor_id = $co['user_id'];

            $db->query(
                "
                 INSERT INTO coauthor(user_id, work_id)
                 VALUES($coauthor_id, $work_id);
                 "
            );

        endforeach;
    }
     header("Location: own-works.php");

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

                <form method="POST" enctype="multipart/form-data">

                    <p>Name:</p>
                    <input type="text" name="work_name" value="<?php echo $work_name ?>" required style="width: 900px; font-size: 13px;">

                    <p>Work type:</p>
                    <select name="work_type">
                        <option><?php echo $work_type; ?></option>
                        <?php foreach ($type as $item):?>
                            <option><?php echo $item['type_name']; ?></option>
                        <?php endforeach;?>
                    </select>

                    <p>Work subtype:</p>
                    <select name="work_subtype">
                        <option><?php echo $work_subtype ?></option>
                        <option></option>
                        <?php foreach ($subtype as $item): ?>
                            <option><?php echo $item["subtype_name"]; ?></option>
                        <?php endforeach;?>
                    </select>

                    <p>Work kind:</p>
                    <select name="work_kind">
                        <option><?php echo $work_kind ?></option>
                        <?php foreach ($kind as $item): ?>
                            <option><?php echo $item["kind_name"]; ?></option>
                        <?php endforeach;?>
                    </select>

                    <p>Date of publication: </p>
                    <input type="date" name="work_published" value = "<?php echo $date_published ?>" required>

                    <p>Number of printed sheets or pages: </p>
                    <input type="number" step=0.05 name="page_no" value = "<?php echo $page_no ?>" required>

                    <p>Language: </p>
                    <select name="work_language">
                        <option><?php echo $work_language ?></option>
                        <?php foreach ($language as $item): ?>
                            <option><?php echo $item["language_name"]; ?></option>
                        <?php endforeach;?>
                    </select>

                    <p>Publisher/magazine name: </p>
                    <input type="text" name="publisher_name" value="<?php echo $publisher_name ?>">

                    <p>Publisher/magazine №: </p>
                    <input type="number" name="publisher_no" value="<?php echo $publisher_no ?>">

                    <p>Publisher/magazine year: </p>
                    <input type="number" name="publisher_year" value="<?php echo $publisher_year ?>">

                    <p>Publisher/magazine's pages: </p>
                    <input type="text" name="publisher_pages" value="<?php echo $publisher_pages ?>">

                    <p>Certificate №: </p>
                    <input type="number" name="certificate_no" value="<?php echo $certificate_no ?>">

                    <p>Patent №: </p>
                    <input type="number" name="patent_no" value="<?php echo $patent_no ?>">

                    <p>Full names of co-authors: </p>
                    <select name="coauthor[]" multiple style="height: 100px;">
                        <option></option>
                        <?php foreach ($teacher as $item): ?>
                            <option><?php echo $item["first_name"]. " ". $item["last_name"]. " ". $item["middle_name"]; ?></option>
                        <?php endforeach;?>
                    </select>

                    <p>Document: </p>
                    <input type="file" name="work_file" value="">

                    <button id="safe_edit" type="submit" name="save"><i class="fa fa-check"></i>Save</button>

                </form>

            </div>



        </div>

    </div>

    </div>

</section>

<?php include "include/footer.php"; ?>

</body>
</html>


<?php
