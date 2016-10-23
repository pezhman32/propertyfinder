<?php
namespace App\Model;
include_once 'AbstractEnum.php';

/**
 * Enum to hold different types of transportation.
 *
 * @package App\Model
 */
class TransportationType extends AbstractEnum
{
    const TRAIN = "Train";
    const AIRPORT_BUS = "Airport bus";
    const FLIGHT = "Flight";

    protected function setTypes()
    {
        $this->availableTypes = [self::TRAIN, self::AIRPORT_BUS, self::FLIGHT];
    }
}