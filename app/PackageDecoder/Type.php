<?php

	namespace App\PackageDecoder;

	use Bolt\Enum;

	class Type extends Enum
	{
		const SUM = 0;
		const PRODUCT = 1;
		const MINIMUM = 2;
		const MAXIMUM = 3;
		const LITERAL = 4;
		const GREATER = 5;
		const LESS = 6;
		const EQUAL = 7;
	}
?>
