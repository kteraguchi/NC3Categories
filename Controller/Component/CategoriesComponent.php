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
 * initCategories
 *
 * @param bool $hasEmpty True on has empty
 * @param string $key keyPath on Hash::combine
 * @return void
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function initCategories($hasEmpty = false, $key = '{n}.CategoryOrder.weight') {
		$categories = $this->controller->Category->getCategories(
			$this->controller->viewVars['blockId'],
			$this->controller->viewVars['roomId']
		);
		if ($hasEmpty) {
			$categories[] = array(
				'Category' => array(
					'id' => '0',
					'key' => null,
					'name' => null,
				),
				'CategoryOrder' => array(
					'weight' => '0',
				)
			);
		}

		$categories = Hash::remove($categories, '{n}.Block');
		$categories = Hash::remove($categories, '{n}.TrackableCreator');
		$categories = Hash::remove($categories, '{n}.TrackableUpdater');
		$categories = Hash::sort($categories, '{n}.CategoryOrder.weight', 'asc');
		$categories = Hash::combine($categories, $key, '{n}');

		$categories = $this->controller->camelizeKeyRecursive($categories);
		$this->controller->set(['categories' => $categories]);
	}

}
