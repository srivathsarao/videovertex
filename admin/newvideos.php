<?php
session_start();
if(!isset($_SESSION['admin'])) {
	header("Location: index.php");
} 
?>
<?php include_once 'includes/header.php'; ?>
<?php
$newVideos = $adminFunctions->getNewVideos();
if (isset($_GET['rows'])) {
	$rows = $_GET['rows'];
	$videoDetails = array();
	for ($i = 0; $i < $rows; $i++) {
		$videoDetail = $newVideos[$i];
		$name = $_GET['name' . $i];
		$genre = $_GET['genre' . $i];
		$description = $_GET['description' . $i];

		$videoDetail->setName($name);
		$videoDetail->setGenreId($genre);
		$videoDetail->setDescription($description);
		$videoDetails[] = $videoDetail;
	}
	
	for($i=0; $i < $rows; $i++) {
		$adminFunctions->createVideos($videoDetails[$i]);
	}
}
$newVideos = $adminFunctions->getNewVideos();
?>
			<td style="background-color: #eeeeee; width: 30%; text-align: top; height: 800px; vertical-align: top;" colspan=2>
				<form action="newvideos.php" method="get"  id="commentForm" >
					<?php
					$genres = $userFunctions->getGenres();
					foreach ($newVideos as $newVideo) {
					?>
						<?php
						getVideoDescription($newVideo->getId(), $newVideo->getThumbnail(), $newVideo->getLength(), $genres);
						?>
					<?php
					}
					if(sizeof($newVideos) > 0) {
					?>
				<input type="hidden" name="rows" value="<?php echo sizeof($newVideos); ?>" />
				<input class="button_small_round_deep_red" style="right: 10%" type="submit" name="Save" value="Save"/>
				<?php } ?>
			</form>
			</td>
<?php include_once 'includes/footer.php'; ?>