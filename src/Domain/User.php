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

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Description of User
 *
 * @author trigger
 */
class User implements UserInterface {

    /**
     * User id.
     * 
     * @var integer
     */
    private $id;

    /**
     * User name.
     * 
     * @var string
     */
    private $username;

    /**
     * User password.
     * 
     * @var string
     */
    private $password;

    /**
     * Salt that was originally use to encode the password.
     * 
     * @var string
     */
    private $salt;

    /**
     * Role.
     * Values : ROLE_USER or ROLE_ADMIN.
     * @var string
     */
    private $role;

    public function getId() {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @inheritDoc
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @inheritDoc
     */
    public function getSalt() {
        return $this->salt;
    }

    public function getRole() {
        return $this->role;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }

    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    public function setSalt($salt) {
        $this->salt = $salt;
        return $this;
    }

    public function setRole($role) {
        $this->role = $role;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRoles() {
        return array($this->getRole());
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials() {
        
    }

}
