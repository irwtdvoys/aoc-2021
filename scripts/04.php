<?php
	const ROOT = __DIR__ . "/../";

	require_once(ROOT . "bin/init.php");

	use App\Bingo;

	$helper = new Bingo(4);//, ROOT . "data/04/example");
	$helper->run()->output();

	// Part 1: 25410
	// Part 2: 2730
?>
