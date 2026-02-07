<?php
/**
 * KumbiaPHP Web Framework
 * Archivo de rutas (Opcional)
 * 
 * Usa este archivo para definir el enrutamiento estatico entre
 * controladores y sus acciones.Un controlador se puede enrutar a 
 * otro controlador utilizando '*' como comodin así:
 * 
 * '/controlador1/accion1/valor_id1'  =>  'controlador2/accion2/valor_id2'
 * 
 * Ej:
 * Enrutar cualquier petición a posts/adicionar a posts/insertar/*
 * '/posts/adicionar/*' => 'posts/insertar/*'
 * 
 * Otros ejemplos:
 * 
 * '/prueba/ruta1/*' => 'prueba/ruta2/*',
 * '/prueba/ruta2/*' => 'prueba/ruta3/*',
 */
return [
    'routes' => [
        '/'         => 'auth/login',
        '/logout'   => 'auth/logout',
        '/ayuda'    => 'pages/ayuda',
        '/colores'  => 'pages/colores',
        '/iconos'   => 'pages/iconos',

        '/docen-asignar-carga'      => 'docentes/asignar_carga',
        '/docen-carga-academica'    => 'docentes/carga',
        '/carga'                    => 'docentes/carga',
        '/docen-reg-observaciones'  => 'docentes/registros_observaciones',
        '/docen-reg-desemp-acad'    => 'docentes/registros_desemp_acad',
        '/docen-notas'              => 'docentes/listNotas',
        '/notas'                    => 'docentes/listNotas',
        '/docen-indicadores'        => 'docentes/listIndicadores',
        '/indicadores'              => 'docentes/listIndicadores',

        '/dirgrupo'                 => 'dirgrupo/index', // ?? no funciona

        //'/docen-dir-grupo'          => 'docentes/direccion_grupo',
        '/docen-seguimientos-grupo' => 'docentes/seguimientos_grupo',
        //'/docen-registros-grupo'    => 'docentes/registros_grupo',
        
        //'/coord-consoli-notas'   => 'coordinador/consolidado_notas',
        //'/coord-consoli-notas'   => 'coordinador/consolidado',
        //'/coord-registros'       => 'coordinador/gestion_registros',
        //'/coord-historicos'      => 'coordinador/historico_notas',
        
        '/secre-estud-list-activos'    => 'secretaria/listadoEstudActivos',
        '/secre-estud-edit-activos'    => 'secretaria/editarEstudActivos',
        '/secre-estud-list-inactivos'  => 'secretaria/listadoEstudInactivos',
        '/secre-admisiones' => 'secretaria/admisiones',
        '/secre-historico-notas'       => 'secretaria/historico_notas',
        ],
];
