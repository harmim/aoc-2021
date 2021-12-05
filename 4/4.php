<?php declare(strict_types=1);

define('GRID_SIZE', 5);

function winner(array $boards, array $numbers): int
{
	foreach ($boards as $k => $b) {
		for ($r = 0; $r < GRID_SIZE; $r++) {
			for ($c = 0; $c < GRID_SIZE; $c++) {
				if (!in_array($b[$r][$c], $numbers, true)) break;
				elseif ($c === GRID_SIZE - 1) return $k;
			}
		}
		for ($c = 0; $c < GRID_SIZE; $c++) {
			for ($r = 0; $r < GRID_SIZE; $r++) {
				if (!in_array($b[$r][$c], $numbers, true)) break;
				elseif ($r === GRID_SIZE - 1) return $k;
			}
		}
	}
	return -1;
}

function winners(array $boards, array $numbers): array
{
	$winners = [];
	$numbersCount = count($numbers);
	for ($i = GRID_SIZE; $i <= $numbersCount; $i++) {
		$slice = array_slice($numbers, 0, $i);
		while (($winner = winner($boards, $slice)) !== -1) {
			$winners[] = (int) end($slice) * array_reduce($boards[$winner], fn (int $c, array $r): int => array_reduce(
				$r, fn (int $c, string $n): int => $c + (in_array($n, $slice, true) ? 0 : (int) $n), $c
			), 0);
			unset($boards[$winner]);
		}
	}
	return $winners;
}

$f = file('input');
$numbers = explode(',', trim($f[0]));
$boards = array_map(fn (array $i): array => array_map(
	fn (string $i): array => preg_split('~\s+~', trim($i)), array_slice($i, 0, GRID_SIZE),
), array_chunk(array_slice($f, 2), GRID_SIZE + 1));
$winners = winners($boards, $numbers);
printf("%d\n", reset($winners));
printf("%d\n", end($winners));
