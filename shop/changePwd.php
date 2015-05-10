<!DOCTYPE html>
<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="../css/normalize.css">
	<link rel="stylesheet" type="text/css" href="../css/foundation.min.css">
	<title>Passwort ändern</title>
    </head>
    <body>
		<?php
		// Verbindung zur Datenbank
		$mysqli = mysqli_connect("localhost", "root", "", "shop");

		// Verbindung pruefen
		if ($mysqli->connect_errno) {
			printf("Connect failed: %s\n", $mysqli->connect_error);
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
		
			if (!empty($_POST['passwort']) && !empty($_POST['neuesPasswort'])) {
				$password = $_POST['passwort'];
				$newPassword = $_POST['neuesPasswort'];

				// Dynamic String building
				$update = "UPDATE nutzer SET passwort='" . $newPassword . "' WHERE email='" . $nutzer['email'] . "' AND passwort='" . $password . "'";

				$result = $mysqli->query($update);

				// erstelltes SQL-Statement ausgeben
				echo '<div class="debug-query">' . $update . '</div>';
			}
		}

		$mysqli->close();
		?>
		<div class="row">
			<div class="large-8 large-offset-2 columns">
				<form action="" method="POST">
					<label>Aktuelles Passwort</label>
					<input type="text" name="passwort">
					<label>Neues Passwort</label>
					<input type="text" name="neuesPasswort">
					<input type="submit" value="Absenden" class="button">
				</form>
			</div>
		</div>
    </body>
</html>
