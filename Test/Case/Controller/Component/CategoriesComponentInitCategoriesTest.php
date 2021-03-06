<?php
/**
 * Test of CategoriesComponent->initCategories()
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CategoriesComponentTestBase', 'Categories.Test/Case/Controller/Component');

/**
 * Test of CategoriesComponent->initCategories()
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\Categories\Test\Case\Controller
 */
class CategoriesComponentInitCategoriesTest extends CategoriesComponentTestBase {

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->_initCategoriesComponent();
		$this->Categories->initialize($this->CategoryController);
	}

/**
 * Expect to CategoriesComponent->initCategories()
 *
 * @return void
 */
	public function test() {
		$this->Categories->controller->viewVars['blockId'] = '1';
		$this->Categories->controller->viewVars['roomId'] = '1';

		$this->Categories->initCategories();

		$this->assertCount(3, $this->Categories->controller->viewVars['categories']);
	}

/**
 * Expect to CategoriesComponent->initCategories() by true on hasEmpty
 *
 * @return void
 */
	public function testHasEmpty() {
		$this->Categories->controller->viewVars['blockId'] = '1';
		$this->Categories->controller->viewVars['roomId'] = '1';

		$this->Categories->initCategories(true);

		$this->assertCount(4, $this->Categories->controller->viewVars['categories']);
	}

/**
 * Expect to CategoriesComponent->initCategories() by another roomId
 *
 * @return void
 */
	public function testAnotherRoomId() {
		$this->Categories->controller->viewVars['blockId'] = '1';
		$this->Categories->controller->viewVars['roomId'] = '3';

		$this->Categories->initCategories();

		$this->assertCount(0, $this->Categories->controller->viewVars['categories']);
	}
}
