<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use AoC\Utils\CircularLinkedList;
	use App\DiracDice\Dice;
	use App\DiracDice\Player;

	class DiracDice extends Helper
	{
		public CircularLinkedList $board;

		public Player $player1;
		public Player $player2;
		public Player $currentPlayer;
		public Dice $dice;

		public array $data;

		const DICE_FREQUENCIES = [
			3 => 1,
			4 => 3,
			5 => 6,
			6 => 7,
			7 => 6,
			8 => 3,
			9 => 1,
		];

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$this->dice = new Dice();
			$this->board = new CircularLinkedList();

			for ($index = 1; $index <= 10; $index++)
			{
				$this->board->push($index);
			}

			$this->board->reset();

			$this->player1 = new Player($this->board->first, 0);
			$this->player2 = new Player($this->board->first, 0);

			$raw = parent::load($override);

			preg_match_all("/Player (?'player'[0-9]) starting position: (?'position'[0-9])/", $raw, $matches);

			for ($index = 0; $index < count($matches[0]); $index++)
			{
				$player = "player" . $matches['player'][$index];
				$this->$player->move((int)$matches['position'][$index] - 1); // players are already on 1
			}

			$this->data = [
				$this->player1->position->data - 1,
				$this->player2->position->data - 1
			];

			$this->currentPlayer = $this->player1;
		}

		public function turn()
		{
			$count = 0;

			while ($count < 3)
			{
				$roll = $this->dice->roll();
				$this->currentPlayer->move($roll);
				$count++;
			}

			$this->currentPlayer->updateScore();

			$this->currentPlayer = ($this->currentPlayer === $this->player1) ? $this->player2 : $this->player1;
		}

		public function quantum(int $p1Space, int $p2Space, int $p1Score, int $p2Score, array &$outcomes = []): array
		{
			$key = implode("-", [$p1Space, $p2Space, $p1Score, $p2Score]);

			if (isset($outcomes[$key]))
			{
				return $outcomes[$key];
			}

			if ($p1Score >= 21)
			{
				return [1, 0];
			}
			elseif ($p2Score >= 21)
			{
				return [0, 1];
			}

			$result = [0, 0];

			foreach (array_keys(self::DICE_FREQUENCIES) as $diceRoll)
			{
				$space = ($p1Space + $diceRoll) % 10;
				$score = $p1Score + $space + 1;

				// Repeat this but for player 2
				$p2Result = $this->quantum($p2Space, $space, $p2Score, $score, $outcomes);

				// Take our result from Player 2 and add to our current result. Multiply by the number of ways we could have rolled this number.
				$result[0] += $p2Result[1] * self::DICE_FREQUENCIES[$diceRoll];
				$result[1] += $p2Result[0] * self::DICE_FREQUENCIES[$diceRoll];
			}

			// Store outcome for these inputs
			$outcomes[$key] = $result;

			return $result;
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			while ($this->player1->score < 1000 && $this->player2->score < 1000)
			{
				$this->turn();
			}

			$result->part1 = $this->currentPlayer->score * $this->dice->total();

			$results = $this->quantum($this->data[0], $this->data[1], 0, 0);
			$result->part2 = max($results);

			return $result;
		}
	}
?>
