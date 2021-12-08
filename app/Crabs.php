<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use Bolt\Maths;

	class Crabs extends Helper
	{
		public array $positions = [];

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$raw = parent::load($override);

			$crabs = array_map("intval", explode(",", $raw));
			$this->positions = array_fill(min($crabs), max($crabs) + 1, 0);

			foreach ($crabs as $crab)
			{
				$this->positions[$crab]++;
			}
		}

		public function run(): Result
		{
			$result = new Result();
			$totals = [
				1 => [],
				2 => []
			];

			foreach (array_keys($this->positions) as $position)
			{
				$totals[1][$position] = 0;
				$totals[2][$position] = 0;

				foreach ($this->positions as $key => $value)
				{
					$distance = abs($key - $position);
					$totals[1][$position] += $distance * $value;
					$totals[2][$position] += $this->triangular($distance) * $value;
				}
			}

			$result->part1 = min($totals[1]);
			$result->part2 = min($totals[2]);

			return $result;
		}

		private function triangular(int $n): int
		{
			return ($n * ($n + 1)) / 2;
		}
	}
?>
