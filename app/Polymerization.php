<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;

	class Polymerization extends Helper
	{
		public array $pairs = [];
		public array $rules = [];
		public array $quantities = [];

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			list($template, $rules) = explode(str_repeat(PHP_EOL, 2), parent::load($override));
			$rules = explode(PHP_EOL, $rules);

			foreach ($rules as $rule)
			{
				list($key, $value) = explode(" -> ", $rule);
				$this->rules[$key] = $value;
			}

			for ($index = 0; $index < strlen($template) - 1; $index++)
			{
				$key = substr($template, $index, 2);
				$this->store($key);
			}

			foreach (str_split($template) as $value)
			{
				$this->tally($value);
			}
		}

		private function tally(string $key, int $quantity = 1): void
		{
			if (!isset($this->quantities[$key]))
			{
				$this->quantities[$key] = 0;
			}

			$this->quantities[$key] += $quantity;
		}

		private function store(string $key, int $value = 1): void
		{
			if (!isset($this->pairs[$key]))
			{
				$this->pairs[$key] = 0;
			}

			$this->pairs[$key] += $value;
		}

		private function iterate(): void
		{
			$old = $this->pairs;
			$this->pairs = [];

			foreach ($old as $pair => $quantity)
			{
				$insert = $this->rules[$pair];

				list($one, $two) = str_split($pair);
				$key1 = $one . $insert;
				$key2 = $insert . $two;

				$this->store($key1, $quantity);
				$this->store($key2, $quantity);
				$this->tally($insert, $quantity);
			}
		}

		private function result(): int
		{
			$quantities = $this->quantities;
			rsort($quantities);

			return current($quantities) - end($quantities);
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			$count = 1;

			while ($count <= 40)
			{
				$this->iterate();

				if ($count === 10)
				{
					$result->part1 = $this->result();
				}

				$count++;
			}

			$result->part2 = $this->result();

			// 2188189693529 low


			return $result;
		}
	}
?>