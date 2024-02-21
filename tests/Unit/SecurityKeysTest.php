<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Urisoft\Env;

/**
 * @internal
 *
 * @coversNothing
 */
class SecurityKeysTest extends TestCase
{
    protected $env;

    protected function setUp(): void
    {
        parent::setUp();

        $this->env = new Env( [
            'AUTH_KEY',
            'SECURE_AUTH_KEY',
            'LOGGED_IN_KEY',
            'NONCE_KEY',
            'AUTH_SALT',
            'SECURE_AUTH_SALT',
            'LOGGED_IN_SALT',
            'NONCE_SALT',
        ], null, false );

        $security_keys = [
            'AUTH_KEY' => 'BmR+ZqO+%U5J`(/x<`k6<80P`yJ;ZPo~wo=IiVi7&9MucFW~2HVl?h^x|4=cGN<)',
            'SECURE_AUTH_KEY' => '`4V+fJoIn-3CO7h1M1EVNwMg-aGGhhHb59Qt+ZzIsuR5}qg3@-A)y|)0m+|k+1`K',
            'LOGGED_IN_KEY' => 'P6CyuyB~|oaA.V>yVnl@5W@aA7ppYdBR-_WnYh~FQ^w.#`6,,V[*:$h!:5umXsW%',
            'NONCE_KEY' => 'dL{$#(o.z|Q>!z=>Jel*&J5|Jzn1;Qm7`N^ME4lE(-v)7-{G2Hiw|3baK<Q#.gZg',
            'AUTH_SALT' => '.*gOx0.,m[,yIWQ[ NL1|6-+/yu5Z~?Y8mDRrIuahI!G)>K|5j,UIp+%|WNgr4W;',
            'SECURE_AUTH_SALT' => 'hH8TjIPb(`y,FP/ 5&luAxnG>fN?ndXTX:vXLWI|S9r0<z;OE8+e|mad)ywlq%(E',
            'LOGGED_IN_SALT' => 'K#8g${uHqg>P>ZKb*|lJ(7j1].gF}}w$buA-*J@++/=F#K[&)nQeB~oyXApBpLJf',
            'NONCE_SALT' => 'p^:mVp7ww-ynCm[j;y3:Zt`YB{GW5x2@HopGKpmz%;Dk/}sY)izWA/+Gn_2BR.JW',
        ];

        // Set environment variables for testing
        $_ENV['AUTH_KEY'] = $security_keys['AUTH_KEY'];
        $_ENV['SECURE_AUTH_KEY'] = $security_keys['SECURE_AUTH_KEY'];
        $_ENV['LOGGED_IN_KEY'] = $security_keys['LOGGED_IN_KEY'];
        $_ENV['NONCE_KEY'] = $security_keys['NONCE_KEY'];
        $_ENV['AUTH_SALT'] = $security_keys['AUTH_SALT'];
        $_ENV['SECURE_AUTH_SALT'] = $security_keys['SECURE_AUTH_SALT'];
        $_ENV['LOGGED_IN_SALT'] = $security_keys['LOGGED_IN_SALT'];
        $_ENV['NONCE_SALT'] = $security_keys['NONCE_SALT'];
    }

    public function test_auth_key(): void
    {
        $this->assertSame('BmR+ZqO+%U5J`(/x<`k6<80P`yJ;ZPo~wo=IiVi7&9MucFW~2HVl?h^x|4=cGN<)', $this->env->get('AUTH_KEY'));
    }

    public function test_secure_auth_key(): void
    {
        $this->assertSame('`4V+fJoIn-3CO7h1M1EVNwMg-aGGhhHb59Qt+ZzIsuR5}qg3@-A)y|)0m+|k+1`K', $this->env->get('SECURE_AUTH_KEY'));
    }

    public function test_logged_in_key(): void
    {
        $this->assertSame('P6CyuyB~|oaA.V>yVnl@5W@aA7ppYdBR-_WnYh~FQ^w.#`6,,V[*:$h!:5umXsW%', $this->env->get('LOGGED_IN_KEY'));
    }

    public function test_nonce_key(): void
    {
        $this->assertSame('dL{$#(o.z|Q>!z=>Jel*&J5|Jzn1;Qm7`N^ME4lE(-v)7-{G2Hiw|3baK<Q#.gZg', $this->env->get('NONCE_KEY'));
    }

    public function test_auth_salt(): void
    {
        $this->assertSame('.*gOx0.,m[,yIWQ[ NL1|6-+/yu5Z~?Y8mDRrIuahI!G)>K|5j,UIp+%|WNgr4W;', $this->env->get('AUTH_SALT'));
    }

    public function test_secure_auth_salt(): void
    {
        $this->assertSame('hH8TjIPb(`y,FP/ 5&luAxnG>fN?ndXTX:vXLWI|S9r0<z;OE8+e|mad)ywlq%(E', $this->env->get('SECURE_AUTH_SALT'));
    }

    public function test_logged_in_salt(): void
    {
        $this->assertSame('K#8g${uHqg>P>ZKb*|lJ(7j1].gF}}w$buA-*J@++/=F#K[&)nQeB~oyXApBpLJf', $this->env->get('LOGGED_IN_SALT'));
    }

    public function test_nonce_salt(): void
    {
        $this->assertSame('p^:mVp7ww-ynCm[j;y3:Zt`YB{GW5x2@HopGKpmz%;Dk/}sY)izWA/+Gn_2BR.JW', $this->env->get('NONCE_SALT'));
    }
}
