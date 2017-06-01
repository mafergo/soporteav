<?php

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

global $app;

//Request::setTrustedProxies(array('127.0.0.1'));

$app->before(function () {
    // redirect the user to the login screen if access to the Resource is protected
    if (false) {
        return new RedirectResponse('/login');
    }
    return null;
});

// Homepage
$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig', array());
})->bind('homepage');

// Accesibilidad
$app->get('/accesibilidad', function (Request $request) use ($app) {
    return $app['twig']->render('accesibilidad.html.twig', array());
})->bind('accesibilidad');

// Aulas
$app->get('/aulas/{page}/{limit}', 'controller.room:indexAction')
    ->value('page', '1')
    ->value('limit', '10')
    ->assert('page', '\d+')
    ->assert('limit', '\d+')
    ->bind('rooms');

$app->get('/aula/{id}', 'controller.room:viewAction')
    ->assert('id', '\d+')
    ->bind('room_view');

$app->get('/aula_preparar', 'controller.room:prepareAction')
    ->bind('room_prepare');

$app->get('/aulas_revisar', function () use ($app) {
    return $app['twig']->render('room/room_revise.html.twig', array());
})->bind('room_revise');

$app->get('/select_aulas/{center_id}', 'controller.issue:selectRoomsAction')
->bind('select_rooms');

// Centros
$app->get('/centros/{page}/{limit}', 'controller.center:indexAction')
    ->value('page', '1')
    ->value('limit', '10')
    ->assert('page', '\d+')
    ->assert('limit', '\d+')
    ->bind('centers');

$app->get('/centro_nuevo', function () use ($app) {
    return $app['twig']->render('center/center_add.html.twig', array());
})->bind('center_add');

$app->get('/centro/{id}', 'controller.center:viewAction')
    ->assert('id', '\d+')
    ->bind('center_view');

// Equipamiento
$app->get('/equipamiento', function () use ($app) {
    return $app['twig']->render('equipment/equipment_index.html.twig', array());
})->bind('equipment');

// Incidencias
$app->get('/incidencias/{page}/{limit}', 'controller.issue:indexAction')
    ->value('page', '1')
    ->value('limit', '10')
    ->assert('page', '\d+')
    ->assert('limit', '\d+')
    ->bind('issues');

$app->get('/incidencia/{id}', 'controller.issue:viewAction')
    ->assert('id', '\d+')
    ->bind('issue_view');

// Grabar incidencias
$app->post('/incidencia/grabar', 'controller.issue:saveAction')
    ->bind('issue_save');

// Incidencias nuevas
$app->get('/incidencia_nueva', 'controller.issue:addAction')
    ->bind('issue_add');

$app->get('/pcs', function () use ($app) {
    return $app['twig']->render('pc/pc_index.html.twig', array());
})->bind('pcs');

// Login
$app->get('/login', function (Request $request) use ($app) {
    return $app['twig']->render('login.html.twig', array(
        'error' => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
})->bind('login');

// Micrófonos
$app->get('/microfonos', function () use ($app) {
    return $app['twig']->render('microphone/microphone_index.html.twig', array());
})->bind('microphones');

$app->get('/microfonos/{page}/{limit}', 'controller.microphone:indexAction')
    ->value('page', '1')
    ->value('limit', '10')
    ->assert('page', '\d+')
    ->assert('limit', '\d+')
    ->bind('microphones');

// Novedades
$app->get('/novedades/{page}/{limit}', 'controller.notice:indexAction')
    ->value('page', '1')
    ->value('limit', '10')
    ->assert('page', '\d+')
    ->assert('limit', '\d+')
    ->bind('notices');

$app->get('/noticia_nueva', function () use ($app) {
    return $app['twig']->render('notice/notice_add.html.twig', array());
})->bind('notice_add');

$app->get('/ordenadores/{page}/{limit}', 'controller.pc:indexAction')
    ->value('page', '1')
    ->value('limit', '10')
    ->assert('page', '\d+')
    ->assert('limit', '\d+')
    ->bind('pcs');

// Personas
$app->get('/personas/{page}/{limit}', 'controller.person:indexAction')
    ->value('page', '1')
    ->value('limit', '10')
    ->assert('page', '\d+')
    ->assert('limit', '\d+')
    ->bind('people');

$app->get('/persona/{id}', 'controller.person:viewAction')
    ->assert('id', '\d+')
    ->bind('person_view');

$app->get('/persona_nueva', function () use ($app) {
    return $app['twig']->render('person/person_add.html.twig', array());
})->bind('people_add');

// Proyectores
$app->get('/proyectores/{page}/{limit}', 'controller.projector:indexAction')
    ->value('page', '1')
    ->value('limit', '10')
    ->assert('page', '\d+')
    ->assert('limit', '\d+')
    ->bind('projectors');

// Unidades
$app->get('/unidades/{page}/{limit}', 'controller.unittech:indexAction')
    ->value('page', '1')
    ->value('limit', '10')
    ->assert('page', '\d+')
    ->assert('limit', '\d+')
    ->bind('unittechs');

$app->get('/private_upload/{item_id}/{path}', function ($item_id, $path) use ($app) {
    if (!file_exists('../var/private_upload/' . $item_id . '/' . $path)) {
        $app->abort(404);
    }
    return $app->sendFile('../var/private_upload/' . $item_id . '/' . $path);
})
    ->assert('item', 'd+');





// Mounting admin routes
$app->mount('/admin', include 'routes_admin.php');


// TESTS & SAMPLES //
$app->get('/prueba', function () use ($app) {
    return print_r($app['orm.ems']);
});


// ERROR MANAGEMENT
$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return null;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/' . $code . '.html.twig',
        'errors/' . substr($code, 0, 2) . 'x.html.twig',
        'errors/' . substr($code, 0, 1) . 'xx.html.twig',
        'errors/default.html.twig',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});
