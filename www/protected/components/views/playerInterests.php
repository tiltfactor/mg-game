<?php if ($interests) : ?>
<table>
    <thead>
    <tr>
        <th>Game</th>
        <th>Interest</th>
        <th>Created</th>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($interests as $interest) : ?>
    <tr>
        <td><?php echo $interest['unique_id']; ?></td>
        <td><?php echo $interest['interest']; ?></td>
        <td><?php echo $interest['created']; ?></td>
    </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else : ?>
<p>You have not finished any games yet.</p>
<?php endif; ?>
