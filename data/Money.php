<?php

/**
 * Class Money value object.
 *
 * @author Hillel Student
 * @copyright 2020
 */
class Money
{
    /** @var string */
    private $currency;

    /** @var float */
    private $value;

    /**
     * Money constructor.
     * @param $value
     * @param string $currency
     */
    public function __construct(float $value, string $currency = 'USD')
    {
        $this->value = $value;
        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

}