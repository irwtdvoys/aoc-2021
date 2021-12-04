<?php
	const ROOT = __DIR__ . "/../";

	require_once(ROOT . "bin/init.php");

	use App\SonarSweep;

	$helper = new SonarSweep(1);//, ROOT . "data/01/example");
	$helper->run()->output();

	// Part 1: 1316
	// Part 2: 1344
?>
