<?php
	const ROOT = __DIR__ . "/../";

	require_once(ROOT . "bin/init.php");

	use App\School;

	$helper = new School(6);//, ROOT . "data/06/example");
	$helper->run()->output();

	// Part 1: 376194
	// Part 2: 1693022481538
?>
