<?php
include_once '../core/dao/Database.php';
include_once '../core/resource/UserFunctions.php';
include_once '../core/dao/UserDAO.php';
include_once '../core/constants/Constants.php';
include_once '../core/bean/Comment.php';
include_once '../core/model/VideoFileUtility.php';

$userFunctions = new UserFunctions();

if ($_POST) {
	$comment = new Comment();
	$comment->setName($_POST['name']);
	$comment->setEmail($_POST['email']);
	$comment->setComment($_POST['comment']);
	$comment->setVideoId($_POST['video_id']);

	$userFunctions->addComment($comment);
?>

<li class="box" style="padding-bottom: 10px">
	<span style="font-weight: bold;" > 
		<?php echo $comment->getName(); ?>
	</span> 
	<br />
	<?php echo $comment->getComment(); ?>
	<br />
	<span style="font-size: x-small;" > 
	<?php 
	$date = new DateTime();
	echo date_format($date, 'Y-m-d H:i:s');
	?>
	</span>
</li>
<?php
}
?>
