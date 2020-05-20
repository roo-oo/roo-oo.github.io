<?php

//Connection to DB
include 'include/db.php';

$department_id = $_GET['department'];

$enterts = $db->query("select work_type.type_name, count(work.work_id) work_no from work_type, work, user, user_info
                                where work_type.type_id = work.type_id and user.user_id=work.user_id and user.user_id=user_info.user_id and user_info.department_id = $department_id
                                GROUP BY work_type.type_name");

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
                <h4>THE PERFORMANCE OF THE DEPARTMENT</h4>
            </div>

            <div id="t_content">

            <table id="t_statistics" style="margin-top: 20px;">

                <?php foreach ($entert as $item): ?>
                <tr class="tr1">
                    <td><?php echo $item["type_name"]; ?></td>
                    <td><a><?php echo $item["work_no"]; ?></a></td>
                </tr>

                    <?php
                    $a = $item["type_name"];
                    $enterts2 = $db->query("select work_subtype.subtype_name, count(work.work_id) work_no 
                                from work_subtype, work, work_type, user, user_info
                                where work_type.type_id = work.type_id and work_subtype.subtype_id = work.subtype_id and work_type.type_name = '$a' and user.user_id=work.user_id and user.user_id=user_info.user_id and user_info.department_id = 1
                                GROUP BY work_subtype.subtype_name");

                    $enterts2->setFetchMode(PDO::FETCH_ASSOC);
                    $entert2 = $enterts2->fetchAll();

                    foreach ($entert2 as $item2): ?>
                        <tr class="tr2">
                            <td><?php echo $item2["subtype_name"]; ?></td>
                            <td><a><?php echo $item2["work_no"]; ?></a></td>
                        </tr>
                    <?php endforeach;?>

                <tr class="tr3">
                    <td colspan="2"></td>
                </tr>

                <?php endforeach;?>
            </table>


        </div>

            </div>

        </div>

    </section>

<?php include "include/footer.php"; ?>

</body>
</html>
