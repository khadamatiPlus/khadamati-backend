<?php

if(!function_exists('manhattanDistance')){
    /**
     * @param $latitudeFrom
     * @param $longitudeFrom
     * @param $latitudeTo
     * @param $longitudeTo
     */
    function manhattanDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
    {
        // Difference between the 'x'
        // coordinates of the given points
        $m = abs($latitudeFrom - $latitudeTo);
        // Difference between the 'y'
        // coordinates of the given points
        $n = abs($longitudeFrom - $longitudeTo);

        return (binomialCoeff($m + $n, $n));
    }
}

if(!function_exists('getNearestCoordinates')){
    /**
     * @param $latitudeFrom
     * @param $longitudeFrom
     * @param $toMultipleCoordinates
     * @param $nearestCount
     * @return array
     */
    function getNearestCoordinates($latitudeFrom, $longitudeFrom, $toMultipleCoordinates): array
    {
        $maxMeter = 5000;
        $nearest = [];

        foreach($toMultipleCoordinates as $id => $toCoordinate) {
            $d = manhattanDistance($latitudeFrom,$longitudeFrom,$toCoordinate['lat'],$toCoordinate['long']) * 100;
            if($d <= $maxMeter)
            {
                $toCoordinate['distance'] = $d;
                $toCoordinate['id'] = $id;
                $nearest[$id] = $toCoordinate;
            }
        }

        usort($nearest, function($a, $b) {
            return $a['distance'] <=> $b['distance'];
        });

        return array_slice($nearest, 0, 5, true);
    }
}


