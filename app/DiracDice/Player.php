<?php

	namespace App\DiracDice;

	use AoC\Utils\LinkedList\Node;

	class Player
	{
		public ?Node $position;
		public int $score;

		public function __construct(Node $position, int $score)
		{
			$this->position = $position;
			$this->score = $score;
		}

		public function move(int $count)
		{
			for ($loop = 0; $loop < $count; $loop++)
			{
				$this->position = $this->position->next;
			}
		}

		public function updateScore()
		{
			$this->score += $this->position->data;
		}
	}
?>
