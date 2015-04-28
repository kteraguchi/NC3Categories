<?php
/**
 * Test of CategoriesComponent
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
App::uses('CategoriesComponent', 'Categories.Controller/Component');
App::uses('Frame', 'Frames.Model');
App::uses('Block', 'Blocks.Model');
App::uses('Category', 'Categories.Model');
App::uses('CategoryOrder', 'Categories.Model');

/**
 * Controller for CategoriesComponent test
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\Categories\Test\Case\Controller
 */
class TestCategoriesController extends AppController {

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

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsFrame',
	);

/**
 * Redirects to given $url, after turning off $this->autoRender.
 * Script execution is halted after the redirect.
 *
 * @param string|array $url A string or array-based URL pointing to another location within the app,
 *     or an absolute URL
 * @param int $status Optional HTTP status code (eg: 404)
 * @param bool $exit If true, exit() will be called after the redirect
 * @return void
 * @link http://book.cakephp.org/2.0/en/controllers.html#Controller::redirect
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function redirect($url, $status = null, $exit = true) {
		$this->autoRender = false;
	}

}

/**
 * Test of CategoriesComponent test
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\Categories\Test\Case\Controller
 */
class CategoriesComponentTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.blocks.block',
		'plugin.boxes.box',
		'plugin.categories.category',
		'plugin.categories.category_order',
		'plugin.frames.frame',
		'plugin.m17n.language',
		'plugin.m17n.languages_page',
		'plugin.pages.page',
		'plugin.roles.default_role_permission',
		'plugin.rooms.room',
		'plugin.rooms.roles_rooms_user',
		'plugin.rooms.roles_room',
		'plugin.rooms.room_role_permission',
		'plugin.users.user_attributes_user',
		'plugin.users.user',
	);

/**
 * CategoriesComponent component
 *
 * @var mixed
 */
	public $Categories = null;

/**
 * Controller of CategoriesComponent test
 *
 * @var mixed
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
		$this->_initCategoriesComponent();
	}

/**
 * tearDown
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();

		unset($this->Categories);
		unset($this->CategoryController);

		Configure::write('Config.language', null);
	}

/**
 * Called before the test().
 *
 * @return void
 */
	public function test() {
	}

/**
 * Initialize of CategoriesComponent
 *
 * @param string $url Trimmed URL string to use. Should not contain the application base path.
 * @param bool $parseEnvironment Set to false to not auto parse the environment. ie. GET, POST and FILES.
 * @param array $params Set CakeRequest->params
 * @return void
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	protected function _initCategoriesComponent($url = null, $parseEnvironment = true, $params = []) {
		//テストコントローラ読み込み
		$CakeRequest = new CakeRequest($url, $parseEnvironment);
		$CakeRequest->params = Hash::merge($CakeRequest->params, $params);

		$CakeResponse = new CakeResponse();
		$this->CategoryController = new TestCategoriesController($CakeRequest, $CakeResponse);
		//コンポーネント読み込み
		$Collection = new ComponentCollection();
		$this->Categories = new CategoriesComponent($Collection);
	}

}
