<!DOCTYPE html>
<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="../css/normalize.css">
	<link rel="stylesheet" type="text/css" href="../css/foundation.min.css">
	<link rel="stylesheet" type="text/css" href="../css/styles.css">
	<title>Demo Login Formular</title>
    </head>
    <body>
		<?php
		/*
		 * Simples Login Formular
		 */

		// Verbindung zur Datenbank
		$mysqli = mysqli_connect("localhost", "root", "", "shop");

		// Verbindung pruefen
		if ($mysqli->connect_errno) {
			printf("Connect failed: %s\n", $mysqli->connect_error);
			exit();
		}

		if (!empty($_POST['email'])) {
			$email = $_POST['email'];
			$password = $_POST['passwort'];
			
			// Dynamic String building
			$query = "SELECT * FROM nutzer WHERE email = '" . $email . "' AND passwort = '" . $password . "'";

			$result = $mysqli->query($query);
			
			echo '<div class="row">'
					. '<div class="large-8 large-offset-2 columns info">';
			if (mysqli_num_rows($result) != 0) {
				echo 'Login erfolgreich';
			} else {
				echo 'Login fehlgeschlagen';
			}
			echo '</div>'
			. '</div>';

			// erstelltes SQL-Statement ausgeben
			echo '<div class="debug-query">' . $query . '</div>';
		}

		$mysqli->close();
		?>
		<div class="row">
			<div class="large-8 large-offset-2 columns">
				<form action="" method="POST">
					<label>E-Mail</label>
					<input type="text" name="email">
					<label>Passwort</label>
					<input type="text" name="passwort">
					<input type="submit" value="Absenden" class="button">
				</form>
			</div>
		</div>
    </body>
</html>
