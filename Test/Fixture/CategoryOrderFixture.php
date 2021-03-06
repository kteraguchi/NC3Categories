<?php
/**
 * CategoryOrderFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * CategoryOrderFixture
 */
class CategoryOrderFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID |  |  | '),
		'category_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'category key | カテゴリーKey | categories.key | ', 'charset' => 'utf8'),
		'block_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'block key | ブロックKey | blocks.key | ', 'charset' => 'utf8'),
		'weight' => array('type' => 'integer', 'null' => false, 'default' => '0', 'comment' => 'The weight of the display(display order) | 表示の重み(表示順序) |  | '),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'created user | 作成者 | users.id | '),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created datetime | 作成日時 |  | '),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'modified user | 更新者 | users.id | '),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'modified datetime | 更新日時 |  | '),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'category_key' => 'category_1',
			'block_key' => 'block_1',
			'weight' => 1,
			'created_user' => 1,
			'created' => '2015-01-28 04:57:05',
			'modified_user' => 1,
			'modified' => '2015-01-28 04:57:05'
		),
		array(
			'id' => 2,
			'category_key' => 'category_2',
			'block_key' => 'block_1',
			'weight' => 2,
			'created_user' => 1,
			'created' => '2015-01-28 04:57:05',
			'modified_user' => 1,
			'modified' => '2015-01-28 04:57:05'
		),
		array(
			'id' => 3,
			'category_key' => 'category_3',
			'block_key' => 'block_1',
			'weight' => 3,
			'created_user' => 1,
			'created' => '2015-01-28 04:57:05',
			'modified_user' => 1,
			'modified' => '2015-01-28 04:57:05'
		),

		//Faqs plugin
		array(
			'id' => 100,
			'category_key' => 'category_100',
			'block_key' => 'block_100',
			'weight' => 1,
			'created_user' => 1,
			'created' => '2015-01-28 04:57:05',
			'modified_user' => 1,
			'modified' => '2015-01-28 04:57:05'
		),

	);

}
