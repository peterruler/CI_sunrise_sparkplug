#!/bin/sh
#!/usr/bin/php -q
<?php
echo "Execute Codeigniter Unittests PHP CLI script\n";
echo exec('vendor/bin/phpunit -c tests/phpunit.xml') . "\n";
?>

