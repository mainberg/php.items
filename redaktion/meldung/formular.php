<?php 
	
	require "../includes/database.inc.php";
	require "../veranstaltung.inc.php";
	
	$itemClass = 'Veranstaltung';
	
	if (!isset($_SERVER['PHP_AUTH_USER'])) {
		header('WWW-Authenticate: Basic realm="My Realm"');
		header('HTTP/1.0 401 Unauthorized');
		echo 'Text, der gesendet wird, falls der Benutzer auf Abbrechen drückt';
		exit;
	} else {
		if ($itemClass::$accounts[$_SERVER['PHP_AUTH_USER']] != $_SERVER['PHP_AUTH_PW']) {
			echo "Konto nicht bekannt oder Passwort nicht korrekt";
			exit;
		} 
	}
	
	if (isset($_GET['id'])) {
		$item = retrieveItem($_GET['id'], $itemClass);
	} else {
		$item = $itemClass::createInstance();
	}	
	
	function input($field, $style = '') {
		global $item;
		$item->properties[$field]->renderInputWidget($style);
	}	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Bibliotheken der Regio Bodensee: Bearbeitung von Veranstaltungen</title>
	</head>
	<body>
		<div class="container">
			<h1>Eingabe von Veranstatung</h1>			
			<form action="veranstaltungen.php" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php echo $item->id ?>" >
				<table>
					<tr>
						<td>
						<p>Id: <?php echo $item->id ?></p>
						<p>Letzte Änderung: <?php echo $item->modified ?></p>
						<p>Bearbeiter: <?php echo $item->modifier ?></p>
						<p><?php input('datum')?></p>
						<p><?php input('zeit', 'width: 280px;')?></p>
						<p><?php input('ort', 'width: 280px;')?></p>						
						<p><?php input('titel')?></p>
						<p><?php input('teaser','width: 280px;')?></p>						
						<p><?php input('link', 'width: 280px;')?></p>
						</td>
						<td>
							<p><?php input('text', 'width: 280px;')?></p>
						</td>
					</tr>
				</table>
				<input name="cancel" type="submit" value="Abbruch">
				<input name="save" type="submit" value="Speichern">
				<input name="delete" type="submit" value="Löschen">
			</form>
		</div>		
	</body>
</html>
