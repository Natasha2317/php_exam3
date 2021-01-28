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
<?php
if (!isset($_GET['page']))
$_GET['page'] = 'create';
echo '<div class="menu">
    <a href="create.php?page=create">Создать сессию</a><br>
    <a href="create.php?page=check">Просмотр ответов</a><br>
</div>';
if (isset($_POST['buttoncr'])) {
    $permitted_chars = '0123456789abcdefghijklmnopqr234980stuvwxy90zdkdornzsp49643850vffjndjsdoduirn3645342840rjkddjeu';
    $a = substr(str_shuffle($permitted_chars), 0, 12);
    // $link = 'http://php-exem-sem2.std-953.ist.mospolytech.ru/session.php?a='.$a;
    $link = 'http://localhost/2sem/exam/session.php?a='.$a;
    $_POST['buttoncr'] = '';
    //Подключаем базу данных
    $mysqli = mysqli_connect('std-mysql', 'std_946_php', '12345678', 'std_946_php');
        if( mysqli_connect_errno() ) // проверяем корректность подключения
            echo 'Ошибка подключения к БД: '.mysqli_connect_error();
        //echo $type;
        $sql_res=mysqli_query($mysqli, "INSERT INTO sessions2(link) VALUES ('$a')");

};
if (isset($_POST['buttoncrQ'])) {
        $qes = htmlspecialchars($_POST['question']);
        //echo $qes;
        $type = $_POST['type'];
        $mysqli = mysqli_connect('std-mysql', 'std_946_php', '12345678', 'std_946_php');
        $sql_res=mysqli_query($mysqli, "SELECT id, link FROM sessions2 ORDER BY id DESC LIMIT 1");
        $row = mysqli_fetch_assoc($sql_res);
        $id_session = $row['id'];
        $link = 'http://localhost/2sem/exam/session.php?a='.$row['link'];
        $sql_res=mysqli_query($mysqli, "INSERT INTO questions(question, status, type, id_session) VALUES ('$qes', 'open', $type, $id_session)");
        //, '".htmlspecialchars($_POST['question'])."'
        // если при выполнении запроса произошла ошибка – выводим сообщение
        if (!$sql_res)
            echo '<div class="error">При создании сессии произошла ошибка '.mysqli_errno($mysqli).'. Повторите попытку</div>';
        else
            echo '<p>Сессия успешно создана. Ссылка на сессию: <a href="'.$link.'">'.$link.'</a> </p>';

};
if ($_GET['page'] == 'create' && !isset($_POST['buttoncr'])){
    echo '
        <div class="create">
        <fieldset>
            <legend> Новая сессия </legend>
            <form name="form" method="post" action="">
            <input type="submit" name="buttoncr" value="Создать новую сессию">
        </form></fieldset>
        </div>';
};
if ($_GET['page'] == 'create' && isset($_POST['buttoncr'])){
    echo '
        <div class="create">
        <fieldset>
            <legend> Новая сессия </legend>
            <form name="form" method="post" action="">
            <label for="question">Первый вопрос: </label>
                <input type="text" name="question" id="question" required autofocus><br>
            <label for="question">Тип вопроса: </label>
            <select name="type">
            <option selected value="1">с открытым ответом (число)</option>
            <option value="2">с открытым ответом (положительное число)</option>
            <option value="3">с открытым ответом (строка)</option>
            <option value="4">с открытым ответом (текст)</option>
            <option value="5">
                    с единственным выбором – ответ на вопрос предполагает выбор одного варианта из
                    предложенных (количество вариантов в вопросе может быть любым, но не менее
                    2);
                </option>
                <option value="6">
                    с множественным выбором – ответ на вопрос предполагает выбор одного или
                    нескольких вариантов из предложенных (количество вариантов в вопросе может
                    быть любым, но не менее 3).
                </option>
            </select><br>
            <input type="submit" name="buttoncrQ" value="Добавить">
        </form></fieldset>
        </div>';

};?>
<!-- 
        </div>
        <div class="mb-3 mt-3" id="options-list" style="display: none">
            <input id="options-value" name="options" type="text" style="display: none">
            <span class="mb-2" style="display: flex">Возможные варианты ответа:</span>
            <ul id="options-render">
            </ul>
            <div class="form-group">
                <div class="input-group mb-3">
                    <input id="options-input" type="text" class="form-control" placeholder="Вариант ответа:" aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button id="options-btn" class="btn btn-outline-secondary" type="button">Добавить</button>
                    </div>
                </div>
            </div>
        </div>
        <button name="buttoncrQ" form="create-form" class="btn btn-primary w-100 mb-2">Добавить</button>
    </form> -->

<?php

if ($_GET['page'] == 'check')
{
    $mysqli = mysqli_connect('std-mysql', 'std_946_php', '12345678', 'std_946_php');
            if( mysqli_connect_errno() ) // проверяем корректность подключения
                echo 'Ошибка подключения к БД: '.mysqli_connect_error();
            $sql_res=mysqli_query($mysqli, "SELECT sessions2.id, link, status, question, type, answers.id, answer, date, ip FROM sessions2, questions, answers WHERE sessions2.id=questions.id_session AND answers.question_id=questions.id");
            if (!$sql_res)
                echo '<div class="error">При поиске ответов произошла ошибка '.mysqli_errno($mysqli).'.</div>';
            else // если все прошло нормально – выводим сообщение
                {
                    while( $row=mysqli_fetch_row($sql_res) ) // пока есть записи
                    {
                        // выводим каждую запись как строку таблицы
                        echo '<table class="table col-10 m-3">
                        <thead>
                            <tr>
                            <th scope="col">ID сессии</th>
                            <th scope="col">ссылка на сессию</th>
                            <th scope="col">статус сессии</th>
                            <th scope="col">Вопрос</th>
                            <th scope="col">тип вопроса</th>
                            <th scope="col">ID ответа</th>
                            <th scope="col">Ответ</th>
                            <th scope="col">Дата ответа</th>
                            <th scope="col">IP отвечающего</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <th scope="row">'.$row[0].'</th>
                            <td><a href="http://localhost/2sem/exam/session.php?a='.$row[1].'">http://localhost/2sem/exam/session.php?a='.$row[1].'</td>
                            <td>'.$row[2].'</td>
                            <td>'.$row[3].'</td>
                            <td>'.$row[4].'</td>
                            <td>'.$row[5].'</td>
                            <td>'.$row[6].'</td>
                            <td>'.$row[7].'</td>
                            <td>'.$row[8].'</td>
                            </tr>
                        </tbody>
                        </table>';

                    }
                };

            }

//<option value="5">с единственным выбором </option>
//<option value="6">с множественным </option>
?>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
    const selectEl = document.getElementById('question-type')
    const optionsList = document.getElementById('options-list')
    selectEl.addEventListener('change', (event) => {
        const val = Number(event.target.value)
        console.log('render', val)
        if (val === 5 || val === 6) {
            optionsList.style.display = 'block'
        } else {
            optionsList.style.display = 'none'
        }
    })
    //	options logic
    const optionBtn = document.getElementById('options-btn')
    const optionRender = document.getElementById('options-render')
    const optionInput = document.getElementById('options-input')
    const optionValue = document.getElementById('options-value')
    let options = []
    optionBtn.addEventListener('click', () => {
        const val = optionInput.value
        const el = document.createElement('li')
        el.textContent = val
        if (val) {
            el.classList.add('options-item')
            options.push(val)
            optionRender.appendChild(el)
        }
        // clear
        optionInput.value = ''
        optionValue.value = options.join(',')
    })
</script>
</body>
</html>