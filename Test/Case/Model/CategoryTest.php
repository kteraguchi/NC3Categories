<?php
/**
 * Category Test Case
 *
 * @property Category $Category
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CategoriesModelTestCase', 'Categories.Test/Case/Model');

/**
 * Category Model Test Case
 */
class CategoryTest extends CategoriesModelTestCase {

/**
 * Expect Category->getCategoryList()
 *
 * @return void
 */
	public function testGetCategoryList() {
		//データ生成
		$blockId = 1;

		//処理実行
		$result = $this->Category->getCategoryList($blockId);

		//期待値の生成
		$expected = array(
			0 => array(
				'Category' => array(
					'id' => 1,
					'key' => 'category_1',
					'name' => 'category_1',
				),
			),
			1 => array(
				'Category' => array(
					'id' => 2,
					'key' => 'category_2',
					'name' => 'category_2',
				),
			),
		);

		//テスト実施
		$this->_assertArray(null, $expected, $result);
	}

/**
 * Expect Category->getCategoryFieldList()
 *
 * @return void
 */
	public function testGetCategoryFieldList() {
		//データ生成
		$blockId = 1;
		$field = 'name';

		//処理実行
		$result = $this->Category->getCategoryFieldList($blockId, $field);

		//期待値の生成
		$expected = array(
			0 => 'category_1',
			1 => 'category_2',
		);

		//テスト実施
		$this->_assertArray(null, $expected, $result);
	}

/**
 * Expect Faq->saveCategory()
 *
 * @return void
 */
	public function testSaveCategory() {
		//データ生成
		$blockId = 1;
		$blockKey = 'block_1';
		$dataList = array(
			0 => array(
				'Category' => array(
					'id' => '2',
					'name' => 'category_2',
				),
			),
			1 => array(
				'Category' => array(
					'id' => '1',
					'name' => 'category_1',
				),
			),
		);

		//処理実行
		$this->Category->saveCategory($dataList, $blockId, $blockKey);

		//期待値の生成
		$expected = $dataList;

		//テスト実施
		$result = $this->Category->find('all', array(
			'fields' => array('id', 'name'),
			'recursive ' => -1,
			'conditions' => array(
				'Category.block_id' => $blockId
			),
			'order' => 'CategoryOrder.weight',
		));
		$this->_assertArray(null, $expected, $result);
	}

/**
 * Expect Faq->saveCategory() by add category
 *
 * @return void
 */
	public function testSaveCategoryByAddCategory() {
		//データ生成
		$blockId = 1;
		$blockKey = 'block_1';
		$dataList = array(
			0 => array(
				'Category' => array(
					'id' => '1',
					'name' => 'category_1',
				),
			),
			1 => array(
				'Category' => array(
					'id' => '2',
					'name' => 'category_2',
				),
			),
			2 => array(
				'Category' => array(
					'id' => '',
					'name' => 'category_3',
				),
			),
		);

		//処理実行
		$this->Category->saveCategory($dataList, $blockId, $blockKey);

		//期待値の生成
		$expected = $dataList;
		$expected[2]['Category']['id'] = '3';

		//テスト実施
		$result = $this->Category->find('all', array(
			'fields' => array('id', 'name'),
			'recursive ' => -1,
			'conditions' => array(
				'Category.block_id' => $blockId
			),
			'order' => 'CategoryOrder.weight',
		));
		$this->_assertArray(null, $expected, $result);
	}
}
