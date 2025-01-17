<?php

/**
 * Verifies if the value is set and not empty
 */
class RequiredValidator implements ValidationContract
{
    public function validate($value): bool
    {
        return isset($value) && !empty(trim($value));
    }
}