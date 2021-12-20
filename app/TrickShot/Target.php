<?php

	namespace App\TrickShot;

	use AoC\Utils\Range;

	class Target
	{
		public Range $x;
		public Range $y;

		public function __construct(Range $x = null, Range $y = null)
		{
			$this->x = $x ?? new Range();
			$this->y = $y ?? new Range();
		}

		public function __clone()
		{
			$this->x = clone $this->x;
			$this->y = clone $this->y;
		}
	}
?>
