<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="../css/normalize.css">
		<link rel="stylesheet" type="text/css" href="../css/foundation.min.css">
		<link rel="stylesheet" type="text/css" href="../css/styles.css">
		<title>Demo Shop</title>
    </head>
    <body>
	<nav class="top-bar" data-topbar role="navigation">
		<section class="top-bar-section">
			<ul class="left">
				<li><a href="produktliste.php?kategorie=Buecher">Bücher</a></li>
			</ul>
			<ul class="left">
				<li><a href="produktliste.php?kategorie=CDs">CDs</a></li>
			</ul>
			<ul class="left">
				<li><a href="produktliste.php?kategorie=DVDs">DVDs</a></li>
			</ul>
		</section>
	</nav>
	<div class="row">
		<div class="large-12 columns">
			<table>
				<tr>
					<th>Name</th>
					<th>E-Mail</th>
				</tr>
				<?php
				// Verbindung zur Datenbank
				$mysqli = mysqli_connect("localhost", "shop", "shop", "shop");
				
				// Verbindung pruefen
				if ($mysqli->connect_errno) {
					printf("Verbindung fehlgeschlagen: %s\n", $mysqli->connect_error);
					exit();
				}

				if (!empty($_GET['id'])) {
					$id = $_GET['id'];

					// Dynamic String building
					$query = "SELECT * FROM nutzer WHERE id  = " . $id;

					// SQL-Statement ausfuehren
					$result = $mysqli->query($query);
					
					if($result->num_rows != 1) {
						header('Location: 404page.php');
					}
				
					$nutzer = mysqli_fetch_assoc($result);
					echo '<tr>';
					echo '<td>' . $nutzer['vorname'] . ' ' . $nutzer['nachname'] . '</td>';
					echo '<td>' . $nutzer['email'] . '</td>';
					echo '</tr>';
					echo '</table>';
					
					if(!empty($_POST['wunsch']) && !empty($_POST['kategorie'])) {
						$insert = "INSERT INTO wunschliste (nutzer, wunsch, kategorie) VALUES (" . $_GET['id'] . ", '" . $_POST['wunsch'] . "', '" . $_POST['kategorie'] . "')";
						
						$mysqli->query($insert);
					}
					
					$wunschQuery = "SELECT * FROM wunschliste WHERE nutzer = " . $id;
					$wunschResult = $mysqli->query($wunschQuery);
					if($wunschResult->num_rows > 0) {
						echo '<h4>Wunschliste</h4>';
						echo '<table>';
							echo '<tr>';
								echo '<th>Wunsch</th>';
								echo '<th>Kategorie</th>';
							echo '</tr>';
						while($wunsch = mysqli_fetch_assoc($wunschResult)) {
							echo '<tr>';
								echo '<td>' . $wunsch['wunsch'] . '</td>';
								echo '<td>' . $wunsch['kategorie'] . '</td>';
							echo '</tr>';
						}
						echo '</table>';
					}
				}
				?>
		</div>
	</div>
	<div class="row">
		<div class="large-8 columns">
			<h4>Etwas auf ihre Wunschliste schreiben</h1>
			<form action="" method="POST">
				<label>Wunsch</label>
				<input type="text" name="wunsch">
				<label>Kategorie</label>
				<input type="text" name="kategorie">
				<input type="submit" value="Absenden" class="button">
			</form>
		</div>
	</div>
	<div class="row">
		<div class="large-12 columns debug">
			<?php 
				// erstelltes SQL-Statement ausgeben
				echo $query;
			?>
		</div>
	</div>
	<?php
		if(!empty($insert)) {
			echo '
			<div class="row">
				<div class="large-12 columns debug">';
					echo $insert;
			echo '
				</div>
			</div>';
		}
	?>
	<?php
		if(!empty($result) && !$result) {
			echo '
			<div class="row">
				<div class="large-12 columns debug">';
					echo $mysqli->error;
			echo '
				</div>
			</div>';
		}
	?>
    </body>
</html>
