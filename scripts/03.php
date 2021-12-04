<?php
	const ROOT = __DIR__ . "/../";

	require_once(ROOT . "bin/init.php");

	use App\BinaryDiagnostic;

	$helper = new BinaryDiagnostic(3);//, ROOT . "data/03/example");
	$helper->run()->output();

	// Part 1: 3549854
	// Part 2: 3765399
?>
