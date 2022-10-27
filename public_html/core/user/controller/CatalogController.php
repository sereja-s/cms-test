<?php

namespace core\user\controller;

use core\base\exceptions\RouteException;

/** 
 * КАталог-контроллер пользовательской части (Выпуск №129)
 */
class CatalogController extends BaseUser
{
	protected function inputData()
	{
		parent::inputData();

		$order = [
			'price' => 'цене',
			'name' => 'названию'
		];

		// Сформируем название для страницы каталог, взависимости от того в какой категории находимся
		$data = [];

		if (!empty($this->parameters['alias'])) {

			$data = $this->model->get('catalog', [
				'where' => ['alias' => $this->parameters['alias'], 'visible' => 1],
				'limit' => 1
			]);

			if (!$data) {

				throw new RouteException('Не найдены записи в таблице catalog по ссылке ', $this->parameters['alias']);
			}

			$data = $data[0];
		}


		// сформируем инструкцию для товаров
		$where = ['visible' => 1];

		if ($data) {

			$where = ['parent_id' => $data['id']];
		} else {

			$data['name'] = 'Каталог';
		}

		$catalogFilters = $catalogPrices = $orderDb = null;


		// Получим товары (с их фильтрами и ценами):

		$goods = $this->model->getGoods([
			'where' => $where
		], $catalogFilters, $catalogPrices);

		//$a = 1;

		return compact('data', 'catalogFilters', 'catalogPrices', 'goods');
	}
}
