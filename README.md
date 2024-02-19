# Env Manager

The Env Manager is a PHP package designed to provide a secure, flexible, and object-oriented approach to managing environment variables in PHP applications. With built-in support for whitelists and optional value encryption, this package ensures that your application handles environment variables in a secure and efficient manner.

## Features

- **Whitelist Management**: Securely specify which environment variables are accessible, preventing unauthorized access to sensitive information.
- **Optional Encryption**: Encrypt environment variable values for an added layer of security, using a customizable encryption path.
- **Type Conversion**: Automatically convert environment variable values to their appropriate data types, including integers and booleans.
- **Flexible Configuration**: Easily set and update the whitelist and encryption path as per your application's requirements.

## Installation

To install the Env Manager, run the following command in your project directory:

```bash
composer require devuri/env
```

## Usage

### Basic Usage

```php
use Urisoft\Env;

// Initialize the Env with a whitelist of environment variables
$env = new Env([
    'APP_KEY', 'DB_HOST', 'DB_NAME', // Add your environment variables here
]);

// Retrieve an environment variable
$dbHost = $env->get('DB_HOST');

// Retrieve an environment variable with a default value
$debugMode = $env->get('DEBUG_MODE', false);
```

### With Encryption

To use the encryption feature, ensure you have set an encryption path and the `Encryption` class is properly configured.

```php
$env = new Env([], '/path/to/encryption/key');

// Retrieve and encrypt an environment variable
$encryptedAppKey = $env->get('APP_KEY', true);
```

### Updating the Whitelist

You can update the whitelist at any time using the `setWhitelist` method.

```php
$env->setWhitelist([
    'NEW_VAR_1', 'NEW_VAR_2', // Add new variables as needed
]);
```

## Security

The Env Manager includes a whitelist feature to ensure only predefined environment variables are accessible, adding an extra layer of security to your application. When using the encryption feature, ensure that your encryption keys are stored securely and are not accessible to unauthorized users.

## Contributing

Contributions to the Urisoft Env Manager are welcome! Please ensure that your contributions follow the project's coding standards and include tests for new features or bug fixes.

## License

This project is licensed under the MIT License - see the LICENSE file for details.
