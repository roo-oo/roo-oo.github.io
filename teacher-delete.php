<?php
include 'include/db.php';

$user_id = $_GET['id'];

$db->query("DELETE FROM user WHERE user_id = $user_id");

header("Location:teacher-list.php");