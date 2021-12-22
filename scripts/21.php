<?php
	const ROOT = __DIR__ . "/../";

	require_once(ROOT . "bin/init.php");

	use App\DiracDice as Day;

	$filename = pathinfo(__FILE__,  PATHINFO_FILENAME);

	(new Day(
		(int)$filename,
		#ROOT . "data/" . $filename . "/example"
	))
		->run()
		->output()
	;

	// Part 1: 920580
	// Part 2: 647920021341197
?>
