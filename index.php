<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>dico</title>
</head>
<body>
	<?php 

	$fichier = file_get_contents("dictionnaire.txt", FILE_USE_INCLUDE_PATH);
	$dico=explode("\n", $fichier);
	// var_dump($dico);
	echo "Combien de mots contient le dictionnaire?".count($dico).'<br>';
	
	$nombredemot=0;
	$nombredemotw=0;
	$nombredemotq=0;

	foreach ($dico as $key => $mot) { 
		$nbChars = strlen($mot);

		if ($nbChars === 15) {
			$nombredemot++;
		}
		$motW = strpos($mot, 'w');
		if ($motW !== false) {
			$nombredemotw++;
		}
		$motQ = strpos($mot, 'q', strlen($mot)-1);
		if ($motQ !== false) {
			$nombredemotq++;
		}
	}

	echo "Combien de mots ont exactement 15 caractères?:".$nombredemot.'<br>';
	echo "Combien de mots ont la lettre w?:".$nombredemotw.'<br>';
	echo "Combien de mots finnisent par la lettre q?:".$nombredemotq.'<br>';
	?>
	<?php 
	$string = file_get_contents("films.json", FILE_USE_INCLUDE_PATH);
	$brut = json_decode($string, true);
	$top = $brut["feed"]["entry"];
	$top100 = count($top);
	// var_dump($top)
	echo "<h3>Top 10 des films</h3>";
	for ($i=1; $i <=10 ; $i++) { 
		$titre = $top[$i]['im:name']["label"];
		echo $i . ' ' . $titre . "<br />";
	}

	echo"<h3>Classement film Gravity</h3>";
	for ($i=0; $i<100 ; $i++) { 
		$titre = $top[$i]['im:name']["label"];
		if ($titre === 'Gravity') {
			echo 'Le classement du film est: '.$i;
		}
	}
	echo "<h3>Réalisateur du film Lego the movie</h3>";
	for($i=0; $i<$top100; $i++){
		$titre = $top[$i]['im:name']["label"];
		if($titre == "The LEGO Movie"){

			echo'Les réalisateurs sont du film The LEGO sont '.$top[$i]["im:artist"]["label"];

		}
	}
	echo "<h3>Nombre de films sorties avant 2000</h3>";
	$nbFilms=0;
	for($i=0; $i<$top100; $i++){
		$date = $top[$i]['im:releaseDate']["label"];
		if(date_parse($date)['year']<2000){
			$nbFilms++;
		}
	}
	echo 'Le nombres de films sorties avant 2000 est de '.$nbFilms;

	echo "<h3>Film le plus récent</h3>";
	for($i=0; $i<$top100; $i++){
		if($i==0){

			$filmRecent=$top[$i];
		}
		else{
			$date = $top[$i]['im:releaseDate']["label"];
			$filmPeutRecent = $filmRecent['im:releaseDate']["label"];
			if($date> $filmPeutRecent){
				$filmRecent = $top[$i];
			}
		}
	}
	echo 'le film le plus récent du classement est '.$filmRecent['im:name']["label"];

	echo "<h3>Film le plus anciens</h3>";
	$filmVieux = '';
	for($i=0; $i<$top100; $i++){
		if($i ==0){
			$filmVieux=$top[$i];
		}
		else{
			$date = $top[$i]['im:releaseDate']["label"];
			$filmAncien = $filmVieux['im:releaseDate']["label"];
			if($date< $filmAncien){
				$filmVieux = $top[$i];
			}
		}
	}
	echo "Le film le plus vieux du classement est ".$filmVieux['im:name']["label"];

	echo "<h3>Categorie de film la plus représentée</h3>";
	$categorie = array();
	foreach ($top as $key => $film) {
		$catFilm = $film['category']['attributes']["label"];
		$categorie[$catFilm]++;
	}
	$represente = array('categorie' => '', 'nombre' => 0);
	foreach ($categorie as $cat => $nombre) {
		if ($nombre > $represente['nombre']) {
			$represente = array('categorie' => $cat, 'nombre' => $nombre);
		}
	}
	echo "La categorie de films la plus représentée est ".$represente['categorie'];
	echo "<h3>Réalisateur le plus présent</h3>";
	$listRea= array();
	foreach ($top as $key => $film) {
		$rea = $film["im:artist"]["label"];
		$listRea[$rea]++;
	}
	$reaFilm = array('realisateur' => '', 'nombre' => 0);
	foreach ($listRea as $rea => $nombre) {
		if($nombre > $reaFilm['nombre']){
			$reaFilm = array('realisateur' => $rea, 'nombre' => $nombre);
		}
	}
	echo "Le realisateur le plus represené est ".$reaFilm['realisateur'];

	echo "<h3> Prix du top 10 des films à l'achat et à la location</h3>";
	$achat=0;
	$location=0;
	for ($i=0; $i < 10; $i++) { 
		$prixA = $top[$i]['im:price']["attributes"]["amount"];
		$prixL = $top[$i]['im:rentalPrice']["attributes"]["amount"];
		$achat += $prixA;
		$location+=$prixL;
	}
	echo "Le prix du top 10 des films à l'achat sur iTunes est de ".$achat.' euros'.'<br>';
	echo "Le prix du top 10 des films à la location sur iTunes est de ".$location.' euros';

	echo "<h3>Mois qui a vu le plus de sorties de films</h3>";
	$famous = [];
	$famous1 = [];
	foreach ($top as $key => $film) {
		$famous[explode(' ', $film['im:releaseDate']['attributes']['label'])[0]]++;
	}arsort($famous);
	$famous1 = array_keys($famous, max($famous));
	if ($famous>1) {
		foreach ($famous1 as $key => $value) {
			echo $value. '<br>';
		}
	}else{
		echo $famous1[0];
	}
	echo "<h3>Les 10 films les moins chers</h3>";
	
	

	?>
</body>
</html>