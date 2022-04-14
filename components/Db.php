<?php
/*
 * Вместо подключения к ресурсу бд используется file_get_contents json файла
 */
class Db
{
    
    public static function getConnection()
    {
        $paramsPath = ROOT.'/config/db.json';

        $db = json_decode(file_get_contents($paramsPath), true);

        return $db;
    }

}
