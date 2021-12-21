<?php

	namespace App\DiracDice;

	class Dice
	{
		public int $counter;

		public function total(): int
		{
			return $this->counter + 1;
		}

		public function roll(): int
		{
			if (!isset($this->counter))
			{
				$this->counter = 0;
			}
			else
			{
				$this->counter++;
			}

			return ($this->counter % 100) + 1;
		}
	}
?>
