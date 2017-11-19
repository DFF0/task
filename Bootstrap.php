<?php

class Bootstrap extends BootstrapAbstract
{
	protected function _initDb()
	{
		// Инициализация базы данных
		$pdo = new PDO('mysql:host=localhost;dbname=testprog.duxu.ru;charset=utf8mb4', 'testprog.duxu.ru', 'PcDtiDkm3yiMamHtL1XAL8YdsMfByhS');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		Db::setDriver($pdo);

		Registry::set('db', Db::driver());
	}
}