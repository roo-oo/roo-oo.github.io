<?php
include 'include/db.php';

$work_id = $_GET['id'];

$db->query("DELETE FROM work WHERE work_id = $work_id");
$db->query("DELETE FROM coauthor WHERE work_id = $work_id");

header("Location: own-works.php");