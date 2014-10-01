<?php

/**
 * Copy as PHP Array.
 *
 * @package In2pire
 * @subpackage CopyAsDeserializedArray
 * @author Nhat Tran <nhat.tran@inspire.vn>
 */

function copyToClipboard($content)
{
    $cmd = 'echo '.  escapeshellarg($content) . ' | __CF_USER_TEXT_ENCODING=' . posix_getuid() . ':0x8000100:0x8000100 pbcopy';
    shell_exec($cmd);
}

$stdIn = fopen('php://stdin', 'r');
$result = array();

while ($row = fgetcsv($stdIn, 0)) {
    $result[] = $row;
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

    copyToClipboard(var_export($result, true));
}
