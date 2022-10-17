<?php
    namespace DAO;

    use Models\Size as Size;

    interface ISizeDAO
    {
        function Add(Size $Size);
        function GetAll();
        function GetById($id);
        function Remove($id);
    }

?>