<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\Bingo\Board;

	class Bingo extends Helper
	{
		/** @var int[] */
		public array $order = [];
		/** @var Board[] */
		public array $boards = [];

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$raw = parent::load($override);
			$sections = explode(str_repeat(PHP_EOL, 2), $raw);

			$this->order = array_map("intval", explode(",", array_shift($sections)));

			$this->boards = array_map(
				function ($element)
				{
					return new Board($element);
				},
				$sections
			);
		}

		public function run(): Result
		{
			$result = new Result();

			foreach ($this->order as $item)
			{
				$index = 1;

				foreach ($this->boards as $board)
				{
					if ($board->won === true)
					{
						$index++;
						continue;
					}

					$board->mark($item);

					if ($board->isWon())
					{
						if (!isset($result->part1))
						{
							$result->part1 = $board->score();
						}

						$result->part2 = $board->score();
					}

					$index++;
				}
			}

			return $result;
		}
	}
?>
