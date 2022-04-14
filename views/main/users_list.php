<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список пользователей</title>
</head>

<body>
<?php if(!empty($users)):?>
    <div class="table-section" style="margin: 0 auto;">
        <table border="1" style="margin-bottom: 20px;">
            <tr>
                <th>Имя</th>
                <th>Фамилия</th>
                <th>Возраст</th>
            </tr>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?=$user['name']; ?></td>
                <td><?=$user['surname']; ?></td>
                <td><?=$user['age']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php elseif(!empty($errors)): ?>
        <?php foreach ($errors as $error): ?>
            <p style="color: red;"><?=$error?></p>
        <?php endforeach; ?>
        <?php else: ?>
            <p>Список пуст</p>
    </div>
<?php endif;?>
    <form action="/logout" method="POST" style="margin-bottom: 20px;">
        <button type="submit" name="button_logout">Выход</button>
    </form>
    <form action="/add" method="POST" style="display:flex; flex-direction: column; margin-bottom: 20px; width:500px;">
        <input type="text" placeholder="Имя" name="name" style="margin-bottom: 10px;" required>
        <input type="text" placeholder="Фамилия" name="surname" style="margin-bottom: 10px;" required>
        <input type="number" min="1" max="150"  placeholder="Возраст" name="age" style="margin-bottom: 10px;" required>
        <input type="text" placeholder="Логин" name="login" style="margin-bottom: 10px;" required>
        <input type="password" placeholder="Пароль" name="password" style="margin-bottom: 10px;" required>

        <button type="submit">Создать пользователя</button>
    </form>
</body>

</html>
