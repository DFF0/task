<?php

class Bootstrap extends BootstrapAbstract
{
	protected function _initDb()
	{
		// Инициализация базы данных
		$pdo = new PDO('mysql:host=localhost;dbname=test_maslennikov;charset=utf8mb4', 'root', 'declloh');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		Db::setDriver($pdo);

		Registry::set('db', Db::driver());
	}
}