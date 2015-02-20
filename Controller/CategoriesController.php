<?php
/**
 * Categories Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CategoriesAppController', 'Categories.Controller');

/**
 * Categories Controller
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\Categories\Controller
 */
class CategoriesController extends CategoriesAppController {

/**
 * use model
 *
 * @var array
 */
	public $uses = array(
		'Categories.Category',
	);

/**
 * use component
 *
 * @var array
 */
	public $components = array();

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.Token'
	);

/**
 * index method
 *
 * @param int $frameId frames.id
 * @return CakeResponse A response object containing the rendered view.
 */
	public function index($frameId = 0) {
		return $this->render('Categories/index');
	}
}
