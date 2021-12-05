<?php
	namespace App\Vents;

	use AoC\Utils\Position2d;

	class Line
	{
		public Position2d $from;
		public Position2d $to;

		public function __construct(Position2d $from, Position2d $to)
		{
			$this->from = $from;
			$this->to = $to;
		}

		public function isDiagonal(): bool
		{
			return $this->from->x !== $this->to->x && $this->from->y !== $this->to->y;
		}

		public function min(string $dimension)
		{
			return min($this->from->$dimension, $this->to->$dimension);
		}

		public function max(string $dimension)
		{
			return max($this->from->$dimension, $this->to->$dimension);
		}
	}
?>
