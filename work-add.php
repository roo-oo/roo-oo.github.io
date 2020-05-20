<?php

//Connection to DB
include 'include/db.php';

$user_id = $_SESSION["user"];

$teachers = $db->query("select * from user, user_info where user.user_id = user_info.user_id and user_info.user_id <> $user_id and (user.role_id = 2 or user.role_id = 3)  
                                    order by user_info.first_name, user_info.last_name, user_info.middle_name");
$teachers->setFetchMode(PDO::FETCH_ASSOC);
$teacher = $teachers->fetchAll();

$typies = $db->query("select * from work_type");
$typies->setFetchMode(PDO::FETCH_ASSOC);
$type = $typies->fetchAll();

$subtypies = $db->query("select * from work_subtype");
$subtypies->setFetchMode(PDO::FETCH_ASSOC);
$subtype = $subtypies->fetchAll();

$kindes = $db->query("select * from work_kind");
$kindes->setFetchMode(PDO::FETCH_ASSOC);
$kind = $kindes->fetchAll();

$languages = $db->query("select * from work_language");
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

    if($_FILES["work_file"]["tmp_name"] != ""){
        $work_file = $_FILES["work_file"]["name"];
        $tmp_name = $_FILES["work_file"]["tmp_name"];
        $dir = "file/";
        move_uploaded_file($tmp_name, $dir.$work_file);
    }
    else{
        $work_file = "";
    }

    $statements1 = $db->query(
        "
				SELECT * FROM work_type where type_name = '$work_type'
			"
    );
    $statement1 = $statements1->fetch();
    $type_id = $statement1['type_id'];

    $statements3 = $db->query(
        "
				SELECT * FROM work_kind where kind_name = '$work_kind'
			"
    );
    $statement3 = $statements3->fetch();
    $kind_id = $statement3['kind_id'];

    $statements4 = $db->query(
        "
				SELECT * FROM work_language where language_name = '$work_language'
			"
    );
    $statement4 = $statements4->fetch();
    $language_id = $statement4['language_id'];

    $db->query("INSERT INTO work (work_name, date_published, date_added, page_no, publisher_name, publisher_no, publisher_year, 
                                            publisher_pages, certificate_no, patent_no, subtype_id, type_id, user_id, kind_id, language_id, file_name)
                            VALUES('$work_name','$work_published',NOW(), $page_no, '$publisher_name', '$publisher_no', '$publisher_year', 
                                    '$publisher_pages', '$certificate_no', '$patent_no', $subtype_id, $type_id, $user_id, $kind_id, $language_id, '$work_file')");


    if (isset($_POST["coauthor"])) {

        $works = $db->query("SELECT * FROM work WHERE work_name = '$work_name' and user_id = $user_id");
        $work = $works->fetch();
        $work_id = $work['work_id'];

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
                        <input type="text" name="work_name" value="" required style="width: 900px; font-size: 13px;">

                        <p>Work type:</p>
                        <select name="work_type">
                            <?php foreach ($type as $item):?>
                                <option><?php echo $item['type_name']; ?></option>
                            <?php endforeach;?>
                        </select>

                        <p>Work subtype:</p>
                        <select name="work_subtype">
                            <option></option>
                            <?php foreach ($subtype as $item): ?>
                                <option><?php echo $item["subtype_name"]; ?></option>
                            <?php endforeach;?>
                        </select>

                        <p>Work kind:</p>
                        <select name="work_kind">
                            <?php foreach ($kind as $item): ?>
                                <option><?php echo $item["kind_name"]; ?></option>
                            <?php endforeach;?>
                        </select>

                        <p>Date of publication: </p>
                        <input type="date" name="work_published" required>

                        <p>Number of printed sheets or pages: </p>
                        <input type="number" step=0.05 name="page_no" required>

                        <p>Language: </p>
                        <select name="work_language">
                            <?php foreach ($language as $item): ?>
                                <option><?php echo $item["language_name"]; ?></option>
                            <?php endforeach;?>
                        </select>

                        <p>Publisher/magazine name: </p>
                        <input type="text" name="publisher_name" value="">

                        <p>Publisher/magazine №: </p>
                        <input type="number" name="publisher_no" value="">

                        <p>Publisher/magazine year: </p>
                        <input type="number" name="publisher_year" value="">

                        <p>Publisher/magazine's pages: </p>
                        <input type="text" name="publisher_pages" value="">

                        <p>Certificate №: </p>
                        <input type="number" name="certificate_no" value="">

                        <p>Patent №: </p>
                        <input type="number" name="patent_no" value="">

                        <p>Full names of co-authors: </p>
                        <select name="coauthor[]" multiple style="height: 100px;">
                            <option></option>
                            <?php foreach ($teacher as $item): ?>
                                <option><?php echo $item["first_name"]. " ". $item["last_name"]. " ". $item["middle_name"]; ?></option>
                            <?php endforeach;?>
                        </select>

                        <p>Document: </p>
                        <input type="file" name="work_file" value="" required>

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
