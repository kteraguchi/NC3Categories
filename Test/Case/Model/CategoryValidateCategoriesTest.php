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
class CategoryValidateCategoriesTest extends CategoryTestBase {

/**
 * Default save data
 *
 * @var array
 */
	private $__defaultData = array(
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
			1 => array(
				'Category' => array(
					'id' => '2',
					'key' => 'category_2',
					'name' => 'category_2',
				),
				'CategoryOrder' => array(
					'id' => '2',
					'category_key' => 'category_2',
					'weight' => '2'
				),
			),
			2 => array(
				'Category' => array(
					'id' => '3',
					'key' => 'category_3',
					'name' => 'category_3',
				),
				'CategoryOrder' => array(
					'id' => '3',
					'category_key' => 'category_3',
					'weight' => '3'
				),
			),
		)
	);

/**
 * Expect Categories `block_id`
 *
 * @return void
 */
	public function test() {
		//データ生成
		$data = $this->__defaultData;

		//テスト実施(カラムなし)
		$result = $this->Category->validateCategories($data);

		//期待値の生成
		$expected = $data;
		$expected = Hash::insert($expected, 'Categories.{n}.Category.block_id', (int)$data['Block']['id']);
		$expected = Hash::insert($expected, 'Categories.{n}.CategoryOrder.block_key', $data['Block']['key']);

		$this->assertEquals($result, $expected);
	}

/**
 * Expect Categories `block_id`
 *
 * @return void
 */
	public function testBlockId() {
		//データ生成
		$data = $this->__defaultData;
		unset($data['Block']);
		$data = Hash::remove($data, 'Categories.{n}.{s}.id');

		//テスト実施(カラムなし)
		$result = $this->Category->validateCategories($data);

		//期待値の生成
		$expected = $data;

		$this->assertEquals($result, $expected);
	}

/**
 * Expect to save the categories
 *
 * @return void
 */
	public function testValidateError() {
		//データ生成
		$data = Hash::merge($this->__defaultData, array(
			'Categories' => array(
				0 => array(
					'Category' => array(
						'name' => '',
					),
				),
			)
		));
		//テスト実施
		$result = $this->Category->validateCategories($data);
		$this->assertFalse($result);
	}

}
