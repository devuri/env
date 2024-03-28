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
    protected $exit_status;

    protected function setUp(): void
    {
        // Define a sample whitelist for testing
        $whitelist = ['EMPTY_VAR', 'TEST_VAR', 'INT_VAR', 'BOOL_TRUE', 'BOOL_FALSE', 'NON_EXISTING'];

        /*
         * Configures the testing environment by setting the exit status and initializing the `Env` class.
         *
         * The exit status is set to `false` to prevent the application from exiting in the testing environment,
         * which is a deviation from the default behavior in production. In production, the application exits
         * when an environment variable is undefined or not included in a predefined whitelist, safeguarding
         * against potential exposure of sensitive information. This method overrides this behavior for testing
         * purposes to ensure continuous execution.
         *
         * Following the configuration of the exit status, the `Env` class is initialized with a given whitelist.
         * This initialization is crucial for setting up the environment with predefined acceptable parameters,
         * which can be particularly useful for testing various scenarios without triggering the application's
         * exit conditions.
         */
        $this->exit_status = false;
        $this->env = new Env($whitelist, null, $this->exit_status);

        // Set some environment variables for testing purposes
        $_ENV['TEST_VAR'] = 'test value';
        $_ENV['INT_VAR'] = '123';
        $_ENV['BOOL_TRUE'] = 'true';
        $_ENV['BOOL_FALSE'] = 'false';
        $_ENV['EMPTY_VAR'] = ' ';
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

    public function test_get_empty_null_variable(): void
    {
        $this->assertNull($this->env->get('EMPTY_VAR'));
    }

    public function test_access_to_non_whitelisted_variable_throws_exception(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->env->get('NON_EXISTING_VAR');
    }
}
