<?php
session_start();
?>
<html>

<head>
    <title>Codding Challenge</title>
    <script src="assets/js/jquery.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <div class="blk">
        <form action="server-includes/upload-json.php" method="post" enctype="multipart/form-data">
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
</body>
</html>