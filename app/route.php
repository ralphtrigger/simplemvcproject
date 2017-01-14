<?php

/*
 * Copyright 2016 trigger.
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

// Home page
$app->get('/', "SimpleMVCProject\Controller\HomeController::indexAction")->bind(
    'home');

// Article details with comments
$app->match('/article/{id}', 
    "SimpleMVCProject\Controller\HomeController::articleAction")->bind('article');

// Login form
$app->get('/login', "SimpleMVCProject\Controller\HomeController::loginAction")->bind(
    'login');

// Admin home page
$app->get('/admin', "SimpleMVCProject\Controller\AdminController::indexAction")->bind(
    'admin');

// Add a new article
$app->match('/admin/article/add', 
    "SimpleMVCProject\Controller\AdminController::addArticleAction")->bind(
    'admin_article_add');

// Edit an existing article
$app->match('/admin/article/{id}/edit', 
    "SimpleMVCProject\Controller\AdminController::editArticleAction")->bind(
    'admin_article_edit');

// Remove an article
$app->get('/admin/article/{id}/delete', 
    "SimpleMVCProject\Controller\AdminController::deleteArticleAction")->bind(
    'admin_article_delete');

// Edit an existing comment
$app->match('/admin/comment/{id}/edit', 
    "SimpleMVCProject\Controller\AdminController::editCommentAction")->bind(
    'admin_comment_edit');

// Remove a comment
$app->get('/admin/comment/{id}/delete', 
    "SimpleMVCProject\Controller\AdminController::deleteCommentAction")->bind(
    'admin_comment_delete');

// Add a new user
$app->match('/admin/user/add', 
    "SimpleMVCProject\Controller\AdminController::addUserAction")->bind(
    'admin_user_add');

// Edit an existing user
$app->match('/admin/user/{id}/edit', 
    "SimpleMVCProject\Controller\AdminController::editUserAction")->bind(
    'admin_user_edit');

// Remove a user
$app->get('/admin/user/{id}/delete', 
    "SimpleMVCProject\Controller\AdminController::deleteUserAction")->bind(
    'admin_user_delete');

// API: get all article
$app->get('/api/articles', 
    "SimpleMVCProject\Controller\ApiController::getArticlesAction")->bind(
    'api_articles');

// API: get an article
$app->get('/api/article/{id}', 
    "SimpleMVCProject\Controller\ApiController::getArticleAction")->bind(
    'api_article');

// API: Create a new article
$app->post('api/article', 
    "SimpleMVCProject\Controller\ApiController::addArticleAction")->bind(
    'api_article_add');

// API: delete an existing article
$app->delete('api/article/{id}', 
    "SimpleMVCProject\Controller\ApiController::deleteArticleAction")->bind(
    'api_article_delete');