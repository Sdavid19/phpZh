<?php
    $taj = $_GET["taj"];
    $reg = json_decode(file_get_contents("data.json"), true);
    if(!isset($_GET["taj"])){
        header("location: index.php");
        exit();
    }

    $r = $reg[$taj];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    Teljes Név: <?= $r["fullname"] ?><br>
    Email: <?= $r["email"] ?><br>
    Taj: <?= $r["taj"] ?><br>
    Nem: <?= $r["gender"] ?><br>
    Dátum:  <?= $r["regdate"] ?><br>
    Megjegyzés: <?= $r["notes"] ?><br>
    <a href="delete.php?taj=<?= $taj ?>">Törlés</a> 
    <a href="index.php">Kezdőlap</a>
</body>
</html>