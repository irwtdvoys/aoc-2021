<?php
	ini_set('memory_limit','256M');

	const ROOT = __DIR__ . "/../";

	require_once(ROOT . "bin/init.php");

	use App\Vents;

	$helper = new Vents(5);//, ROOT . "data/05/example");
	$helper->run()->output();

	// Part 1: 7674
	// Part 2: 20898
?>
