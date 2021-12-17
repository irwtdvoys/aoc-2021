<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use AoC\Utils\Range;
	use Bolt\Maths;

	class Target
	{
		public Range $x;
		public Range $y;

		public function __construct(Range $x = null, Range $y = null)
		{
			$this->x = $x ?? new Range();
			$this->y = $y ?? new Range();
		}
	}

	class TrickShot extends Helper
	{
		public Target $target;

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$raw = parent::load($override);

			preg_match("/x=(?'x1'[\d\-]+)..(?'x2'[\d\-]+), y=(?'y1'[\d\-]+)..(?'y2'[\d\-]+)/", $raw, $matches);

			$this->target = new Target();
			$this->target->x->add($matches["x1"]);
			$this->target->x->add($matches["x2"]);
			$this->target->y->add($matches["y1"]);
			$this->target->y->add($matches["y2"]);
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			$velocity = (-1 * $this->target->y->min) -1;
			$result->part1 = Maths::triangular($velocity);

			$count = 0;

			for ($x = 1; $x < 500; $x++)
			{
				for ($y = $this->target->y->min; $y < 100; $y++)
				{
					$current = [0, 0];
					$xx = $x;
					$yy = $y;

					while ($current[0] < $this->target->x->max && $current[1] > $this->target->y->min)
					{
						$current[0] += $xx;
						$current[1] += $yy;
						$xx = max($xx - 1, 0);
						$yy--;

						if ($current[0] >= $this->target->x->min && $current[0] <= $this->target->x->max && $current[1] >= $this->target->y->min && $current[1] <= $this->target->y->max)
						{
							$count++;
							break;
						}
					}
				}
			}

			$result->part2 = $count;

			return $result;
		}
	}
?>
