<?php

/**
 * Verifies if the value is a string and if the length is less or equal than maxLength and more or equal than minLength
 */
class StringValidator implements ValidationContract
{
    private $maxLength;
    private $minLength;

    public function __construct($maxLength, $minLength = 1)
    {
        $this->maxLength = $maxLength;
        $this->minLength = $minLength;
    }

    public function validate($value): bool
    {

        if (isset($this->maxLength) && strlen($value) > $this->maxLength) {
            return false;
        }

        if (isset($this->minLength) && strlen($value) < $this->minLength) {
            return false;
        }


        return is_string($value);
    }
}
