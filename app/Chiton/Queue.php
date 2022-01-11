<?php
	namespace App\Chiton;

	use SplPriorityQueue;

	class Queue extends SplPriorityQueue
	{
		public function __construct()
		{
			$this->setExtractFlags(SplPriorityQueue::EXTR_BOTH);
		}

		public function compare($priority1, $priority2): int
		{
			if ($priority1 === $priority2)
			{
				return 0;
			}

			return $priority1 > $priority2 ? -1 : 1;
		}
	}
?>
