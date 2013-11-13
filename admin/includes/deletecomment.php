<?php 
ob_start();
include_once '../../core/dao/Database.php';
include_once '../../core/resource/AdminFunctions.php';
include_once '../../core/dao/AdminDAO.php';
include_once '../../core/model/VideoFileUtility.php';
include_once '../../core/constants/Constants.php';

if(isset($_POST['id'])) {
	$id = $_POST['id'];
	$videoId = $_POST['video_id'];
	$adminFunctions = new AdminFunctions();
	$adminFunctions->deleteComment($id);
	header("Location: ../editvideo.php?id=$videoId");
}
ob_end_flush();
?>