<?php

$lockFiles = glob(sys_get_temp_dir() . "/*.lock");

foreach ($lockFiles as $lockFile) {
    unlink($lockFile);
    echo "Lock file rimosso: $lockFile\n";
}

echo "Tutti i lock file sono stati rimossi.\n";