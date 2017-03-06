<?php 
	
	include("../../ressources/framework/login.inc.php");
	
	require "../../ressources/framework/controler.inc.php";
	require "../../ressources/link.inc.php";
	
	$controler = new FormularControler(LinkModel::getInstance());	
	
	$controler->doGet($_GET);
	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Bibliotheken der Regio Bodensee: Bearbeitung von Links</title>
	</head>
	<body>
		<div class="container">
			<form action="liste.php?id=<?php echo $controler->record['parent'] ?>" method="POST">
				<fieldset>
					<legend>Daten</legend>
					<input type="hidden" name="id" value="<?php echo $controler->record['id'] ?>" >
					<input type="hidden" name="modified" value="<?php echo $controler->record['modified'] ?>" >
					<input type="hidden" name="modifier" value="<?php echo $controler->record['modifier'] ?>" >
					<input type="hidden" name="parent" value="<?php echo $controler->record['parent'] ?>" >
					<input type="hidden" name="pos" value="<?php echo $controler->record['pos'] ?>" >
					<input type="hidden" name="type" value="<?php echo $controler->record['type'] ?>" >
					<div>
						<label>Titel</label><br>
						<input name="titel" type="text" value="<?php echo $controler->record['titel'] ?>" >
					</div>	
					<div>
						<label>Beschreibung:</label><br>
						<textarea name="beschreibung"><?php echo $controler->record['beschreibung'] ?></textarea>
					</div>
					<?php if($controler->record['type'] == 1){ ?>
						<div>
							<label>Url</label><br>
							<input name="url" type="text" value="<?php echo $controler->record['url'] ?>" >
						</div>
					<?php } else { ?>
						<input type="hidden" name="url" value="<?php echo $controler->record['url'] ?>" >
					<?php } ?>
					</div>   
					
				</fieldset>
				<input name="cancel" type="submit" value="Abbruch">
				<input name="save" type="submit" value="Speichern">
				<input name="delete" type="submit" value="Löschen">
			</form>			
		</div>		
	</body>
</html>