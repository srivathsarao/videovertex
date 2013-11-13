<?php function getVideoDescription($id, $filename, $length, $genres, $name=null, $genreId=null, $description=null) { ?>
	<div class="widget">
		<div class="header">
		<h3><?php 
		if($genreId == null) {
			echo $id + 1; 
		} else {
			echo $id;
		}
		?></h3>
		</div>
		<table style="width: 100%">
			<tr>
				<td>
					Name
				</td>
				<td>
					<input type="text" class="required" name="name<?php echo $id; ?>" value="<?php echo $name; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					Thumbnail
				</td>
				<td>
					<img alt="" height="94" width="192" src="../images/thumbnails/<?php echo $filename; ?>" onError="this.src='../images/no-thumbnail-img.jpg';">
				</td>
			</tr>
			<tr>
				<td>
					Length
				</td>
				<td>
					<?php echo $length; ?>
					<input type="hidden" name="length" value="<?php echo $length; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					Genre
				</td>
				<td>
					<select name="genre<?php echo $id; ?>"  class="required" >
						<option></option>
						<?php
						foreach ($genres as $genre) {
						if($genre->getId() == $genreId) {
						?>
						<option value="<?php echo $genre->getId(); ?>" selected="selected" ><?php echo $genre->getName(); ?></option>
						<?php } else { ?>
						<option value="<?php echo $genre->getId(); ?>"><?php echo $genre->getName(); ?></option>
						<?php }
						} ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					Description
				</td>
				<td>
					<textarea class="text required" style="width: 100%; background: white;" name="description<?php echo $id; ?>"><?php echo $description; ?></textarea>
				</td>
			</tr>
			<tr>
				<td>
				</td>
				<td>
				</td>
			</tr>
		</table>
	</div>
<?php } ?>
