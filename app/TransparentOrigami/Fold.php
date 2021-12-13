<?php
	namespace App\TransparentOrigami;

	class Fold
	{
		public string $type;
		public int $value;

		public function __construct(string $type, int $value)
		{
			$this->type = $type;
			$this->value = $value;
		}
	}
?>
