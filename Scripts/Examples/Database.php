<?php
/**
 * Работа с базой данных
 */
// Где-то на просторах ActionController
class SomeController extends ActionController
{
    public function SelectAction()
    {
        // Пример выборки
        // $this->_db Это инициализированный объект PDO
        $this->_view->values = $this->_db->query('SELECT * FROM `table`')->fetchAll(PDO::FETCH_ASSOC);
    }
}

// В любом другом месте
$pdo = Registry::get('db');

// Или так
$pdo = Db::driver();