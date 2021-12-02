<?php
	namespace App\Dive;

	class Instruction
	{
		public string $direction;
		public int $distance;

		public function __construct(string $direction, int $distance)
		{
			$this->direction = $direction;
			$this->distance = $distance;
		}
	}
?>
