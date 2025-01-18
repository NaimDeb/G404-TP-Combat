<?php

/**
 * Verifies if the value is an integer
 */
class IntegerValidator implements ValidationContract
{
private $maxValue;
private $minValue;

public function __construct($maxValue = null, $minValue = null)
{
    $this->maxValue = $maxValue;
    $this->minValue = $minValue;
}


    public function validate($value): bool
    {

        if  (!filter_var($value, FILTER_VALIDATE_INT)){
            return false;
        }

        if (isset($this->maxValue) && $value > $this->maxValue) {
            return false;
        }

        if (isset($this->minValue) && $value < $this->minValue) {
            return false;
        }


        return filter_var($value, FILTER_VALIDATE_INT) !== false;
    }
}