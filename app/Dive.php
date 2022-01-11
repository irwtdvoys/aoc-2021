<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\Dive\Instruction;
	use App\Dive\Position;

	class Dive extends Helper
	{
		const DIRECTION_FORWARD = "forward";
		const DIRECTION_UP = "up";
		const DIRECTION_DOWN = "down";

		/** @var Position[] */
		public array $positions = [];
		/** @var Instruction[] */
		public array $instructions = [];

		public function __construct(int $day, bool $verbose = false, string $override = null)
		{
			parent::__construct($day, $verbose);

			$raw = parent::load($override);
			$steps = explode(PHP_EOL, $raw);

			$this->instructions = array_map(
				function ($element)
				{
					list($direction, $distance) = explode(" ", $element);
					return new Instruction($direction, $distance);
				},
				$steps
			);

			$this->positions[1] = new Position();
			$this->positions[2] = new Position();
		}

		public function run(): Result
		{
			$result = new Result();

			foreach ($this->instructions as $instruction)
			{
				switch ($instruction->direction)
				{
					case self::DIRECTION_FORWARD:
						$this->positions[1]->y += $instruction->distance;

						$this->positions[2]->y += $instruction->distance;
						$this->positions[2]->z += $this->positions[2]->aim * $instruction->distance;
						break;
					case self::DIRECTION_UP:
						$this->positions[1]->z += $instruction->distance;

						$this->positions[2]->aim -= $instruction->distance;
						break;
					case self::DIRECTION_DOWN:
						$this->positions[1]->z -= $instruction->distance;

						$this->positions[2]->aim += $instruction->distance;
						break;
				}
			}

			$result->part1 = $this->positions[1]->result();
			$result->part2 = $this->positions[2]->result();

			return $result;
		}
	}
?>