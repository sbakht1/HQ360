<?php $role = user_data('Title')[1];?>
<?php if ($role !== 'inventory' && $role !== 'it') : ?>
<div class="actions">
    <?= btn([current_url().'/new','Add New','primary']); ?>
    <?= btn([current_url().'/form','Edit Form','outline-primary']); ?>
</div>
<?php endif; ?>
<?= card('start');?>
    <table class="table">
        <thead>
            <th>Date</th>
            <th>Employee</th>
            <th>Store</th>
            <th>Interaction Type</th>
            <th>AT&T Score</th>
            <th>TWE Score</th>
            <th></th>
        </thead>
        <tbody>
        <?php foreach($observations as $obs): $detail = json_decode($obs->detail);?>
            <tr>
                <td><span class="moment" data-time="<?= $obs->date; ?>" data-form="ll"></span></td>
                <td><?= $obs->employee ?></td>
                <td><?= $obs->store ?></td>
                <td><?= $obs->interaction_type ?></td>
                <td>
                    <span class="text-<?= $detail->atntScore[3];?>"><?= $detail->atntScore[0].' / '.$detail->atntScore[1].' '.$detail->atntScore[2]; ?></span>
                </td>
                <td>
                    <span class="text-<?= $detail->tweScore[3];?>"><?= $detail->tweScore[0].' / '.$detail->tweScore[1].' '.$detail->tweScore[2]; ?></span>
                </td>
                <th>
                    <?= table_btn([user_data('Title')[1].'/observations/'.$obs->id,'More Detail','primary']); ?>
                </th>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
<?= card('end');?>