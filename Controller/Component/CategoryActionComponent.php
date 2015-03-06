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
 * @package NetCommons\Faqs\Controller\Component
 */
class CategoryActionComponent extends Component {

/**
 * use component
 *
 * @var array
 */
	public $components = array();

	public function initialize(Controller $controller) {
        $this->controller = $controller;
    }

	public function edit($block) {
		$this->__initCategory($block['Block']['id']);

		if ($this->controller->request->isGet()) {
			CakeSession::write('backUrl', $this->controller->request->referer());
		}

		if ($this->controller->request->isPost()) {
			$this->controller->Category->saveCategory(
				$this->controller->data, $block['Block']['id'], $block['Block']['key']
			);
			if (!$this->__handleValidationError($this->controller->Category->validationErrors)) {
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
 * _setFrame method
 *
 * @param int $frameId frames.id
 * @return void
 */
	protected function _setFrame($frameId) {
		$frame = $this->controller->Frame->getFrame($frameId, $this->controller->plugin);
		$this->controller->set('frame', $frame['Frame']);
	}

/**
 * __initCategory method
 *
 * @return void
 */
	private function __initCategory($blockId) {
		$categoryList = $this->controller->Category->getCategoryList($blockId);
		$results = array('categoryList' => $categoryList);

		$results = $this->controller->camelizeKeyRecursive($results);
		$this->controller->set($results);
	}

/**
 * Handle validation error
 *
 * @param array $errors validation errors
 * @return bool true on success, false on error
 */
	private function __handleValidationError($errors) {
		if ($errors) {
			$this->controller->validationErrors = $errors;
			$this->controller->set('validationErrors', $this->controller->validationErrors);
			if ($this->controller->request->is('ajax')) {
				$results = ['error' => ['validationErrors' => $errors]];
				$this->controller->renderJson($results, __d('net_commons', 'Bad Request'), 400);
			}
			return false;
		}

		return true;
	}
}