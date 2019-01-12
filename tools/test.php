<?php

	$re = '/(([a-z]*)\()?(\\\\([0-9]))(\))?/m';
	$str = 'strtolower(\\1).strtoupper(\\2)';
	$subst = '\\1$match[\\4]\\5';
	
	$result = pregUreplace($re, $subst, $str);
	
	echo "The result of the substitution is ".$result . PHP_EOL;
