<?php
/**
 * Test of Category->getCategories()
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
 * Test of Category->getCategories()
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\Categories\Test\Case\Model
 */
class CategoryGetCategoriesTest extends CategoryTestBase {

/**
 * Expect to get the categories
 *
 * @return void
 */
	public function test() {
		//データ生成
		$blockId = 1;
		$roomId = 1;

		//処理実行
		$result = $this->Category->getCategories($blockId, $roomId);
		$result = Hash::remove($result, '{n}.Block');

		//期待値の生成
		$expected = array(
			0 => array(
				'Category' => array(
					'id' => '1',
					'key' => 'category_1',
					'name' => 'category_1',
					'block_id' => '1',
				),
				'CategoryOrder' => array(
					'id' => '1',
					'category_key' => 'category_1',
					'block_key' => 'block_1',
					'weight' => '1',
				),
			),
			1 => array(
				'Category' => array(
					'id' => '2',
					'key' => 'category_2',
					'name' => 'category_2',
					'block_id' => '1',
				),
				'CategoryOrder' => array(
					'id' => '2',
					'category_key' => 'category_2',
					'block_key' => 'block_1',
					'weight' => '2',
				),
			),
			2 => array(
				'Category' => array(
					'id' => '3',
					'key' => 'category_3',
					'name' => 'category_3',
					'block_id' => '1',
				),
				'CategoryOrder' => array(
					'id' => '3',
					'category_key' => 'category_3',
					'block_key' => 'block_1',
					'weight' => '3',
				),
			),
		);

		//テスト実施
		$this->_assertArray($expected, $result);
	}

/**
 * Expect empty by another roomId
 *
 * @return void
 */
	public function testAnotherRoomId() {
		//データ生成
		$blockId = 1;
		$roomId = 2;

		//処理実行
		$result = $this->Category->getCategories($blockId, $roomId);
		$result = Hash::remove($result, '{n}.Block');

		//期待値の生成
		$expected = array();

		//テスト実施
		$this->_assertArray($expected, $result);
	}
}
