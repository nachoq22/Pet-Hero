<?php
    namespace Models;

    class User
    {
        private $id;
        private $username;
        private $password;
        private $email;

        function getId()
        {
            return $this->id;
        }

        function setId($id)
        {
            $this->id = $id;
        }

        function getUsername()
        {
            return $this->username;
        }

        function setUsername($username)
        {
            $this->username = $username;
        }

        function getPassword()
        {
            return $this->password;
        }

        function setPassword($password)
        {
            $this->password = $password;
        }

        function getEmail()
        {
            return $this->email;
        }

        function setEmail($email)
        {
            $this->email = $email;
        }

    }


?>