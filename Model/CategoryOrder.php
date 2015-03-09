<?php
/**
 * CategoryOrder Model
 *
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CategoriesAppModel', 'Categories.Model');

/**
 * CategoryOrder Model
 */
class CategoryOrder extends CategoriesAppModel {

/**
 * Primary Key
 *
 * @var string
 */
	public $primaryKey = 'category_key';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();
}
