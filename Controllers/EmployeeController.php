<?php

/**
 * Тестовый контроллер
 */
class EmployeeController extends ActionController
{
    /**
     * Общая инициализация контроллера, выполняется для всех действий
     */
    public function _init()
    {
        // Добавление пунктов в левое меню
        $this->_layout->LocalMenu->add('<h2>Новый сотрудник</h2>
<form action="/Employee/Add/" method="post" class="form-add">
    <label>
        Фамилия<br>
        <input type="text" name="data[second_name]" required>
    </label>
    <label>
        Имя<br>
        <input type="text" name="data[first_name]" required>
    </label>
    <label>
        Отчество<br>
        <input type="text" name="data[middle_name]" required>
    </label>
    <label>
        Пол<br>
        <select name="data[sex]">
            <option value="Не указан">Не указан</option>
            <option value="Мужской">Мужской</option>
            <option value="Женский">Женский</option>
        </select>
    </label>
    <label>
        Дата рождения<br>
        <input type="date" name="data[dob]" required>
    </label>
    <label>
        Должность<br>
        <input type="text" name="data[position]" required>
    </label>
    <label>
        Пасспорт<br>
        <input type="text" name="data[passport]" class="mask-passport" required>
    </label>
    <label>
        Почта<br>
        <input type="email" name="data[email]" required>
    </label>
    <label>
        Телефон<br>
        <input type="text" name="data[phone]" class="mask-phone" required>
    </label>
    <button type="submit">Добавить</button>
</form>');

    }

    /**
     * Действие по умолчанию
     */
    public function IndexAction()
    {
        $this->_view->employees = $this->_me->getEmployees();
    }

    /**
     * Добвляет нового сотрудника
     */
    public function AddAction()
    {
        if ( isset($_POST['data']) )
        {
            $this->_me->addEmployee( $_POST['data'] );
        }

        header("location: /Employee/");
    }

    /**
     * Получение данных сотрудника
     * Вывод фотмы для редактирования
     * Редактирование нового сотрудника
     */
    public function EditAction()
    {
        $id = $this->_request->getParam('id', 0);

        if ( $id )
        {
            if ( isset($_POST['data']) )
            {
                $this->_me->updateEmployee( $id, $_POST['data'] );
            }

            $this->_view->data = $this->_me->getEmployeeById( $id );
        }
        else
        {
            header("location: /Employee/");
        }
    }

    /**
     * Удаляет сотрудника
     */
    public function DeleteAction()
    {
        $id = $this->_request->getParam('id', 0);

        if ( $id )
        {
            $this->_me->deleteEmployee( $id );
        }

        header("location: /Employee/");
    }
}