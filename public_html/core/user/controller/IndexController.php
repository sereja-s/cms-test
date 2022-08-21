<?php

namespace core\user\controller;

use core\admin\model\Model;
use core\base\controller\BaseController;

class IndexController extends BaseUser
{

	protected $name;

	// Выпуск №12
	//use trait1;
	//use trait2;
	//use trait1, trait2;
	//use trait1, trait2 {
	// если трейты имеют одноимённые методы, необходимо указать метод какого трейта является приоритетным
	// например можем записать-  методом: who() 1-го трейта заменить одноимённый метод 2-го трейта
	//trait1::who insteadof trait2;
	// или наоборот
	//trait2::who insteadof trait1;
	//}

	//use trait1, trait2 {
	// что бы пользоваться методами обоих трейдов, необходимо методу трейта, который заменили дать псевдоним
	// теперь этот метод можно вызыввать по псевдониму
	//trait1::who insteadof trait2;
	// (псевдоним можно объявить только для метода, который уже переопределён (замещён) иным метоодом !!!)
	//trait2::who as who2;
	//}


	/* protected function hello()
	{
		$template = $this->render(false, ['name' => 'Marina Sergeevna']);
		exit($template);
	} */

	protected function inputData()
	{
		// Выпуск №10
		//$template = $this->render(false, ['name' => 'Masha']);
		//exit($template);


		// Выпуск №11
		//$name = 'Masha';		
		//$this->name = 'Ivan';	
		// в функцию: compact() на вход передаём переменные (их название в строковом виде) и она формирует массив, который вернём
		//return compact('name', 'surname');

		//$name = 'Marina';
		//$content = $this->render('', compact('name'));
		//$header = $this->render(TEMPLATE . 'header');
		//$footer = $this->render(TEMPLATE . 'footer');
		//return compact('header', 'content', 'footer');


		// Выпуск №12
		//$this->who();
		//$this->who2();
		//exit();

		//$num = '1';
		//$num = $this->clearNum($num);
		//exit();

		//$post = $this->isPost();
		exit();
	}

	//protected function outputData()
	//{
	// Выпуск №11
	// получаем нулевой элемент массива (в $data), поданного на вход методу outputData() в качестве аргумента (в метод: request() в BaseController)
	//$vars = func_get_arg(0);
	// и передаём в качестве 2-го(необязателльного) параметра методу: render()
	//exit($this->render('', $vars));

	//return $vars;

	//return $this->render(TEMPLATE . 'templater', $vars);

	//$this->page = $this->render(TEMPLATE . 'templater', $vars);
	//}
}
