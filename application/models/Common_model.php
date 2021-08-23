<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Common_model extends CI_Model {
    public function calcSecondsBetweenTwoDates($start, $end) {
        $startDate = new DateTime($start);
        $endDate = new DateTime($end);

        $diff = $startDate->diff($endDate);

        $daysInSecs = $diff->format("%r%a") * 24 * 60 * 60;
        $hoursInSecs = $diff->format("%r").$diff->h * 60 * 60;
        $minsInSecs = $diff->format("%r").$diff->i * 60;

        $remainSecs = $daysInSecs + $hoursInSecs + $minsInSecs + $diff->s;

        return $remainSecs;
    }
}