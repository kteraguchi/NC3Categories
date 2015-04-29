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

App::uses('CategoriesComponentTest', 'Categories.Test/Case/Controller/Component');

/**
 * Test of CategoriesComponent->initCategories()
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\Categories\Test\Case\Controller
 */
class CategoriesComponentTestEdit extends CategoriesComponentTest {

/**
 * Expect to CategoriesComponent->edit() by GET request.
 *
 * @return void
 */
	public function testGet() {
		//データ生成
		$params = array(
			'plugin' => 'test',
			'pass' => array('1', '1')
		);
		$this->_initCategoriesComponent($params);
		$this->Categories->initialize($this->CategoryController);
		$this->Categories->controller->viewVars['roomId'] = '1';
		$this->Categories->controller->viewVars['blockId'] = '1';

		//edit()実行
		$this->Categories->edit();

		$this->assertCount(3, $this->Categories->controller->viewVars['categories']);
	}

/**
 * Expect to CategoriesComponent->edit() by Post request.
 *
 * @return void
 */
	public function testPost() {
		//データ生成
		$params = array(
			'plugin' => 'test',
			'pass' => array('1', '1'),
		);
		$_POST = array(
			'_method' => 'POST',
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
			)
		);

		$this->_initCategoriesComponent($params);
		$this->Categories->initialize($this->CategoryController);
		$this->Categories->controller->viewVars['frameId'] = '1';
		$this->Categories->controller->viewVars['blockId'] = '1';
		$this->Categories->controller->viewVars['roomId'] = '1';

		//edit()実行
		$this->Categories->edit();

		$this->assertFalse($this->Categories->controller->autoRender);
	}

/**
 * Expect validationError of CategoriesComponent->edit() by Post request.
 *
 * @return void
 */
	public function testPostValidationError() {
		//データ生成
		$params = array(
			'plugin' => 'test',
			'pass' => array('1', '1'),
		);
		$_POST = array(
			'_method' => 'POST',
			'Block' => array(
				'id' => '1',
				'key' => 'block_1'
			),
			'Categories' => array(
				0 => array(
					'Category' => array(
						'id' => '1',
						'key' => 'category_1',
						'name' => '',
					),
					'CategoryOrder' => array(
						'id' => '1',
						'category_key' => 'category_1',
						'weight' => '1'
					),
				),
			)
		);

		$this->_initCategoriesComponent($params);
		$this->Categories->initialize($this->CategoryController);
		$this->Categories->controller->viewVars['frameId'] = '1';
		$this->Categories->controller->viewVars['blockId'] = '1';
		$this->Categories->controller->viewVars['roomId'] = '1';

		//edit()実行
		$this->Categories->edit();

		$this->assertTrue($this->Categories->controller->autoRender);
		$this->assertCount(1, $this->Categories->controller->viewVars['categories']);
	}

}
