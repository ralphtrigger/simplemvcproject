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
namespace SimpleMVCProject\Tests;

use Silex\WebTestCase;

/**
 *
 * @author trigger
 *        
 */
class AppTest extends WebTestCase
{
    /**
     * Basic, application-wide functionnal test inspired by Symfony best pratices.
     * Simply check that all applcation URLs load successfully.
     * During test execution, this method is called for each URL returned by the provideUrls method.
     * 
     * @dataProvider provideUrls
     */
    public function testPageIsSuccessful($url)
    {
        $client = $this->createClient();
        $client->request('GET', $url);
        
        $this->assertTrue($client->getResponse()
            ->isSuccessful());
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Silex\WebTestCase::createApplication()
     */
    public function createApplication()
    {
        $app = new \Silex\Application();
        
        require __DIR__ . '/../../app/config/dev.php';
        require __DIR__ . '/../../app/app.php';
        require __DIR__ . '/../../app/route.php';
        
        // Generate raw exception instead of HTML page if errors occurs
        unset($app['exception_handler']);
        // Simulate session for testing
        $app['session.test'] = true;
        // Enable anonymous acces to admin zone
        $app['security.access_rules'] = array();
        
        return $app;
    }

    /**
     * Provides all valid application URLs.
     * 
     * @return string[][] The list of all valid application URLs.
     */
    public function provideUrls()
    {
        return array(
            array('/'),
            array('/article/1'),
            array('/login'),
            array('/admin'),
            array('/admin/article/add'),
            array('/admin/article/1/edit'),
            array('/admin/comment/1/edit'),
            array('/admin/user/add'),
            array('/admin/user/1/edit'),
            array('/api/articles'),
            array('/api/article/1'),
        );
    }
}