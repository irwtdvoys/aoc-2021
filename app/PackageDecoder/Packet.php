<?php

	namespace App\PackageDecoder;

	class Packet
	{
		public string $data;
		public int $version;
		public int $type;
		public int $length;
		public int $value;

		private int $depth;

		public string $binary;

		public array $subPackets = [];

		private array $conversions = [
			"0" => "0000",
			"1" => "0001",
			"2" => "0010",
			"3" => "0011",
			"4" => "0100",
			"5" => "0101",
			"6" => "0110",
			"7" => "0111",
			"8" => "1000",
			"9" => "1001",
			"A" => "1010",
			"B" => "1011",
			"C" => "1100",
			"D" => "1101",
			"E" => "1110",
			"F" => "1111",
		];

		public function __construct(string $data, int $dataType = DataType::HEX, int $depth = 0)
		{
			$this->data = $data;
			$this->depth = $depth;

			if ($data === "")
			{
				die("ERROR");
			}

			switch ($dataType)
			{
				case DataType::HEX:
					$binary = $this->toBinary($data);
					break;
				default:
					$binary = $data;
					break;
			}

			$version = substr($binary, 0, 3);
			$type = substr($binary, 3, 3);

			$this->version = $this->toDecimal($version);
			$this->type = $this->toDecimal($type);

			$this->binary = $version . $type;

			switch ($this->type)
			{
				case Type::LITERAL:
					$remainder = substr($binary, 6);
					$groups = str_split($remainder, 5);

					$data = "";

					foreach ($groups as $group)
					{
						$data .= substr($group, 1);
						$this->binary .= $group;

						if (str_starts_with($group, "0"))
						{
							break;
						}
					}

					$this->value = $this->toDecimal($data);
					break;
				default:
					$this->length = (int)substr($binary, 6, 1);
					$this->binary .= $this->length;

					switch ($this->length)
					{
						case 0:
							$tmp = substr($binary, 7, 15);
							$this->binary .= $tmp;
							$length = $this->toDecimal($tmp);
							$subData = substr($binary, 22, $length);
							$this->binary .= $subData;

							while (strlen($subData) > 0)
							{
								$packet = new Packet($subData, DataType::BIN, $this->depth + 1);
								$this->subPackets[] = $packet;
								$subData = substr($subData, strlen($packet->binary));
							}

							break;
						case 1:
							$tmp = substr($binary, 7, 11);
							$this->binary .= $tmp;
							$number = $this->toDecimal($tmp);
							$subData = substr($binary, 18);

							for ($count = 0; $count < $number; $count++)
							{
								$packet = new Packet($subData, DataType::BIN, $this->depth + 1);
								$this->subPackets[] = $packet;
								$this->binary .= $packet->binary;
								$subData = substr($subData, strlen($packet->binary));
							}

							break;
					}
					break;
			}
		}

		public function __toString(): string
		{
			return str_repeat("\t", $this->depth, ) . "<Packet version='" . $this->version . "' type='" . $this->type . "' />";
		}

		private function toDecimal(string $bin): int
		{
			return (int)base_convert($bin, 2, 10);
		}

		private function toBinary(string $hex): string
		{
			return implode(
				"",
				array_map(
					function ($element)
					{
						return $this->conversions[$element];
					},
					str_split($hex)
				)
			);
		}

		public function versionCount(): int
		{
			$count = $this->version;

			foreach ($this->subPackets as $packet)
			{
				$count += $packet->versionCount();
			}
			return $count;
		}

		private function subValues(): array
		{
			return array_map(
				function ($element)
				{
					return $element->value();
				},
				$this->subPackets
			);
		}

		public function value(): int
		{
			$value = 0;

			switch ($this->type)
			{
				case Type::SUM:
					$value = array_sum($this->subValues());
					break;
				case Type::PRODUCT:
					$values = $this->subValues();
					$value = count($values) === 1 ? $values[0] : array_product($values);
					break;
				case Type::MINIMUM:
					$value = min($this->subValues());
					break;
				case Type::MAXIMUM:
					$value = max($this->subValues());
					break;
				case Type::LITERAL:
					$value = $this->value;
					break;
				case Type::GREATER:
					list($a, $b) = $this->subValues();
					$value = $a > $b ? 1 : 0;
					break;
				case Type::LESS:
					list($a, $b) = $this->subValues();
					$value = $a < $b ? 1 : 0;
					break;
				case Type::EQUAL:
					list($a, $b) = $this->subValues();
					$value = $a === $b ? 1 : 0;
					break;
			}

			return $value;
		}
	}
?>
