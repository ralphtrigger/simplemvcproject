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

use Exception;
use SimpleMVCProject\Domain\User;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Description of UserDAO
 *
 * @author trigger
 */
class UserDAO extends DAO implements UserProviderInterface {

    /**
     * Return a user matching the supplied id.
     * 
     * @param integer $id The user id.
     * @return \SimpleMVCProject\Domain\User
     * @throws Exception If no matching user is found.
     */
    public function find($id) {
        $sql = "select * from t_user where usr_id=?";
        $row = $this->getDB()->fetchAssoc($sql, array($id));

        if ($row) {
            return $this->buildObjectDomain($row);
        } else {
            throw new Exception("No user matching id " . $id);
        }
    }

    /**
     * Create User object base on a DB row.
     * 
     * @param array $row The DB row containing User data
     * @return \SimpleMVCProject\Domain\User
     */
    protected function buildObjectDomain(array $row) {
        $user = new User();
        $user->setId($row['usr_id']);
        $user->setUsername($row['usr_name']);
        $user->setPassword($row['usr_password']);
        $user->setSalt($row['usr_salt']);
        $user->setRole($row['usr_role']);
        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($username): UserInterface {
        $sql = "select * from t_user where usr_name=?";
        $row = $this->getDB()->fetchAssoc($sql, array($username));

        if ($row) {
            return $this->buildObjectDomain($row);
        } else {
            throw new UsernameNotFoundException(
                    sprintf('User "%s" not found', $username));
        }
    }

    /**
     * {@inheritDoc}
     */
    public function refreshUser(UserInterface $user): UserInterface {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(
                    sprintf('Instances of "%s" are not supported', $class));
        } else {
            return $this->loadUserByUsername($user->getUsername());
        }
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class): bool {
        return 'SimpleMVCProject\Domain\User' === $class;
    }

}
