
<table style="text-align:center;">
    <thead>
        <tr>
            <th style="width: 15%;">Id</th>
            <th style="width: 30%;">Name</th>
        </tr>
    </thead>
    <tbody>
    <?php
    foreach($sizeList as $size){ ?>
        <tr>
            <td><?php echo $size->getId() ?></td>
            <td><?php echo $size->getName() ?></td>
        </tr>
    <?php 
    } ?>                          
    </tbody>
</table>