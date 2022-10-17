<?php
    namespace Pettype;

    class Pettype
    {
        private $id;
        private $description;

        function getId()
        {
            return $this->id;
        }

        function setId($id)
        {
            $this->id = $id;
        }

        function getDescription()
        {
            return $this->description;
        }

        function setDescription($description)
        {
            $this->description = $description;
        }
    }

?>