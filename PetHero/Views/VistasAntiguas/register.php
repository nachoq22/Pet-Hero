<head>
    <title>Logear</title>
</head>
<body>
        <form action="<?php echo FRONT_ROOT."/Home/Register" ?>" method="post">
        User
        <input type="text" name="userName" >
        <br>
        Contraseña
        <input type="password" name="password">
        <br>
        Email
        <input type="email" name="email">
        <br>
        <input type="submit" class="btn" value="Agregar" style="background-color:#DC8E47;color:white;"/>
        <br>
        <button type="reset">Reset</button>
        </form> 
        Eliminar usuario
        <form action="<?php echo FRONT_ROOT."/Home/DeleteUser" ?>" method="post">
        <input type="number" name="id">
        <input type="submit" class="btn" value="Agregar" style="background-color:#DC8E47;color:white;"/>
        </form>
        
        
</body>
