<?php if ($games) : ?>

  <table>
    <thead>
      <tr>
        <th>Game</th>
        <?php foreach ($games as $game) : ?>
            <th><?php echo $game->unique_id; ?></th>
        <?php endforeach; ?>
      </tr>
    </thead>
    <tbody>
    <?php for ($x=1;$x<=5;$x++):?>
        <tr>
            <td><?php echo $x;?></td>
                <?php foreach ($topscore as $gamescores) : ?>

                    <?php if( count($gamescores)>=$x AND $gamescores!== 0){?>
                        <td><?php echo $gamescores[$x-1]->score; ?>
                            (<?php echo $gamescores[$x-1]->username?>)</td>
                    <?php }else{ ?>
                        <td></td>
                    <?php } ?>
                <?php endforeach; ?>
        </tr>
    <?php endfor?>
    </tbody>
  </table>
<?php else : ?>
  <p>No high scores available</p>
<?php endif; ?>