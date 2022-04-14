<?php

class SiteController
{

    public function actionIndex()
    {

        require_once(ROOT . '/views/main/index.php');

        return true;
    }

    public function actionAuth() {
        $login = $_POST['login'] ?? false;
        $password = md5($_POST['password']) ?? false;

        $errors = []; // ошибки

        // небольшая валидация на пустоту и длину строк
        if(!$login || !$password) {
            header('Location: /');
            exit('Без post не пускаю');
        }

        // найденный пользователь по логину и паролю, возвращает хэш id
        $authLogin = Users::getUserByLoginAndPassword($login, $password);

        if($authLogin) {
            setcookie("id_user", $authLogin, time()+3600*24*7); // устанавливаем время жизни куки 7 дней
            header('Location: /user-list');
        } else {
            $errors[] = 'Неверный логин или пароль';
            require_once(ROOT . '/views/main/index.php');
        }
    }

    public function actionUserList() {
        if($this->checkAuth()) {
            $users = Users::getUsersList();
        } else {
            header('Location: /');
        }

        require_once(ROOT . '/views/main/users_list.php');
    }

    public function actionLogout() {
        if(isset($_COOKIE['id_user']) && !empty($_COOKIE['id_user']) && isset($_POST['button_logout'])) {
            unset($_COOKIE['id_user']);
            setcookie('id_user', null, -1, '/'); // удаляем куки
            header('Location: /');
        } else {
            exit;
        }
    }

    public function actionAdd() {
        // проверка, чтобы не слали post запросы на добавление скриптом с установленной куки
        if(!$this->checkAuth()) {
            header('Location: /');
            exit;
        }

        $data = []; // масссив post данных htmlspecialchars("<a href='test'>Test</a>", ENT_QUOTES);
        $errors = []; // ошибки

        $data['name'] = isset($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES) : false;
        $data['surname'] = isset($_POST['surname']) ? htmlspecialchars($_POST['surname'], ENT_QUOTES) : false;
        $data['age'] = isset($_POST['age']) ? htmlspecialchars($_POST['age'], ENT_QUOTES) : false;
        $data['login'] = isset($_POST['login']) ? htmlspecialchars($_POST['login'], ENT_QUOTES) : false;
        $data['password'] = isset($_POST['password']) ? md5(htmlspecialchars($_POST['password'], ENT_QUOTES)) : false;

        // валидация, для валидации можно реализовать отдельную масштабную функцию
        foreach ($data as $key => $item) {
            if(strlen($item) > 30 && $key != 'password') {
                $errors[] = 'Одно из полей содержит больше 30и символов';
                break;
            } else if(!$item) {
                header('Location: /user-list');
                exit;
            }
        }

        if(empty($errors)) {
            $data['id'] = md5(time().$data['login']); // хэшировать нужно лучше, чтобы уменьшить вероятность коллизии

            $result = Users::addUser($data);

            if($result) {
                header('Location: /user-list');
                exit;
            } else {
                $errors[] = 'Такой логин уже существует.';
            }
        }

        require_once(ROOT . '/views/main/users_list.php');
    }

    public function checkAuth() {
        if(isset($_COOKIE['id_user']) && !empty($_COOKIE['id_user'])) {
            $hash = $_COOKIE['id_user'];
            if(Users::getUserByHash($hash)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
