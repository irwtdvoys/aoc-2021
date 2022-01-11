<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use AoC\Utils\Colours;
	use AoC\Utils\Position2d;
	use AoC\Utils\Range;
	use App\TransparentOrigami\Fold;

	class TransparentOrigami extends Helper
	{
		/** @var Position2d[] */
		public array $paper = [];
		/** @var Fold[] */
		public array $folds = [];
		public Position2d $dimensions;

		public function __construct(int $day, bool $verbose = false, string $override = null)
		{
			parent::__construct($day, $verbose);

			$raw = parent::load($override);

			$xRange = new Range();
			$yRange = new Range();

			$this->dimensions = new Position2d();

			list($points, $folds) = explode(str_repeat(PHP_EOL, 2), $raw);

			$points = explode(PHP_EOL, $points);
			$folds = explode(PHP_EOL, $folds);

			foreach ($points as $point)
			{
				list($x, $y) = explode(",", $point);
				$tmp = new Position2d($x, $y);

				$this->paper[(string)$tmp] = $tmp;
				$xRange->add($x);
				$yRange->add($y);
			}

			$this->dimensions = new Position2d($xRange->max, $yRange->max);

			foreach ($folds as $fold)
			{
				list($type, $value) = explode("=", str_replace("fold along ", "", $fold));
				$this->folds[] = new Fold($type, $value);
			}
		}

		public function draw()
		{
			for ($y = 0; $y <= $this->dimensions->y; $y++)
			{
				for ($x = 0; $x <= $this->dimensions->x; $x++)
				{
					$position = new Position2d($x, $y);

					echo(isset($this->paper[(string)$position]) ? Colours::colour("█", Colours::BLUE) : " ");
				}

				echo(PHP_EOL);
			}

			echo(str_repeat(PHP_EOL, 2));
		}

		public function fold(Fold $fold)
		{
			$paper = [];

			foreach ($this->paper as $next)
			{
				if ($next->{$fold->type} > $fold->value)
				{
					$next->{$fold->type} = $fold->value - ($next->{$fold->type} - $fold->value);
				}

				$paper[(string)$next] = $next;
			}

			$this->paper = $paper;
			$this->dimensions->{$fold->type} = ($this->dimensions->{$fold->type} - 1) / 2;
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			foreach ($this->folds as $fold)
			{
				$this->fold($fold);

				if ($result->part1 === 0)
				{
					$result->part1 = count($this->paper);
				}
			}

			$this->draw();

			return $result;
		}
	}
?>