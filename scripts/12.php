<?php
	const ROOT = __DIR__ . "/../";

	require_once(ROOT . "bin/init.php");

	use App\PassagePathing as Day;

	$filename = pathinfo(__FILE__,  PATHINFO_FILENAME);

	(new Day(
		(int)$filename,
		#ROOT . "data/" . $filename . "/examples/03"
	))
		->run()
		->output()
	;

	// Part 1: 0
	// Part 2: 0
?>
