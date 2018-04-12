<?php

return [
    'fecha' => ['formato' => 'Y-m-d H:i:s'],
    'pagination' => 2,
    'apunte_tipos' => ['Examen', 'Examen Calificado', 'Monografía', 'Tarea', 'Trabajo Grupal'],
    'menu' => [
        ['name' => 'Apuntes', 'route' => 'admin.apuntes', 'icon' => 'book'],
        ['name' => 'Usuarios', 'route' => 'usuarios.index', 'icon' => 'users'],
        ['name' => 'Configuración', 'icon' => 'cogs' , 'submenu' => [
        ['name' => 'Universidades', 'route' => 'universidades.index'],
        ['name' => 'Cursos', 'route' => 'cursos.index'],
    	]],
    ],
	'convertapi' =>  ['secret' => '1ZxFIfKjBV0C2M9D', 'url' => 'https://v2.convertapi.com/'],
	'cloudconvert' =>  ['key' => 'uODVYcaZz7xmbLp-p_JtKJHTB0KIDbgTb9dw2gg_qXvJ362gCNg9aWcVWwxTCI3ck-kDdFIIo9CH3RYQ-eFr3Q'],
	
];