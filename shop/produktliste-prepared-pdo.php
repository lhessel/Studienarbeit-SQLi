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
				// Verbindung zur Datenbank / PDO Objekt
				$pdo = new PDO("mysql:host=localhost;dbname=shop;", "root", "");

				if (!empty($_GET['kategorie'])) {
					$kategorie = $_GET['kategorie'];
					
					// Prepared Statement vorbereiten
					$stmt = $pdo->prepare('SELECT p.* FROM produkt p, kategorie k WHERE k.name  = :kategorie AND k.id = p.kategorie');
					
					// Statement mit gegebenen Parametern ausfuehren
					$stmt->execute(array(':kategorie' => $kategorie));
					
					// Ergebnisse der Abfrage erhalten
					$produkte = $stmt->fetchAll();
					
					// Ausgabe
					foreach($produkte as $produkt) {
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
    </body>
</html>
