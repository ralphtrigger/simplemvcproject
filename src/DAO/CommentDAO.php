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
namespace SimpleMVCProject\DAO;

use SimpleMVCProject\Domain\Comment;

/**
 * Description of CommentDAO
 *
 * @author trigger
 */
class CommentDAO extends DAO
{

    /**
     *
     * @var \SimpleMVCProject\DAO\ArticleDAO
     */
    private $articleDAO;

    /**
     *
     * @var \SimpleMVCProject\DAO\UserDAO
     */
    private $userDAO;

    /**
     * Create an comment object base on a DB row.
     *
     * @param array $row
     *            The DB row containing Comment data.
     * @return Comment
     */
    protected function buildObjectDomain(array $row)
    {
        $comment = new Comment();
        $comment->setId($row['com_id']);
        $comment->setContent($row['com_content']);
        
        if (array_key_exists('art_id', $row)) {
            // Find and set the appropriate article
            $articleId = $row['art_id'];
            $article = $this->articleDAO->find($articleId);
            $comment->setArticle($article);
        }
        
        if (array_key_exists('usr_id', $row)) {
            // Find and set the appropriate author
            $userId = $row['usr_id'];
            $user = $this->userDAO->find($userId);
            $comment->setAuthor($user);
        }
        
        return $comment;
    }

    public function setArticleDAO($articleDAO)
    {
        $this->articleDAO = $articleDAO;
    }

    public function setUserDAO(UserDAO $userDAO)
    {
        $this->userDAO = $userDAO;
    }

    public function findAllByArticle($articleId)
    {
        // The associated article
        $article = $this->articleDAO->find($articleId);
        
        $sql = "select com_id, com_content, usr_id from comment " .
             "where art_id=? order by com_id";
        
        $result = $this->getDB()->fetchAll($sql, 
            array(
                $articleId
            ));
        
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
    public function save(Comment $comment)
    {
        $commentData = array(
            'art_id' => $comment->getArticle()->getId(),
            'usr_id' => $comment->getAuthor()->getId(),
            'com_content' => $comment->getContent()
        );
        
        if ($comment->getId()) {
            // The comment has already been saved : update it
            $this->getDB()->update('comment', $commentData, 
                array(
                    'com_id' => $comment->getId()
                ));
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
     * Returns a list of all comments, sorted by date (most recent first).
     *
     * @return array The list of comments.
     */
    public function findAll()
    {
        $sql = "select * from comment order by com_id desc";
        $result = $this->getDB()->fetchAll($sql);
        // Convert query result to an array of domain object
        $entities = array();
        foreach ($result as $row) {
            $id = $row['com_id'];
            $entities[$id] = $this->buildObjectDomain($row);
        }
        return $entities;
    }

    /**
     * Removes all comments for an article.
     *
     * @param integer $articleId            
     */
    public function deleteAllByArticle($articleId)
    {
        $this->getDB()->delete('comment', 
            array(
                'art_id' => $articleId
            ));
    }

    /**
     * Returns a comment matching the supplied id.
     *
     * @param integer $id
     *            The comment id.
     * @throws \Exception
     * @return \SimpleMVCProject\Domain\Comment
     */
    public function find($id)
    {
        $sql = "select * from comment where com_id=?";
        $row = $this->getDB()->fetchAssoc($sql, array(
            $id
        ));
        
        if ($row) {
            return $this->buildObjectDomain($row);
        } else {
            throw new \Exception('No comment matching id ' . $id);
        }
    }

    /**
     * Removes a comment from the database.
     *
     * @param integer $id
     *            The comment id.
     */
    public function delete($id)
    {
        // Delete the comment
        $this->getDB()->delete('comment', 
            array(
                'com_id' => $id
            ));
    }

    /**
     * Removes all the comments for a user.
     *
     * @param integer $userId
     *            The user id.
     */
    public function deleteAllByUser($userId)
    {
        $this->getDB()->delete('comment', 
            array(
                'usr_id' => $userId
            ));
    }
}
