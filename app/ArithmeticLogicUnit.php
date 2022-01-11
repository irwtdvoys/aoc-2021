<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use AoC\Utils\Position4d;
	use Exception;

	class ArithmeticLogicUnit extends Helper
	{
		public Position4d $processor;
		public array $instructions;
		public array $inputs;
		public int $pointer = 0;

		public function __construct(int $day, bool $verbose = false, string $override = null)
		{
			parent::__construct($day, $verbose);

			$this->processor = new Position4d();

			$raw = parent::load($override);

			$this->instructions = array_map(
				function ($element)
				{
					$parts = explode(" ", $element);

					for ($index = 1; $index < count($parts); $index++)
					{
						if (is_numeric($parts[$index]))
						{
							$parts[$index] = (int)$parts[$index];
						}
					}

					return $parts;
				},
				explode(PHP_EOL, $raw)
			);
		}

		private function fetch(string|int $value): int
		{
			return is_int($value) ? $value : $this->processor->$value;
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			$this->inputs = str_split("11711691612189");

			foreach ($this->instructions as $instruction)
			{
				switch ($instruction[0])
				{
					case "inp":
						$this->processor->{$instruction[1]} = $this->inputs[$this->pointer];
						$this->pointer++;
						break;
					case "add":
						$this->processor->{$instruction[1]} += $this->fetch($instruction[2]);
						break;
					case "mul":
						$this->processor->{$instruction[1]} *= $this->fetch($instruction[2]);
						break;
					case "div":
						if ($this->fetch($instruction[2]) === 0)
						{
							throw new Exception("Divide by 0");
						}

						$this->processor->{$instruction[1]} = (int)($this->processor->{$instruction[1]} / $this->fetch($instruction[2]));
						break;
					case "mod":
						if ($this->processor->{$instruction[1]} < 0 || $this->fetch($instruction[2]) <= 0)
						{
							throw new Exception("MOD execute error");
						}

						$this->processor->{$instruction[1]} = $this->processor->{$instruction[1]} % $this->fetch($instruction[2]);
						break;
					case "eql":
						$this->processor->{$instruction[1]} = $this->processor->{$instruction[1]} === $this->fetch($instruction[2]) ? 1 : 0;
						break;
				}
			}

			dump((string)$this->processor);
			dump($this->processor->z === 0 ? "VALID": "INVALID");

			return $result;
		}
	}
?>
