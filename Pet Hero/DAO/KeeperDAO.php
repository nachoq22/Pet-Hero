<?php
    namespace DAO;

    use DAO\IKeeper as IKeeper;
    use Models\Keeper as Keeper;
    use Models\Location as Location;

    class KeeperDAO implements IKeeperDAO
    {
        private $keeperList = array();

        function Add(Keeper $keeper)
        {
            $this->RetrieveData();

            array_push($this->keeperList, $keeper);

            $this->saveData();
        }

        function GetAll()
        {
            $this->RetrieveData;

            return $this->keeperList;
        }

        function GetById($id)
        {
            $this->RetrieveData();

            $keeper = array_values($keeper);

            return (count($keeper) > 0) ? $keeper[0] : null;
            
        }

        function Remove($id)
        {
            $this->RetrieveData();

            $this->keeperList = array_filter($this->keeperList, function($keeper) use($id){
                return $keeper->getCode() != $id;
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