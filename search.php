<?php include_once 'includes/header.php';?>
			<link href="css/pagination.css" rel="stylesheet" type="text/css" />
			<link href="css/C_red.css" rel="stylesheet" type="text/css" />
			<td style="background-color: #eeeeee; width: 30%; text-align: top; height: 800px; vertical-align: top;" colspan=2>
				<form action="search.php" class="form">
					<div class="header">
						<h3>Search</h3>
						<table>
							<tr>
								<td>
									Name :
								</td>
								<td>
									<input type="text" name="name">
								</td>
								<td>
									<input type="checkbox" name="partialMatch" checked="checked"> Include partial mached movie names
								</td>
							</tr>
						 	<tr>
								<td>
									Genre :
								</td>
								<td>
									<select name="genre">
										<option value="all">All</option>
										<?php
										$genres = $userFunctions->getGenres();
										foreach ($genres as $genre) {
											?>
											<option value="<?php echo $genre->getId(); ?>"><?php echo $genre->getName(); ?></option>
											<?php
										} ?>
									</select>
								</td>
							</tr>
							<tr>
								<td />
								<td>
									<input class="button_small_round_deep_red"  type="submit" value="Search">
								</td>
							</tr>
						</table>
					</div>
					<div class="widget">
						<div class="header">
							<h3>Results</h3>
						</div>
						<?php 
							if($getResults) {
								foreach($videos as $video) {
									getThumbnail($video->getId(), $video->getName(), $video->getThumbnail(), $video->getViews());
								} 
							}
						?>
					</div>
					<div>
						<?php 
						if($getResults) {
							echo pagination($limit, $page, $totalVideos, $userFunctions->selfURL()); 
						}
						?>
					</div>
				</form>
			</td>
<?php include_once 'includes/footer.php';?>