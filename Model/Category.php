<?php
/**
 * Category Model
 *
 * @property Block $Block
 * @property Category $Category
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CategoriesAppModel', 'Categories.Model');

/**
 * Category Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Categories\Model
 */
class Category extends CategoriesAppModel {

/**
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'NetCommons.OriginalKey'
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Block' => array(
			'className' => 'Blocks.Block',
			'foreignKey' => 'block_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CategoryOrder' => array(
			'className' => 'Categories.CategoryOrder',
			'foreignKey' => false,
			'conditions' => 'CategoryOrder.category_key=Category.key',
			'fields' => '',
			'order' => array('CategoryOrder.weight' => 'ASC')
		),
	);

/**
 * Called during validation operations, before validation. Please note that custom
 * validation rules can be defined in $validate.
 *
 * @param array $options Options passed from Model::save().
 * @return bool True if validate operation should continue, false to abort
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#beforevalidate
 * @see Model::save()
 */
	public function beforeValidate($options = array()) {
		$this->validate = array(
			//'id' => array(
			//	'numeric' => array(
			//		'rule' => array('numeric'),
			//		'message' => __d('net_commons', 'Invalid request.'),
			//		'allowEmpty' => true,
			//	),
			//),
			'block_id' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => false,
					'required' => true,
					'on' => 'update', // Limit validation to 'create' or 'update' operations
				),
			),
			'key' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => false,
					'required' => true,
					'on' => 'update', // Limit validation to 'create' or 'update' operations
				),
			),
			'name' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('categories', 'Category')),
					'allowEmpty' => false,
					'required' => true,
				),
			),
		);

		return parent::beforeValidate($options);
	}

/**
 * Get categories
 *
 * @param int $blockId blocks.id
 * @param int $roomId rooms.id
 * @return array Categories
 */
	public function getCategories($blockId, $roomId) {
		$conditions = array(
			'Block.id' => $blockId,
			'Block.room_id' => $roomId,
		);

		$categories = $this->find('all', array(
				'recursive' => 0,
				'conditions' => $conditions,
			)
		);

		return $categories;
	}

/**
 * Save categories
 * Please do the transaction and validation in the caller.
 *
 * @param array $data received post data
 * @return bool True on success, false on validation errors
 * @throws InternalErrorException
 */
	public function saveCategories($data) {
		$this->loadModels([
			'CategoryOrder' => 'Categories.CategoryOrder',
		]);

		if (! isset($data['Categories'])) {
			$data['Categories'] = [];
		}

		$categoryKeys = Hash::combine($data['Categories'], '{n}.Category.key', '{n}.Category.key');

		//削除処理
		$conditionsCategory = array(
			'block_id' => $data['Block']['id']
		);
		$conditionsCateOrder = array(
			'block_key' => $data['Block']['key']
		);
		if ($categoryKeys) {
			$conditionsCategory[$this->alias . '.key NOT'] = $categoryKeys;
			$conditionsCateOrder[$this->CategoryOrder->alias . '.category_key NOT'] = $categoryKeys;
		}

		if (! $this->deleteAll($conditionsCategory, false)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}
		if (! $this->CategoryOrder->deleteAll($conditionsCateOrder, false)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		//登録処理
				$indexes = array_keys($data['Categories']);
		foreach ($indexes as $i) {
			$category = $data['Categories'][$i];
			$category['Category']['block_id'] = (int)$data['Block']['id'];
			if (! $category = $this->save($category, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			$data['Categories'][$i]['CategoryOrder']['block_key'] = $data['Block']['key'];
			$data['Categories'][$i]['CategoryOrder']['category_key'] = $category['Category']['key'];
			if (! $this->CategoryOrder->save($data['Categories'][$i], false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		}

		return true;
	}

/**
 * Validate Category
 *
 * @param array $data received post data
 * @param array $contains Optional validate sets
 * @return bool True on success, false on validation errors
 */
	public function validateCategory($data, $contains = []) {
		$this->set($data);
		$this->validates();
		if ($this->validationErrors) {
			return false;
		}

		if (in_array('categoryOrder', $contains, true)) {
			if (! $this->CategoryOrder->validateCategoryOrder($data)) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->CategoryOrder->validationErrors);
				return false;
			}
		}
		return true;
	}

/**
 * Validate Categories
 *
 * @param array $data received post data
 * @return mixed Array on success, false on validation errors
 */
	public function validateCategories($data) {
		$indexes = array_keys($data['Categories']);
		foreach ($indexes as $i) {
			if (isset($data['Block']['id'])) {
				$data['Categories'][$i]['Category']['block_id'] = (int)$data['Block']['id'];
				$data['Categories'][$i]['CategoryOrder']['block_key'] = $data['Block']['key'];
			}

			if (! $this->validateCategory($data['Categories'][$i], ['categoryOrder'])) {
				return false;
			}
		}

		return $data;
	}

/**
 * Delete categories by blocks.key.
 * Please do the transaction and validation in the caller.
 *
 * @param string $blockKey blocks.key
 * @return void
 *
 * @throws InternalErrorException
 */
	public function deleteByBlockKey($blockKey) {
		$this->loadModels([
			'Category' => 'Categories.Category',
			'CategoryOrder' => 'Categories.CategoryOrder',
			'Block' => 'Blocks.Block',
		]);

		$blocks = $this->Block->find('list', array(
				'recursive' => -1,
				'conditions' => array(
					$this->Block->alias . '.key' => $blockKey
				),
			)
		);
		$blocks = array_keys($blocks);

		//Categoryデータ削除
		if (! $this->deleteAll(array($this->alias . '.block_id' => $blocks), false)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		//CategoryOrderデータ削除
		if (! $this->CategoryOrder->deleteAll(array($this->CategoryOrder->alias . '.block_key' => $blockKey), false)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}
	}

}
