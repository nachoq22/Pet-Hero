<?php
    namespace DAO;

    use DAO\IPetDAO as IPetDAO;
    use Models\Pet as Pet;
    use Models\Size as Size;

    class PetDAO implements IPetDAO
    {
        private $petList = array();

        function Add(Dog $pet)
        {
            $this->RetrieveData();

            array_push($this->petList, $pet);

            $this->saveData();
        }

        function GetAll()
        {
            $this->RetrieveData;

            return $this->petList;
        }

        function GetById($id)
        {
            $this->RetrieveData();

            $pets = array_values($pets);

            return (count($pets) > 0) ? $pets[0] : null;
            
        }

        function Remove($id)
        {
            $this->RetrieveData();

            $this->petList = array_filter($this->petList, function($pet) use($id){
                return $pet->getCode() != $id;
            });

            $this->SaveData();
        }

        private function RetrieveData()
        {
            $this->beerList = array();
            // Terminar luego
        }

        private function SaveData()
        {
            //terminar Luego
        }

    }



?>