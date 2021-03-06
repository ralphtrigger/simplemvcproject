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

function get_articles() {
// Database parameters
    $servername = 'localhost';
    $user = 'test_user';
    $pwd = 'secret';
    $dbname = 'testdb';
    $port = '3306';
// create connection
    $conn = mysqli_connect($servername, $user, $pwd, $dbname, $port);
    if (!$conn) {
        die('Could not connect to MySQL: ' . mysqli_connect_error());
    }
// get articles from database
    $sql = 'select * from article order by art_id desc';
    $articles = mysqli_query($conn, $sql);
// close connection
    mysqli_close($conn);
    return $articles;
}
