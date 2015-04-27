<?php
/**
 * Categories Component
 *   Before use of this component, please define NetCommonsFrame component,
 *   NetCommonsRoomRole component and Category model in caller.
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
App::uses('Component', 'Controller');

/**
 * Categories Component
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Categories\Controller\Component
 */
class CategoriesComponent extends Component {

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
 * edit
 *
 * @return void
 */
	public function edit() {
		//blockId取得
		$this->controller->set('blockId',
			isset($this->controller->params['pass'][1]) ? (int)$this->controller->params['pass'][1] : null
		);

		//Categoriesの取得
		if (! $this->initCategories()) {
			return;
		}

		//POST処理
		if ($this->controller->request->isPost()) {
			//登録処理
			$data = $this->controller->data;
			$this->controller->Category->saveCategories($data);
			//validationError
			if ($this->controller->handleValidationError($this->controller->Category->validationErrors)) {
				//リダイレクト
				if (! $this->controller->request->is('ajax')) {
					$this->controller->redirect(array(
						'plugin' => $this->controller->params['plugin'],
						'controller' => 'blocks',
						'action' => 'edit',
						$this->controller->viewVars['frameId'],
						$this->controller->viewVars['blockId']
					));
				}
				return;
			}

			$results = $this->controller->camelizeKeyRecursive($data);
			$this->controller->set($results);
		}
	}

/**
 * initCategories
 *
 * @return bool True on success, False on failure
 */
	public function initCategories() {
		if (! $categories = $this->controller->Category->getCategories(
			$this->controller->viewVars['blockId'],
			$this->controller->viewVars['roomId']
		)) {
			$this->controller->throwBadRequest();
			return false;
		}

		$categories = Hash::remove($categories, '{n}.Block');
		$categories = Hash::remove($categories, '{n}.TrackableCreator');
		$categories = Hash::remove($categories, '{n}.TrackableUpdater');

		$categories = $this->controller->camelizeKeyRecursive($categories);
		$this->controller->set(['categories' => $categories]);

		return true;
	}

}
