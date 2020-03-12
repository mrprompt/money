<?php
namespace MrPrompt\Tests\Money;

use InvalidArgumentException;
use MrPrompt\Money\Currency;
use PHPUnit\Framework\TestCase;

class CurrencyTest extends TestCase
{
    /**
     * Asserts that the given callback throws the given exception.
     *
     * @param string $expectClass The name of the expected exception class
     * @param callable $callback A callback which should throw the exception
     */
    protected function assertException(string $expectClass, callable $callback)
    {
        try {
            $callback();
        } catch (\Throwable $exception) {
            $this->assertInstanceOf($expectClass, $exception, 'An invalid exception was thrown');
            return;
        }

        $this->fail('No exception was thrown');
    }

    /**
     * @test
     */
    public function constructorWithoutParameters()
    {
        $currency = new Currency();

        $this->assertInstanceOf(Currency::class, $currency);
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function constructorWithInvalidCurrencyCodeThrowsException()
    {
        $this->assertException(InvalidArgumentException::class, function() {
            new Currency('...');
        });
    }

    /**
     * @test
     */
    public function nameReturnString()
    {
        $currency = new Currency();
        $result = $currency->name();

        $this->assertNotEmpty($result);
        $this->assertEquals('Real', $result);
    }

    /**
     * @test
     */
    public function codeReturnString()
    {
        $currency = new Currency();
        $result = $currency->code();

        $this->assertEquals('BRL', $result);
    }

    /**
     * @test
     */
    public function numberReturnInteger()
    {
        $currency = new Currency();
        $result = $currency->number();

        $this->assertEquals(986, $result);
    }

    /**
     * @test
     */
    public function decimalsReturnString()
    {
        $currency = new Currency();
        $result = $currency->decimals();

        $this->assertEquals('2', $result);
    }

    /**
     * @test
     */
    public function countriesReturnArray()
    {
        $currency = new Currency();
        $result = $currency->countries();

        $this->assertIsArray($result);
    }

    /**
     * @test
     */
    public function formatReturnNumeric()
    {
        $currency = new Currency();
        $result = $currency->format(100.00, 'pt_BR', $currency->code());

        $this->assertEquals('$100.00', $result);
    }
}
