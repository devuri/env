<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Urisoft\Env;
use InvalidArgumentException;

class EnvTest extends TestCase
{
    protected $env;

    protected function setUp(): void
    {
        // Define a sample whitelist for testing
        $whitelist = ['TEST_VAR', 'INT_VAR', 'BOOL_TRUE', 'BOOL_FALSE', 'NON_EXISTING'];

        // Initialize the Env class with the sample whitelist
        $this->env = new Env($whitelist);

        // Set some environment variables for testing purposes
        $_ENV['TEST_VAR'] = 'test value';
        $_ENV['INT_VAR'] = '123';
        $_ENV['BOOL_TRUE'] = 'true';
        $_ENV['BOOL_FALSE'] = 'false';
    }

    public function testGetExistingVariable()
    {
        $this->assertSame('test value', $this->env->get('TEST_VAR'));
    }

    public function testGetNonExistingVariableReturnsDefault()
    {
        $this->assertSame('default', $this->env->get('NON_EXISTING', 'default'));
    }

    public function testGetIntegerVariable()
    {
        $this->assertSame(123, $this->env->get('INT_VAR'));
    }

    public function testGetBooleanTrueVariable()
    {
        $this->assertTrue($this->env->get('BOOL_TRUE'));
    }

    public function testGetBooleanFalseVariable()
    {
        $this->assertFalse($this->env->get('BOOL_FALSE'));
    }

	public function testAccessToNonWhitelistedVariableThrowsException()
	{
	    $this->expectException(InvalidArgumentException::class);
	    $this->env->get('NON_EXISTING_VAR');
	}
}
