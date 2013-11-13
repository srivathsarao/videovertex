<?php
session_start();
if(!isset($_SESSION['admin'])) {
	header("Location: index.php");
} 
?>
<?php
include_once 'includes/header.php';?>
<?php
$videoDetail;
$comments;
if(isset($_GET['delete'])) {
	$id = $_GET['rows'];
	$videoDetail = $userFunctions->getVideoDetails($id);
	$comments = $userFunctions->getComments($id);
	
	$adminFunctions->deleteVideo($videoDetail);
	header("location: newvideos.php");
} else if(isset($_GET['rows'])) {
	$rows = $_GET['rows'];
	$name = $_GET['name' . $rows];
	$genre = $_GET['genre' . $rows];
	$description = $_GET['description' . $rows];
	
	$videoDetail = $userFunctions->getVideoDetails($rows);
	$videoDetail->setName($name);
	$videoDetail->setGenreId($genre);
	$videoDetail->setDescription($description);
	
	$adminFunctions->saveVideo($videoDetail);
	$videoDetail = $userFunctions->getVideoDetails($rows);
	$comments = $userFunctions->getComments($rows);
} else if(isset($_GET['id'])) {
	$id = $_GET['id'];
	$videoDetail = $userFunctions->getVideoDetails($id);
	$comments = $userFunctions->getComments($id);
}
?>
			<td style="background-color: #eeeeee; width: 30%; text-align: top; height: 800px; vertical-align: top;" colspan=2>
			<form action="editvideo.php" method="get" id="commentForm" >
			<?php
				$genres = $userFunctions->getGenres();
				if($videoDetail != null) {
					getVideoDescription($videoDetail->getId(), $videoDetail->getThumbnail(), $videoDetail->getLength(), $genres, $videoDetail->getName(), $videoDetail->getGenreId(), $videoDetail->getDescription());
					?>
						<input type="hidden" name="rows" value="<?php echo $videoDetail->getId(); ?>" />
						<input class="button_small_round_deep_red" style="right: 10%" type="submit" value="Submit" />
						<input class="button_small_round_deep_red" style="right: 10%" type="submit" name="delete" value="Delete" />
					<?php
				}
			?>
			</form>
			<br />
			<ul id="update" class="timeline">
					<?php
					foreach ($comments as $videoComment) {
					?>
						<li class="box">
							<form action="includes/deletecomment.php" method="post">
							<span class="com_name"> 
								<?php echo $videoComment->getName(); ?>
							</span> 
							<br />
							<?php echo $videoComment->getComment(); ?>
							<br />
							<?php echo $videoComment->getDate(); ?>
							<input type="hidden" name="id" value="<?php echo $videoComment->getId(); ?>">
							<input type="hidden" name="video_id" value="<?php echo $videoComment->getVideoId(); ?>">
							<input  class="button_small_round_deep_red" type="submit" value="Delete" name="Delete" />
							</form>
						</li>
					<?php
					} 
					?>
			</ul>
			</td>
<?php include_once 'includes/footer.php';?>