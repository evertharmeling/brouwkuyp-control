<?php

$loader = @include __DIR__ . '/../vendor/autoload.php';

if (!$loader) {
    die(<<<'EOT'
You must set up the project dependencies, run the following command:
composer install

EOT
    );
}

spl_autoload_register(function ($class) {
    if (0 === strpos($class, 'Brouwkuyp\\Bundle\\LogicBundle\\')) {
        $path = implode('/', array_slice(explode('\\', $class), 3)) . '.php';
        require_once __DIR__ . '/../../LogicBundle/' . $path;

        return true;
    }
});
