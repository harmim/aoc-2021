<?php declare(strict_types=1);

define('D_RESET', 6);
define('D_NEW', 8);

function not_optimised(array $s, int $n): int
{
	for ($i = 0; $i < $n; $i++) {
		$new = [];
		$s = array_merge(array_map(function (int $d) use (&$new): int {
			if ($d === 0) {
				$new[] = D_NEW;
				return D_RESET;
			}
			return --$d;
		}, $s), $new);
	}
	return count($s);
}

function optimised(array $s, int $n): int
{
	$s = array_count_values($s);
	for ($i = 0; $i < $n; $i++) {
		$new = array_fill(0, 9, 0);
		foreach ($s as $d => $c) {
			if ($d === 0) {
				$new[D_NEW] += $c;
				$new[D_RESET] += $c;
			}
			else $new[--$d] += $c;
		}
		$s = $new;
	}
	return array_sum($s);
}

$s = array_map('intval', explode(',', file('input')[0]));
printf("%d\n", not_optimised($s, 80));
printf("%d\n", optimised($s, 256));
