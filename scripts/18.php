<?php
	const ROOT = __DIR__ . "/../";

	require_once(ROOT . "bin/init.php");

	use App\Snailfish as Day;

	$filename = pathinfo(__FILE__,  PATHINFO_FILENAME);

	(new Day(
		(int)$filename
	))
		->run()
		->output()
	;

	// Part 1: 3359
	// Part 2: 4616
?>
