<?php
    namespace DAO;

    use Models\Owner as Owner;

    interface IOwnerDAO
    {
        function Add(Owner $Owner);
        function GetAll();
        function GetById($id);
        function Remove($id);
    }

?>