<?php declare(strict_types=1);

function windowed(array $a, int $n): array
{
	$w = [];
	while (count($a) >= $n) {
		$w[] = array_slice($a, 0, $n);
		array_shift($a);
	}
	return $w;
}

function part_one(array $a): int
{
	return count(array_filter(windowed($a, 2), fn (array $a): bool => $a[1] > $a[0]));
}

$f = file('input');
printf("%d\n", part_one($f));
printf("%d\n", part_one(array_map(fn (array $a): int => array_sum($a), windowed($f, 3))));
