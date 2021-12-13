<?php
	const ROOT = __DIR__ . "/../";

	require_once(ROOT . "bin/init.php");

	use App\SyntaxScoring as Day;

	$filename = pathinfo(__FILE__,  PATHINFO_FILENAME);

	(new Day(
		(int)$filename,
		#ROOT . "data/" . $filename . "/example"
	))
		->run()
		->output()
	;

	// Part 1: 394647
	// Part 2: 2380061249
?>
