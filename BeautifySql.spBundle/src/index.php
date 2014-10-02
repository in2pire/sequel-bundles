<?php

/**
 * Beautify SQL Query.
 *
 * @package In2pire
 * @subpackage BeautifySql
 * @author Nhat Tran <nhat.tran@inspire.vn>
 */

// Define App Environment constants.
define('APP_ROOT', dirname(__FILE__));
chdir(APP_ROOT);

// PSR-0: Add class loader.
require 'vendor/autoload.php';

use In2pire\Sql\SqlBeautifier;

ob_start();

while ($buf = fgets(STDIN)) {
    echo $buf;
}

$sql = trim(ob_get_clean());

if (empty($sql)) {
    return;
}

$sql = SqlBeautifier::format($sql);
echo $sql;
