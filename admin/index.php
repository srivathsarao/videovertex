<?php
session_start(); 
?>
<?php include_once 'includes/header.php';?>
<?php
$showmessage = false;
if(isset($_POST['name']) && isset($_POST['password'])) {
	$name = $_POST['name'];
	$pass = $_POST['password'];
	if($name == 'admin' && $pass == 'admin_pass') {
		$_SESSION['admin'] = $_POST['name'];
		header("location: newvideos.php");
	} else {
		$showmessage = true;
	}
} 
?>
<td style="background-color: #eeeeee; width: 30%; text-align: top; height: 650px; vertical-align: top;" colspan=2>
	<form action="index.php" method="post">
		<table style="padding: 100px">
			<tr>
				<td>
				Name:
				</td>
				<td>
				<input type="text" name="name" />
				</td>
			</tr>
			<tr>
				<td>
				Password:
				</td>
				<td>
				<input type="password" name="password" />
				</td>
			</tr>
			<tr>
				<td />
				<td>
				<?php
					if($showmessage) {
						echo "User Name or Password incorrect";
					} 
				?>
				</td>
			</tr>
			<tr>
				<td />
				<td>
				<input class="button_small_round_deep_red" type="submit" value="Login" />
				</td>
			</tr>
		</table>
	</form>
</td>
<?php include_once 'includes/footer.php';?>