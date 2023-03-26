<?php

function meter_distance_to_text(float $distance): string
{
    $result = "";

    if ($distance > 1000) {
        $kms = intval($distance / 1000);
        $result .= $kms . "km ";
        $distance -= $kms * 1000;
    }

    $result .= number_format($distance) . "m";

    return $result;
}
