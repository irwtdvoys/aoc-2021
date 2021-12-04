<?php
	namespace App\Bingo;

	use AoC\Utils\Position2d;

	class Board
	{
		/** @var Position2d[] */
		public array $numbers = [];
		/** @var bool[][]  */
		public array $marks = [[]];

		public ?int $last = null;
		public bool $won = false;

		public function __construct($data)
		{
			$size = 5;

			$row = array_fill(0, $size, false);
			$this->marks = array_fill(0, $size, $row);

			$rows = explode(PHP_EOL, $data);

			$y = 0;

			foreach ($rows as $row)
			{
				$values = array_map(
					"intval",
					array_values(
						array_filter(
							explode(" ", $row),
							function ($element)
							{
								return $element !== "";
							}
						)
					)
				);

				foreach ($values as $x => $value)
				{
					$this->numbers[$value] = new Position2d($x, $y);
				}

				$y++;
			}
		}

		public function exists(int $number): bool
		{
			$numbers = array_keys($this->numbers);

			return in_array($number, $numbers);
		}

		public function mark(int $number): void
		{
			if (!$this->exists($number))
			{
				return;
			}

			$this->last = $number;
			$position = $this->numbers[$number];

			$this->marks[$position->y][$position->x] = true;
		}

		public function check(int $number): bool
		{
			$position = $this->numbers[$number];

			return $this->marks[$position->y][$position->x];
		}

		public function score(): int
		{
			$total = 0;

			foreach ($this->numbers as $value => $position)
			{
				if ($this->marks[$position->y][$position->x] === false)
				{
					$total += $value;
				}
			}

			return $total * $this->last;
		}

		public function isWon(): bool
		{
			$result = false;

			// check rows
			foreach ($this->marks as $row)
			{
				if (array_sum($row) === 5)
				{
					$this->won = true;
					return true;
				}
			}

			// check columns
			for ($x = 0; $x < 5; $x++)
			{
				$count = 0;

				for ($y = 0; $y < 5; $y++)
				{
					if ($this->marks[$y][$x] === true)
					{
						$count++;
					}
				}

				if ($count === 5)
				{
					$this->won = true;
					return true;
				}
			}

			return $result;
		}
	}
?>
