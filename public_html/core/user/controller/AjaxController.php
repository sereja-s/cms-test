<?php

namespace core\user\controller;

use core\base\controller\BaseAjax;

/**
 * Ajax-контроллер пользовательской части (Выпуск №67)
 */
class AjaxController extends BaseUser
{
	public function ajax()
	{
		return 'USER AJAX';

		/* if (isset($this->ajaxData['ajax'])) {

			$this->inputData();

			foreach ($this->ajaxData as $key => $item) {

				$this->ajaxData[$key] = $this->clearStr($item);
			}

			switch ($this->ajaxData['ajax']) {

				case 'catalog_quantities':


					$qty =  $this->clearNum($this->ajaxData['qty'] ?? 0);

					$qty && $_SESSION['quantities'] = $qty;

					break;

					case 'add_to_cart';

					return $this->_addToCart();

					break;
			}
		}

		return json_encode(['success' => '0', 'message' => 'No ajax variable']); */
	}

	/* protected function _addToCart()
	{

		//return $this->ajaxData['qty'];

		return $this->addToCart($this->ajaxData['id'] ?? null, $this->ajaxData['qty'] ?? 1);
	} */
}
