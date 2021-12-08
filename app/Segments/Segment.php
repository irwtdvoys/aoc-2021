<?php
	namespace App\Segments;

	class Segment
	{
		public array $patterns = [];
		public array $outputs = [];
		public array $numbers = [];

		public function __construct(string $input)
		{
			list($patterns, $outputs) = explode(" | ", $input);

			$this->patterns = $this->split($patterns);
			$this->outputs = $this->split($outputs);

			$this->decode();
		}

		private function split(string $string)
		{
			return array_map(
				function ($element)
				{
					$split = str_split($element);
					sort($split);

					return $split;

				},
				explode(" ", $string)
			);
		}

		private function select(int $size): int|array
		{
			return array_values(
				array_filter(
					$this->patterns,
					function ($element) use ($size)
					{
						return count($element) === $size;
					}
				)
			);
		}

		public function find($value): int
		{
			return array_search($value, $this->numbers);
		}

		public function output(): int
		{
			$total = "";

			foreach ($this->outputs as $output)
			{
				$total .= $this->find($output);
			}

			return $total;
		}

		public function decode(): void
		{
			$this->numbers = array_fill(0, 10, 0);

			$this->numbers[1] = $this->select(2)[0];
			$this->numbers[4] = $this->select(4)[0];
			$this->numbers[7] = $this->select(3)[0];
			$this->numbers[8] = $this->select(7)[0];

			$sixes = $this->select(6);

			foreach ($sixes as $next)
			{
				if (count(array_intersect($next, $this->numbers[1])) === 1)
				{
					$this->numbers[6] = $next;
				}
				elseif (count(array_intersect($next, $this->numbers[4])) === 4)
				{
					$this->numbers[9] = $next;
				}
				else
				{
					$this->numbers[0] = $next;
				}
			}

			$fives = $this->select(5);

			foreach ($fives as $next)
			{
				if (count(array_intersect($next, $this->numbers[1])) === 2)
				{
					$this->numbers[3] = $next;
				}
				elseif (count(array_intersect($next, $this->numbers[4])) === 2)
				{
					$this->numbers[2] = $next;
				}
				else
				{
					$this->numbers[5] = $next;
				}
			}
		}
	}
?>
