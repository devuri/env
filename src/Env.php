<?php

namespace Urisoft;

use InvalidArgumentException;

class Env
{
    protected $whitelist = [];
    protected $encryptionPath;

    public function __construct( array $whitelist = [], $encryptionPath = null )
    {
        $this->whitelist      = $whitelist;
        $this->encryptionPath = $encryptionPath;
    }

    public function setWhitelist( array $whitelist ): void
    {
        $this->whitelist = $whitelist;
    }

    /**
     * Sanitizes a given string by removing or encoding unwanted characters and whitespace.
     *
     * This method serves as a public interface to the `_sanitizeIt` method, providing
     * a way to sanitize input strings according to the specified level of strictness.
     * When `$strict` is true, it employs a more rigorous sanitization process by stripping
     * all HTML tags from the input.
     *
     * @param string $value  The input string to be sanitized.
     * @param bool   $strict Optional. Determines the sanitization level. When set to true,
     *                       the method performs a more stringent sanitization by removing
     *                       all HTML tags. Defaults to false, in which case the input string
     *                       is sanitized without removing HTML tags.
     *
     * @return string The sanitized string.
     */
    public function sanitize( string $value, bool $strict = false ): string
    {
        return $this->_sanitizeIt( $value, $strict );
    }

    /**
     * Retrieves a sanitized, and optionally encrypted or modified, environment variable by name.
     *
     * This method first checks if the requested environment variable name is within the allowed whitelist.
     * If not, it throws an InvalidArgumentException. If the variable is in the whitelist, it retrieves the value
     * from the environment, with a fallback to the provided default or encryption flag. The value is then sanitized
     * for safe use. If encryption is requested (by setting the second parameter to true), and an encryption path
     * is defined, the value is encrypted. Otherwise, the method attempts to cast the value to its appropriate
     * data type based on its content. It supports casting to integer and boolean, and recognizes 'null' values
     * which are converted to an empty string. Additionally, the value can be converted to lowercase based on
     * the `$strtolower` parameter.
     *
     * @param string $name             The name of the environment variable to retrieve.
     * @param mixed  $defaultOrEncrypt Default value to return if the environment variable is not set,
     *                                 or boolean true to indicate that the value should be encrypted.
     * @param bool   $strtolower       Whether to convert the retrieved value to lowercase. Defaults to false.
     *
     * @throws InvalidArgumentException If the requested environment variable name is not in the whitelist
     *                                  or if encryption is requested but the encryption path is not defined.
     *
     * @return mixed The sanitized environment variable value, possibly encrypted or typecast,
     *               or transformed to lowercase if specified.
     */
    public function get( $name, $defaultOrEncrypt = null, $strtolower = false )
    {
        if ( ! \in_array( $name, $this->whitelist, true ) ) {
            throw new InvalidArgumentException( "Access to undefined environment variable: {$name}" );
        }

        $value = $_ENV[ $name ] ?? $defaultOrEncrypt;

        // Sanitize the value.
        $value = $this->sanitize( $value );

        if ( true === $defaultOrEncrypt ) {
            if ( ! $this->encryptionPath ) {
                throw new InvalidArgumentException( 'Error: Encryption path is not defined' );
            }

            $encryption = new Encryption( $this->encryptionPath );

            return $encryption->encrypt( $value );
        }

        if ( $this->isIntVal( $value ) ) {
            return (int) $value;
        }

        if ( \in_array( $value, [ 'Null', 'null', 'NULL', null ], true ) ) {
            return '';
        }

        switch ( strtolower( $value ) ) {
            case 'true':
                return true;
            case 'false':
                return false;
        }

        return $strtolower ? strtolower( $value ) : $value;
    }

    protected function filterInt( $value )
    {
        return false !== filter_var( $value, FILTER_VALIDATE_INT );
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

    /**
     * Performs the actual sanitization of a given string based on the specified level of strictness.
     *
     * This private method is responsible for the core sanitization logic applied to the input string.
     * It trims whitespace from the beginning and end of the string, optionally strips all HTML tags
     * if strict sanitization is required, and removes excessive whitespace and non-printable characters
     * from the string to ensure it is clean and safe for use.
     *
     * @param string $value  The input string to be sanitized.
     * @param bool   $strict Determines the sanitization level. When set to true, the method
     *                       strips all HTML tags from the input string for a stricter sanitization.
     *                       Defaults to false, allowing HTML tags to remain in the sanitized output.
     *
     * @return string The sanitized string, with unwanted characters and excessive whitespace removed.
     */
    private function _sanitizeIt( string $value, bool $strict = false ): string
    {
        $value = trim( $value );
        $value = $strict ? strip_tags( $value ) : $value;
        $value = preg_replace( '/[\r\n\t ]+/', ' ', $value );

        return preg_replace( '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/', '', $value );
    }
}
