<?php
	const ROOT = __DIR__ . "/../";

	require_once(ROOT . "bin/init.php");

	use App\Dive;

	$helper = new Dive(2, ROOT . "data/02/example");
	$helper->run()->output();
?>
