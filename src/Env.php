<?php

namespace Urisoft;

use Urisoft\Encryption;
use InvalidArgumentException;

class Env
{
    protected $whitelist = [];
    protected $encryptionPath;

    public function __construct(array $whitelist = [], $encryptionPath = null)
    {
        $this->whitelist = $whitelist;
        $this->encryptionPath = $encryptionPath;
    }

    public function setWhitelist(array $whitelist)
    {
        $this->whitelist = $whitelist;
    }

    public function get($name, $defaultOrEncrypt = null, $strtolower = false)
    {
        if (!in_array($name, $this->whitelist, true )) {
            throw new InvalidArgumentException("Access to undefined environment variable: {$name}");
        }

        $value = $_ENV[$name] ?? $defaultOrEncrypt;

        if (true === $defaultOrEncrypt) {
            if (!$this->encryptionPath) {
                throw new InvalidArgumentException('Error: Encryption path is not defined');
            }

            $encryption = new Encryption($this->encryptionPath);
            return $encryption->encrypt($value);
        }

        if ($this->isIntVal($value)) {
            return (int) $value;
        }

        if (in_array($value, ['Null', 'null', 'NULL', null], true)) {
            return '';
        }

        switch (strtolower($value)) {
            case 'true': return true;
            case 'false': return false;
        }

		return $strtolower ? strtolower($value) : $value;
    }

    protected function filterInt($value)
    {
        return filter_var($value, FILTER_VALIDATE_INT) !== false;
    }

	/**
     * Check if a string is an integer value.
     *
     * @param int|string $str The string to check.
     *
     * @return bool Returns true if the string is an integer value, and false otherwise.
     */
    protected function isIntVal( $str )
    {
        return is_numeric( $str ) && \intval( $str ) == $str;
    }
}
