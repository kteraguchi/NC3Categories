<?php
/**
 * Test of CategoriesComponent->initialize()
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CategoriesComponentTest', 'Categories.Test/Case/Controller/Component');

/**
 * Test of CategoriesComponent->initialize()
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\Categories\Test\Case\Controller
 */
class CategoriesComponentTestInitialize extends CategoriesComponentTest {

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->_initCategoriesComponent();
	}

/**
 * Expect to CategoriesComponent->initialize()
 *
 * @return void
 */
	public function test() {
		$this->Categories->initialize($this->CategoryController);
		$this->assertEquals('object', gettype($this->Categories->controller));
	}

}
