<?php
	namespace App\Chiton;

	class Node
	{
		public int $value;
		public bool $visited = false;

		public function __construct(int $value)
		{
			$this->value = $value;
		}
	}
?>
