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

namespace SimpleMVCProject\Domain;

/**
 * Description of Comment
 *
 * @author trigger
 */
class Comment {
    /**
     * Comment id.
     * 
     * @var integer
     */
    private $id;
    /**
     * Comment author.
     * 
     * @var \SimpleMVCProject\Domain\User
     */
    private $author;
    /**
     * Comment content.
     * 
     * @var string
     */
    private $content;
    /**
     *
     * @var \SimpleMVCProject\Domain\Article
     */
    private $article;

    public function getId() {
        return $this->id;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getContent() {
        return $this->content;
    }

    public function getArticle() {
        return $this->article;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setAuthor(User $author) {
        $this->author = $author;
        return $this;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function setArticle($article) {
        $this->article = $article;
        return $this;
    }

}
