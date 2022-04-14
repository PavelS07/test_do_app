<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Авторизация</title>
</head>

<body>
    <div class="form-section" style="margin: 0 auto; width: 500px;">
        <h2 style="text-align: center;">Войти</h2>
        <?php if(isset($errors) && !empty($errors)): ?>
        <?php foreach ($errors as $error): ?>
        <p style="color:red;"><?=$error?></p>
        <?php endforeach;?>
        <?php endif; ?>
        <form action="/auth" method="POST" style="display: flex; flex-direction: column">
            <input type="text" name="login" placeholder="Логин" style="margin-bottom: 10px" required>
            <input type="password" name="password" placeholder="Пароль" style="margin-bottom: 10px" required>
            <button type="submit">Войти</button>
        </form>
    </div>
</body>

</html>
