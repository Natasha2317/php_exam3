<?php
    // if (isset($_POST['deleteSession']) && isset($_GET['id'])){
    // $id = $_GET['id'];
    // echo $id;
    $mysqli = mysqli_connect('std-mysql', 'std_946_php', '12345678', 'std_946_php');
    if( mysqli_connect_errno() ) // проверяем корректность подключения
        echo 'Ошибка подключения к БД: '.mysqli_connect_error();
    // $sql_res=mysqli_query($mysqli, "SELECT * FROM sessions2 WHERE id=$id");
    // $sql_res=mysqli_query($mysqli, "DELETE FROM sessions2 WHERE id=$id");
    echo $_GET['id'];
    if( isset($_GET['id'])){
        $get_id = $_GET['id'];
        // формируем и выполняем SQL-запрос на удаление записи с указанным id
        $query = $mysqli->query("DELETE FROM sessions2 WHERE id=$get_id");
    };

?>