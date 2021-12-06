<?php
	namespace App\School;

	class LanternFish
	{
		public int $timer;

		public function __construct(int $initialState)
		{
			$this->timer = $initialState;
		}

		public function tick(): ?LanternFish
		{
			if ($this->timer === 0)
			{
				$this->timer = 6;

				return new LanternFish(8);
			}

			$this->timer--;

			return null;
		}
	}
?>
