<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\PassagePathing\Node;

	class PassagePathing extends Helper
	{
		/** @var Node[] */
		public array $nodes;

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$rows = explode(PHP_EOL, parent::load($override));
			$labels = [];
			$connections = [];

			foreach ($rows as $row)
			{
				$parts = explode("-", $row);
				$labels = array_merge($labels, $parts);
				$connections[] = $parts;
			}

			$labels = array_unique($labels);

			foreach ($labels as $label)
			{
				$this->nodes[$label] = new Node($label);
			}

			foreach ($connections as list($a, $b))
			{
				$this->nodes[$a]->add($this->nodes[$b]);
				$this->nodes[$b]->add($this->nodes[$a]);
			}
		}

		public function isRevisited($path): bool
		{
			$counts = array_count_values($path);

			foreach ($counts as $key => $count)
			{
				if ($key === strtolower($key) && $count > 1)
				{
					return true;
				}
			}

			return false;
		}

		public function paths(array $path, bool $revisit = false): array
		{
			$node = $this->nodes[end($path)];

			$paths = [];

			foreach ($node->connections as $connection)
			{
				$id = $connection->id;

				if ($id === "start" || ($connection->isSmall && in_array($id, $path) && (!$revisit || $this->isRevisited($path))))
				{
					continue;
				}

				$newPath = [...$path, $id];

				if ($id === "end")
				{
					$paths[] = $newPath;
				}
				else
				{
					$paths = array_merge($paths, $this->paths($newPath, $revisit));
				}
			}

			return $paths;
		}


		public function run(): Result
		{
			return new Result(
				count($this->paths(["start"])),
				count($this->paths(["start"], true))
			);
		}
	}
?>