<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use AoC\Utils\Position2d;
	use App\SeaCucumber\Tiles;

	class SeaCucumber extends Helper
	{
		public array $region;

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$raw = parent::load($override);

			$this->region = array_map(
				function ($element)
				{
					return str_split($element);
				},
				explode(PHP_EOL, $raw)
			);
		}

		private function draw(): void
		{
			foreach ($this->region as $row)
			{
				echo(implode("", $row) . PHP_EOL);
			}

			echo(PHP_EOL);
		}

		private function move(string $herd): int
		{
			$count = 0;
			$region = $this->region;

			for ($y = 0; $y < count($this->region); $y++)
			{
				for ($x = 0; $x < count($this->region[$y]); $x++)
				{
					if ($this->region[$y][$x] === $herd)
					{
						switch ($herd)
						{
							case Tiles::EAST:
								$target = new Position2d(($x + 1) % count($this->region[$y]), $y);
								break;
							case Tiles::SOUTH:
								$target = new Position2d($x, ($y + 1) % count($this->region));
								break;

						}

						if ($this->region[$target->y][$target->x] === Tiles::BLANK)
						{
							$region[$y][$x] = Tiles::BLANK;
							$region[$target->y][$target->x] = $herd;
							$count++;
						}
						else
						{
							$region[$y][$x] = $herd;
						}
					}
				}
			}

			$this->region = $region;

			return $count;
		}

		private function step()
		{
			$total = 0;
			$total += $this->move(Tiles::EAST);
			$total += $this->move(Tiles::SOUTH);

			return $total;
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			$loop = 1;
			$moved = PHP_INT_MAX;

			while ($moved > 0)
			{
				$moved = $this->step();
				$loop++;
			}

			$result->part1 = $loop - 1;

			return $result;
		}
	}
?>
