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
### Create a Convenient Wrapper

To create a function that acts as a convenient wrapper for instantiating and using your `Env` class, you can define a function in a global scope (or within a specific namespace if you prefer to keep things organized). This function can initialize the `Env` class with predefined settings like the whitelist and encryption path, and then return an instance or a specific value from the `Env` object.

Here's an example of how you might implement such a function:

```php
use Urisoft\Env;

/**
 * A convenient global function to access environment variables using the Env class.
 *
 * @param string $name The name of the environment variable.
 * @param mixed  $defaultOrEncrypt Default value or encryption flag.
 * @param bool   $strtolower Whether to convert the value to lowercase.
 *
 * @return mixed The value of the environment variable, processed according to the Env class logic.
 */
function env($name, $defaultOrEncrypt = null, $strtolower = false) {
    // Define your whitelist and encryption path here. These could also be fetched from a configuration file or another source.
    $whitelist = [
        // Add your environment variables to the whitelist
    ];

    $encryptionPath = '/path/to/your/encryption/key';

    // Create an instance of the Env class with your predefined settings
    static $env = null;
    if ($env === null) {
        $env = new Env($whitelist, $encryptionPath);
    }

    // Use the Env instance to get the environment variable value
    return $env->get($name, $defaultOrEncrypt, $strtolower);
}
```

### Notes:

- **Static Variable**: The function uses a static variable to store the `Env` instance. This means that the same `Env` object is reused across all calls to the `env` function within a single request, which is efficient because it avoids the overhead of re-instantiating the `Env` class every time the function is called.
- **Configuration**: The whitelist and encryption path are hardcoded in this example, but you might want to load these from a configuration file or environment variables to make the function more flexible and environment-specific.
- **Global vs. Namespaced**: Depending on your application's architecture, you might place this function in the global namespace (as shown) or within a specific namespace. If placed within a namespace, remember to reference it correctly when calling the function.
- **Reusability**: This approach makes it easy to fetch environment variables using the `env` function throughout your application, leveraging the full functionality of the `Env` class with minimal boilerplate code.

This function can then be used throughout your application to fetch environment variables in a standardized way, like so:

```php
$dbHost = env('DB_HOST');
$debugMode = env('DEBUG_MODE', false);
```

> Adjust the implementation details such as the whitelist and encryption path to suit your application's needs.

## Security

The Env Manager includes a whitelist feature to ensure only predefined environment variables are accessible, adding an extra layer of security to your application. When using the encryption feature, ensure that your encryption keys are stored securely and are not accessible to unauthorized users.

## Contributing

Contributions to the Urisoft Env Manager are welcome! Please ensure that your contributions follow the project's coding standards and include tests for new features or bug fixes.

## License

Licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
