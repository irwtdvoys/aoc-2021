<?php

	namespace App\Snailfish;

	class Number
	{
		public array $data;
		public ?Number $parent;

		public function __construct($left, $right, Number $parent = null)
		{
			$this->parent = $parent;

			if ($left instanceof Number)
			{
				$left->parent = $this;
			}

			if ($right instanceof Number)
			{
				$right->parent = $this;
			}

			$this->data = [
				is_array($left) ? new Number($left[0], $left[1], $this) : ($left instanceof Number ? $left : (int)$left),
				is_array($right) ? new Number($right[0], $right[1], $this) : ($right instanceof Number ? $right : (int)$right),
			];
		}

		public function __toString(): string
		{
			return "[" . implode(",", $this->data) . "]";
		}

		public function magnitude(): int
		{
			$left = $this->data[Side::LEFT] instanceof Number ? $this->data[Side::LEFT]->magnitude() : $this->data[Side::LEFT];
			$right = $this->data[Side::RIGHT] instanceof Number ? $this->data[Side::RIGHT]->magnitude() : $this->data[Side::RIGHT];

			return (3 * $left) + (2 * $right);
		}

		public function split(int $depth = 1)
		{
			foreach (Side::expose() as $side)
			{
				if ($this->data[$side] instanceof Number)
				{
					$result = $this->data[$side]->split($depth + 1);

					if ($result === true)
					{
						return true;
					}
				}
				elseif (is_int($this->data[$side]) && $this->data[$side] >= 10)
				{
					$value = $this->data[$side] / 2;
					$this->data[$side] = new Number(floor($value), ceil($value), $this);

					return true;
				}
			}

			return false;
		}

		public function add(int $side, int $value, Number $current): void
		{
			$other = $side === Side::LEFT ? Side::RIGHT : Side::LEFT;

			while (true)
			{
				if (
					!isset($current->parent) ||
					is_int($current->parent->data[$side]) ||
					spl_object_id($current->parent->data[$side]) !== spl_object_id($current)
				)
				{
					break;
				}

				$current = $current->parent;
			}

			$current = $current->parent;

			if (!isset($current))
			{
				return;
			}
			elseif (is_int($current->data[$side]))
			{
				$current->data[$side] += $value;
			}
			elseif ($current->data[$side] instanceof Number)
			{
				$current = $current->data[$side];

				while (!is_int($current->data[$other]))
				{
					$current = $current->data[$other];
				}

				$current->data[$other] += $value;
			}
		}

		public function explode(int $depth = 0): ?array
		{
			if ($depth >= 4)
			{
				return $this->data;
			}

			foreach (Side::expose() as $side)
			{
				if ($this->data[$side] instanceof Number)
				{
					$result = $this->data[$side]->explode($depth + 1);

					if ($result)
					{
						$this->add(Side::LEFT, $result[0], $this->data[$side]);
						$this->add(Side::RIGHT, $result[1], $this->data[$side]);

						$this->data[$side] = 0;
					}
				}
			}

			return null;
		}
	}
?>
