<?php
namespace App\Model;
include_once 'TransportationType.php';

/**
 * BoardingCard Model
 *
 * @package App\Model
 */
class BoardingCard
{
    /**
     * @var string place's name you are coming from, like Barcelona
     */
    private $from;
    /**
     * @var string place's name you are going to, like Gerona Airport
     */
    private $to;
    /**
     * @var string details about place you have to go, like flight SK455, Gate 45B
     */
    private $toDetails;
    /**
     * @var string seat details
     */
    private $seat;
    /**
     * @var TransportationType type of transportation
     */
    private $type;
    /**
     * @var string details about transportation type like flight number etc.
     */
    private $typeDetails;
    /**
     * @var string any other details will go hear like details about baggage etc.
     */
    private $boardingDetails;

    /**
     * BoardingCard constructor.
     * @param TransportationType $type if set as null, means it's our last card and we are arrived.
     * @param $typeDetails
     * @param $seat
     * @param $from
     * @param $to
     * @param $toDetails
     * @param $boardingDetails
     */
    public function __construct(TransportationType $type, $typeDetails, $seat, $from, $to, $toDetails, $boardingDetails)
    {
        $this->from = $from;
        $this->to = $to;
        $this->toDetails = $toDetails;
        $this->seat = $seat;
        $this->type = $type;
        $this->typeDetails = $typeDetails;
        $this->boardingDetails = $boardingDetails;
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param string $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    /**
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param string $to
     */
    public function setTo($to)
    {
        $this->to = $to;
    }

    /**
     * @return string
     */
    public function getToDetails()
    {
        return $this->toDetails;
    }

    /**
     * @param string $toDetails
     */
    public function setToDetails($toDetails)
    {
        $this->toDetails = $toDetails;
    }

    /**
     * @return string
     */
    public function getSeat()
    {
        return $this->seat;
    }

    /**
     * @param string $seat
     */
    public function setSeat($seat)
    {
        $this->seat = $seat;
    }

    /**
     * @return TransportationType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param TransportationType $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getTypeDetails()
    {
        return $this->typeDetails;
    }

    /**
     * @param string $typeDetails
     */
    public function setTypeDetails($typeDetails)
    {
        $this->typeDetails = $typeDetails;
    }

    /**
     * @return string
     */
    public function getBoardingDetails()
    {
        return $this->boardingDetails;
    }

    /**
     * @param string $boardingDetails
     */
    public function setBoardingDetails($boardingDetails)
    {
        $this->boardingDetails = $boardingDetails;
    }

    public function __toString()
    {
        return sprintf("%s %s %s %s -> %s %s %s", $this->from, $this->type->getValue(), $this->typeDetails,
            $this->seat, $this->to, $this->toDetails, $this->boardingDetails);
    }


}