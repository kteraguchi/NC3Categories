<?php
/**
 * Test of CategoryOrder->validateCategoryOrder()
 *
 * @property CategoryOrder $CategoryOrder
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CategoryTestBase', 'Categories.Test/Case/Model');

/**
 * Test of CategoryOrder->validateCategoryOrder()
 */
class CategoryOrderValidateCategoryOrderTest extends CategoryTestBase {

/**
 * Default save data
 *
 * @var array
 */
	private $__defaultData = array(
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
 * Test case of number
 *
 * @var array
 */
	private $__validateNumber = array(
		null, '', 'abcde', false, true, '123abcd'
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
		$result = $this->CategoryOrder->validateCategoryOrder($data);
		//戻り値チェック
		$expectMessage = 'Expect `' . $field . '` field, error data: ' . print_r($data, true);
		$this->assertFalse($result, $expectMessage);
		//validationErrorsチェック
		$this->assertEquals($this->CategoryOrder->validationErrors, $expected);
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
		$result = $this->CategoryOrder->validateCategoryOrder($data);
		$this->assertTrue($result);
	}

/**
 * Expect CategoryOrder `block_key` error by notEmpty error on update
 *
 * @return void
 */
	public function testBlockKeyErrorByNotEmptyOnUpdate() {
		$field = 'block_key';
		$message = __d('net_commons', 'Invalid request.');

		//データ生成
		$data = $this->__defaultData;

		//期待値
		$expected = array(
			$field => array($message)
		);

		//テスト実施(カラムなし)
		//unset($data['CategoryOrder'][$field]);
		//$this->__assertValidationError($field, $data, $expected);

		//テスト実施
		foreach ($this->__validateNotEmpty as $check) {
			$data['CategoryOrder'][$field] = $check;
			$this->__assertValidationError($field, $data, $expected);
		}
	}

/**
 * Expect CategoryOrder `block_key` error by notEmpty error on update
 *
 * @return void
 */
	public function testCategoryKeyErrorByNotEmptyOnUpdate() {
		$field = 'category_key';
		$message = __d('net_commons', 'Invalid request.');

		//データ生成
		$data = $this->__defaultData;

		//期待値
		$expected = array(
			$field => array($message)
		);

		//テスト実施(カラムなし)
		unset($data['CategoryOrder'][$field]);
		$this->__assertValidationError($field, $data, $expected);

		//テスト実施
		foreach ($this->__validateNotEmpty as $check) {
			$data['CategoryOrder'][$field] = $check;
			$this->__assertValidationError($field, $data, $expected);
		}
	}

/**
 * Expect CategoryOrder `weight` error by Number error on create
 *
 * @return void
 */
	public function testWeightErrorByNumber() {
		$field = 'weight';
		$message = __d('net_commons', 'Invalid request.');

		//データ生成
		$data = $this->__defaultData;

		//期待値
		$expected = array(
			$field => array($message)
		);

		//テスト実施
		foreach ($this->__validateNumber as $check) {
			$data['CategoryOrder'][$field] = $check;
			$this->__assertValidationError($field, $data, $expected);
		}
	}
}
