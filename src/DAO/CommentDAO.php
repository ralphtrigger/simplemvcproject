<?php

/*
 * Copyright 2017 trigger.
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

use SimpleMVCProject\Domain\Comment;

/**
 * Description of CommentDAO
 *
 * @author trigger
 */
class CommentDAO extends DAO {

    /**
     * @var ArticleDAO
     */
    private $articleDAO;

    public function setArticleDAO($articleDAO) {
        $this->articleDAO = $articleDAO;
    }

    public function findAllByArticle($articleId) {
        // The associated article
        $article = $this->articleDAO->find($articleId);
        
        $sql = "select com_id, com_content, com_author from comment "
                . "where art_id=? order by com_id";
        
        $result = $this->getDB()->fetchAll($sql, array($articleId));
        
        // Convert query result to an array domain objects.
        $comments = array();
        foreach ($result as $row) {
            $commentId = $row['com_id'];
            $comment = $this->buildObjectDomain($row);
            // The associated article
            $comment->setArticle($article);
            $comments[$commentId] = $comment;
        }
        
        return $comments;
    }

    /**
     * Create an comment object base on a DB row.
     * 
     * @param array $row The DB row containing Comment data.
     * @return \SimpleMVCProject\Domain\Comment
     */
    protected function buildObjectDomain(array $row) {
        $comment = new Comment();
        $comment->setId($row['com_id']);
        $comment->setAuthor($row['com_author']);
        $comment->setContent($row['com_content']);
        
        if(array_key_exists('art_id', $row)){
            // Find and set the appropriate article
            $articleId = $row['art_id'];
            $article = $this->articleDAO->find($articleId);
            $comment->setArticle($article);
        }
        
        return $comment;
    }

}
