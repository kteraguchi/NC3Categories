<?php
/**
 * Category Model
 *
 * @property Block $Block
 * @property Faq $Faq
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CategoriesAppModel', 'Categories.Model');

/**
 * Category Model
 */
class Category extends CategoriesAppModel {

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
			'className' => 'Faqs.CategoryOrder',
			'foreignKey' => 'key',
			'conditions' => '',
			'fields' => '',
			'order' => '',
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
			'id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => true,
				),
			),
			'name' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
		);

		return parent::beforeValidate($options);
	}

/**
 * getCategoryList
 *
 * @param int $blockId blocks.id
 * @return array
 */
	public function getCategoryList($blockId) {
		$options = $this->__getCategoryListOptions($blockId);

		return $this->find('all', $options);
	}

/**
 * __getCategoryListOptions
 *
 * @param int $blockId blocks.id
 * @return array
 */
	private function __getCategoryListOptions($blockId) {
		return array(
			'fields' => array(
				'Category.id',
				'Category.key',
				'Category.name',
			),
			'conditions' => array('Category.block_id' => $blockId),
			'order' => array('CategoryOrder.weight'),
			'callbacks' => false,
		);
	}

	public function getCategoryFormList($blockId) {
		$options = $this->__getCategoryListOptions($blockId);
		$categoryList['List'] = $this->find('all', $options);

		return $categoryList;
	}

/**
 * saveCategory
 *
 * @param array $data received post data
 * @param int $blockId blocks.id
 * @param string $blockKey blocks.key
 * @return boolean
 * @throws InternalErrorException
 */
	public function saveCategory($data, $blockId, $blockKey) {
//		//validationを実行
//		if (! $this->__validateCategory($data, $blockId)) {
//			return false;
//		}

		$editKeyList = array('default');
		$editIdList = array();
		foreach ($data['List'] as $index => $category) {

			// カテゴリーの更新
			if (empty($category['Category']['id'])) {
				$category['Category']['block_id'] = $blockId;
				$category['Category']['key'] = Security::hash($this->name . mt_rand() . microtime(), 'md5');
			}
			$category = $this->save($category, false);
			if (! $category) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			// カテゴリー順の更新
			$categoryOrder = array(
				'CategoryOrder' => array(
					'category_key' => $category['Category']['key'],
					'weight' => $index + 1
				)
			);
			if (isset($category['Category']['block_id'])) {
				$categoryOrder['CategoryOrder']['block_key'] = $blockKey;
			}
			if (! $this->CategoryOrder->save($categoryOrder, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			$editKeyList[] = $category['Category']['key'];
			$editIdList[] = $category['Category']['id'];
		}

		// 不要カテゴリーの削除
		$conditions = array(
			'Category.block_id' => $blockId,
			'NOT' => array('Category.key' => $editKeyList),
		);
		if (! $this->deleteAll($conditions)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		// 不要カテゴリー順の削除
		$conditions = array(
			'CategoryOrder.block_key' => $blockKey,
			'NOT' => array('CategoryOrder.category_key' => $editKeyList),
		);
		if (! $this->CategoryOrder->deleteAll($conditions)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		return true;
	}

/**
 * validate category
 *
 * @param array $data received post data
 * @param int $blockId blocks.id
 * @return mixed object announcement, false error
 */
	private function __validateCategory($data, $blockId) {
		foreach($data as $category){
			// カテゴリ新規登録の場合
			if (empty($category['Category']['id'])) {
				$category['Category']['block_id'] = $blockId;
				// keyの生成
				$category['Category']['key'] = Security::hash($this->name . mt_rand() . microtime(), 'md5');
			}

			$this->set($data);
			return $this->validates();
		}
	}

}
