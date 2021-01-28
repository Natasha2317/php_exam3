<?php
    $answer = $_POST['answer'];
    $id = $_POST['id'];
    $date = date("d.m.Y H-i:s");
    $ip = $_SERVER['REMOTE_ADDR'];
    $mysqli = mysqli_connect('std-mysql', 'std_946_php', '12345678', 'std_946_php');
        if( mysqli_connect_errno() ) // проверяем корректность подключения
            echo 'Ошибка подключения к БД: '.mysqli_connect_error();
        $sql_res=mysqli_query($mysqli, "INSERT INTO answers(answer, question_id, date, ip) VALUES ('$answer', $id, '$date', '$ip')");
        if (!$sql_res)
            echo '<div class="error">При создании ответа произошла ошибка '.mysqli_errno($mysqli).'. Повторите попытку</div>';
        else // если все прошло нормально – выводим сообщение
            echo '<p>Спасибо, мы зачли ваш ответ!</p>';
?>