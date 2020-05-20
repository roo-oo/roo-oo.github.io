<?php

//Connection to DB
include 'include/db.php';

$email = $_SESSION["email"];
$user_id = $_SESSION["user"];

?>


<div id="left_box">

    <div class="left_box_block" style="padding-top: 30px;"><a href="identity.php">PERSONAL DATA</a></div>
    <div class="left_box_block"><a href="own-works.php">SCIENTIFIC AND METHODOLOGICAL WORKS</a></div>

    <?php if($email=='v.serbin@edu.iitu.kz'):?>
    <div class="left_box_block"><a href="teacher-list.php">LIST OF TEACHERS OF THE DEPARTMENT</a></div>
    <?php endif; ?>

</div>
