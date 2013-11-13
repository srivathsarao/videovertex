<?php include_once 'includes/header.php';?>
			<link href="css/pagination.css" rel="stylesheet" type="text/css" />
			<link href="css/C_red.css" rel="stylesheet" type="text/css" />
			<td style="background-color: #eeeeee; width: 30%; text-align: top; height: 850px; vertical-align: top;" colspan=2>
				<div class="widget" style="height: 850px">
					<div class="header">
						<h3><?php echo $title; ?></h3>
					</div>
					<?php
					foreach($videos as $video) {
						getThumbnail($video->getId(), $video->getName(), $video->getThumbnail(), $video->getViews());
					} 
					?>
				</div>
				<div>
					<?php echo pagination($limit, $page, $totalVideos, $userFunctions->selfURL()); ?>
				</div>
			</td>
<?php include_once 'includes/footer.php';?>