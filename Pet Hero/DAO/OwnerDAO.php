<?php
    namespace DAO;

    use DAO\IOwnerDAO as IOwnerDAO;
    use Models\Owner as Owner;
    use Models\Pet as Pet;
    use Models\Location as Location;

    class OwnerDAO implements IOwnerDAO
    {
        private $ownerList = array();

        function Add(Owner $owner)
        {
            $this->RetrieveData();

            $owner->setId($this->GetNextId());

            array_push($this->ownerList, $owner);

            $this->SaveData();
        }

        function GetAll()
        {
            $this->RetrieveData();

            return $this->ownerList;
        }

        function GetById($id)
        {
            $this->RetrieveData();

            $owner = array_filter($this->ownerList, function($owner) use($id){
                return $owner->getId() == $id;
            });

            $owner = array_values($location); 

            return (count($location) > 0) ? $location[0] : null;
        }

        function Remove($id)
        {
            $this->RetrieveData();

            $this->ownerList = array_filter($this->ownerList, function($owner) use($id){
                return $owner->getCode() != $id;
            });

            $this->SaveData();
        }

        private function RetrieveData()
        {
             
        }

        private function SaveData()
        {
           
        }

        
    }


?>