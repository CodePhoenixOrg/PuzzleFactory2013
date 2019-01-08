<?php

class Program
{
    private static $exclusions;

    public static function main($argv, $argc)
    {

        //print_r($argv);

        $filename = (isset($argv[1])) ? $argv[1] : '';

        $prg = new Program();
        $prg->search($filename);
    }

    public function replace($filename)
    {
        $re = '/(\w)?(?!^.)(_([a-z])([a-z]*))/m';
        $str = file_get_contents($filename);
        $exclude = file_get_contents('exclude.txt');

        self::$exclusions = explode("\n", $exclude);

        $result = preg_replace_callback($re, 'Program::replaceCallback', $str);

        echo "The result of the substitution is ".$result;
    }

    public function search($filename)
    {
        // $re = '/([a-z]*)_([a-z])([a-z]*)/m';
        $re = '/_([a-z])([a-z]*)/m';

        $str = file_get_contents($filename);

		$matches = [];
        preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);
		print_r($matches);
        // Print the entire match result
        // foreach ($matches as $key=>$value) {
		// 	// print $matches[$key][0] . PHP_EOL;
		// 	print_r($matches[$key], true) . PHP_EOL;
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

