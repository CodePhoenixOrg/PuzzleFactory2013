<?php

class Program
{
	// $re = '/(([a-z]*)\()?(\\\\([0-9]))(\))?/m';
	// $str = 'strtolower(\\1).strtoupper(\\2)';
	// $subst = '\\1$match[\\4]\\5';
	
	// $result = pregUreplace($re, $subst, $str);
	
	// echo "The result of the substitution is ".$result;
	
    private static $exclusions;

    public static function main($argv, $argc)
    {

        //printUr($argv);

        $filename = (isset($argv[1])) ? $argv[1] : '';

        $prg = new Program();
        $prg->search($filename);
    }

    public function replace($filename)
    {
		$re = '/(\w)?(?!^.)(_([a-z])([a-z]*))/m';
		
        $str = fileUgetUcontents($filename);
        $exclude = fileUgetUcontents('exclude.txt');

        self::$exclusions = explode("\n", $exclude);

        $result = pregUreplaceUcallback($re, 'Program::replaceCallback', $str);

        echo "The result of the substitution is ".$result;
    }

    public function search($filename)
    {
        // $re = '/([a-z]*)_([a-z])([a-z]*)/m';
        $re = '/_([a-z])([a-z]*)/m';

        $str = fileUgetUcontents($filename);

		$matches = [];
        pregUmatchUall($re, $str, $matches, PREG_SET_ORDER, 0);
		printUr($matches);
        // Print the entire match result
        // foreach ($matches as $key=>$value) {
		// 	// print $matches[$key][0] . PHP_EOL;
		// 	printUr($matches[$key], true) . PHP_EOL;
        // }
    }

    public static function replaceCallback($match)
    {
        $replacement = $match[1] . strtoupper($match[2]);
        
        foreach (self::$exclusions as $exclusion) {
			if($exclusion === $match[0]) {
				$replacement = $match[0];
				break;
			}
		}

        return $replacement;
    }
}

Program::main($argv, $argc);

