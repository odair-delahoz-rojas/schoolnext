# AdminLTE 4 PHP Helper Library

A PHP-8.2 library designed to simplify the generation of AdminLTE 4 HTML components, widgets and layouts.

## Description

This library provides a set of PHP classes that act as helpers for rendering various UI components from the AdminLTE 4 dashboard template. It aims to streamline the process of building AdminLTE-powered interfaces in PHP applications by offering an object-oriented approach to component creation.

## Installation

This library can be installed via Composer. First, ensure you have Composer installed.

1.  **Add the repository to your `composer.json` (if not publishing to Packagist):**

    If you are using this library directly from its source or before it's officially on Packagist, you might need to add a repository entry to your project's `composer.json`:

    ```json
    {
        "repositories": [
            {
                "type": "path",
                "url": "./path/to/AdminLTE4Helper" // Adjust this path to where you cloned/placed the library
            }
        ],
        "require": {
            "odairdelahoz/adminlte4-helper": "*"
        }
    }
    ```

2.  **Require the package:**

    ```bash
    composer require odairdelahoz/adminlte4-helper
    ```


## Usage

After installing via Composer, you can use the components by including Composer's autoloader:

```php
<?php
require_once __DIR__ . '/vendor/autoload.php';

use AdminLTE\Components\Card;
use AdminLTE\Components\Alert;
use AdminLTE\Layout;

// Example: Render a Card
echo Card::render('My First Card', 'This is the content of my card.', ['color' => 'primary']);

// Example: Render an Alert
echo Alert::render('Success! Your operation was successful.', ['color' => 'success', 'dismissible' => true]);

// Example: Using the Layout class
$layout = new Layout('My Page Title', ['fixed_header' => true]);
$layout->renderHead();
// ... render other layout parts ...
$layout->renderBodyEnd();
?>
```

## Examples

Explore the `examples/` directory within the library for detailed usage demonstrations of each component and layout type. Each file in that directory showcases different options and configurations.

To view the layout examples, you can open `examples/layout_preview.php` in your browser (after running `composer install` in the `AdminLTE4Helper` directory).

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file in the main project repository for details.
