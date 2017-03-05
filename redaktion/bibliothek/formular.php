<?php 
	
	include("../../ressources/framework/login.inc.php");
	
	require "../../ressources/framework/controler.inc.php";
	require "../../ressources/bibliothek.inc.php";	
	require "../../ressources/components/tags.php";
	
	$controler = new FormularControler(BibliothekModel::getInstance());	
		
	$controler->doGet($_GET);	
		
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Bibliotheken der Regio Bodensee: Bearbeitung von Bibliotheksportraits</title>
	</head>
	<body>
		<div class="container">
			<h1>Eingabe von Bibliotheken</h1>			
			<form action="liste.php" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php echo $controler->record['id'] ?>" >
				<input type="hidden" name="modified" value="<?php echo $controler->record['modified'] ?>" >
				<input type="hidden" name="modifier" value="<?php echo $controler->record['modifier'] ?>" >
				<table>
					<tr>
						<td>
						<p>Id: <?php echo $controler->record['id'] ?></p>
						<p>Letzte Änderung: <?php echo $controler->record['modified'] ?></p>
						<p>Bearbeiter: <?php echo $controler->record['modifier'] ?></p>
						<p><?php $controler->input('land')?></p>
						<p><?php $controler->input('ort', 'width: 280px;')?></p>
						<p><?php $controler->input('name', 'width: 280px;')?></p>						
						<p><?php $controler->input('anschrift')?></p>
						<p><?php $controler->input('oeffnung')?></p>
						<p><?php $controler->input('logo', 'width: 280px;')?></p>
						<p><?php $controler->input('lage', 'width: 280px;')?></p>
						</td>
						<td>
							<p><?php $controler->input('portrait', 'height:800px')?></p>
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
