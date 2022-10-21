<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    Bienvenido
    <form action="<?php echo FRONT_ROOT."/Location/Add" ?>" method="post" style="background-color: #EAEDED;padding: 2rem !important;">
          <table> 
            <thead>              
              <tr>
                <th>Adress</th>
                <th>Neighborhood</th>
                <th>city</th>
                <th>province</th>
                <th>Country</th>                
              </tr>
            </thead>

              <tr>
                <td style="max-width: 120px;">    
                  <input type="text" name="Adress" required>
                </td>
                <td>
                  <input type="text" name="Neighborhood"  required>
                </td>
                <td>
                  <input type="text" name="City" required>
                </td>
                <td>
                  <input type="text" name="Province" required>
                </td>                
                <td>
                  <input type="text" name="Country" required>
                </td>            
              </tr>

          </table>
          <div>
            <input type="submit" class="btn" value="Agregar" style="background-color:#DC8E47;color:white;"/>
          </div>
        </form>
</body>
</html>