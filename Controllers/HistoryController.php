<?php

/**
 * Тестовый контроллер
 */
class HistoryController extends ActionController
{
    /**
     * Общая инициализация контроллера, выполняется для всех действий
     */
    public function _init()
    {
        // Добавление пунктов в левое меню
        $this->_layout->LocalMenu->add('<a href="/History/">Вся история</a>');
    }

    /**
     * Действие по умолчанию
     */
    public function IndexAction()
    {
        $id = $this->_request->getParam('id', 0);

        $this->histories = array();
        if ( $id )
        {
            $this->_view->histories = $this->_me->getHistoryByEid( $id );
        }
        else
        {
            $this->_view->histories = $this->_me->getHistories();
        }
    }
}