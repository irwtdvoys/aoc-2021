<?php
	const ROOT = __DIR__ . "/../";

	require_once(ROOT . "bin/init.php");

	use App\DumboOctopus as Day;

	$filename = pathinfo(__FILE__,  PATHINFO_FILENAME);

	(new Day(
		(int)$filename,
		#ROOT . "data/" . $filename . "/example"
	))
		->run()
		->output()
	;

	// Part 1: 1694
	// Part 2: 346
?>
