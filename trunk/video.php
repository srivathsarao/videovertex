<?php include_once 'includes/header.php'; ?>
			<td style="background-color: #eeeeee; width: 30%; text-align: top; height: 750px; vertical-align: top;">
				<div class="widget">
					<script type="text/javascript" src="flash/flowplayer-3.2.11.min.js"></script>
					<a href="videos/<?php echo $videoDetail->getFileName(); ?>" style="display:block;width:650px;height:330px" id="player"></a> 
					<script>
						flowplayer("player", "flash/flowplayer-3.2.15.swf");
					</script>
					<div class="header">
						<h3><?php echo $videoDetail->getName(); ?></h3>
						<label class="views">Views : <?php echo $videoDetail->getViews(); ?></label>
					</div>
					<div class="exemple views">
						<input type="hidden" value="<?php echo $rating->getId(); ?>" id="ratingId" />
						<input type="hidden" value="<?php echo $rating->getTotalRating(); ?>" id="totalRating" />
						<div class="ratingclass" id="<?php echo $rating->getAverageRating(); ?>">
					</div>
					</div>
					<br />
					<div style="padding: 14px; text-align:justify;">
						<?php echo $videoDetail->getDescription(); ?>
					</div>
					<div class="widget">
					<div class="header">
						<h3>Comments</h3>
					</div>
					<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
					<script type="text/javascript" src="js/jRating.jquery.js"></script>
					<script type="text/javascript" src="js/jquery.comments.js"></script>
					<script type="text/javascript" src="js/jquery.validate.js"></script>
					<script type="text/javascript">
					  $(document).ready(function(){
						    $("#commentForm").validate();
							$('.ratingclass').jRating({
								length:5,
								decimalLength:1,
								rateMax:5,
							});
						  });
					</script>
					<form action="#" method="post" id="commentForm">
						<table style="padding: 10px">
							<tr>
								<td>Name<input type="hidden" id="video_id" value="<?php echo $id; ?>"/></td>
								<td><input type="text" id="name" class="required"/></td>
							</tr>
							<tr>
								<td>Email</td>
								<td><input type="text" id="email" class="required email" /></td>
							</tr>
							<tr>
								<td>Comments</td>
								<td><textarea id="comment" class="required"></textarea></td>
							</tr>
							<tr>
								<td />
								<td><input class="button_small_round_deep_red submit" type="submit" value=" Submit Comment " /></td>
							</tr>
						</table>
					</form>
					<ul id="update" class="timeline">
					<?php
					foreach ($videoComments as $videoComment) {
					?>
						<li class="box" style="padding-bottom: 10px">
							<span style="font-weight: bold;" > 
								<?php echo $videoComment->getName(); ?>
							</span> 
							<br />
							<?php echo $videoComment->getComment(); ?>
							<br />
							<span style="font-size: x-small;" > 
							<?php echo $videoComment->getDate(); ?>
							</span>
						</li>
					<?php
					} 
					?>
					</ul>
				</div>
				</div>
			</td>
			<td	style="background-color: #eeeeee; width: 70%; text-align: top; height: 800px; vertical-align: top;">
				<?php 	
				$similarVideos = $userFunctions->getSimilarVideos($videoDetail->getName(), $videoDetail->getGenreId(), 3);
				if(sizeof($similarVideos) > 0) {
				?>
				<div class="widget">

				<div class="header">
						<h3>Similar Movies</h3>
					</div>
					<?php
					foreach ($similarVideos as $similarVideo) {
						getThumbnail($similarVideo->getId(), $similarVideo->getName(), $similarVideo->getThumbnail(), $similarVideo->getViews());
					}
					?>
				</div>
				<?php } ?>
				<div class="widget">
					<div class="header">
						<h3>Most Viewed</h3>
						<a href="viewall.php?type=mostviewed">view more</a>
					</div>
					<?php
					$mostViewedVideos = $userFunctions->getMostViewedVideos(0, 3);
					foreach ($mostViewedVideos as $recentlyAddedVideo) {
						getThumbnail($recentlyAddedVideo->getId(), $recentlyAddedVideo->getName(), $recentlyAddedVideo->getThumbnail(), $recentlyAddedVideo->getViews());
					}
					?>
				</div>
			</td>
<?php include_once 'includes/footer.php'; ?>