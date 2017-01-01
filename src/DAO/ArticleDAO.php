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

namespace simplemvcproject\DAO;

use Doctrine\DBAL\Connection;
use simplemvcproject\Domain\Article;

/**
 * Description of ArticleDAO
 *
 * @author trigger
 */
class ArticleDAO {
    /**
     * Database Connection.
     * 
     * @var \Doctrine\DBAL\Connection
     */
    private $db;

    /**
     * Constructor.
     * 
     * @param \Doctrine\DBAL\Connection $db
     */
    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Return a list of all articles, sorted by date (most recent first).
     * 
     * @return array A list of all article
     */
    public function findAll() {
        $sql = "select * from article order by art_id desc";
        $result = $this->db->fetchAll($sql);

        // Convert query result to an array of domain objects
        $articles = array();
        foreach ($result as $row) {
            $articleId = $row['art_id'];
            $articles[$articleId] = $this->buildArticle($row);
        }

        return $articles;
    }

    /**
     * Create an article object base on a DB row.
     * 
     * @param array $row The DB row containing Article data.
     * @return \simplemvcproject\Domain\Article
     */
    private function buildArticle(array $row) {
        $article = new Article();
        $article->setId($row['art_id']);
        $article->setTitle($row['art_title']);
        $article->setContent($row['art_content']);
        return $article;
    }

}
