<?php
    namespace DAO;

    use DAO\ISizeDAO as ISizeDAO;
    use Models\Size as Size;

    class SizeDAO implements ISizeDAO
    {
        private $sizeList = array();

        function Add(Size $size)
        {
            $this->RetrieveData();

            array_push($this->sizeList, $size);

            $this->saveData();
        }

        function GetAll()
        {
            $this->RetrieveData;

            return $this->sizeList;
        }

        function GetById($id)
        {
            $this->RetrieveData();

            $sizes = array_values($sizes);

            return (count($sizes) > 0) ? $sizes[0] : null;
            
        }

        function Remove($id)
        {
            $this->RetrieveData();

            $this->sizeList = array_filter($this->sizeList, function($size) use($id){
                return $size->getCode() != $id;
            });

            $this->SaveData();
        }

        private function RetrieveData()
        {
            $this->sizeList = array();
            // Terminar luego
        }

        private function SaveData()
        {
            //terminar Luego
        }

        

        
    }



?>