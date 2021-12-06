<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use AoC\Utils\Position2d;
	use App\School\LanternFish;
	use App\Vents\Line;

	class School extends Helper
	{
		/** @var LanternFish[] */
		public array $fish = [];

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$raw = parent::load($override);

			$values = explode(",", $raw);

			$this->fish = array_map(
				function ($element)
				{
					return new LanternFish((int)$element);
				},
				$values
			);
		}

		private function draw(): void
		{
			$values = [];

			foreach ($this->fish as $fish)
			{
				$values[] = $fish->timer;
			}

			echo(implode(",", $values) . PHP_EOL);
		}

		public function run(): Result
		{
			$result = new Result();

			for ($loop = 0; $loop < 80; $loop++)
			{
				$new = [];

				foreach ($this->fish as $fish)
				{
					$return = $fish->tick();

					if (isset($return))
					{
						$new[] = $return;
					}
				}

				$this->fish = array_merge($this->fish, $new);
			}

			$result->part1 = count($this->fish);

			return $result;
		}
	}
?>
