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

App::uses('CategoryTestBase', 'Categories.Test/Case/Model');

/**
 * Category Model Test Case
 */
class CategoryValidateCategoryTest extends CategoryTestBase {

/**
 * Default save data
 *
 * @var array
 */
	private $__defaultData = array(
		'Category' => array(
			'id' => '1',
			'key' => 'category_1',
			'name' => 'category_1',
			'block_id' => '1',
		),
		'CategoryOrder' => array(
			'id' => '1',
			'category_key' => 'category_1',
			'weight' => '1',
			'block_key' => 'block_1',
		),
	);

/**
 * Test case of notEmpty
 *
 * @var array
 */
	private $__validateNotEmpty = array(
		null, '', false,
	);

/**
 * __assertValidationError
 *
 * @param string $field Field name
 * @param array $data Save data
 * @param array $expected Expected value
 * @return void
 */
	private function __assertValidationError($field, $data, $expected) {
		//初期処理
		$this->setUp();
		//validate処理実行
		$result = $this->Category->validateCategory($data, ['categoryOrder']);
		//戻り値チェック
		$expectMessage = 'Expect `' . $field . '` field, error data: ' . print_r($data, true);
		$this->assertFalse($result, $expectMessage);
		//validationErrorsチェック
		$this->assertEquals($this->Category->validationErrors, $expected);
		//終了処理
		$this->tearDown();
	}

/**
 * Expect to save the categories
 *
 * @return void
 */
	public function test() {
		//データ生成
		$data = $this->__defaultData;

		//処理実行
		$result = $this->Category->validateCategory($data, ['categoryOrder']);
		$this->assertTrue($result);
	}

/**
 * Expect Category `block_id` error by notEmpty error on update
 *
 * @return void
 */
	public function testBlockIdErrorByNotEmptyOnUpdate() {
		$field = 'block_id';
		$message = __d('net_commons', 'Invalid request.');

		//データ生成
		$data = $this->__defaultData;

		//期待値
		$expected = array(
			$field => array($message)
		);

		//テスト実施(カラムなし)
		unset($data['Category'][$field]);
		$this->__assertValidationError($field, $data, $expected);

		//テスト実施
		foreach ($this->__validateNotEmpty as $check) {
			$data['Category'][$field] = $check;
			$this->__assertValidationError($field, $data, $expected);
		}
	}

/**
 * Expect Category `name` validation error by notEmpty error on create
 *
 * @return void
 */
	public function testNameErrorByNotEmptyOnCreate() {
		$field = 'name';
		$message = sprintf(__d('net_commons', 'Please input %s.'), __d('categories', 'Category'));

		//データ生成
		$data = $this->__defaultData;
		unset($data['Category']['id'], $data['CategoryOrder']['id']);

		//期待値
		$expected = array(
			$field => array($message)
		);

		//テスト実施(カラムなし)
		unset($data['Category'][$field]);
		$this->__assertValidationError($field, $data, $expected);

		//テスト実施
		foreach ($this->__validateNotEmpty as $check) {
			$data['Category'][$field] = $check;
			$this->__assertValidationError($field, $data, $expected);
		}
	}

/**
 * Expect Category `key` error by notEmpty error on update
 *
 * @return void
 */
	public function testKeyErrorByNotEmptyOnUpdate() {
		$field = 'key';
		$message = __d('net_commons', 'Invalid request.');

		//データ生成
		$data = $this->__defaultData;

		//期待値
		$expected = array(
			$field => array($message)
		);

		//テスト実施(カラムなし)
		unset($data['Category'][$field]);
		$this->__assertValidationError($field, $data, $expected);

		//テスト実施
		foreach ($this->__validateNotEmpty as $check) {
			$data['Category'][$field] = $check;
			$this->__assertValidationError($field, $data, $expected);
		}
	}

/**
 * Expect CategoryOrder validation error
 *
 * @return void
 */
	public function testCategoryOrderValidationError() {
		$field = 'block_key';
		$message = __d('net_commons', 'Invalid request.');

		//データ生成
		$data = $this->__defaultData;

		//期待値
		$expected = array(
			$field => array($message)
		);

		//テスト実施
		$data['CategoryOrder'][$field] = '';
		$this->__assertValidationError($field, $data, $expected);
	}
}
