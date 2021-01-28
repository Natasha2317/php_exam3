<?php session_start();
    $num = (isset($_SESSION['num'])) ? $_SESSION['num']:0;
    $num++;
    $_SESSION['num'] = $num;
?>
<!doctype html>
<html leng="EN">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="style.css?<?php echo time();?>">
  	<link href="https://fonts.googleapis.com/css?family=PT+Sans|Playfair+Display+SC" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
    <header>
    </header>
    <main>

    <?php

    if (!isset($_POST['password']) || ($_POST['password']) !== '12345'){

        echo'<div class="form">
        <h3>Вход для администратора</h3>
            <form action="" method="post">
            <div class="form__name">
                <label for="password">Пароль</label>
                <input type="text" name="password" id="password" placeholder="Введите пароль"><br>
            </div>
            <div class="form__name_button">
                <input type="submit" value="Войти" class="form__button">
            </div>
            </form>
        </div>';
        }
    else include 'create.php';
    ?>
    </main>
</body>
</html>
