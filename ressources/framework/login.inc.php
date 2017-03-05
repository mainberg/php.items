<?php

	$config = (object) array(
		'accounts' => array(
			'christof' => 'hiho',
			'weigel' => 'dlarah',
			'norrmann' => 'akinom'
		)
	);
	
	if (!isset($_SERVER['PHP_AUTH_USER'])) {
		header('WWW-Authenticate: Basic realm="My Realm"');
		header('HTTP/1.0 401 Unauthorized');
		echo 'Der Login-Dialog wurde abgebrochen';
		exit;
	} else {
		if ($config->accounts[$_SERVER['PHP_AUTH_USER']] != $_SERVER['PHP_AUTH_PW']) {
			echo "Konto nicht bekannt oder Passwort nicht korrekt";
			exit;
		} 
	}

?>