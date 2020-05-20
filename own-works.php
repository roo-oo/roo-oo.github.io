<?php

//Connection to DB
include 'include/db.php';

$user_id = $_SESSION["user"];

$works = $db->query("select * from work, work_type, work_subtype, work_kind, work_language, user_info
                                where work.type_id = work_type.type_id and work.subtype_id = work_subtype.subtype_id and work.kind_id = work_kind.kind_id 
                                and work.language_id = work_language.language_id and user_info.user_id = work.user_id and work.user_id = $user_id
                                order by work.work_name
");
$works->setFetchMode(PDO::FETCH_ASSOC);
$work = $works->fetchAll();
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

                <h4>SCIENTIFIC AND METHODOLOGICAL WORKS</h4>

                <table id="profile_works_list">

                    <tr>
                        <th>
                            №
                        </th>
                        <th>
                           WORK NAME
                        </th>
                        <th>
                            WORK TYPE
                        </th>
                        <th>
                            AUTHOR
                        </th>
                        <th>
                            Publisher, magazine (name, number, year, pages) or №
                            copyright certificate, patent
                        </th>
                        <th>
                            DATE OF PUBLICATION
                        </th>
                        <th>
                            KIND OF WORK
                        </th>
                        <th>
                            LANGUAGE
                        </th>
                        <th>
                            NUMBER OF PRINTED SHEETS OR PAGES
                        </th>
                        <th>
                            FULL NAME OF co-AUTHORS
                        </th>
                        <th>
                            DATE ADDED
                        </th>
                        <th>
                            <a href="work-add.php"><i class="fa fa-plus"></i></a>
                        </th>
                    </tr>

                    <?php $n = 1; foreach ($work as $item): ?>
                    <tr>
                        <td>
                            <?php echo $n ?>
                        </td>
                        <td>
                            <?php echo $item["work_name"] ?>
                        </td>
                        <td>
                            <?php
                            if ($item["subtype_name"] == NULL){
                                $a = "";
                                    }
                            else{$a = ", ";}
                            echo $item["type_name"]. $a. $item["subtype_name"];
                            ?>
                        </td>
                        <td>
                            <?php echo $item["first_name"]. " ". $item["last_name"]. " ". $item["middle_name"]; ?>
                        </td>
                        <td>
                            <?php echo $item["publisher_name"]. "; ". $item["publisher_no"]. "; ". $item["publisher_year"]. "; ". $item["publisher_pages"]. "; ". $item["certificate_no"]. "; ". $item["patent_no"]; ?>
                        </td>
                        <td>
                            <?php echo $item['date_published'] ?>
                        </td>
                        <td>
                            <?php echo $item['kind_name'] ?>
                        </td>
                        <td>
                            <?php echo $item['language_name'] ?>
                        </td>
                        <td>
                            <?php echo $item['page_no'] ?>
                        </td>
                        <td>
                            <?php
                            $work_id = $item['work_id'];
                            $coauthors = $db->query("select * from coauthor, user_info 
                                                               where coauthor.work_id = $work_id and coauthor.user_id = user_info.user_id");
                            $coauthors->setFetchMode(PDO::FETCH_ASSOC);
                            $coauthor = $coauthors->fetchAll();

                            foreach ($coauthor as $value):
                            echo $value["first_name"]. " ". $value["last_name"]. " ". $value["middle_name"]. "; ";
                            endforeach;?>
                        </td>
                        <td>
                            <?php echo $item['date_added'] ?>
                        </td>
                        <td>
                            <a href="file/<?php echo $item['file_name']?>" download><i class="fa fa-download"></i></a>
                            <br>
                            <a href="work-edit.php?<?php echo "id=".$item["work_id"]; ?>"><i class="fa fa-edit"></i></a>
                            <br>
                            <a href="work-delete.php?<?php echo "id=".$item["work_id"]; ?>"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                        <?php $n = $n+1; endforeach; ?>

                </table>
            </div>

        </div>

    </div>

    </div>

</section>

<?php include "include/footer.php"; ?>

</body>
</html>


