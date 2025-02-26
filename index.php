<?php
    $reg = json_decode(file_get_contents("data.json"), true);
    usort($reg, fn($a, $b) => strcmp($a["fullname"], $b["fullname"]))
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="reg.php">Új regisztráció ipadrol</a>
    <h1>Regisztráltak listája</h1>
    <?php foreach($reg as $r): ?>
        <li><a href="show.php?taj=<?= $r['taj'] ?>"><?= $r["fullname"] ?></a></li>
    <?php endforeach; ?>
</body>
</html>