<?php
	const ROOT = __DIR__ . "/../";

	require_once(ROOT . "bin/init.php");

	use App\Segments;

	$helper = new Segments(8);//, ROOT . "data/08/example");
	$helper->run()->output();

	// Part 1: 412
	// Part 2: 978171
?>
