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

namespace SimpleMVCProject\DAO;

use Doctrine\DBAL\Connection;
use SimpleMVCProject\Domain\Article;

/**
 * Description of ArticleDAO
 *
 * @author trigger
 */
class ArticleDAO extends DAO {

    /**
     * Return a list of all articles, sorted by date (most recent first).
     * 
     * @return array A list of all article
     */
    public function findAll() {
        $sql = "select * from article order by art_id desc";
        $result = $this->getDB()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $articles = array();
        foreach ($result as $row) {
            $articleId = $row['art_id'];
            $articles[$articleId] = $this->buildObjectDomain($row);
        }

        return $articles;
    }

    /**
     * Return an article matching the supplied id.
     * 
     * @param integer $id
     * @return \SimpleMVCProject\Domain\Article
     * @throws Exception if no matching article is found
     */
    public function find($id) {
        $sql = "select * from article where art_id=?";
        $row = $this->getDB()->fetchAssoc($sql, array($id));

        if ($row) {
            return $this->buildObjectDomain($row);
        } else {
            throw new Exception("No article matching id " . $id);
        }
    }

    /**
     * Create an article object base on a DB row.
     * 
     * @param array $row The DB row containing Article data.
     * @return \SimpleMVCProject\Domain\Article
     */
    protected function buildObjectDomain(array $row) {
        $article = new Article();
        $article->setId($row['art_id']);
        $article->setTitle($row['art_title']);
        $article->setContent($row['art_content']);
        return $article;
    }

}
