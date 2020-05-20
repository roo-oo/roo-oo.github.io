<?php
include 'include/db.php';

$department_id = $_GET['department'];

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

            <div id="topic">
                <h2>DEPARTMENT OF INFORMATION SYSTEMS</h2>
                <h4>LIST OF SCIENTIFIC AND METHODOLOGICAL WORKS OF THE DEPARTMENT</h4>
            </div>

            <div id="t_work" style="padding-bottom: 2em;">

                <form method="get" action="work-list.php">

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
                        <button name="department" value="<?php echo $department_id?>">Search</button>

                </form>

                <table id="profile_works_list" style="width: 99%; margin-left: 0">

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
                            FULL NAME OF co-AUTHORS
                        </th>
                        <th>
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
                                <a href="file/<?php echo $item["file_name"]; ?>" download><i class="fa fa-download"></i></a>
                            </td>
                        </tr>
                        <?php $n = $n+1; endforeach; ?>

                </table>

            </div>
        </div>

    </section>

    <?php include "include/footer.php"; ?>

</body>
</html>
