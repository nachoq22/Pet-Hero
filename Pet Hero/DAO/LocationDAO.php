<?php
    namespace DAO;

    use DAO\ILocationDAO as ILocationDAO;
    use Models\Location as Location;

    class LocationDAO implements ILocationDAO
    {
        private $locationList = array();

        function Add(Location $location)
        {
            $this->RetrieveData();

            $location->setId($this->GetNextId());

            array_push($this->locationList, $location);

            $this->SaveData();
        }

        function GetAll()
        {
            $this->RetrieveData();

            return $this->locationList;
        }

        function GetById($id)
        {
            $this->RetrieveData();

            $owner = array_filter($this->locationList, function($location) use($id){
                return $location->getId() == $id;
            });

            $location = array_values($location); 

            return (count($location) > 0) ? $location[0] : null;
        }

        function Remove($id)
        {
            $this->RetrieveData();

            $this->locationList = array_filter($this->locationList, function($location) use($id){
                return $location->getCode() != $id;
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