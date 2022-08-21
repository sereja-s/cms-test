<?php

namespace core\user\controller;

use core\user\model\Model;

abstract class BaseUser extends \core\base\controller\BaseController
{
	protected $model;
	protected $table;

	protected $set;
	protected $menu;

	protected $breadcrumbs;

	/*Проектные свойства*/
	protected $socials;


	protected function inputData()
	{
		// инициализируем стили и скрипты На вход здесь ничего не передаём
		$this->init();

		!$this->model && $this->model = Model::instance();
	}

	/* protected function outputData()
	{
	} */
}
