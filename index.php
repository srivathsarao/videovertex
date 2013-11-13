<?php include_once 'includes/header.php';?>
			<td style="background-color: #eeeeee; width: 30%; text-align: top; height: 750px; vertical-align: top;" colspan=2>
					<div class="widget">
						<div class="header">
							<h3>Recently Added</h3>
							<a href="viewall.php?type=recentlyadded">view more</a>
						</div>
						<?php 
						$recentlyAddedVideos = $userFunctions->getRecentlyAddedVideos(0, 8);
						foreach ($recentlyAddedVideos as $recentlyAddedVideo) {
							getThumbnail($recentlyAddedVideo->getId(), $recentlyAddedVideo->getName(), $recentlyAddedVideo->getThumbnail(), $recentlyAddedVideo->getViews());
						}
						?>
					</div>
					<div class="widget">
						<div class="header">
							<h3>Most Viewed</h3>
							<a href="viewall.php?type=mostviewed">view more</a>
						</div>
						<?php
						$mostViewedVideos = $userFunctions->getMostViewedVideos(0, 8);
						foreach ($mostViewedVideos as $recentlyAddedVideo) {
							getThumbnail($recentlyAddedVideo->getId(), $recentlyAddedVideo->getName(), $recentlyAddedVideo->getThumbnail(), $recentlyAddedVideo->getViews());
						}
						?>
					</div>
			</td>
<?php include_once 'includes/footer.php';?>