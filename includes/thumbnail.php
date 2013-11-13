<?php function getThumbnail($id, $name, $image, $views) { ?>
<div style="padding: 15px;  display: inline-block;">
	<a href="video.php?id=<?php echo $id;?>" style="text-decoration: none;">
		<div>
			<img alt="" height="94" width="192" src="images/thumbnails/<?php echo $image;?>" onError="this.src='images/no-thumbnail-img.jpg';">
			<div style="font-weight: bold; width: 192px; word-wrap: break-word;">
			<?php echo $name; ?>
			</div>
			<div style="font-size: 10px; color: gray;">
			Views: <?php echo $views; ?>
			</div>
		</div>
	</a>
</div>
<?php } ?>