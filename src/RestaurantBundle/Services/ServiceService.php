<?php

namespace RestaurantBundle\Services;
use Doctrine\ORM\EntityManager;

class ServiceService
{
	
	private $entityManager;

	public function __construct($router,EntityManager $entityManager) 
	{
        $this->entityManager  = $entityManager;
   		$this->router  = $router;
	}
    public function timeToSeconds($date){
        $parsed_date=date_parse($date);
        $k=$parsed_date['hour'] * 3600 + $parsed_date['minute'] * 60 + $parsed_date['second'];
        return $k;
    }
    public function timeToSecondsRelative($date){
        $parsed_date=date_parse($date);
        $k=$parsed_date['relative']['hour'] * 3600 + $parsed_date['relative']['minute'] * 60 + $parsed_date['relative']['second'];
        return $k;
    }
    public function secondsToTime($time){
        $k=gmdate("h:i A", $time);
        return $k;
    }
    public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('#[^\\pL\d]+#u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        if (function_exists('iconv'))
        {
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('#[^-\w]+#', '', $text);

        if (empty($text))
        {
            return 'n-a';
        }

        return $text;
    }
}    
    