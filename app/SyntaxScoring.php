<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use SplStack;
	use stdClass;

	class SyntaxScoring extends Helper
	{
		public array $lines = [];

		const TYPE_CURLY = "curly";
		const TYPE_SQUARE = "square";
		const TYPE_ROUND = "round";
		const TYPE_ANGLE= "angle";

		const TYPE_SYNTAX = 0;
		const TYPE_AUTOCOMPLETE = 1;

		public array $brackets = [
			self::TYPE_CURLY => ["{", "}"],
			self::TYPE_SQUARE => ["[", "]"],
			self::TYPE_ROUND => ["(", ")"],
			self::TYPE_ANGLE => ["<", ">"]
		];

		public array $open = ["{", "[", "(", "<"];
		public array $closed = ["}", "]", ")", ">"];

		public array $scores = [
			self::TYPE_SYNTAX => [
				self::TYPE_CURLY => 1197,
				self::TYPE_SQUARE => 57,
				self::TYPE_ROUND => 3,
				self::TYPE_ANGLE => 25137
			],
			self::TYPE_AUTOCOMPLETE => [
				self::TYPE_CURLY => 3,
				self::TYPE_SQUARE => 2,
				self::TYPE_ROUND => 1,
				self::TYPE_ANGLE => 4
			]
		];

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$this->lines = explode(PHP_EOL, parent::load($override));
		}

		public function getBracketType(string $character): string
		{
			foreach ($this->brackets as $type => $values)
			{
				if (in_array($character, $values))
				{
					return $type;
				}
			}

			return false;
		}

		public function process(string $line, $processType): int
		{
			$stack = new SplStack();

			$characters = str_split($line);

			foreach ($characters as $character)
			{
				$type = $this->getBracketType($character);

				if (in_array($character, $this->open))
				{
					$stack->push($type);
				}
				else
				{
					$pop = $stack->pop();

					if ($type !== $pop)
					{
						if ($processType === self::TYPE_SYNTAX)
						{
							return $this->scores[$processType][$type];
						}

						return 0;
					}
				}
			}

			if ($processType === self::TYPE_AUTOCOMPLETE)
			{
				$total = 0;

				while (!$stack->isEmpty())
				{
					$total = ($total * 5) + $this->scores[$processType][$stack->pop()];
				}

				return $total;
			}

			return 0;
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			$scores = [];

			foreach ($this->lines as $line)
			{
				$result->part1 += $this->process($line, self::TYPE_SYNTAX);
				$score = $this->process($line, self::TYPE_AUTOCOMPLETE);

				if ($score > 0)
				{
					$scores[] = $score;
				}
			}

			sort($scores);

			$result->part2 = $scores[floor(count($scores) / 2)];

			return $result;
		}
	}
?>