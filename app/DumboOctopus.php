<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use AoC\Utils\Colours;
	use AoC\Utils\Position2d;

	class DumboOctopus extends Helper
	{
		public array $map = [[]];

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$raw = parent::load($override);
			$rows = explode(PHP_EOL, $raw);

			for ($y = 0; $y < count($rows); $y++)
			{
				$row = str_split($rows[$y]);

				for ($x = 0; $x < count($row); $x++)
				{
					$this->map[$x][$y] = $row[$x];
				}
			}
		}

		private function draw(array $flashed = []): void
		{
			$colours = [
				Colours::RESET,
				Colours::RESET,
				Colours::BG_RED,
				Colours::BG_MAGENTA,
				Colours::BG_CYAN,
				Colours::BG_BLUE,
				Colours::BG_GREEN,
				Colours::BG_YELLOW,
				Colours::BG_WHITE,
				Colours::BG_BLACK,
			];

			for ($y = 0; $y < count($this->map[0]); $y++)
			{
				for ($x = 0; $x < count($this->map); $x++)
				{
					$value = $this->map[$x][$y];

					$format = [
						$colours[$value] ?? Colours::BG_BLACK
					];

					if (in_array($x . ", " . $y, $flashed))
					{
						$format[] = Colours::TYPE_BOLD;
					}

					echo(Colours::format($format, $value));
				}

				echo(PHP_EOL);
			}

			echo(PHP_EOL);
		}

		private function adjacent(Position2d $position): array
		{
			$results = [];

			for ($x = $position->x - 1; $x <= $position->x + 1; $x++)
			{
				for ($y = $position->y - 1; $y <= $position->y + 1; $y++)
				{
					if (!isset($this->map[$x][$y]) || ($x === $position->x && $y === $position->y))
					{
						continue;
					}

					$results[] = new Position2d($x, $y);
				}
			}

			return $results;
		}

		private function flash(Position2d $position)
		{
			foreach ($this->adjacent($position) as $next)
			{
				$this->map[$next->x][$next->y]++;
			}
		}

		private function tick(bool $draw = false): int
		{
			$flashed = [];

			for ($x = 0; $x < count($this->map); $x++)
			{
				for ($y = 0; $y < count($this->map); $y++)
				{
					$this->map[$x][$y]++;
				}
			}

			do
			{
				$new = false;

				for ($x = 0; $x < count($this->map); $x++)
				{
					for ($y = 0; $y < count($this->map); $y++)
					{
						$point = new Position2d($x, $y);
						$key = (string)$point;

						if ($this->map[$x][$y] > 9 && !in_array($key, array_keys($flashed)))
						{
							$flashed[$key] = $point;
							$new = true;

							$this->flash($point);
						}
					}
				}
			}
			while ($new === true);

			foreach ($flashed as $position)
			{
				$this->map[$position->x][$position->y] = 0;
			}

			if ($draw)
			{
				$this->draw(array_keys($flashed));
			}

			return count($flashed);
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			$iteration = 1;

			while (true)
			{
				$count = $this->tick();

				if ($iteration <= 100)
				{
					$result->part1 += $count;
				}

				if ($count === 100)
				{
					$result->part2 = $iteration;
					break;
				}

				$iteration++;
			}

			return $result;
		}
	}
?>