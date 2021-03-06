<?php
/**
 * Test of Category
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsBlockComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsRoomRoleComponent', 'NetCommons.Controller/Component');
App::uses('YACakeTestCase', 'NetCommons.TestSuite');
App::uses('AuthComponent', 'Component');
App::uses('Block', 'Blocks.Model');
App::uses('Category', 'Categories.Model');
App::uses('CategoryOrder', 'Categories.Model');

/**
 * Test of Category
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\Categories\Test\Case\Model
 */
class CategoryTestBase extends YACakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.blocks.block',
		'plugin.categories.category',
		'plugin.categories.category_order',
		'plugin.users.user_attributes_user',
		'plugin.users.user',
	);

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Category = ClassRegistry::init('Categories.Category');
		$this->CategoryOrder = ClassRegistry::init('Categories.CategoryOrder');
		$this->Block = ClassRegistry::init('Blocks.Block');
	}

/**
 * tearDown
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Category);
		unset($this->CategoryOrder);
		unset($this->Block);

		parent::tearDown();
	}

/**
 * Do test assert, after created_date, created_user, modified_date and modified_user fields remove.
 *
 * @param array $expected expected data
 * @param array $result result data
 * @return void
 */
	protected function _assertArray($expected, $result) {
		$result = Hash::remove($result, 'created');
		$result = Hash::remove($result, 'created_user');
		$result = Hash::remove($result, 'modified');
		$result = Hash::remove($result, 'modified_user');
		$result = Hash::remove($result, '{s}.created');
		$result = Hash::remove($result, '{s}.created_user');
		$result = Hash::remove($result, '{s}.modified');
		$result = Hash::remove($result, '{s}.modified_user');
		$result = Hash::remove($result, '{n}.{s}.created');
		$result = Hash::remove($result, '{n}.{s}.created_user');
		$result = Hash::remove($result, '{n}.{s}.modified');
		$result = Hash::remove($result, '{n}.{s}.modified_user');
		$result = Hash::remove($result, 'TrackableCreator');
		$result = Hash::remove($result, 'TrackableUpdater');
		$result = Hash::remove($result, '{n}.TrackableCreator');
		$result = Hash::remove($result, '{n}.TrackableUpdater');

		$this->assertEquals($expected, $result);
	}
}
