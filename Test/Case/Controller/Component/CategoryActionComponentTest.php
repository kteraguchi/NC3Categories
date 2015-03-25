<?php
/**
 * CategoriesActionComponent Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');
App::uses('CakeRequest', 'Network');
App::uses('CakeResponse', 'Network');
App::uses('ComponentCollection', 'Controller');
App::uses('CategoryActionComponent', 'Categories.Controller/Component');
App::uses('Frame', 'Frames.Model');
App::uses('Block', 'Blocks.Model');
App::uses('Category', 'Categories.Model');
App::uses('CategoryOrder', 'Categories.Model');

/**
 * Controller for CategoryAction component test
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\NetCommons\Test\Case\Controller
 */
class TestCategoryActionController extends AppController {

/**
 * use model
 *
 * @var array
 */
	public $uses = array(
		'Frames.Frame',
		'Blocks.Block',
		'Categories.Category',
		'Categories.CategoryOrder',
	);
}

/**
 * CategoryAction Component test case
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\Categories\Test\Case\Controller
 */
class CategoryActionComponentTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.categories.block',
		'plugin.categories.frame',
		'plugin.frames.box',
		'plugin.m17n.language',
		'plugin.m17n.languages_page',
		'plugin.pages.page',
		'plugin.roles.default_role_permission',
		'plugin.rooms.room',
		'plugin.rooms.roles_rooms_user',
		'plugin.rooms.roles_room',
		'plugin.rooms.room_role_permission',
	);

/**
 * CategoryAction component
 *
 * @var Component CategoriesAction component
 */
	public $CategoriesAction = null;

/**
 * Controller for CategoryAction component test
 *
 * @var Controller Controller for CategoryAction component test
 */
	public $CategoryController = null;

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		Configure::write('Config.language', 'ja');

		//テストコントローラ読み込み
		$CakeRequest = new CakeRequest();
		$CakeResponse = new CakeResponse();
		$this->CategoryController = new TestCategoryActionController($CakeRequest, $CakeResponse);
		//コンポーネント読み込み
		$Collection = new ComponentCollection();
		$this->CategoriesAction = new CategoryActionComponent($Collection);
		$this->CategoriesAction->viewSetting = false;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();

		unset($this->CategoriesAction);
		unset($this->CategoryController);

		Configure::write('Config.language', null);
	}

/**
 * testInitialize method
 *
 * @return void
 */
	public function testInitialize() {
		$this->CategoriesAction->initialize($this->CategoryController);
		$expected = array();
		$this->assertEquals($expected, $this->CategoryController->viewVars);
	}
}
