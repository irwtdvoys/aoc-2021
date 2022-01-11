<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use AoC\Utils\Position2d;
	use App\Chiton\Node;
	use App\Chiton\Queue;

	class Chiton extends Helper
	{
		public array $cavern;
		public Position2d $target;

		public function __construct(int $day, bool $verbose = false, string $override = null)
		{
			parent::__construct($day, $verbose);

			$rows = explode(PHP_EOL, parent::load($override));

			$this->target = new Position2d(strlen($rows[0]) - 1, count($rows) - 1);

			for ($y = 0; $y < count($rows); $y++)
			{
				$items = str_split($rows[$y]);

				for ($x = 0; $x < count($items); $x++)
				{
					$this->cavern[$x][$y] = new Node((int)$items[$x]);
				}
			}
		}

		private function expand(): void
		{
			$expanded = [];

			foreach ($this->cavern as $column)
			{
				foreach ($column as $item)
				{
					$item->visited = false;
				}

				$tmp = [];

				for ($loop = 0; $loop < 5; $loop++)
				{
					foreach ($column as $item)
					{
						$value = $item->value + $loop;

						if ($value > 9)
						{
							$value -= 9;
						}

						$tmp[] = new Node($value);
					}
				}

				$expanded[] = $tmp;
			}

			$data = $expanded;

			for ($loop = 1; $loop < 5; $loop++)
			{
				foreach ($expanded as $column)
				{
					$tmp = [];

					foreach ($column as $item)
					{
						$value = $item->value + $loop;

						if ($value > 9)
						{
							$value -= 9;
						}

						$tmp[] = new Node($value);
					}

					$data[] = $tmp;
				}
			}

			$this->cavern = $data;
			$this->target = new Position2d(count($this->cavern) - 1, count($this->cavern[0]) - 1);
		}

		private function process(): int
		{
			$queue = new Queue();
			$queue->insert(new Position2d(0, 0), 0);

			while ($queue->valid())
			{
				$tmp = $queue->extract();
				$current = $tmp['data'];
				$risk = $tmp['priority'];

				if ($this->cavern[$current->x][$current->y]->visited)
				{
					continue;
				}

				if ($this->verbose)
				{
					echo("(" . $current . ") " . $risk . PHP_EOL);
				}

				if ($current->x === $this->target->x && $current->y === $this->target->y)
				{
					return $risk;
				}

				$this->cavern[$current->x][$current->y]->visited = true;

				$adjacent = [
					new Position2d($current->x - 1, $current->y),
					new Position2d($current->x + 1, $current->y),
					new Position2d($current->x, $current->y - 1),
					new Position2d($current->x, $current->y + 1),
				];

				$adjacent = array_filter(
					$adjacent,
					function (Position2d $element)
					{
						return isset($this->cavern[$element->x][$element->y]) && !$this->cavern[$element->x][$element->y]->visited;
					}
				);

				foreach ($adjacent as $next)
				{
					$queue->insert($next, $risk + $this->cavern[$next->x][$next->y]->value);
				}
			}

			return 0;
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			$result->part1 = $this->process();
			$this->expand();
			$result->part2 = $this->process();

			return $result;
		}
	}
?>
