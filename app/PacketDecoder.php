<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\PackageDecoder\Packet;

	class PacketDecoder extends Helper
	{
		public array $examples = [
			"D2FE28",
			"38006F45291200",
			"EE00D40C823060",
			"8A004A801A8002F478",
			"620080001611562C8802118E34",
			"C0015000016115A2E0802F182340",
			"A0016C880162017C3686B18A3D4780",
			"C200B40A82",
			"04005AC33890",
			"880086C3E88112",
			"CE00C43D881120",
			"F600BC2D8F",
			"9C005AC2F8F0",
			"9C0141080250320F1802104A08",
		];

		public string $input;

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$this->input = parent::load($override);
		}

		public function run(): Result
		{
			$packet = new Packet($this->input);

			return new Result(
				$packet->versionCount(),
				$packet->value()
			);
		}
	}
?>