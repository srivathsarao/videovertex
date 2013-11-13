<?php
ob_start();
include_once 'core/dao/Database.php';
include_once 'core/resource/UserFunctions.php';
include_once 'core/dao/UserDAO.php';
include_once 'core/model/VideoFileUtility.php';
include_once 'core/bean/VideoDetails.php';
include_once 'core/constants/Constants.php';
include_once 'core/bean/Genre.php';
include_once 'core/bean/Comment.php';
include_once 'core/bean/Rating.php';

include_once 'includes/thumbnail.php';
include_once 'includes/pagination.php';

$userFunctions = new UserFunctions();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head><title>Movies Lover</title>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
<?php
$file = basename(strtolower($_SERVER['SCRIPT_NAME'])); 
if($file == 'index.php') {
	$string = "Movies Lover find ";
	$genres = $userFunctions->getGenres();
	foreach ($genres as $genre) {
		$string = $string . " " . $genre->getName();
	}
	?>
	<META name="Keywords" content="<?php echo $string; ?>"/>
	<META name="Description" content="<?php echo 'Movies Lover is one of the most popular online entertainment destinations'; ?>"/>
	<?php
} else if($file == 'search.php') {
	$totalVideos = 0;
	$name = "";
	$partial;
	$videos;
	
	$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
	$limit = 20;
	$startpoint = ($page * $limit) - $limit;
	
	$getResults = false;
	
	if(isset($_GET['name'])) {
		$name = $_GET['name'];
		if(isset($_GET['partialMatch']) && $_GET['partialMatch'] == "on") {
			$partial = true;
		} else {
			$partial = false;
		}
		$genreId = $_GET['genre'];
		$getResults = true;
	}
	
	if($getResults) {
		$videos = $userFunctions->getSearchVideos($name, $partial, $genreId, $startpoint, $limit);
		$totalVideos = $userFunctions->getTotalSearchVideo($name, $partial, $genreId);
	}
	?>
<META name="Keywords" content="<?php echo 'search ' . $name . ' Partial Match genre match'; ?>"/>
<META name="Description" content="<?php echo 'Number of search results=' . $totalVideos; ?>"/>
	<?php
} else if($file == 'video.php') {
	$videoDetail;
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		$userFunctions->increaseVideoViews($id);
		$videoDetail = $userFunctions->getVideoDetails($id);
		$videoComments = $userFunctions->getComments($id);
		$rating = $userFunctions->getRating($id);
	} else {
		header("location: index.php");
	}
	?>
<META name="Keywords" content="<?php echo $videoDetail->getName(); ?>"/>
<META name="Description" content="<?php echo strip_tags($videoDetail->getDescription()); ?>"/>
	<?php
} else if($file == 'viewall.php') {
	$title = "";
	$videos;
	$totalVideos;
	
	$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
	$limit = 20;
	$startpoint = ($page * $limit) - $limit;
	
	if (isset($_GET['genre'])) {
		$genre = $_GET['genre'];
		$totalVideos = $userFunctions->getTotalVideosByGenre($genre);
		$videos = $userFunctions->getMostViewedVideoDetailsByGenre($genre, $startpoint, $limit);
		$title = $userFunctions->getGenreName($genre);
	} else if(isset($_GET['type'])) {
		$type = $_GET['type'];
		$totalVideos = $userFunctions->getTotalVideos();
		if($type == "mostviewed") {
			$title = "Most Viewed";
			$videos = $userFunctions->getMostViewedVideos($startpoint, $limit);
		} else if($type == "recentlyadded") {
			$title = "Recently Added";
			$videos = $userFunctions->getRecentlyAddedVideos($startpoint, $limit);
		}
	} else {
		header("location: index.php");
	}
	?>
<META name="Keywords" content="<?php echo $title; ?>"/>
<META name="Description" content="<?php echo 'total videos in Genre ' . $title . '=' . $totalVideos; ?>"/>
	<?php
}
?>
<link rel="shortcut icon" href="images/favicon.png">
<link rel="stylesheet" href="css/jRating.jquery.css" type="text/css" />
<link rel="stylesheet" href="css/menu.css" type="text/css" />
<link rel="stylesheet" href="css/style.css" type="text/css" />
<link rel="stylesheet" href="css/table.css" type="text/css" />
<!--[if IE]>
	<link rel="stylesheet" type="text/css" href="css/table_ie.css" />
<![endif]-->

<!-- Google Analytics code Starts -->

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-35738859-4']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<!-- Google Analytics code Ends -->
</head>
<body>
	<table class="containertable">
		<tr>
			<td colspan="2">
				<a href="index.php">
					<img alt="Movies Lover" src="images/movies-logo.png" />
				</a>
				<div style="background-image:url(images/center_tile.gif)">
					<table cellpadding=0 cellspacing=0 style="width:100%;">
						<tr>
							<td><div style="font-size:1px;width:6px;height:34px;background-image:url(images/left_cap.gif);"></div></td>
							<td style="width:100%;">
								<ul id="qm0" class="qmmc">
									<li><a href="index.php">HOME</a></li>
									<li><span class="qmdivider qmdividery" ></span></li>
									<li><a href="javascript:void(0)">GENRE</a>
										<ul>
											<?php
											$genres = $userFunctions->getGenres();
											foreach ($genres as $genre) {
												?>
												<li><a href="viewall.php?genre=<?php echo $genre->getId(); ?>"><?php echo $genre->getName(); ?></a></li>
												<?php
											} ?>
										</ul>
									</li>
									<li><span class="qmdivider qmdividery" ></span></li>
									<li><a href="viewall.php?type=mostviewed">MOST VIEWED</a></li>
									<li><span class="qmdivider qmdividery" ></span></li>
									<li><a href="viewall.php?type=recentlyadded">RECENTLY ADDED</a></li>
								<li class="qmclear">&nbsp;</li></ul>
							</td>
							<td><div style="border-width:0px 0px 0px 1px;border-color:#aaaaaa;border-style:solid;font-size:1px;width:8px;height:31px;"></div></td>
							<td style="padding:0px 5px 0px 0px;">
								<form action="search.php" method="get">
									<input type="hidden" name="genre" value="all" />
									<input type="hidden" name="partialMatch" value="on" />
									<input type="text" name="name" style="font-family:arial;font-size:13px;width:100px;border-style:solid;border-width:1px;border-color:#ffffff;border-top-color:#aca899;border-left-color:#aca899;padding: 0" value="" />
								</form>
							</td>
							<td style="padding:0px 5px 0px 0px;font-family:arial;font-size:13px;color:#444444">
							SEARCH
							</td>
							<td>
								<div style="font-size:1px;width:6px;height:34px;background-image:url(images/right_cap.gif);" />
							</td>
						</tr>
					</table>
				</div>
			</td>
		</tr>
		<tr>