<?php

class Timer {
	private static $start;
	private static $stop;
	private static $numOfHours;
    public static function start(){
       return self::$start = date('Y-m-d H:i:s');
    }

    public static function stop(){
        return self::$stop = date('Y-m-d H:i:s');
    }
}
?>

