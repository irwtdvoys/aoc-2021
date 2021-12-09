<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use AoC\Utils\Colours;
	use AoC\Utils\Position2d;

	class SmokeBasin extends Helper
	{
		/** @var int[] */
		public array $heightMap = [];
		/** @var Position2d[] */
		public array $lowPoints = [];

		/** @var int[] */
		public array $groups = [];

		public Position2d $dimensions;

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$raw = parent::load($override);
			$rows = explode(PHP_EOL, $raw);

			for ($y = 0; $y < count($rows); $y++)
			{
				$values = str_split($rows[$y]);

				for ($x = 0; $x < count($values); $x++)
				{
					$this->heightMap[$x . ", " . $y] = (int)$values[$x];
				}
			}

			$this->dimensions = new Position2d(count($values), count($rows));
		}

		private function adjacent(Position2d $position): array
		{
			$results = [];

			for ($x = $position->x - 1; $x <= $position->x + 1; $x++)
			{
				for ($y = $position->y - 1; $y <= $position->y + 1; $y++)
				{
					if (!isset($this->heightMap[$x . ", " . $y]) || ($x === $position->x && $y === $position->y))
					{
						continue;
					}

					$results[] = new Position2d($x, $y);
				}
			}

			return $results;
		}

		private function neighbours(Position2d $position): array
		{
			$candidates = [
				new Position2d($position->x - 1, $position->y),
				new Position2d($position->x + 1, $position->y),
				new Position2d($position->x, $position->y - 1),
				new Position2d($position->x, $position->y + 1)
			];

			return array_values(
				array_filter(
					array_map(
						function ($element)
						{
							return isset($this->heightMap[(string)$element]) ? $element : null;
						},
						$candidates
					)
				)
			);
		}

		public function draw(): void
		{
			$colours = [
				Colours::RED,
				Colours::GREEN,
				Colours::YELLOW,
				Colours::BLUE,
				Colours::MAGENTA,
				Colours::CYAN
			];

			for ($y = 0; $y < $this->dimensions->y; $y++)
			{
				for ($x = 0; $x < $this->dimensions->x; $x++)
				{
					$current = new Position2d($x, $y);
					$colour = Colours::WHITE;
					$type = Colours::TYPE_STANDARD;

					if (isset($this->groups[(string)$current]))
					{
						$colour = $colours[$this->groups[(string)$current] % 6];
					}

					foreach ($this->lowPoints as $point)
					{
						if ($point->x === $x && $point->y === $y)
						{
							$type = Colours::TYPE_BOLD;
						}
					}

					echo(Colours::colour($this->heightMap[(string)$current], $colour, $type) . " ");
				}

				echo(PHP_EOL);
			}

			echo(PHP_EOL);
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			for ($x = 0; $x < $this->dimensions->x; $x++)
			{
				for ($y = 0; $y < $this->dimensions->y; $y++)
				{
					$position = new Position2d($x, $y);
					$adjacent = $this->adjacent($position);

					$filtered = array_filter(
						$adjacent,
						function ($element) use ($position)
						{
							return $this->heightMap[(string)$element] > $this->heightMap[(string)$position];
						}
					);

					if (count($filtered) === count($adjacent))
					{
						$result->part1 += $this->heightMap[(string)$position] + 1;
						$this->lowPoints[] = $position;
					}
				}
			}

			$counter = 0;

			foreach ($this->lowPoints as $point)
			{
				$list = [$point];

				while (count($list) > 0)
				{
					$current = array_pop($list);

					if (isset($this->groups[(string)$current]))
					{
						continue;
					}

					$this->groups[(string)$current] = $counter;
					$neighbours = $this->neighbours($current);

					$list = array_merge(
						$list,
						array_filter(
							$neighbours,
							function ($element)
							{
								return $this->heightMap[(string)$element] !== 9;
							}
						)
					);
				}

				$counter++;
			}

			$sizes = array_count_values($this->groups);
			rsort($sizes);
			$result->part2 = array_product(array_slice($sizes,0, 3));

			$this->draw();

			return $result;
		}
	}
?>