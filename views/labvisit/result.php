
<?php
/* @var $this yii\web\View */
/* @var $data array */

?>

<h1>Lab Results</h1>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>HN</th>
            <th>Visit ID</th>
            <th>Registration Date</th>
            <th>Max Visit</th>
            <th>Max Date</th>
            <th>Staff ID</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $row): ?>
            <tr>
                <td><?= $row['hn'] ?></td>
                <td><?= $row['visit_id'] ?></td>
                <td><?= $row['reg_datetime'] ?></td>
                <td><?= $row['max_visit'] ?></td>
                <td><?= $row['maxdate'] ?></td>
                <td><?= $row['staff_id'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
