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
					<th>Nr.</th>
					<th>Produkt</th>
				</tr>
				<?php
				// Verbindung zur Datenbank
				$mysqli = mysqli_connect("localhost", "root", "", "shop");
				
				// Verbindung pruefen
				if ($mysqli->connect_errno) {
					printf("Verbindung fehlgeschlagen: %s\n", $mysqli->connect_error);
					exit();
				}
				
				$error = false;
				
				if (!empty($_GET['produkt']) && !inBlacklist($_GET['produkt'])) {
					$id = $_GET['produkt'];

					// Dynamic String building
					$query = "SELECT p.* FROM produkt p WHERE p.id  = " . $id;

					// SQL-Statement ausfuehren
					$result = $mysqli->query($query);
					
					$produkt = mysqli_fetch_assoc($result);
					echo '<tr>';
					echo '<td>' . $produkt['id'] . '</td>';
					echo '<td><a href="produkte?produkt=' . $produkt['id'] . '">' . $produkt['name'] . '</a></td>';
					echo '</tr>';
				} else {
					$error = true;
				}
				
				function inBlacklist($value) {	
					// Blacklist
					$blacklist = array('\'', 'or', 'substring', '@@version');
				
					// fuer jeden Wert in der Blacklist
					foreach($blacklist as $blacklistedValue) {
						// pruefe ob blacklisted value in URL-Parameter auftaucht
						if(preg_match('/' . $blacklistedValue . '/', $value) == 1) {
							// Der Wert ist in der Blacklist
							return true;
						}
					}
					return false;
				}
				?>
			</table>
		</div>
	</div>
	<?php
		if($error) {
			echo '
			<div class="row">
				<div class="large-12 columns error">';
					echo "Ein Fehler ist aufgetreten.";
			echo '
				</div>
			</div>';
		}
	?>
	<?php 
		if(!empty($query)) {
			echo '
			<div class="row">
				<div class="large-12 columns debug">';
					echo $query;
			echo '
				</div>
			</div>';
		}
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
