
<table style="text-align:center;">
    <thead>
        <tr>
            <th style="width: 15%;">Adress</th>
            <th style="width: 30%;">Neighborhood</th>
            <th style="width: 30%;">City</th>
            <th style="width: 15%;">Province</th>
            <th style="width: 10%;">Country</th>
        </tr>
    </thead>
    <tbody>
    <?php
    foreach($locationList as $location){ ?>
        <tr>
            <td><?php echo $location->getAdress() ?></td>
                <td><?php echo $location->getNeighborhood() ?></td>
                <td><?php echo $location->getCity() ?></td>
                <td><?php echo $location->getProvince() ?></td>
                <td><?php echo $location->getCountry() ?></td>
        </tr>
    <?php 
    } ?>                          
    </tbody>
</table>