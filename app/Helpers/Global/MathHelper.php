<?php

if(!function_exists('numberFormatPrecision')){
    function numberFormatPrecision($number, $precision = 3, $separator = '.')
    {
        $numberParts = explode($separator, $number);
        $response = $numberParts[0];
        if (count($numberParts)>1 && $precision > 0) {
            $response .= $separator;
            $response .= substr($numberParts[1], 0, $precision);
        }
        return $response;
    }
}



if(!function_exists('binomialCoeff')){
    /**
     * @param $n
     * @param $k
     * @return int
     */
    function binomialCoeff($n, $k)
    {
        $res = 1;

        // Since C(n, k) = C(n, n-k)
        if ($k > $n - $k)
            $k = $n - $k;

        // Calculate value of
        // [n * (n-1) *---* (n-k+1)] /
        // [k * (k-1) *---* 1]
        for ($i = 0; $i < $k; ++$i) {
            $res *= ($n - $i);
            $res /= ($i + 1);
        }

        return $res;
    }
}

if(!function_exists('checkEqualZero'))
{

    /**
     * @param $val
     * @return bool
     */
    function checkEqualZero($val): bool
    {
        return empty($val) || (double)$val == 0;
    }
}
