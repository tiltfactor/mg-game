<?php if ($games) : ?> 
  <table>
    <thead>
      <tr>
        <th>Game</th>
        <?php foreach ($games as $game) : ?>
            <th><?php echo $game->name; ?></th>
        <?php endforeach; ?>
      </tr>
    </thead>
    <tbody>
      <tr>
          <td>Total points</td>
          <?php foreach ($games as $game) : ?>
              <td><?php echo $game->score; ?></td>
          <?php endforeach; ?>
      </tr>
      <tr>
          <td>Total games</td>
          <?php foreach ($games as $game) : ?>
              <td><?php echo $game->number_played; ?></td>
          <?php endforeach; ?>
      </tr>
    </tbody>
  </table>
<?php else : ?>
  <p>You have not finished any games yet.</p>
<?php endif; ?>
