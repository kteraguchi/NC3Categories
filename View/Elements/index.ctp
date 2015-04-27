<?php
/**
 * Element of Categories index
 *   - $categories:
 *       The results data of Category->getCategories(), and The formatter is camelized data.
 *   - $frameId: frames.id
 *   - $blockId: blocks.id
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

$categories = array_map('h', Hash::combine($categories, '{n}.category.id', '{n}.category.name'));
?>

<div class="panel panel-default">
	<div class="panel-heading clearfix">
		<span>
			<?php echo __d('categories', 'Category'); ?>
		</span>
		<div class="pull-right">
			<a class="btn btn-xs btn-primary"
			   href="<?php echo $this->Html->url('/' . $this->params['plugin'] . '/categories/edit/' . $frameId . '/' . $blockId); ?>">
				<span class="glyphicon glyphicon-edit"> </span>
			</a>
		</div>
	</div>
	<div class="panel-body">
		<?php if ($categories && count($categories)): ?>
			<?php echo implode(', ', $categories) ?>
		<?php else: ?>
			<?php echo __d('categories', 'No category.'); ?>
		<?php endif; ?>
	</div>
</div>
