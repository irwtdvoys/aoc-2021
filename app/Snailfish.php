<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\Snailfish\Number;

	class Snailfish extends Helper
	{
		private array $numbers;

		public array $examples = [
			"[1,2]",
			"[[1,2],3]",
			"[9,[8,7]]",
			"[[1,9],[8,5]]",
			"[[[[1,2],[3,4]],[[5,6],[7,8]]],9]",
			"[[[9,[3,8]],[[0,9],6]],[[[3,7],[4,9]],3]]",
			"[[[[1,3],[5,3]],[[1,3],[8,7]]],[[[4,9],[6,9]],[[8,2],[7,3]]]]",
			"[[[[[9,8],1],2],3],4]",
		];

		public function __construct(int $day, bool $verbose = false)
		{
			parent::__construct($day, $verbose);

			$this->numbers = $this->parseInput();
		}

		public function parseInput()
		{
			return array_map(
				function($element)
				{
					$json = json_decode($element);
					return new Number(...$json);
				},
				explode(PHP_EOL, parent::load())
			);
		}

		public function reduce(Number $number)
		{
			$number->explode();

			$cache = "";

			while ($cache !== (string)$number)
			{
				$cache = (string)$number;

				$number->split();
				$number->explode();
			}

			return $number;
		}

		public function run(): Result
		{
			$result = new Result();

			$current = null;

			for ($index = 1; $index < count($this->numbers); $index++)
			{
				$number = new Number($current ?? $this->numbers[0], $this->numbers[$index]);
				$current = $this->reduce($number);
			}

			$result->part1 = $current->magnitude();

			$numbers = $this->parseInput();
			$results = [];

			foreach ($numbers as $number)
			{
				$original = (string)$number;

				$results = array_merge(
					$results,
					array_map(
						function ($element) use ($original)
						{
							$current = new Number(...json_decode($original));
							$calc = new Number($current, $element);
							$calc = $this->reduce($calc);
							return $calc->magnitude();
						},
						array_filter(
							$this->parseInput(),
							function ($element) use ($number)
							{
								return (string)$element !== (string)$number;
							}
						)
					)
				);
			}

			$result->part2 = max($results);

			return $result;
		}
	}
?>
