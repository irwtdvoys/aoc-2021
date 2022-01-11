<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;

	class BinaryDiagnostic extends Helper
	{
		public array $data = [];

		public function __construct(int $day, bool $verbose = false, string $override = null)
		{
			parent::__construct($day, $verbose);

			$raw = parent::load($override);
			$this->data = explode(PHP_EOL, $raw);
		}

		private function buildFrequencies(array $data): array
		{
			$frequencies = [[]];

			foreach ($data as $datum)
			{
				$values = str_split($datum, 1);

				for ($index = 0; $index < count($values); $index++)
				{
					if (!isset($frequencies[$index][$values[$index]]))
					{
						$frequencies[$index][$values[$index]] = 0;
					}

					$frequencies[$index][$values[$index]]++;
				}
			}

			return $frequencies;
		}

		private function filterValues(array $values, string $prefix): array
		{
			return array_values(
				array_filter(
					$values,
					function ($element) use ($prefix)
					{
						return str_starts_with($element, $prefix);
					}
				)
			);
		}

		public function run(): Result
		{
			$result = new Result();

			$gamma = "";
			$epsilon = "";

			$frequencies = $this->buildFrequencies($this->data);

			foreach ($frequencies as $frequency)
			{
				$gamma .= ($frequency[0] > $frequency[1]) ? "0" : "1";
				$epsilon .= ($frequency[0] < $frequency[1]) ? "0" : "1";
			}

			$result->part1 = bindec($epsilon) * bindec($gamma);


			$o2 = "";
			$index = 0;
			$data = $this->data;

			while (count($data) > 1)
			{
				$frequencies = $this->buildFrequencies($data);
				$frequency = $frequencies[$index];

				$o2 .= ($frequency[1] >= $frequency[0]) ? "1" : "0";

				$data = $this->filterValues($data, $o2);

				$index++;
			}

			$o2 = $data[0];

			$co2 = "";
			$index = 0;
			$data = $this->data;

			while (count($data) > 1)
			{
				$frequencies = $this->buildFrequencies($data);
				$frequency = $frequencies[$index];

				$co2 .= ($frequency[0] <= $frequency[1]) ? "0" : "1";

				$data = $this->filterValues($data, $co2);

				$index++;
			}


			$co2 = $data[0];


			$result->part2 = bindec($o2) * bindec($co2);

			return $result;
		}
	}
?>