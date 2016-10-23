<?php
namespace App\Service;

use App\Model\BoardingCard;

interface IBoardingService
{
    /**
     * Adds new BoardingCard to the list
     *
     * @param BoardingCard $card
     * @return void
     */
    public function addCard(BoardingCard $card);

    /**
     * Return validated list or throws an exception if list is broken
     *
     * @return array
     * @throws BoardingServiceBrokenChainException
     */
    public function getChain();
}