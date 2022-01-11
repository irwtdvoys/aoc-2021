<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use AoC\Utils\Position2d;
	use App\Vents\Line;

	class Vents extends Helper
	{
		/** @var Position2d[][] */
		public array $lines = [];

		public array $regions = [[[]]];

		public function __construct(int $day, bool $verbose = false, string $override = null)
		{
			parent::__construct($day, $verbose);

			$raw = parent::load($override);

			preg_match_all("/(?'fromX'\d+),(?'fromY'\d+) -> (?'toX'\d+),(?'toY'\d+)/", $raw, $matches);

			for ($index = 0; $index < count($matches[0]); $index++)
			{
				$from = new Position2d($matches['fromX'][$index], $matches['fromY'][$index]);
				$to = new Position2d($matches['toX'][$index], $matches['toY'][$index]);

				$this->lines[] = new Line($from, $to);
			}
		}

		private function points(array $region): int
		{
			$tmp = [];

			foreach ($region as $next)
			{
				$tmp = array_merge($tmp, $next);
			}

			$tmp = array_filter(
				$tmp,
				function ($element)
				{
					return $element >= 2;
				}
			);

			return count($tmp);
		}

		public function draw(array $region): void
		{
			for ($y = 0; $y < 10; $y++)
			{
				for ($x = 0; $x < 10; $x++)
				{
					if (!isset($region[$x][$y]))
					{
						$region[$x][$y] = "0";
					}

					echo($region[$x][$y] . " ");
				}

				echo(PHP_EOL);
			}

			echo(PHP_EOL);
		}

		public function plot(Line $line, int $region): void
		{
			$xRange = range($line->from->x, $line->to->x);
			$yRange = range($line->from->y, $line->to->y);

			$xCount = 0;

			foreach ($xRange as $x)
			{
				$yCount = 0;

				foreach ($yRange as $y)
				{
					if (!isset($this->regions[$region][$x][$y]))
					{
						$this->regions[$region][$x][$y] = 0;
					}

					if (!$line->isDiagonal() || $xCount === $yCount)
					{
						$this->regions[$region][$x][$y]++;
					}

					$yCount++;
				}

				$xCount++;
			}
		}

		public function run(): Result
		{
			$result = new Result();

			foreach ($this->lines as $line)
			{
				$diagonal = $line->isDiagonal();

				if (!$diagonal)
				{
					$this->plot($line, 1);
					$this->plot($line, 2);
				}
				else
				{
					$this->plot($line, 2);
				}
			}

			$result->part1 = $this->points($this->regions[1]);
			$result->part2 = $this->points($this->regions[2]);

			if ($this->verbose)
			{
				$this->draw($this->regions[1]);
				$this->draw($this->regions[2]);
			}

			return $result;
		}
	}
?>
