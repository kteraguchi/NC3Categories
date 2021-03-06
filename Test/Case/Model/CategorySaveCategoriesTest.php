<?php
/**
 * Test of Category->saveCategories()
 *
 * @property Category $Category
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CategoryTestBase', 'Categories.Test/Case/Model');

/**
 * Test of Category->saveCategories()
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\Categories\Test\Case\Model
 * @SuppressWarnings(PHPMD.TooManyMethods)
 */
class CategorySaveCategoriesTest extends CategoryTestBase {

/**
 * Default save data
 *
 * @var array
 */
	private $__defaultData = array(
		'Block' => array(
			'id' => '1',
			'key' => 'block_1'
		),
		'Categories' => array(
			0 => array(
				'Category' => array(
					'id' => '1',
					'key' => 'category_1',
					'name' => 'category_1',
				),
				'CategoryOrder' => array(
					'id' => '1',
					'category_key' => 'category_1',
					'weight' => '1'
				),
			),
			1 => array(
				'Category' => array(
					'id' => '2',
					'key' => 'category_2',
					'name' => 'category_2',
				),
				'CategoryOrder' => array(
					'id' => '2',
					'category_key' => 'category_2',
					'weight' => '2'
				),
			),
			2 => array(
				'Category' => array(
					'id' => '3',
					'key' => 'category_3',
					'name' => 'category_3',
				),
				'CategoryOrder' => array(
					'id' => '3',
					'category_key' => 'category_3',
					'weight' => '3'
				),
			),
		)
	);

/**
 * Expect to save the categories
 *
 * @return void
 */
	public function test() {
		//データ生成
		$data = $this->__defaultData;

		//処理実行
		$result = $this->Category->saveCategories($data);
		$this->assertTrue($result);

		$result = $this->Category->getCategories('1', '1');
		$result = Hash::remove($result, '{n}.Block');

		//期待値の生成
		$expected = Hash::sort($data['Categories'], '{n}.CategoryOrder.weight', 'asc');
		$expected = Hash::insert($expected, '{n}.Category.block_id', '1');
		$expected = Hash::insert($expected, '{n}.CategoryOrder.block_key', 'block_1');

		//テスト実施
		$this->_assertArray($expected, $result);
	}

/**
 * Expect modified name and weight
 *
 * @return void
 */
	public function testEditNameAndWeight() {
		//データ生成
		$data = Hash::merge($this->__defaultData, array(
			'Categories' => array(
				0 => array(
					'Category' => array(
						'name' => 'category_edit_1',
					),
					'CategoryOrder' => array(
						'weight' => '2'
					),
				),
				1 => array(
					'Category' => array(
						'name' => 'category_edit_2',
					),
					'CategoryOrder' => array(
						'weight' => '3'
					),
				),
				2 => array(
					'Category' => array(
						'name' => 'category_edit_3',
					),
					'CategoryOrder' => array(
						'weight' => '1'
					),
				)
			)
		));

		//処理実行
		$result = $this->Category->saveCategories($data);
		$this->assertTrue($result);

		$result = $this->Category->getCategories('1', '1');
		$result = Hash::remove($result, '{n}.Block');

		//期待値の生成
		$expected = Hash::sort($data['Categories'], '{n}.CategoryOrder.weight', 'asc');
		$expected = Hash::insert($expected, '{n}.Category.block_id', '1');
		$expected = Hash::insert($expected, '{n}.CategoryOrder.block_key', 'block_1');

		//テスト実施
		$this->_assertArray($expected, $result);
	}

/**
 * Expect to add to the begin of categories
 *
 * @return void
 */
	public function testAddToBegin() {
		//データ生成
		$data = Hash::merge($this->__defaultData, array(
			'Categories' => array(
				0 => array(
					'Category' => array(
						'name' => 'category_edit_1',
					),
					'CategoryOrder' => array(
						'weight' => '2'
					),
				),
				1 => array(
					'Category' => array(
						'name' => 'category_edit_2',
					),
					'CategoryOrder' => array(
						'weight' => '3'
					),
				),
				2 => array(
					'Category' => array(
						'name' => 'category_edit_3',
					),
					'CategoryOrder' => array(
						'weight' => '4'
					),
				),
				3 => array(
					'Category' => array(
						'id' => '',
						'key' => '',
						'name' => 'category_name_4',
					),
					'CategoryOrder' => array(
						'id' => '',
						'category_key' => '',
						'weight' => '1'
					),
				),
			)
		));

		//処理実行
		$result = $this->Category->saveCategories($data);
		$this->assertTrue($result);

		$result = $this->Category->getCategories('1', '1');
		$result = Hash::remove($result, '{n}.Block');

		//取得したデータ数のチェック
		$this->assertCount(4, $result);

		$index = 0;
		$addCategoryId = $this->Category->getLastInsertID();
		$this->assertNotEmpty($result[$index]['Category']['id'], 'Category.id');
		$result[$index]['Category']['id'] = $addCategoryId;

		$this->assertNotEmpty($result[$index]['Category']['key'], 'Category.key');
		$result[$index]['Category']['key'] = 'category_' . $addCategoryId;

		$this->assertNotEmpty($result[$index]['CategoryOrder']['id'], 'CategoryOrder.id');
		$result[$index]['CategoryOrder']['id'] = $addCategoryId;

		$this->assertNotEmpty($result[$index]['CategoryOrder']['category_key'], 'CategoryOrder.category_key');
		$result[$index]['CategoryOrder']['category_key'] = $result[$index]['Category']['key'];

		//期待値の生成
		$expected = Hash::sort($data['Categories'], '{n}.CategoryOrder.weight', 'asc');
		$expected = Hash::insert($expected, '{n}.Category.block_id', '1');
		$expected = Hash::insert($expected, '{n}.CategoryOrder.block_key', 'block_1');
		$expected = Hash::merge($expected,
			array($index => array(
				'Category' => array(
					'id' => $addCategoryId,
					'block_id' => '1',
					'key' => 'category_' . $addCategoryId,
				),
				'CategoryOrder' => array(
					'id' => $addCategoryId,
					'block_key' => 'block_1',
					'category_key' => 'category_' . $addCategoryId,
					'weight' => '1'
				),
			))
		);

		//テスト実施
		$this->_assertArray($expected, $result);
	}

/**
 * Expect to add to the end of categories
 *
 * @return void
 */
	public function testAddToEnd() {
		//データ生成
		$data = Hash::merge($this->__defaultData, array(
			'Categories' => array(
				0 => array(
					'Category' => array(
						'name' => 'category_edit_1',
					),
					'CategoryOrder' => array(
						'weight' => '1'
					),
				),
				1 => array(
					'Category' => array(
						'name' => 'category_edit_2',
					),
					'CategoryOrder' => array(
						'weight' => '2'
					),
				),
				2 => array(
					'Category' => array(
						'name' => 'category_edit_3',
					),
					'CategoryOrder' => array(
						'weight' => '3'
					),
				),
				3 => array(
					'Category' => array(
						'id' => '',
						'key' => '',
						'name' => 'category_name_4',
					),
					'CategoryOrder' => array(
						'id' => '',
						'category_key' => '',
						'weight' => '4'
					),
				),
			)
		));

		//処理実行
		$result = $this->Category->saveCategories($data);
		$this->assertTrue($result);

		$result = $this->Category->getCategories('1', '1');
		$result = Hash::remove($result, '{n}.Block');

		//取得したデータ数のチェック
		$this->assertCount(4, $result);

		$index = 3;
		$addCategoryId = $this->Category->getLastInsertID();
		$this->assertNotEmpty($result[$index]['Category']['id'], 'Category.id');
		$result[$index]['Category']['id'] = $addCategoryId;

		$this->assertNotEmpty($result[$index]['Category']['key'], 'Category.key');
		$result[$index]['Category']['key'] = 'category_' . $addCategoryId;

		$this->assertNotEmpty($result[$index]['CategoryOrder']['id'], 'CategoryOrder.id');
		$result[$index]['CategoryOrder']['id'] = $addCategoryId;

		$this->assertNotEmpty($result[$index]['CategoryOrder']['category_key'], 'CategoryOrder.category_key');
		$result[$index]['CategoryOrder']['category_key'] = $result[$index]['Category']['key'];

		//期待値の生成
		$expected = Hash::sort($data['Categories'], '{n}.CategoryOrder.weight', 'asc');
		$expected = Hash::insert($expected, '{n}.Category.block_id', '1');
		$expected = Hash::insert($expected, '{n}.CategoryOrder.block_key', 'block_1');
		$expected = Hash::merge($expected,
			array($index => array(
				'Category' => array(
					'id' => $addCategoryId,
					'block_id' => '1',
					'key' => 'category_' . $addCategoryId,
				),
				'CategoryOrder' => array(
					'id' => $addCategoryId,
					'block_key' => 'block_1',
					'category_key' => 'category_' . $addCategoryId,
					'weight' => '4'
				),
			))
		);

		//テスト実施
		$this->_assertArray($expected, $result);
	}

/**
 * Expect to add to in
 *
 * @return void
 */
	public function testAddToIn() {
		//データ生成
		$data = Hash::merge($this->__defaultData, array(
			'Categories' => array(
				0 => array(
					'Category' => array(
						'name' => 'category_edit_1',
					),
					'CategoryOrder' => array(
						'weight' => '1'
					),
				),
				1 => array(
					'Category' => array(
						'name' => 'category_edit_2',
					),
					'CategoryOrder' => array(
						'weight' => '3'
					),
				),
				2 => array(
					'Category' => array(
						'name' => 'category_edit_3',
					),
					'CategoryOrder' => array(
						'weight' => '4'
					),
				),
				3 => array(
					'Category' => array(
						'id' => '',
						'key' => '',
						'name' => 'category_name_4',
					),
					'CategoryOrder' => array(
						'id' => '',
						'category_key' => '',
						'weight' => '2'
					),
				),
			)
		));

		//処理実行
		$result = $this->Category->saveCategories($data);
		$this->assertTrue($result);

		$result = $this->Category->getCategories('1', '1');
		$result = Hash::remove($result, '{n}.Block');

		//取得したデータ数のチェック
		$this->assertCount(4, $result);

		$index = 1;
		$addCategoryId = $this->Category->getLastInsertID();
		$this->assertNotEmpty($result[$index]['Category']['id'], 'Category.id');
		$result[$index]['Category']['id'] = $addCategoryId;

		$this->assertNotEmpty($result[$index]['Category']['key'], 'Category.key');
		$result[$index]['Category']['key'] = 'category_' . $addCategoryId;

		$this->assertNotEmpty($result[$index]['CategoryOrder']['id'], 'CategoryOrder.id');
		$result[$index]['CategoryOrder']['id'] = $addCategoryId;

		$this->assertNotEmpty($result[$index]['CategoryOrder']['category_key'], 'CategoryOrder.category_key');
		$result[$index]['CategoryOrder']['category_key'] = $result[$index]['Category']['key'];

		//期待値の生成
		$expected = Hash::sort($data['Categories'], '{n}.CategoryOrder.weight', 'asc');
		$expected = Hash::insert($expected, '{n}.Category.block_id', '1');
		$expected = Hash::insert($expected, '{n}.CategoryOrder.block_key', 'block_1');
		$expected = Hash::merge($expected,
			array($index => array(
				'Category' => array(
					'id' => $addCategoryId,
					'block_id' => '1',
					'key' => 'category_' . $addCategoryId,
				),
				'CategoryOrder' => array(
					'id' => $addCategoryId,
					'block_key' => 'block_1',
					'category_key' => 'category_' . $addCategoryId,
					'weight' => '2'
				),
			))
		);

		//テスト実施
		$this->_assertArray($expected, $result);
	}

/**
 * Expect to delete to the begin of categories
 *
 * @return void
 */
	public function testDeleteToBegin() {
		//データ生成
		$data = Hash::merge($this->__defaultData, array(
			'Categories' => array(
				1 => array(
					'CategoryOrder' => array(
						'weight' => '1'
					),
				),
				2 => array(
					'CategoryOrder' => array(
						'weight' => '2'
					),
				),
			)
		));
		$data = Hash::remove($data, 'Categories.0');

		//処理実行
		$result = $this->Category->saveCategories($data);
		$this->assertTrue($result);

		$result = $this->Category->getCategories('1', '1');
		$result = Hash::remove($result, '{n}.Block');

		//取得したデータ数のチェック
		$this->assertCount(2, $result);

		//期待値の生成
		$expected = Hash::sort($data['Categories'], '{n}.CategoryOrder.weight', 'asc');
		$expected = Hash::insert($expected, '{n}.Category.block_id', '1');
		$expected = Hash::insert($expected, '{n}.CategoryOrder.block_key', 'block_1');

		//テスト実施
		$this->_assertArray($expected, $result);
	}

/**
 * Expect to delete to the end of categories
 *
 * @return void
 */
	public function testDeleteToEnd() {
		//データ生成
		$data = Hash::merge($this->__defaultData, array(
			'Categories' => array(
				0 => array(
					'CategoryOrder' => array(
						'weight' => '1'
					),
				),
				1 => array(
					'CategoryOrder' => array(
						'weight' => '2'
					),
				),
			)
		));
		$data = Hash::remove($data, 'Categories.2');

		//処理実行
		$result = $this->Category->saveCategories($data);
		$this->assertTrue($result);

		$result = $this->Category->getCategories('1', '1');
		$result = Hash::remove($result, '{n}.Block');

		//取得したデータ数のチェック
		$this->assertCount(2, $result);

		//期待値の生成
		$expected = Hash::sort($data['Categories'], '{n}.CategoryOrder.weight', 'asc');
		$expected = Hash::insert($expected, '{n}.Category.block_id', '1');
		$expected = Hash::insert($expected, '{n}.CategoryOrder.block_key', 'block_1');

		//テスト実施
		$this->_assertArray($expected, $result);
	}

/**
 * Expect to delete to in
 *
 * @return void
 */
	public function testDeleteToIn() {
		//データ生成
		$data = Hash::merge($this->__defaultData, array(
			'Categories' => array(
				0 => array(
					'CategoryOrder' => array(
						'weight' => '1'
					),
				),
				2 => array(
					'CategoryOrder' => array(
						'weight' => '2'
					),
				),
			)
		));
		$data = Hash::remove($data, 'Categories.1');

		//処理実行
		$result = $this->Category->saveCategories($data);
		$this->assertTrue($result);

		$result = $this->Category->getCategories('1', '1');
		$result = Hash::remove($result, '{n}.Block');

		//取得したデータ数のチェック
		$this->assertCount(2, $result);

		//期待値の生成
		$expected = Hash::sort($data['Categories'], '{n}.CategoryOrder.weight', 'asc');
		$expected = Hash::insert($expected, '{n}.Category.block_id', '1');
		$expected = Hash::insert($expected, '{n}.CategoryOrder.block_key', 'block_1');

		//テスト実施
		$this->_assertArray($expected, $result);
	}

/**
 * Expect to add and delete to in.
 *
 * @return void
 */
	public function testAddDeleteToIn() {
		//データ生成
		$data = Hash::merge($this->__defaultData, array(
			'Categories' => array(
				0 => array(
					'Category' => array(
						'name' => 'category_edit_1',
					),
					'CategoryOrder' => array(
						'weight' => '3'
					),
				),
				2 => array(
					'Category' => array(
						'name' => 'category_edit_3',
					),
					'CategoryOrder' => array(
						'weight' => '1'
					),
				),
				3 => array(
					'Category' => array(
						'id' => '',
						'key' => '',
						'name' => 'category_name_4',
					),
					'CategoryOrder' => array(
						'id' => '',
						'category_key' => '',
						'weight' => '2'
					),
				),
			)
		));
		$data = Hash::remove($data, 'Categories.1');

		//処理実行
		$result = $this->Category->saveCategories($data);
		$this->assertTrue($result);

		$result = $this->Category->getCategories('1', '1');
		$result = Hash::remove($result, '{n}.Block');

		//取得したデータ数のチェック
		$this->assertCount(3, $result);

		$index = 1;
		$addCategoryId = $this->Category->getLastInsertID();
		$this->assertNotEmpty($result[$index]['Category']['id'], 'Category.id');
		$result[$index]['Category']['id'] = $addCategoryId;

		$this->assertNotEmpty($result[$index]['Category']['key'], 'Category.key');
		$result[$index]['Category']['key'] = 'category_' . $addCategoryId;

		$this->assertNotEmpty($result[$index]['CategoryOrder']['id'], 'CategoryOrder.id');
		$result[$index]['CategoryOrder']['id'] = $addCategoryId;

		$this->assertNotEmpty($result[$index]['CategoryOrder']['category_key'], 'CategoryOrder.category_key');
		$result[$index]['CategoryOrder']['category_key'] = $result[$index]['Category']['key'];

		//期待値の生成
		$expected = Hash::sort($data['Categories'], '{n}.CategoryOrder.weight', 'asc');
		$expected = Hash::insert($expected, '{n}.Category.block_id', '1');
		$expected = Hash::insert($expected, '{n}.CategoryOrder.block_key', 'block_1');
		$expected = Hash::merge($expected,
			array($index => array(
				'Category' => array(
					'id' => $addCategoryId,
					'block_id' => '1',
					'key' => 'category_' . $addCategoryId,
				),
				'CategoryOrder' => array(
					'id' => $addCategoryId,
					'block_key' => 'block_1',
					'category_key' => 'category_' . $addCategoryId,
					'weight' => '2'
				),
			))
		);

		//テスト実施
		$this->_assertArray($expected, $result);
	}

/**
 * Expect to all delete
 *
 * @return void
 */
	public function testAllDelete() {
		//データ生成
		$data = $this->__defaultData;
		$data = Hash::remove($data, 'Categories.0');
		$data = Hash::remove($data, 'Categories.1');
		$data = Hash::remove($data, 'Categories.2');

		//処理実行
		$result = $this->Category->saveCategories($data);
		$this->assertTrue($result);

		$result = $this->Category->getCategories('1', '1');
		$result = Hash::remove($result, '{n}.Block');

		//取得したデータ数のチェック
		$this->assertCount(0, $result);

		//期待値の生成
		$expected = Hash::sort($data['Categories'], '{n}.CategoryOrder.weight', 'asc');

		//テスト実施
		$this->_assertArray($expected, $result);
	}

/**
 * Expect to all delete by undefined `Categories`
 *
 * @return void
 */
	public function testAllDeleteByUndefinedCategories() {
		//データ生成
		$data = $this->__defaultData;
		$data = Hash::remove($data, 'Categories');

		//処理実行
		$result = $this->Category->saveCategories($data);
		$this->assertTrue($result);

		$result = $this->Category->getCategories('1', '1');
		$result = Hash::remove($result, '{n}.Block');

		//取得したデータ数のチェック
		$this->assertCount(0, $result);

		//期待値の生成
		$expected = array();

		//テスト実施
		$this->_assertArray($expected, $result);
	}

/**
 * Expect one category by delete
 *
 * @return void
 */
	public function testOneCategoryByDelete() {
		//データ生成
		$data = $this->__defaultData;
		$data = Hash::remove($data, 'Categories.1');
		$data = Hash::remove($data, 'Categories.2');

		//処理実行
		$result = $this->Category->saveCategories($data);
		$this->assertTrue($result);

		$result = $this->Category->getCategories('1', '1');
		$result = Hash::remove($result, '{n}.Block');

		//取得したデータ数のチェック
		$this->assertCount(1, $result);

		//期待値の生成
		$expected = Hash::sort($data['Categories'], '{n}.CategoryOrder.weight', 'asc');
		$expected = Hash::insert($expected, '{n}.Category.block_id', '1');
		$expected = Hash::insert($expected, '{n}.CategoryOrder.block_key', 'block_1');

		//テスト実施
		$this->_assertArray($expected, $result);
	}

/**
 * Expect to fail on Category->save()
 * e.g.) connection error
 *
 * @return  void
 */
	public function testFailOnSave() {
		$this->setExpectedException('InternalErrorException');

		$data = $this->__defaultData;

		$this->Category = $this->getMockForModel('Categories.Category', array('save'));
		$this->Category->expects($this->any())
			->method('save')
			->will($this->returnValue(false));

		$this->Category->saveCategories($data);
	}

/**
 * Expect to fail on Category->deleteAll()
 * e.g.) connection error
 *
 * @return  void
 */
	public function testFailOnDeleteAll() {
		$this->setExpectedException('InternalErrorException');

		$data = $this->__defaultData;

		$this->Category = $this->getMockForModel('Categories.Category', array('deleteAll'));
		$this->Category->expects($this->any())
			->method('deleteAll')
			->will($this->returnValue(false));

		$this->Category->saveCategories($data);
	}

/**
 * Expect to fail on CategoryOrder->save()
 * e.g.) connection error
 *
 * @return  void
 */
	public function testFailOnCategoryOrderSave() {
		$this->setExpectedException('InternalErrorException');

		$data = $this->__defaultData;

		$this->CategoryOrder = $this->getMockForModel('Categories.CategoryOrder', array('save'));
		$this->CategoryOrder->expects($this->any())
			->method('save')
			->will($this->returnValue(false));

		$this->Category->saveCategories($data);
	}

/**
 * Expect to fail on CategoryOrder->save()
 * e.g.) connection error
 *
 * @return  void
 */
	public function testFailOnCategoryOrderDeleteAll() {
		$this->setExpectedException('InternalErrorException');

		$data = $this->__defaultData;

		$this->CategoryOrder = $this->getMockForModel('Categories.CategoryOrder', array('deleteAll'));
		$this->CategoryOrder->expects($this->any())
			->method('deleteAll')
			->will($this->returnValue(false));

		$this->Category->saveCategories($data);
	}

}
