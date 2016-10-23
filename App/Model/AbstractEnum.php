<?php
namespace App\Model;
include_once 'TypeNotFoundException.php';

/**
 * Class AbstractEnum
 * All enum types must extend from AbstractEnum to use advantage of implemented features.
 * By extending AbstractEnum we can make sure we are always use correct types as well as autocomplete feature
 *
 * @package App\Model
 */
abstract class AbstractEnum
{
    protected $value;
    protected $availableTypes = [];

    /**
     * This method must be implemented in every extended class to fill $availableTypes
     *
     * @internal param array $availableTypes
     * @return void
     */
    protected abstract function setTypes();

    /**
     * TransportationTypes constructor.
     * You have to pass a valid type to this constructor otherwise throws a TypeNotFoundException exception.
     *
     * @throws TypeNotFoundException if type not found in valid types list
     */
    public function __construct($type)
    {
        $this->setTypes();
        if (!$this->availableTypes) {
            throw new \Exception("Invalid enum");
        }

        if (array_search($type, $this->availableTypes) === false) {
            throw new TypeNotFoundException("Given {$type} is not a valid TransportationTypes.");
        }

        $this->value = $type;
    }

    /**
     * @return mixed
     * @throws TypeNotFoundException if type not found in valid types list
     */
    public function getValue()
    {
        if (!$this->value) {
            throw new TypeNotFoundException("Value is empty!");
        }

        return $this->value;
    }

    /**
     * @param string $type
     * @throws TypeNotFoundException if type not found in valid types list
     */
    protected function checkType($type) {
        if (array_search($type, $this->availableTypes) === false) {
            throw new TypeNotFoundException("Given '{$type}' is not a valid TransportationTypes.");
        }
    }
}