<?php

/**
 * Тестовый контроллер
 */
class TestController extends ActionController
{
    /**
     * Общая инициализация контроллера, выполняется для всех действий
     */
    public function _init()
    {
        // Добавление пунктов в левое меню
        $this->_layout->LocalMenu->add('<a href="/Test/Database/">Выборка из базы</a>');
        $this->_layout->LocalMenu->add('<a href="/Test/phpinfo/" target="_blank">phpinfo()</a>');
    }

    /**
     * Действие по умолчанию
     */
    public function IndexAction()
    {
        // Просто отображаем шаблон Scripts/Views/Test/Index.phtml
    }

    /**
     * Пример работы с базой
     */
    public function DatabaseAction()
    {
        // Выполнение запроса
        $stm = $this->_db->query('SHOW DATABASES');

        // Сохранение результатов
        $this->_view->databases = $stm->fetchAll();

        // Обязательное закрытие курсора, иначе последующе запросы могут вызывать ошибки
        $stm->closeCursor();

        // Пример выборки таблиц из базы данных
        $stm = $this->_db->query('SHOW TABLES');
        $this->_view->tables = $stm->fetchAll();
        $stm->closeCursor();
    }

    /**
     * Отображение страницы с информацией о php
     */
    public function phpinfoAction()
    {
        // Отключение вида
        $this->_view->disable();

        // Отключение основного шаблона
        $this->_layout->disable();

        // Отображение информации
        phpinfo();
    }
}