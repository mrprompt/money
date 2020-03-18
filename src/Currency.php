<?php
namespace MrPrompt\Money;

use InvalidArgumentException;
use SimpleXMLElement;

final class Currency
{
    /**
     * @var SimpleXMLElement
     */
    private $loader;

    /**
     * @var SimpleXMLElement
     */
    private $currency;

    /**
     * Currency constructor.
     * @param string $code
     */
    public function __construct(string $code = 'BRL')
    {
        $this->loader = $this->loadCurrenciesDatabase();
        $this->currency = $this->findByCode($code);
    }

    /**
     * Load the currencies database.
     * @return SimpleXMLElement
     */
    private function loadCurrenciesDatabase(): SimpleXMLElement
    {
        return simplexml_load_file(__DIR__ . "/../data/money.xml");
    }

    /**
     * Search the currency from the code.
     *
     * @param string $code
     * @return SimpleXMLElement
     * @throws InvalidArgumentException
     */
    private function findByCode(string $code): SimpleXMLElement
    {
        $currencies = $this->loader->xpath("//currency[@code='{$code}']");

        if (!$currencies) {
            throw new InvalidArgumentException('Currency not found!');
        }

        return array_shift($currencies);
    }

    /**
     * Get the name of the actual currency.
     * @return string
     */
    public function name(): string
    {
        return (string) $this->currency->__toString();
    }

    /**
     * Get the code of the actual currency.
     * @return string
     */
    public function code(): string
    {
        return (string) $this->currency->attributes()['code'];
    }

    /**
     * Get the numeric code of the actual currency.
     * @return int
     */
    public function number(): int
    {
        return (int) $this->currency->attributes()['number'];
    }

    /**
     * Get the number of decimals of the actual currency.
     * @return string
     */
    public function decimals(): string
    {
        return (string) $this->currency->attributes()['decimals'];
    }

    /**
     * Get the countries where the actual currency is used.
     * @return array
     */
    public function countries(): array
    {
        return explode(',', $this->currency->attributes()['countries']);
    }

    /**
     * Format a float number into money
     * @param float $number
     * @param string $locale
     * @param string $currency
     * @return string
     * @codeCoverageIgnore
     */
    public function format(float $number, string $locale = 'en_US', string $currency = 'USD'): string
    {
        // PHP 7.4+
        if (function_exists('numfmt_create') && function_exists('numfmt_format_currency')) {
            $fmt = numfmt_create($locale, \NumberFormatter::CURRENCY);
            return numfmt_format_currency($fmt, $number, $currency);
        }

        return number_format($number, $this->decimals());
    }
}