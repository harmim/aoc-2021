<?php declare(strict_types=1);

function add_point(array &$a, int $x, int $y, &$counter): void
{
	$a[$x][$y] = isset($a[$x][$y]) ? $a[$x][$y] + 1 : 1;
	$counter += $a[$x][$y] === 2 ? 1 : 0;
}

$lines = array_map(fn (string $i): array => array_map(
	fn (string $i): array => array_map('intval', explode(',', $i)), explode(' -> ', trim($i)),
), file('input'));
$partOne = 0;
$diagramPartOne = array_reduce($lines, function (array $c, array $l) use (&$partOne): array {
	if (($x = $l[0][0]) === $l[1][0]) {
		$maxY = max($l[0][1], $l[1][1]);
		for ($y = min($l[0][1], $l[1][1]); $y <= $maxY; $y++) add_point($c, $x, $y, $partOne);
	} elseif (($y = $l[0][1]) === $l[1][1]) {
		$maxX = max($l[0][0], $l[1][0]);
		for ($x = min($l[0][0], $l[1][0]); $x <= $maxX; $x++) add_point($c, $x, $y, $partOne);
	}
	return $c;
}, []);
$partTwo = $partOne;
$foo = array_reduce($lines, function (array $c, array $l) use (&$partTwo): array {
	if (($x1 = $l[0][0]) !== ($x2 = $l[1][0]) && ($y1 = $l[0][1]) !== ($y2 = $l[1][1])) {
		if (($x1 < $x2 && $y1 < $y2) || ($x1 > $x2 && $y1 > $y2)) {
			$maxX = max($x1, $x2);
			for ($x = min($x1, $x2), $y = min($y1, $y2); $x <= $maxX; $x++, $y++) add_point($c, $x, $y, $partTwo);
		} elseif ($x1 < $x2 && $y1 > $y2) {
			for ($x = $x1, $y = $y1; $x <= $x2; $x++, $y--) add_point($c, $x, $y, $partTwo);
		} else {
			for ($x = $x1, $y = $y1; $x >= $x2; $x--, $y++) add_point($c, $x, $y, $partTwo);
		}
	}
	return $c;
}, $diagramPartOne);
printf("%d\n", $partOne);
printf("%d\n", $partTwo);
