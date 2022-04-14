<?php 

class Users
{
  public static function getUserByLoginAndPassword($login, $password)
  {

    $data = Db::getConnection();

    foreach ($data as $item) {
        if($item['login'] == $login && $item['password'] == $password) return $item['id'];
    }

    return false;
  }

  public static function getUsersList() {
      return Db::getConnection();
  }

  public static function getUserByHash($hash) {
      $data = Db::getConnection();

      foreach ($data as $item) {
          if($item['id'] == $hash) return true;
      }

      return false;
  }

  public static function addUser($data) {
      $d = Db::getConnection();

      foreach ($d as $item) {
          if($item['login'] == $data['login']) {
              return false;
          }
      }

      array_push($d, $data);

      file_put_contents(ROOT.'/config/db.json', json_encode($d));

      return true;
  }
}

?>