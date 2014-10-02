<?php

/**
 * Copy as PHP Array.
 *
 * @package In2pire
 * @subpackage CopyAsDeserializedArray
 * @author Nhat Tran <nhat.tran@inspire.vn>
 */

error_reporting(0);

define('C_TAB', "\t");
define('C_NEWLINE', "\n");
define('C_ESCAPED_TAB', '⇥');
define('C_ESCAPED_NEWLINE', '↵');

function copyToClipboard($content)
{
    $cmd = 'echo '.  escapeshellarg($content) . ' | __CF_USER_TEXT_ENCODING=' . posix_getuid() . ':0x8000100:0x8000100 pbcopy';
    shell_exec($cmd);
}

function getCsvData($line)
{
    $line = trim($line, C_NEWLINE);
    $columns = explode(C_TAB, $line);
    $columns = array_map('cleanCsvData', $columns);
    return $columns;
}

function cleanCsvData($value)
{
    $value = str_replace(C_ESCAPED_TAB, C_TAB, $value);
    $value = str_replace(C_NEWLINE, C_ESCAPED_NEWLINE, $value);
    return $value;
}

function cleanExportArray($array)
{
    $output = var_export($array, true);
    $output = preg_replace('#([\t ]*)\d+\s=>\s*#', '\\1', $output);
    $output = preg_replace('#=> \n[\t ]*array \(\n#', "=> array(\n", $output);
    return $output;
}

ob_start();
$result = [];

while ($line = fgets(STDIN)) {
    $result[] = getCsvData($line);
}

$columns = array_shift($result);

foreach ($result as $key => $data) {
    $result[$key] = array_combine($columns, $data);
}

$count = count($result);

if ($count) {
    if ($count == 1) {
        $result = reset($result);
    }

    copyToClipboard(cleanExportArray($result));
}
