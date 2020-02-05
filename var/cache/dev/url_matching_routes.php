<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/_profiler' => [[['_route' => '_profiler_home', '_controller' => 'web_profiler.controller.profiler::homeAction'], null, null, null, true, false, null]],
        '/_profiler/search' => [[['_route' => '_profiler_search', '_controller' => 'web_profiler.controller.profiler::searchAction'], null, null, null, false, false, null]],
        '/_profiler/search_bar' => [[['_route' => '_profiler_search_bar', '_controller' => 'web_profiler.controller.profiler::searchBarAction'], null, null, null, false, false, null]],
        '/_profiler/phpinfo' => [[['_route' => '_profiler_phpinfo', '_controller' => 'web_profiler.controller.profiler::phpinfoAction'], null, null, null, false, false, null]],
        '/_profiler/open' => [[['_route' => '_profiler_open_file', '_controller' => 'web_profiler.controller.profiler::openAction'], null, null, null, false, false, null]],
        '/aficiones' => [[['_route' => 'aficiones_index', '_controller' => 'App\\Controller\\AficionesController::index'], null, ['GET' => 0], null, true, false, null]],
        '/aficiones/new' => [[['_route' => 'aficiones_new', '_controller' => 'App\\Controller\\AficionesController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/ciudades' => [[['_route' => 'ciudades_index', '_controller' => 'App\\Controller\\CiudadesController::index'], null, ['GET' => 0], null, true, false, null]],
        '/ciudades/new' => [[['_route' => 'ciudades_new', '_controller' => 'App\\Controller\\CiudadesController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/home' => [[['_route' => 'home', '_controller' => 'App\\Controller\\HomeController::index'], null, null, null, false, false, null]],
        '/register' => [[['_route' => 'app_register', '_controller' => 'App\\Controller\\RegisterController::register'], null, null, null, false, false, null]],
        '/login' => [[['_route' => 'app_login', '_controller' => 'App\\Controller\\SecurityController::login'], null, null, null, false, false, null]],
        '/logout' => [[['_route' => 'app_logout', '_controller' => 'App\\Controller\\SecurityController::logout'], null, null, null, false, false, null]],
        '/usuarios' => [[['_route' => 'usuarios_index', '_controller' => 'App\\Controller\\UsuariosController::index'], null, ['GET' => 0], null, true, false, null]],
        '/usuarios/new' => [[['_route' => 'usuarios_new', '_controller' => 'App\\Controller\\UsuariosController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_(?'
                    .'|error/(\\d+)(?:\\.([^/]++))?(*:38)'
                    .'|wdt/([^/]++)(*:57)'
                    .'|profiler/([^/]++)(?'
                        .'|/(?'
                            .'|search/results(*:102)'
                            .'|router(*:116)'
                            .'|exception(?'
                                .'|(*:136)'
                                .'|\\.css(*:149)'
                            .')'
                        .')'
                        .'|(*:159)'
                    .')'
                .')'
                .'|/aficiones/([^/]++)(?'
                    .'|(*:191)'
                    .'|/edit(*:204)'
                    .'|(*:212)'
                .')'
                .'|/ciudades/([^/]++)(?'
                    .'|(*:242)'
                    .'|/edit(*:255)'
                    .'|(*:263)'
                .')'
                .'|/usuarios/([^/]++)(?'
                    .'|(*:293)'
                    .'|/edit(*:306)'
                    .'|(*:314)'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        38 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        57 => [[['_route' => '_wdt', '_controller' => 'web_profiler.controller.profiler::toolbarAction'], ['token'], null, null, false, true, null]],
        102 => [[['_route' => '_profiler_search_results', '_controller' => 'web_profiler.controller.profiler::searchResultsAction'], ['token'], null, null, false, false, null]],
        116 => [[['_route' => '_profiler_router', '_controller' => 'web_profiler.controller.router::panelAction'], ['token'], null, null, false, false, null]],
        136 => [[['_route' => '_profiler_exception', '_controller' => 'web_profiler.controller.exception_panel::body'], ['token'], null, null, false, false, null]],
        149 => [[['_route' => '_profiler_exception_css', '_controller' => 'web_profiler.controller.exception_panel::stylesheet'], ['token'], null, null, false, false, null]],
        159 => [[['_route' => '_profiler', '_controller' => 'web_profiler.controller.profiler::panelAction'], ['token'], null, null, false, true, null]],
        191 => [[['_route' => 'aficiones_show', '_controller' => 'App\\Controller\\AficionesController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        204 => [[['_route' => 'aficiones_edit', '_controller' => 'App\\Controller\\AficionesController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        212 => [[['_route' => 'aficiones_delete', '_controller' => 'App\\Controller\\AficionesController::delete'], ['id'], ['DELETE' => 0], null, false, true, null]],
        242 => [[['_route' => 'ciudades_show', '_controller' => 'App\\Controller\\CiudadesController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        255 => [[['_route' => 'ciudades_edit', '_controller' => 'App\\Controller\\CiudadesController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        263 => [[['_route' => 'ciudades_delete', '_controller' => 'App\\Controller\\CiudadesController::delete'], ['id'], ['DELETE' => 0], null, false, true, null]],
        293 => [[['_route' => 'usuarios_show', '_controller' => 'App\\Controller\\UsuariosController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        306 => [[['_route' => 'usuarios_edit', '_controller' => 'App\\Controller\\UsuariosController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        314 => [
            [['_route' => 'usuarios_delete', '_controller' => 'App\\Controller\\UsuariosController::delete'], ['id'], ['DELETE' => 0], null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
