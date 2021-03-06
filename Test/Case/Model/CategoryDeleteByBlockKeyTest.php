<?php
/**
 * Test of Category->deleteByBlockKey()
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
 * Test of Category->deleteByBlockKey()
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\Categories\Test\Case\Model
 * @SuppressWarnings(PHPMD.TooManyMethods)
 */
class CategoryDeleteByBlockKeyTest extends CategoryTestBase {

/**
 * Expect to save the categories
 *
 * @return void
 */
	public function test() {
		$blockId = '1';
		$blockKey = 'block_1';
		$roomId = '1';

		//事前チェック
		$result = $this->Category->getCategories($blockId, $roomId);
		$result = Hash::remove($result, '{n}.Block');
		$this->assertNotEmpty($result);

		//処理実行
		$this->Category->deleteByBlockKey($blockKey);

		//テスト実施
		$result = $this->Category->getCategories($blockId, $roomId);

		$count = $this->Category->find('count', array(
			'recursive' => -1,
			'conditions' => array(
				'block_id' => $blockId
			),
		));
		$this->assertEquals(0, $count, 'Category->findCount');

		$count = $this->CategoryOrder->find('count', array(
			'recursive' => -1,
			'conditions' => array(
				'block_key' => $blockKey
			),
		));
		$this->assertEquals(0, $count, 'CategoryOrder->findCount');
	}

/**
 * Expect to fail on Category->deleteAll()
 * e.g.) connection error
 *
 * @return  void
 */
	public function testFailOnDeleteAll() {
		$this->setExpectedException('InternalErrorException');

		$this->Category = $this->getMockForModel('Categories.Category', array('deleteAll'));
		$this->Category->expects($this->any())
			->method('deleteAll')
			->will($this->returnValue(false));

		$blockId = '1';
		$blockKey = 'block_1';
		$roomId = '1';

		//事前チェック
		$result = $this->Category->getCategories($blockId, $roomId);
		$result = Hash::remove($result, '{n}.Block');
		$this->assertNotEmpty($result);

		//処理実行
		$this->Category->deleteByBlockKey($blockKey);
	}

/**
 * Expect to fail on CategoryOrder->save()
 * e.g.) connection error
 *
 * @return  void
 */
	public function testFailOnCategoryOrderDeleteAll() {
		$this->setExpectedException('InternalErrorException');

		$this->CategoryOrder = $this->getMockForModel('Categories.CategoryOrder', array('deleteAll'));
		$this->CategoryOrder->expects($this->any())
			->method('deleteAll')
			->will($this->returnValue(false));

		$blockId = '1';
		$blockKey = 'block_1';
		$roomId = '1';

		//事前チェック
		$result = $this->Category->getCategories($blockId, $roomId);
		$result = Hash::remove($result, '{n}.Block');
		$this->assertNotEmpty($result);

		//処理実行
		$this->Category->deleteByBlockKey($blockKey);
	}

}
