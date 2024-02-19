<?php

namespace Tests\Unit;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Urisoft\Env;

/**
 * @internal
 *
 * @coversNothing
 */
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

    public function test_get_existing_variable(): void
    {
        $this->assertSame('test value', $this->env->get('TEST_VAR'));
    }

    public function test_get_non_existing_variable_returns_default(): void
    {
        $this->assertSame('default', $this->env->get('NON_EXISTING', 'default'));
    }

    public function test_get_integer_variable(): void
    {
        $this->assertSame(123, $this->env->get('INT_VAR'));
    }

    public function test_get_boolean_true_variable(): void
    {
        $this->assertTrue($this->env->get('BOOL_TRUE'));
    }

    public function test_get_boolean_false_variable(): void
    {
        $this->assertFalse($this->env->get('BOOL_FALSE'));
    }

    public function test_access_to_non_whitelisted_variable_throws_exception(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->env->get('NON_EXISTING_VAR');
    }
}
