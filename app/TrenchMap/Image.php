<?php

	namespace App\TrenchMap;

	use AoC\Utils\Position2d;
	use App\TrickShot\Target;

	class Image
	{
		public array $data = [[]];
		public Target $range;
		public int $iterations = 0;
		public bool $isSimple;

		public function __construct(string $data, bool $isSimple = true)
		{
			$rows = explode(PHP_EOL, $data);

			$this->range = new Target();

			for ($y = 0; $y < count($rows); $y++)
			{
				$elements = str_split($rows[$y]);

				for ($x = 0; $x < count($elements); $x++)
				{
					$this->data[$x][$y] = $elements[$x];
					$this->range->x->add($x);
					$this->range->y->add($y);
				}
			}

			$this->isSimple = $isSimple;
		}

		public function __clone()
		{
			$this->range = clone $this->range;
		}

		public function calculate(Position2d $position): int
		{
			$binary = "";
			$fill = Tile::DARK;

			if (!$this->isSimple)
			{
				$fill = ($this->iterations % 2 === 0) ? Tile::DARK : Tile::LIGHT;
			}

			for ($y = -1; $y <= 1; $y++)
			{
				for ($x = -1; $x <= 1; $x++)
				{
					$targetX = $position->x + $x;
					$targetY = $position->y + $y;

					$value = $this->data[$targetX][$targetY] ?? $fill;
					$binary .= $value === Tile::LIGHT ? "1" : "0";
				}
			}

			return bindec($binary);
		}

		public function set(Position2d $position, string $value): void
		{
			$this->data[$position->x][$position->y] = $value;
			$this->range->x->add($position->x);
			$this->range->y->add($position->y);
		}

		public function draw(): void
		{
			$margin = $this->iterations;

			for ($y = $this->range->y->min + $margin; $y <= $this->range->y->max - $margin; $y++)
			{
				for ($x = $this->range->x->min + $margin; $x <= $this->range->x->max - $margin; $x++)
				{
					echo($this->data[$x][$y]);
				}

				echo(PHP_EOL);
			}

			echo(PHP_EOL);
		}

		public function lit(): int
		{
			$count = 0;
			$margin = $this->iterations - 1;

			for ($x = $this->range->x->min + $margin; $x < $this->range->x->max - $margin; $x++)
			{
				for ($y = $this->range->y->min + $margin; $y < $this->range->y->max - $margin; $y++)
				{
					if ($this->data[$x][$y] === Tile::LIGHT)
					{
						$count++;
					}
				}
			}

			return $count;
		}
	}
?>
