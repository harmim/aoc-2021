<?php declare(strict_types=1);

$f = file('input');
printf("%d\n", array_product(array_reduce($f, function (array $c, string $i): array {
	$i = explode(' ', $i);
	return match ($i[0]) {
		'forward' => [$c[0] + (int) $i[1], $c[1]],
		'up' => [$c[0], $c[1] - (int) $i[1]],
		'down' => [$c[0], $c[1] + (int) $i[1]],
	};
}, [0, 0])));
printf("%d\n", array_product(array_slice(array_reduce($f, function (array $c, string $i): array {
	$i = explode(' ', $i);
	return match ($i[0]) {
		'forward' => [$c[0] + (int) $i[1], $c[1] + $c[2] * (int) $i[1], $c[2]],
		'up' => [$c[0], $c[1], $c[2] - (int) $i[1]],
		'down' => [$c[0], $c[1], $c[2] + (int) $i[1]],
	};
}, [0, 0, 0]), 0, 2)));
