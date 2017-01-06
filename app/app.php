<?php

/*
 * Copyright 2017 trigger.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\HttpFoundation\Request;

// Register global error and exception handler
ErrorHandler::register();
ExceptionHandler::register();

// Register service providers.
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), 
    array(
        'twig.path' => __DIR__ . '/../views'
    ));
$app['twig'] = $app->extend('twig', 
    function (Twig_Environment $twig, $app) {
        $twig->addExtension(new Twig_Extensions_Extension_Text());
        return $twig;
    });
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\AssetServiceProvider(), 
    array(
        'assets.version' => 'v1'
    ));
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider(), 
    array(
        'security.firewalls' => array(
            'secured' => array(
                'pattern' => '^/',
                'anonymous' => true,
                'logout' => true,
                'form' => array(
                    'login_path' => '/login',
                    'check_path' => '/login_check'
                ),
                'users' => function () use ($app) {
                    return new SimpleMVCProject\DAO\UserDAO($app['db']);
                }
            )
        )
    ));
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\LocaleServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());
$app->register(new Silex\Provider\MonologServiceProvider(), 
    array(
        'monolog.logfile' => __DIR__ . '/../var/logs/simplemvcproject.log',
        'monolog.name' => 'SimpleMVCProject',
        'monolog.level' => $app['monolog.level']
    ));
// Register services.
$app['dao.article'] = function ($app) {
    return new SimpleMVCProject\DAO\ArticleDAO($app['db']);
};
$app['dao.user'] = function ($app) {
    return new SimpleMVCProject\DAO\UserDAO($app['db']);
};
$app['dao.comment'] = function ($app) {
    $commentDAO = new SimpleMVCProject\DAO\CommentDAO($app['db']);
    $commentDAO->setArticleDAO($app['dao.article']);
    $commentDAO->setUserDAO($app['dao.user']);
    return $commentDAO;
};

// Register error handler
$app->error(
    function (\Exception $e, Request $request, $code) use ($app) {
        switch ($code) {
            case 403:
                $message = 'Access denied';
                break;
            case 404:
                $message = 'The requested resource could not be found.';
                break;
            default:
                $message = 'Something went wrong';
        }
        return $app['twig']->render('error.html.twig', 
            array(
                'message' => $message
            ));
    });