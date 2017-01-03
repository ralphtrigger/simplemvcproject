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
     * @var \SimpleMVCProject\DAO\ArticleDAO
     */
    private $articleDAO;
    /**
     * @var \SimpleMVCProject\DAO\UserDAO
     */
    private $userDAO;

    public function setArticleDAO($articleDAO) {
        $this->articleDAO = $articleDAO;
    }
    
    public function setUserDAO(UserDAO $userDAO) {
        $this->userDAO = $userDAO;
    }
    
    public function findAllByArticle($articleId) {
        // The associated article
        $article = $this->articleDAO->find($articleId);
        
        $sql = "select com_id, com_content, usr_id from comment "
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
     * Save a comment into the database.
     * 
     * @param \SimpleMVCProject\Domain\Comment $comment
     */
    public function save(Comment $comment) {
        $commentData = array(
            'art_id' => $comment->getArticle()->getId(),
            'usr_id' => $comment->getAuthor()->getId(),
            'com_content' => $comment->getContent()
        );
        
        if($comment->getId()) {
            // The comment has already been saved : update it
            $this->getDB()->update('comment', $commentData, array('com_id' => $comment->getId()));
        } else {
            // The comment has never been saved : insert it
            $this->getDB()->insert('comment', $commentData);
            // Get the id of the newly created comment
            $id = $this->getDB()->lastInsertId();
            // and set it on the entity
            $comment->setId($id);
        }
    }

    /**
     * Create an comment object base on a DB row.
     * 
     * @param array $row The DB row containing Comment data.
     * @return Comment
     */
    protected function buildObjectDomain(array $row) {
        $comment = new Comment();
        $comment->setId($row['com_id']);
        $comment->setContent($row['com_content']);
        
        if(array_key_exists('art_id', $row)){
            // Find and set the appropriate article
            $articleId = $row['art_id'];
            $article = $this->articleDAO->find($articleId);
            $comment->setArticle($article);
        }
        
        if(array_key_exists('usr_id', $row)){
            // Find and set the appropriate author
            $userId = $row['usr_id'];
            $user = $this->userDAO->find($userId);
            $comment->setAuthor($user);
        }
        
        return $comment;
    }

}
