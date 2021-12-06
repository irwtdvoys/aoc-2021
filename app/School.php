<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;

	class School extends Helper
	{
		/** @var int[] */
		public array $gestation = [];

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$raw = parent::load($override);
			$values = explode(",", $raw);

			$this->gestation = array_fill(0, 9, 0);

			foreach ($values as $value)
			{
				$this->gestation[(int)$value]++;
			}
		}

		private function tick(): void
		{
			$new = $this->gestation;

			$breeders = array_shift($new);

			$new[6] += $breeders;
			$new[8] = $breeders;

			$this->gestation = $new;
		}

		public function run(): Result
		{
			$result = new Result();

			for ($loop = 1; $loop <= 256; $loop++)
			{
				$this->tick();

				if ($loop === 80)
				{
					$result->part1 = array_sum($this->gestation);
				}
			}

			$result->part2 = array_sum($this->gestation);

			return $result;
		}
	}
?>
