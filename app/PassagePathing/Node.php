<?php

	namespace App\PassagePathing;

	class Node
	{
		public string $id;
		public bool $isSmall;
		/** @var Node[] */
		public array $connections = [];

		public function __construct($id)
		{
			$this->id = $id;
			$this->isSmall = $id === strtolower($id);
		}

		public function add(Node $connection): self
		{
			$this->connections[] = $connection;

			return $this;
		}
	}
?>
