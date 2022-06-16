<?php
session_start();
include_once('includes/Database.php')
?>
<html>

<head>
    <title>Codding Challenge</title>
    <script src="assets/js/jquery.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <div class="blk">
        <form action="includes/upload-json.php" method="post" enctype="multipart/form-data">
            <?php if (isset($_SESSION['error'])) : ?>
                <div class="error"><?= $_SESSION['error'] ?></div>
                <?php unset($_SESSION['error']); ?>
            <?php endif ?>
            <?php if (isset($_SESSION['success'])) : ?>
                <div class="success"><?= $_SESSION['success'] ?></div>
                <?php unset($_SESSION['success']); ?>
            <?php endif ?>
            <div class="inside">
                <label for="file">Filename:</label><br><br>
                <input type="file" name="json_file" id="json_file" /><br><br>
                <button type="submit" class="btn">Upload</button>
            </div>
        </form>
        <?php $rows = $mysql_obj->get_rows() ?>
        <?php if (count($rows)) : ?>
            <table width="100%" border="1" id="table_records">
                <thead>
                    <th>Sr #</th>
                    <th>Employee Name</th>
                    <th>Employee Email</th>
                    <th>Event Name</th>
                    <th>Participant Fee</th>

                </thead>
                <tbody>
                    <?php $total_fee = 0; ?>
                    <?php foreach ($rows as $key => $row) : ?>
                        <?php $total_fee += $row['participation_fee']; ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><?= $row['employee_name'] ?></td>
                            <td><?= $row['employee_mail'] ?></td>
                            <td> <?= $row['event_name'] ?></td>
                            <td><?= $row['participation_fee'] ?></td>
                        </tr>
                    <?php endforeach ?>
                    <tr>
                        <td colspan="4">
                            <p style="float: right ">Total Fee:</p>
                        </td>
                        <td colspan=""><?= $total_fee ?></td>
                    </tr>
                </tbody>
            </table>
        <?php endif ?>
</body>
</html>