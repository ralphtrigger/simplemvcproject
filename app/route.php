<?php

/* 
 * Copyright 2016 trigger.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

// Home page
$app->get('/', function(){
    require '../src/model.php';
    
    $articles = getArticles();
    
    ob_start(); // start buffering html output
    
    require '../views/view.php';
    
    $view = ob_get_clean(); // Assign HTML ouput to $view
    
    return $view;
});