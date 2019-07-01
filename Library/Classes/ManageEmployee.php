<?php

class ManageEmployee
{
    /**
     * @var PDO $pdo
     */
    private $pdo;

    public function registryPDO()
    {
        $this->pdo = Registry::get('db');
    }


    /**
     * Добавляет нового сотрудника в базу
     * @param $data
     */
    public function addEmployee( $data )
    {
        if ( !$this->validateForm($data) ) return;

        $q = "INSERT IGNORE INTO task_employee
(`first_name`, `middle_name`, `second_name`, `position`, `sex`, `dob`, `passport`, `phone`, `email`)
VALUES
('".strip_tags($data['first_name'])."',
 '".strip_tags($data['middle_name'])."',
 '".strip_tags($data['second_name'])."',
 '".strip_tags($data['position'])."',
 '".strip_tags($data['sex'])."',
 '".strip_tags($data['dob'])."',
 '".strip_tags($data['passport'])."',
 '".strip_tags($data['phone'])."',
 '".strip_tags($data['email'])."'
 )";

        $r = $this->pdo->query($q);

        if ( $r === FALSE )
        {
            return;
        }

        $id = $this->pdo->lastInsertId();
        $historyData = array(
            'eid' => $id,
            'action' => 'insert',
            'changes' => json_encode($data, JSON_UNESCAPED_UNICODE)
        );

        $this->addHistory($historyData);
    }

    /**
     * @param int $id
     * @param array $data
     * @return string
     */
    public function updateEmployee( $id, $data )
    {
        if ( !$this->validateForm($data) ) return 'Не валидно';

        $changes = $this->compareChanges( $id, $data );

        // изменений нет
        if ( empty($changes) ) return '';

        $q = "UPDATE `task_employee`
SET
    `first_name`='".strip_tags($data['first_name'])."',
    `middle_name`='".strip_tags($data['middle_name'])."',
    `second_name`='".strip_tags($data['second_name'])."',
    `position`='".strip_tags($data['position'])."',
    `sex`='".strip_tags($data['sex'])."',
    `dob`='".strip_tags($data['dob'])."',
    `passport`='".strip_tags($data['passport'])."',
    `phone`='".strip_tags($data['phone'])."',
    `email`='".strip_tags($data['email'])."'
WHERE id=".(int)$id;

        $r = $this->pdo->query($q);

        if ( $r === FALSE )
        {
            return $this->pdo->errorInfo();
        }

        $historyData = array(
            'eid' => $id,
            'action' => 'update',
            'changes' => json_encode($changes, JSON_UNESCAPED_UNICODE)
        );

        $this->addHistory($historyData);

        return 'ok';
    }

    /**
     * не удаляет работника, меняет поле is_deleted на 1
     * @param int $id - ид сотрудника
     */
    public function deleteEmployee( $id )
    {
        $q = "UPDATE `task_employee` SET `is_deleted`=1 WHERE id=".(int)$id;
        $r = $this->pdo->query($q);

        if ( $r === FALSE )
        {
            return;
        }

        $data = $this->getEmployeeById( $id );
        $historyData = array(
            'eid' => $id,
            'action' => 'delete',
            'changes' => json_encode($data, JSON_UNESCAPED_UNICODE)
        );

        $this->addHistory($historyData);
    }

    /**
     * Выдает всех неудаленных сотрудников
     * @return array
     */
    public function getEmployees()
    {
        $q = "SELECT * FROM task_employee WHERE is_deleted = 0 ORDER BY id DESC";

        $r = $this->pdo->query($q);

        $result = array();

        if ( $r !== FALSE )
        {
            while ( $row = $r->fetch(PDO::FETCH_ASSOC) )
            {
                $result[] = $row;
            }
        }

        return $result;
    }

    /**
     * Выдает одного сотрудника по ид
     * @param int $id - ид сотрудника
     * @return array
     */
    public function getEmployeeById( $id )
    {
        $q = "SELECT * FROM `task_employee` WHERE id=".(int)$id;
        $r = $this->pdo->query($q);

        if ( $r === FALSE )
        {
            return array();
        }

        return $r->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Достает и фоимрует строку: Фамилия Имя Отчество
     * @param $id - ид сотрудника
     * @return string
     */
    public function getFio( $id )
    {
        $data = $this->getEmployeeById( $id );

        return $data['second_name'].' '.$data['first_name'].' '.$data['middle_name'];
    }

    /**
     * Выдает всю историю. Сортировка по времени
     * @return array
     */
    public function getHistories()
    {
        $q = "SELECT * FROM `task_history` ORDER BY datetime ASC";

        $r = $this->pdo->query($q);

        $result = array();

        if ( $r !== FALSE )
        {
            while ( $row = $r->fetch(PDO::FETCH_ASSOC) )
            {
                $result[] = $row;
                $result['json'] = json_decode($row['changes'], true);
            }
        }

        return $result;
    }

    /**
     * Выдает всю историю по сотруднику. Сортировка по времени
     * @param $eid - ид сотрудника
     * @return array
     */
    public function getHistoryByEid( $eid )
    {
        $q = "SELECT * FROM `task_history` WHERE eid=".(int)$eid. " ORDER BY datetime ASC";
        $r = $this->pdo->query($q);

        $result = array();

        if ( $r !== FALSE )
        {
            while ( $row = $r->fetch(PDO::FETCH_ASSOC) )
            {
                $result[] = $row;
                $result['json'] = json_decode($row['changes'], true);
            }
        }

        return $result;
    }

    /**
     * Добавляет историю изменений сотрудников
     * @param $data
     */
    private function addHistory( $data )
    {
        $q = "INSERT IGNORE INTO task_history
(`eid`, `action`, `changes`, `datetime`)
VALUES
(".(int)$data['eid'].",
 '".$data['action']."',
 '".$data['changes']."',
 NOW()
 )";

        $r = $this->pdo->query($q);

        if ( $r === FALSE )
        {
            return;
        }
    }

    /**
     * сравнивает старые данные с новыми
     * @param $id - ид сотрудника
     * @param $newData - измененные данные
     * @return array
     */
    private function compareChanges( $id, $newData )
    {
        $changes = array();
        $oldData = $this->getEmployeeById( $id );

        foreach ( $newData as $key => $value )
        {
            if ( $oldData[$key] !== $value )
            {
                $changes[$key] = array($oldData[$key], $value);
            }
        }

        return $changes;
    }

    /**
     * валидность формы
     * @param array $data - данные с формы
     * @return bool
     */
    private function validateForm( $data )
    {
        if ( ( !isset($data['second_name']) || strlen($data['second_name']) == 0 || strlen($data['second_name']) > 255 ) ||
            ( !isset($data['first_name']) || strlen($data['first_name']) == 0 || strlen($data['first_name']) > 255 ) ||
            ( !isset($data['middle_name']) || strlen($data['middle_name']) == 0 || strlen($data['middle_name']) > 255 ) ||
            ( !isset($data['position']) || strlen($data['position']) == 0 || strlen($data['position']) > 255 ) ||
            !isset($data['sex']) || !isset($data['dob']) || !isset($data['phone']) || !isset($data['passport']) ||
            !preg_match('/^[\w\.-]+@[\w\.-]+$/', $data['email']) )
        {
            return false;
        }
        return true;
    }
}
