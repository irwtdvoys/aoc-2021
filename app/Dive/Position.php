<?php
	namespace App\Dive;

	use AoC\Utils\Position3d;

	class Position extends Position3d
	{
		public int $aim = 0;

		public function __construct(int $x = 0, int $y = 0, int $z = 0, int $aim = 0)
		{
			parent::__construct($x, $y, $z);

			$this->aim = $aim;
		}

		public function result()
		{
			return abs($this->y) * abs($this->z);
		}
	}
?>
