<?php
namespace App\Test;
include_once 'TestFailedException.php';

use App\Service\BoardingService;
use App\Service\IBoardingService;
use App\Model\BoardingCard;
use App\Model\TransportationType;
use App\Service\BoardingServiceBrokenChainException;

/**
 * Class BoardingServiceTest
 * Unit tests to cover BoardingService
 *
 * @package App\Test
 */
class BoardingServiceTest
{
    /**
     * @var IBoardingService
     */
    private $boardingService;

    public static function runAll() {
        $test = new self();
        $test->testOriginalExample();
        $test->testBrokenChain();
        $test->testEmptyChain();
    }

    private function __construct()
    {
    }

    /**
     * Reset environment before each run
     */
    private function __beforeRun()
    {
        $this->boardingService = new BoardingService();
    }

    /**
     * Example given on documentation, list shuffles each time to generate a random list
     *
     * @throws TestFailedException
     */
    private function testOriginalExample()
    {
        $this->__beforeRun();
        $cards = [
            new BoardingCard(new TransportationType(TransportationType::TRAIN),
                "78A", "45B", "Madrid", "Barcelona", null, null),
            new BoardingCard(new TransportationType(TransportationType::AIRPORT_BUS),
                null, null, "Barcelona", "Gerona Airport", null, null),
            new BoardingCard(new TransportationType(TransportationType::FLIGHT),
                "SK455", "3A", "Gerona Airport", "Stockholm", "Gate 45B", "Baggage drop at ticket counter 344"),
            new BoardingCard(new TransportationType(TransportationType::FLIGHT),
                "SK22", "7B", "Stockholm", "New York JFK", "Gate 22", "Baggage will we automatically transferred")
        ];
        $correctOrder = $cards;

        //shuffle the list:
        shuffle($cards);
        foreach ($cards as $card) {
            $this->boardingService->addCard($card);
        }

        if ($this->boardingService->getChain() !== $correctOrder) {
            throw new TestFailedException();
        }
    }

    /**
     * Using a broken chain we must get an exception
     *
     * @throws TestFailedException if broken chain not detected
     */
    private function testBrokenChain()
    {
        $this->__beforeRun();
        $cards = [
            new BoardingCard(new TransportationType(TransportationType::TRAIN),
                "78A", "45B", "Madrid", "Barcelona", null, null),
            new BoardingCard(new TransportationType(TransportationType::AIRPORT_BUS),
                null, null, "Barcelona - break it", "Gerona Airport", null, null),
            new BoardingCard(new TransportationType(TransportationType::FLIGHT),
                "SK455", "3A", "Gerona Airport", "Stockholm", "Gate 45B", "Baggage drop at ticket counter 344"),
            new BoardingCard(new TransportationType(TransportationType::FLIGHT),
                "SK22", "7B", "Stockholm", "New York JFK", "Gate 22", "Baggage will we automatically transferred")
        ];

        foreach ($cards as $card) {
            $this->boardingService->addCard($card);
        }

        try {
            $this->boardingService->getChain();
        } catch (BoardingServiceBrokenChainException $e) {
            return;
        }

        throw new TestFailedException("Test failed: No BoardingServiceBrokenChainException");
    }

    /**
     * Empty chain must result in exception
     *
     * @throws TestFailedException if empty chain not detected
     */
    private function testEmptyChain()
    {
        $this->__beforeRun();
        $cards = [];

        try {
            $this->boardingService->getChain();
        } catch (BoardingServiceBrokenChainException $e) {
            return;
        }

        throw new TestFailedException("Test failed: No BoardingServiceBrokenChainException");
    }
}