<?php declare(strict_types=1);

$s = array_map('intval', explode(',', file('input')[0]));
sort($s);
$c = count($s);
$i = floor($c / 2);
$meds = $c & 1 ? [$s[$i]] : [$s[$i - 1], $s[$i]];
$avg = array_sum($s) / $c;
$avgs = [floor($avg), ceil($avg)];
$arithSer = fn (int $n): int => $n * ($n + 1) / 2;
$r = fn (array $a, callable $f): int => min(array_map(
	fn (int $x): int => array_reduce($s, fn (int $c, int $p): int => $c + $f($p, $x), 0),
	$a
));
printf("%d\n", $r($meds, fn (int $p, int $x): int => abs($p - $x)));
printf("%d\n", $r($avgs, fn (int $p, int $x): int => $arithSer(abs($p - $x))));
