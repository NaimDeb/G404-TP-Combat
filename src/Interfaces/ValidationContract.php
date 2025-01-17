<?php

interface ValidationContract
{
    public function validate($value): bool;
}