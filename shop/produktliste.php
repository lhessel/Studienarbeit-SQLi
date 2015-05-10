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

				if (!empty($_GET['kategorie'])) {
					$kategorie = $_GET['kategorie'];

					// Dynamic String building
					$query = "SELECT p.* FROM produkt p, kategorie k WHERE k.name  = '" . $kategorie . "' AND k.id = p.kategorie";

					// SQL-Statement ausfuehren
					$result = $mysqli->query($query);					
					
					while ($produkt = mysqli_fetch_assoc($result)) {
						echo '<tr>';
						echo '<td>' . $produkt['id'] . '</td>';
						echo '<td><a href="produkte.php?produkt=' . $produkt['id'] . '">' . $produkt['name'] . '</a></td>';
						echo '</tr>';
					}
				}
				?>
			</table>
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
		if(!$result) {
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
