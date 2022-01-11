<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;

	class SonarSweep extends Helper
	{
		private array $data;

		public function __construct(int $day, bool $verbose = false, string $override = null)
		{
			parent::__construct($day, $verbose);

			$raw = parent::load($override);
			$rows = explode(PHP_EOL, $raw);

			$this->data = array_map("intval", $rows);
		}

		private function process(int $size): int
		{
			$count = 0;

			for ($index = 0; $index < count($this->data) - ($size - 1); $index++)
			{
				$window = array_slice($this->data, $index, $size);
				$sum = array_sum($window);

				if (isset($current) && $sum > $current)
				{
					$count++;
				}

				$current = $sum;
			}

			return $count;
		}

		public function run(): Result
		{
			$result = new Result(
				$this->process(1),
				$this->process(3)
			);

			return $result;
		}
	}
?>