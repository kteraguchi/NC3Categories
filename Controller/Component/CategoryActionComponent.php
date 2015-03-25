<?php
/**
 * CategoryAction Component
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
App::uses('Component', 'Controller');

/**
 * CategoryAction Component
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\Categories\Controller\Component
 */
class CategoryActionComponent extends Component {

/**
 * use component
 *
 * @var array
 */
	public $components = array();

/**
 * Initialize component
 *
 * @param Controller $controller Instantiating controller
 * @return void
 */
	public function initialize(Controller $controller) {
		$this->controller = $controller;
	}

/**
 * edit method
 *
 * @param array $block blocks
 * @return void
 */
	public function edit($block) {
		$this->__initCategory($block['Block']['id']);
		if ($this->controller->request->isGet()) {
			CakeSession::write('backUrl', $this->controller->request->referer());
		}

		if ($this->controller->request->isPost()) {
			$this->controller->Category->saveCategory(
				$this->controller->data, $block['Block']['id'], $block['Block']['key']
			);
			if (!$this->controller->handleValidationError($this->controller->Category->validationErrors)) {
				return;
			}

			if (!$this->controller->request->is('ajax')) {
				$backUrl = CakeSession::read('backUrl');
				CakeSession::delete('backUrl');
				$this->controller->redirect($backUrl);
			}
		}
	}

/**
 * __initCategory method
 *
 * @param int $blockId blocks.id
 * @return void
 */
	private function __initCategory($blockId) {
		$categoryList = $this->controller->Category->getCategoryList($blockId);
		$results = array('categoryList' => $categoryList);

		$results = $this->controller->camelizeKeyRecursive($results);
		$this->controller->set($results);
	}
}