<?php
    $fullname = $_POST['fullname'] ?? '';
    $email = $_POST['email'] ?? '';
    $taj = $_POST['taj'] ?? '';
    $age = $_POST['age'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $accept = $_POST['accept'] ?? false;
    $accept = filter_var($accept, FILTER_VALIDATE_BOOLEAN);
    $regdate = $_POST['regdate'] ?? date('Y-m-d H:m:s');
    $notes = $_POST['notes'] ??'';
    $errors = [];

    if(count($_POST) > 0){
        if(trim($fullname) === ''){
            $errors['fullname'] = "A név megadása kötelező!";
        } else{
            $words = explode(" ", $fullname);
            if(count($words) < 2){
                $errors["fullname"] = "Legalább két szó!";
            }
        }

        if(trim($email) === ''){
            $errors['email'] = 'Email megadása kötelező!';
        } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'Érvényes emailt adj meg!';
        }

        if(strlen($taj) != 9){
            $errors['taj'] = 'A TAJ-nak 9 számnak kell lennie!';
        } else{
            $chars = str_split($taj);
            $digits = array_filter($chars, fn($num) => $num >= 0 && $num <= 9);
            if(count($digits) != 9){
                $errors['taj'] = 'Tajszámban csak szám lehet!';
            }   
        }

        if(trim($age) === ''){
            $errors['age'] = 'Életkor megadása kötelező!';
        } else if(filter_var($age, FILTER_VALIDATE_INT) === false){
            $errors['age'] = 'Életkornak számnak kell lennie!';
        } else {
            $age = intval($age);
            if($age < 1){
                $errors['age'] = 'Az életkornak pozitívnak kell lennie!';
            }
        }

        if(trim($gender) === ''){
            $errors['gender'] = 'Gender megadása kötelező!';
        } else if($gender != 'm' && $gender != 'f'){
            $errors['gender'] = 'Férfi vagy nőnek kell lennie!';
        }

        if(!$accept){
            $errors['accept'] = 'Fogadd el a feltételeket!';
        }

        if(count($errors) == 0){
            $reg = json_decode(file_get_contents('data.json'), true);
            
            $reg[$taj] = [
                "fullname" => $fullname,
                "email" => $email,
                "taj" => $taj,
                "age" => $age,
                "gender" => $gender,
                "regdate" => $regdate,
                "notes" => $notes
            ];

            file_put_contents("data.json", json_encode($reg, JSON_PRETTY_PRINT));
        }
    }

?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pelda</title>
</head>
<body>
    <form action="reg.php" method="post">
        Teljes név: <input type="text" name="fullname" value="<?= $fullname ?>"><br>
        E-mail: <input type="text" name="email" value="<?= $email ?>"><br>
        TAJ: <input type="text" name="taj" value="<?= $taj?>" ><br>
        Életkor: <input type="text" name="age" value="<?= $age ?>"><br>
        Nem:
            <input type="radio" name="gender" value="m" <?= $gender === 'm' ? 'checked' : '' ?> >Férfi
            <input type="radio" name="gender" value="f" <?= $gender === 'f' ? 'checked' : '' ?>>Nő <br>
        <input type="checkbox" name="accept" <?= $accept ? 'checked' : '' ?>><br>
        Regisztráció dátuma: <input type="date" name="regdate" value="<?= $regdate ?>"><br>
        Megjegyzés: <br> <textarea name="notes"><?= $notes ?></textarea><br>
        <button type="submit">Regisztráció</button>
    </form>
    <a href="index.php">Vissza a kezdőlapra</a>

    <ul>
        <?php foreach(($errors ?? []) as $e): ?>
            <li><?= $e ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>