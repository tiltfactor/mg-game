<?php
/**
 * Created by PhpStorm.
 * User: katy
 * Date: 4/17/14
 * Time: 5:35 PM
 */
?>
<table>
    <?php if($scores!=0){?>
    <thead>
    <tr>
        <th>   </th>
        <th>Scrore</th>
        <th>Player</th>
    </tr>
    </thead>
    <tbody>

        <?php for ($x=1;$x<5;$x++):?>
            <tr>
                <td><?php echo $x;?></td>
                <?php if( count($scores)>=$x AND $scores!== 0){?>
                    <td><?php echo $scores[$x-1]->score; ?></td>
                    <td><?php echo $scores[$x-1]->username;?></td>
                <?php }else{ ?>
                    <td></td>
                <?php } ?>
            </tr>
        <?php endfor?>
    <?php }else{
        echo("no scores");
    }?>
    </tbody>
</table>


