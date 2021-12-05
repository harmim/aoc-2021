<?php declare(strict_types=1);

function part_two(array $f, int $bitsCount, bool $co2 = false): int
{
	for ($j = 0; $j < $bitsCount; $j++) {
		$b = array_reduce($f, fn (int $c, string $i): int => $i[$j] ? ++$c : --$c, 0) >= 0
			? ($co2 ? '0' : '1')
			: ($co2 ? '1' : '0');
		$f = array_filter($f, fn (string $i): bool => $i[$j] === $b);
		if (count($f) === 1) return bindec(reset($f));
	}
	return 1;
}

$f = file('input');
$bitsCount = strlen(trim($f[0]));
$partOne = array_map(
	fn (int $i): array => [(string) ($i >= 0 ? 1 : 0), (string) $i >= 0 ? 0 : 1],
	array_reduce($f, fn (array $c, string $i): array => array_map(
		fn (int $a, int $b): int => $b ? ++$a : --$a, $c, str_split(trim($i)),
	), array_fill(0, $bitsCount, 0)),
);
printf("%d\n", bindec(implode(array_column($partOne, 0))) * bindec(implode(array_column($partOne, 1))));
printf("%d\n", part_two($f, $bitsCount) * part_two($f, $bitsCount, true));
