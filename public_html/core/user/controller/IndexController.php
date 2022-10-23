<?php

namespace core\user\controller;

/** 
 * Индексный контроллер пользовательской части
 */
class IndexController extends BaseUser
{
	protected $name;

	protected function inputData()
	{
		// Выпуск №120
		parent::inputData();

		// Выпуск №124- Пользовательская часть | вывод акций (слайдер под верхним меню)
		$sales = $this->model->get('sales', [
			'where' => ['visible' => 1],
			'order' => ['menu_position']
		]);

		// собираем переменные в массив и возвращаем
		return compact('sales');
	}
}
