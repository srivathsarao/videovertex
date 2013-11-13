<?php
session_start();
if(!isset($_SESSION['admin'])) {
	header("Location: index.php");
} 
?>
<?php 
include_once 'includes/header.php';
$id = null;
$name = null;

if(isset($_GET['update']) && isset($_GET['name']) && isset($_GET['id']) && $_GET['id'] != "") {
	$id = $_GET['id'];
	$name= $_GET['name'];
	$genre = new Genre();
	$genre->setId($id);
	$genre->setName($name);
	$adminFunctions->editGenres($genre);
} else if(isset($_GET['update']) && isset($_GET['name'])) {
	$name= $_GET['name'];
	$genre = new Genre();
	$genre->setName($name);
	$adminFunctions->createGenre($genre);
} else if(isset($_GET['delete'])) {
	$genre = new Genre();
	$genre->setId($_GET['id']);
	$adminFunctions->deleteGenres($genre);
} else if(isset($_GET['edit'])) {
	$id = $_GET['id'];
	$name= $_GET['name'];
}
$genres = $userFunctions->getGenres();
?>
			<td style="background-color: #eeeeee; width: 30%; text-align: top; height: 800px; vertical-align: top;" colspan=2>
				<div class="header">
					<?php if(isset($id)) { ?>
					<h3>Edit Genre<?php echo " " . $name; ?></h3>
					<?php } else { ?>
					<h3>Create Genre</h3>
					<?php } ?>
					<form method="GET" action="editgenres.php" class="form" id="commentForm" >
						<table>
							<tr>
								<td>
									Name :
								</td>
								<td>
									<input type="text" name="name" value="<?php echo $name; ?>" class="required" />
									<input type="hidden" name="id" value="<?php echo $id; ?>">
								</td>
							</tr>
							<tr>
								<td />
								<td>
									<input class="button_small_round_deep_red" name="update" type="submit" value="Save"> 
								</td>
							</tr>
						</table>
					</form>
				</div>
				<div class="widget">
					<div class="header">
						<h3>Genres</h3>
					</div>
					<table>
						<?php foreach ($genres as $genre) {	?>			
						<tr>
							<td>
								<form method="GET" action="editgenres.php" class="form">
								<INPUT type="hidden" name="id" VALUE="<?php echo $genre->getId(); ?>" />
								<?php echo $genre->getName(); ?>
								<INPUT  type='hidden' name='name' VALUE='<?php echo $genre->getName(); ?>'/>
							</td>
							<td>
								<input class="button_small_round_deep_red" name="edit" type="submit" value="Edit" />
							</td>
							<td>
								<input class="button_small_round_deep_red" name="delete" type="submit" value="Delete" />
								</form>
							</td>
						</tr>
						<?php }	?>	
					</table>
				</div>
			</td>
<?php include_once 'includes/footer.php';?>