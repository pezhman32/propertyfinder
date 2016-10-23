<?php
namespace App;
include_once 'Model/BoardingCard.php';
include_once 'Service/BoardingService.php';
include_once 'Test/BoardingServiceTest.php';

use App\Model\BoardingCard;
use App\Model\TransportationType;
use App\Service\BoardingService;
use App\Test\BoardingServiceTest;

class Application
{
    /**
     * Our main solution is implemented into this service
     *
     * @var Service\IBoardingService
     */
    private $boardingService;

    /**
     * Just create a new instance and return it
     *
     * @return Application
     */
    public static function init()
    {
        $app = new Application();
        return $app;
    }

    /**
     * Application constructor.
     * Runs tests and create the boardingService instance, adds cards and print the sorted list all in one place!
     */
    private function __construct()
    {
        $this->runTests();

        $this->boardingService = new BoardingService();
        $this->addBoardCards();
        $this->printAllCardsAsSorted();
    }

    /**
     * Runs unit tests
     */
    private function runTests()
    {
        BoardingServiceTest::runAll();
    }

    /**
     * Adds boarding cards
     */
    private function addBoardCards()
    {
        $this->boardingService->addCard(new BoardingCard(new TransportationType(TransportationType::FLIGHT),
            "SK455", "3A", "Gerona Airport", "Stockholm", "Gate 45B", "Baggage drop at ticket counter 344"));
        $this->boardingService->addCard(new BoardingCard(new TransportationType(TransportationType::AIRPORT_BUS),
            null, null, "Barcelona", "Gerona Airport", null, null));
        $this->boardingService->addCard(new BoardingCard(new TransportationType(TransportationType::FLIGHT),
            "SK22", "7B", "Stockholm", "New York JFK", "Gate 22", "Baggage will we automatically transferred from your last leg"));
        $this->boardingService->addCard(new BoardingCard(new TransportationType(TransportationType::TRAIN),
            "78A", "45B", "Madrid", "Barcelona", null, null));
    }

    /**
     * Prints sorted list
     */
    private function printAllCardsAsSorted()
    {
        $sortedList = $this->boardingService->getChain();
        foreach ($sortedList as $item) {
            printf("%s<br />", $item);
        }
    }
}