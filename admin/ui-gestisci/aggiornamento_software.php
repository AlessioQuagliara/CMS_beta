<?php

$projectDir = realpath(__DIR__ . '/../../');
$repoUrl = 'https://github.com/AlessioSpotex/CMS_beta.git';
$tempDir = sys_get_temp_dir() . '/backup';

exec("git clone $repoUrl $tempDir 2>&1", $output, $return_var);
if ($return_var !== 0) {
    echo "Errore durante il clonaggio del repository: " . implode("\n", $output);
    exit;
}

function copyFiles($src, $dst) {
    $dir = opendir($src);
    @mkdir($dst);
    while (false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..')) {
            if (is_dir($src . '/' . $file)) {
                if ($file !== 'src') {
                    copyFiles($src . '/' . $file, $dst . '/' . $file);
                }
            } else {
                if ($file !== 'conn.php') {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
    }
    closedir($dir);
}

copyFiles($tempDir, $projectDir);

exec("rm -rf $tempDir");

echo "Aggiornamento completato con successo.";
?>
