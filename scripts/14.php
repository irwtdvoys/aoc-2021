<?php
	const ROOT = __DIR__ . "/../";

	require_once(ROOT . "bin/init.php");

	use App\Polymerization as Day;

	$filename = pathinfo(__FILE__,  PATHINFO_FILENAME);

	(new Day(
		(int)$filename,
		#ROOT . "data/" . $filename . "/example"
	))
		->run()
		->output()
	;

	// Part 1: 2657
	// Part 2: 2911561572630
?>
