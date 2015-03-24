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

App::uses('CategoriesModelTestCase', 'Categories.Test/Case/Model');

/**
 * Category Model Test Case
 */
class CategoryValidateErrorTest extends CategoriesModelTestCase {

/**
 * Expect Faq->saveCategory()
 *
 * @return void
 */
	public function testSaveCategory() {
		//データ生成
		$blockId = 1;
		$blockKey = 'block_1';
		$dataList = array(
			0 => array(
				'Category' => array(
					'id' => '2',
					'name' => '',
				),
			),
			1 => array(
				'Category' => array(
					'id' => '1',
					'name' => 'category_1',
				),
			),
		);

		//期待値
		$expected = array(
			'0' => array(
				'name' => array(
					0 => __d('net_commons', 'Invalid request.'),
				),
			)
		);

		//テスト実施
		$this->__assertSaveCategory('comment', $dataList, $expected, $blockId, $blockKey);
	}

/**
 * __assertSaveCategory
 *
 * @param string $field Field name
 * @param array $data Save data
 * @param array $expected Expected value
 * @param int $blockId blocks.id
 * @param string $blockKey blocks.key
 * @return void
 */
	private function __assertSaveCategory($field, $data, $expected, $blockId, $blockKey) {
		//初期処理
		$this->setUp();
		//登録処理実行
		$result = $this->Category->saveCategory($data, $blockId, $blockKey);
		//戻り値テスト
		$this->assertFalse($result, 'Result error: ' . $field . ' ' . print_r($data, true));
		//validationErrorsテスト
		$this->assertEquals($this->Category->validationErrors, $expected,
							'Validation error: ' . $field . ' ' . print_r($this->Category->validationErrors, true) . print_r($data, true));
		//終了処理
		$this->tearDown();
	}
}
