<?php


$msg_comprimir_imagenes = '<span class="w3-small">Con el fin de optimizar el espacio en disco duro de nuestro servidor,
le sugerimos <u>comprimir las imágenes antes de subirlas</u>.<br> Este servicio lo puede obtener gratuitamente en '
.OdaTags::linkExterno('https://www.iloveimg.com/es/comprimir-imagen', 'www.iloveimg.com', '')
.'<br> ** Tamaño máximo de los archivos a subir: <b>'.ini_get('upload_max_filesize').'</b>'
.'</span>';

return [
    'comprimir_imagenes' => $msg_comprimir_imagenes,
];

