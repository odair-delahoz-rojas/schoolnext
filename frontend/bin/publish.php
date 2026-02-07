<?php

// Script para publicar los assets de AdminLTE desde vendor a la carpeta public

$vendorDir = dirname(__DIR__) . '/vendor';
$publicDir = dirname(__DIR__) . '/public';

$source = $vendorDir . '/almasaeed2010/adminlte/dist';
$destination = $publicDir . '/vendor/adminlte';

function recursiveCopy($src, $dst)
{
    if (!is_dir($dst)) {
        mkdir($dst, 0755, true);
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($src, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($iterator as $item) {
        if ($item->isDir()) {
            $dir = $dst . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
        } else {
            copy($item, $dst . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
        }
    }
}

if (is_dir($source)) {
    echo "Copiando assets de AdminLTE...\n";
    recursiveCopy($source, $destination);
    echo "Assets de AdminLTE publicados correctamente en public/vendor/adminlte\n";
} else {
    echo "Error: No se encontró el directorio de AdminLTE en vendor.\n";
    exit(1);
}

