<?php
namespace App\Service;
include_once 'IBoardingService.php';
include_once 'BoardingServiceBrokenChainException.php';

use App\Model\BoardingCard;

/**
 * Class BoardingService
 * Manage boardingCards by using linked chains and sort them in place. chains are merged by using getChain() method
 *
 * @package App\Service
 */
class BoardingService implements IBoardingService
{
    /**
     * List of available chains, we will merge these chains and result would be only 1 unbroken chain
     *
     * @var array
     */
    private $chains = [];

    /**
     * Adds new BoardingCard to the list
     *
     * @param BoardingCard $card
     * @return void
     */
    public function addCard(BoardingCard $card)
    {
        //if chains list is empty, create the first one:
        if (count($this->chains) === 0) {
            $this->chains[] = [$card];
            return;
        }

        foreach ($this->chains as &$chain) {
            //try first element of the chain
            if ($chain[0]->getFrom() === $card->getTo()) {
                array_unshift($chain, $card);
                return;
            }

            //try last element in the chain
            if ($chain[count($chain) - 1]->getTo() === $card->getFrom()) {
                array_push($chain, $card);
                return;
            }
        }

        //if no related chain found, lets create another one:
        $this->chains[] = [$card];
    }

    /**
     * Returns validated list or throws an exception if list is broken
     *
     * @return array validated merged chain
     * @throws BoardingServiceBrokenChainException if list is broken
     */
    public function getChain()
    {
        $this->mergeChains();
        if (count($this->chains) != 1) {
            throw new BoardingServiceBrokenChainException("Chain is broken, there are some missing BoardingCards here!");
        }

        return $this->chains[0];
    }

    /**
     * Merge chains into a single chain
     *
     * @throws BoardingServiceBrokenChainException if chain is broken
     */
    private function mergeChains()
    {
        if (!$this->chains) {
            throw new BoardingServiceBrokenChainException("Chains list is empty!");
        }

        //Shift an element off the beginning of chains to set as base
        $list = array_shift($this->chains);
        while (count($this->chains)) {
            $found = false;
            for ($i = 0; $i < count($this->chains); $i++) {
                $chain = $this->chains[$i];
                //if chains is at the end of the list
                if ($chain[0]->getFrom() === $list[count($list) - 1]->getTo()) {
                    $list = $this->addToList($list, $chain);
                    $found = true;
                    break;
                }

                if ($chain[count($chain) - 1]->getTo() === $list[0]->getFrom()) {
                    $list = $this->addToList($chain, $list);
                    $found = true;
                    break;
                }
            }

            if ($found) {
                unset($this->chains[$i]);
            } else {
                throw new BoardingServiceBrokenChainException("Chain is broken, there are some missing BoardingCards here!");
            }
        }

        $this->chains = [$list];
    }

    /**
     * Adds $second array to the end of the $first array
     *
     * @param array $first
     * @param array $second
     * @return array result
     */
    private function addToList($first, $second)
    {
        $final = $first;
        foreach ($second as $item) {
            $final[] = $item;
        }

        return $final;
    }
}