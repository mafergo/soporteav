<?php
/**
 * Soporteav Project - app.php
 * Created 1/5/16 - 0:00
 *
 * $app is a dependency container based on Pimple
 * ¡Silex itself is a Pimple container!
 */

// Center
use US\Soporteav\Controller\CenterController;
use US\Soporteav\Repository\CenterRepository;
// Issue
use US\Soporteav\Controller\IssueController;
use US\Soporteav\Repository\IssueRepository;
// Microphone
use US\Soporteav\Controller\MicrophoneController;
use US\Soporteav\Repository\MicrophoneRepository;
// New
use US\Soporteav\Controller\NoticeController;
use US\Soporteav\Repository\NoticeRepository;
// Person
use US\Soporteav\Controller\PersonController;
use US\Soporteav\Repository\PersonRepository;

// Pc
use US\Soporteav\Controller\PcController;
use US\Soporteav\Repository\PcRepository;

// Projector
use US\Soporteav\Controller\ProjectorController;
use US\Soporteav\Repository\ProjectorRepository;

// Room
use US\Soporteav\Controller\RoomController;
use US\Soporteav\Repository\RoomRepository;

// Unittech
use US\Soporteav\Controller\UnittechController;
use US\Soporteav\Repository\UnittechRepository;

use Silex\Application;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\RoutingServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Symfony\Component\Translation\Loader\YamlFileLoader;

$app = new Application();
$app->register(new RoutingServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new ServiceControllerServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider());

// Options for Doctrine ORM
$app["orm.em.options"] = array(
    "mappings" => array(
        array(
            "type" => "annotation",
            "namespace" => "US\\Soporteav\\Entity",
            "path" => realpath(__DIR__ . "/../src/Entity")
        )
    )
);

$app["orm.proxies_dir"] = __DIR__ . "/../var/cache/doctrine/proxies";

// Authentication and Security
$app['security.access_rules'] = array(
    array('^/admin', 'ROLE_ADMIN'),
    array('^.*$', 'ROLE_USER'),
);

$app['security.firewalls'] = array(
    'admin' => array(
        'pattern' => '^/admin/',
        'form' => array('login_path' => '/login', 'check_path' => '/admin/login_check'),
        'logout' => array('logout_path' => '/admin/logout', 'invalidate_session' => true),
        'users' => array(
            'admin' => array('ROLE_ADMIN', '5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg=='),
        ),
    ),
    'unsecured' => array(
        'anonymous' => true,
    ),
);
$app->register(new Silex\Provider\SecurityServiceProvider(), $app['security.firewalls']);

// Register controllers as Silex services
$app['controller.microphone'] = function ($app) {
    return new MicrophoneController($app['repository.microphone']);
};

// Register repositories as Silex services
$app['repository.microphone'] = function ($app) {
    return new MicrophoneRepository($app['orm.em'], $app['orm.em']->getClassMetadata('US\Soporteav\Entity\Microphone'));
};

// Register controllers as Silex services
$app['controller.notice'] = function ($app) {
    return new NoticeController($app['repository.notice']);
};

// Register repositories as Silex services
$app['repository.notice'] = function ($app) {
    return new NoticeRepository($app['orm.em'], $app['orm.em']->getClassMetadata('US\Soporteav\Entity\Notice'));
};

// Register controllers as Silex services
$app['controller.center'] = function ($app) {
    return new CenterController($app['repository.center']);
};

// Register repositories as Silex services
$app['repository.center'] = function ($app) {
    return new CenterRepository($app['orm.em'], $app['orm.em']->getClassMetadata('US\Soporteav\Entity\Center'));
};

// Register controllers as Silex services
$app['controller.issue'] = function ($app) {
    return new IssueController($app['repository.issue']);
};

// Register repositories as Silex services
$app['repository.issue'] = function ($app) {
    return new IssueRepository($app['orm.em'], $app['orm.em']->getClassMetadata('US\Soporteav\Entity\Issue\Issue'));
};

// Register repositories as Silex services
$app['repository.person'] = function ($app) {
    return new PersonRepository($app['orm.em'], $app['orm.em']->getClassMetadata('US\Soporteav\Entity\Person'));
};

// Register controllers as Silex services
$app['controller.person'] = function ($app) {
    return new PersonController($app['repository.person']);
};

// Register repositories as Silex services
$app['repository.pc'] = function ($app) {
    return new PcRepository($app['orm.em'], $app['orm.em']->getClassMetadata('US\Soporteav\Entity\Pc'));
};

// Register controllers as Silex services
$app['controller.pc'] = function ($app) {
    return new PcController($app['repository.pc']);
};

// Register repositories as Silex services
$app['repository.projector'] = function ($app) {
    return new ProjectorRepository($app['orm.em'], $app['orm.em']->getClassMetadata('US\Soporteav\Entity\Projector'));
};

// Register controllers as Silex services
$app['controller.projector'] = function ($app) {
    return new ProjectorController($app['repository.projector']);
};

// Register repositories as Silex services
$app['repository.room'] = function ($app) {
    return new RoomRepository($app['orm.em'], $app['orm.em']->getClassMetadata('US\Soporteav\Entity\Room'));
};

// Register controllers as Silex services
$app['controller.room'] = function ($app) {
    return new RoomController($app['repository.room']);
};

// Register controllers as Silex services
$app['controller.unittech'] = function ($app) {
    return new UnittechController($app['repository.unittech']);
};

// Register repositories as Silex services
$app['repository.unittech'] = function ($app) {
    return new UnittechRepository($app['orm.em'], $app['orm.em']->getClassMetadata('US\Soporteav\Entity\Unittech'));
};




// Options for Twig Template Engine
$app['twig.path'] = array(__DIR__ . '/../views');
$app['twig.options'] = array('cache' => __DIR__ . '/../var/cache/twig');

$app['twig'] = $app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...
    /** @var  Twig_Environment $twig */
    $twig->addFunction(new \Twig_SimpleFunction('asset', function ($asset) use ($app) {
        return $app['request_stack']->getMasterRequest()->getBasepath() . '/' . ltrim($asset, '/');
    }));

    return $twig;
});

// Translation
$app->register(new TranslationServiceProvider(), array(
    'locale' => 'es',
    'locale_fallbacks' => array('es'),
));

$app['translator'] = $app->extend('translator', function ($translator, $app) {
    /** @var Symfony\Component\Translation\Translator  $translator */
    $translator->addLoader('yaml', new YamlFileLoader());
    $translator->addResource('yaml', __DIR__ . '/../locales/es.yml', 'es');
    return $translator;
});

// Finally
return $app;
