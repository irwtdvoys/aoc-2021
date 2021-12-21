<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use AoC\Utils\Position2d;
	use App\TrenchMap\Image;
	use App\TrenchMap\Tile;

	class TrenchMap extends Helper
	{
		public array $algorithm;
		public Image $image;

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			list($algorithm, $image) = explode(str_repeat(PHP_EOL, 2), parent::load($override));

			$this->algorithm = str_split($algorithm);
			$isSimple = $this->algorithm[0] === Tile::DARK;
			$this->image = new Image($image, $isSimple);
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			for ($count = 1; $count <= 50; $count++)
			{
				$image = clone $this->image;

				for ($x = $image->range->x->min - 2; $x <= $image->range->x->max + 2; $x++)
				{
					for ($y = $image->range->y->min - 2; $y <= $image->range->y->max + 2; $y++)
					{
						$position = new Position2d($x, $y);
						$index = $image->calculate($position);
						$this->image->set($position, $this->algorithm[$index]);
					}
				}

				$this->image->iterations++;

				if ($count === 2)
				{
					$result->part1 = $this->image->lit();
				}
			}

			$result->part2 = $this->image->lit();

			return $result;
		}
	}
?>
