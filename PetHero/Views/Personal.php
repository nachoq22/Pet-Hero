<head>
    <title>Ingresar personal Data</title>
</head>
<body>
        <form action="<?php echo FRONT_ROOT."/Keeper/AddPersonalData" ?>" method="post">
        Nombre
        <input type="text" name="name" >
        <br>
        Apellido
        <input type="text" name="surname">
        <br>
        Sexo
        <input type="text" name="sex">
        <br>
        Dni
        <input type="text" name="dni">
        <br>
        <!--Domicilio
        <input type="text" name="adress">
        <br>
        Barrio
        <input type="text" name="neighborhood">
        <br>
        Ciudad
        <input type="text" name="city">
        <br>
        provincia
        <input type="text" name="province">
        <br>
        pais
        <input type="text" name="country">
        <br>-->
        <input type="submit" class="btn" value="Ingresar" style="background-color:#DC8E47;color:white;"/>
        <br>
        <button type="reset">Reset</button>
        
        </form> 
</body>

