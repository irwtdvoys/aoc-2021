<?php
	const ROOT = __DIR__ . "/../";

	require_once(ROOT . "bin/init.php");

	use App\Crabs;

	$helper = new Crabs(7);//, ROOT . "data/07/example");
	$helper->run()->output();

	// Part 1: 336040
	// Part 2: 94813675
?>
