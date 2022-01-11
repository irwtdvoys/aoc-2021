<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\Segments\Display;

	class Segments extends Helper
	{
		/** @var Display[] */
		public array $entries = [];

		public function __construct(int $day, bool $verbose = false, string $override = null)
		{
			parent::__construct($day, $verbose);

			$raw = parent::load($override);
			$rows = explode(PHP_EOL, $raw);

			foreach ($rows as $row)
			{
				$this->entries[] = new Display($row);
			}
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			foreach ($this->entries as $entry)
			{
				foreach ($entry->outputs as $output)
				{
					if (in_array(count($output), [2, 4, 3, 7]))
					{
						$result->part1++;
					}
				}

				$result->part2 += $entry->output();
			}

			return $result;
		}
	}
?>
