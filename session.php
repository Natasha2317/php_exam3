<?php
    $a = $_GET['a'];
    $mysqli = mysqli_connect('std-mysql', 'std_946_php', '12345678', 'std_946_php');
        if( mysqli_connect_errno() ) // проверяем корректность подключения
            echo 'Ошибка подключения к БД: '.mysqli_connect_error();
    $sql_res=mysqli_query($mysqli, "SELECT question, questions.id, type FROM questions JOIN sessions2 ON questions.id_session = sessions2.id WHERE link='$a'");
    $row = mysqli_fetch_assoc($sql_res);
    switch ($row['type']) {

        case 1:
            echo '
        <form name="form_q" method="post" action="answer.php">
        <label for="q">'.$row['question'].' (тип вопроса 1)</label>
        <input type="number" name="answer" id="q" required autofocus><br>
        <input type="submit" name="buttonan" value="Ответить">
        <textarea style="display:none" type="number" name="id">'.$row['id'].'</textarea>
        </form>';
            break;
        case 2:
            echo '
        <form name="form_q" method="post" action="answer.php">
        <label for="q">'.$row['question'].' (тип вопроса 2)</label>
        <input type="number" min="0" name="answer" id="q" required autofocus><br>
        <textarea style="display:none" type="number" name="id">'.$row['id'].'</textarea>
        <input type="submit" name="buttonan" value="Ответить">
        </form>';
            break;
        case 3:
            echo '
        <form name="form_q" method="post" action="answer.php">
        <label for="q">'.$row['question'].' (тип вопроса 3)</label>
        <input type="text" maxlength="30" name="answer" id="q" required autofocus><br>
        <textarea style="display:none" type="number" name="id">'.$row['id'].'</textarea>
        <input type="submit" name="buttonan" value="Ответить">
        </form>';
            break;
            case 4:
                echo '
        <form name="form_q" method="post" action="answer.php">
        <label for="q">'.$row['question'].' (тип вопроса 4)</label>
        <textarea type="text" maxlength="255" name="answer" id="q" required autofocus></textarea><br>
        <textarea style="display:none" type="number" name="id">'.$row['id'].'</textarea>
        <input type="submit" name="buttonan" value="Ответить">
        </form>';
                break;
        default:
            echo 'Сессия не существует или закрыта администратором';
        };

?>


<?php session_start();
    $num = (isset($_SESSION['num'])) ? $_SESSION['num']:0;
    $num++;
    $_SESSION['num'] = $num;
?>
