<?php
/**
 * Element of Categories edit form
 *   - $categories:
 *       The results data of Category->getCategories(), and The formatter is camelized data.
 *   - $cancelUrl: Cancel url.
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Html->script('/categories/js/categories.js', false); ?>

<?php echo $this->Form->create('Category', array('novalidate' => true)); ?>
	<?php $this->Form->unlockField('Categories'); ?>

	<div class="panel panel-default" ng-controller="Categories" ng-init="initialize(<?php echo h(json_encode(['categories' => $categories])); ?>)">
		<div class="panel-heading">
			<?php echo __d('categories', 'Category'); ?>
		</div>

		<div class="panel-body">
			<div class="form-group text-right">
				<button type="button" class="btn btn-success" ng-click="add()">
					<span class="glyphicon glyphicon-plus"> </span>
				</button>
			</div>

			<?php echo $this->Form->hidden('Block.id', array(
					'value' => $blockId,
				)); ?>

			<?php echo $this->Form->hidden('Block.key', array(
					'value' => $blockKey,
				)); ?>


			<div ng-hide="categories.length">
				<p><?php echo __d('categories', 'No category.'); ?></p>
			</div>

			<div class="form-group" ng-repeat="c in categories track by $index">

				<div class="input-group">
					<div class="input-group-btn">
						<button type="button" class="btn btn-default"
								ng-click="move('up', $index)" ng-disabled="$first">
							<span class="glyphicon glyphicon-arrow-up"></span>
						</button>

						<button type="button" class="btn btn-default"
								ng-click="move('down', $index)" ng-disabled="$last">
							<span class="glyphicon glyphicon-arrow-down"></span>
						</button>
					</div>

					<input type="hidden" name="data[Categories][{{$index}}][Category][id]" ng-value="c.category.id">
					<input type="hidden" name="data[Categories][{{$index}}][Category][key]" ng-value="c.category.key">
					<input type="hidden" name="data[Categories][{{$index}}][CategoryOrder][id]" ng-value="c.categoryOrder.id">
					<input type="hidden" name="data[Categories][{{$index}}][CategoryOrder][category_key]" ng-value="c.categoryOrder.categoryKey">
					<input type="hidden" name="data[Categories][{{$index}}][CategoryOrder][weight]" ng-value="{{$index + 1}}">
					<input type="text" name="data[Categories][{{$index}}][Category][name]" ng-model="c.category.name" class="form-control" required>

					<div class="input-group-btn">
						<button type="button" class="btn btn-default" tooltip="<?php echo __d('net_commons', 'Delete'); ?>"
								ng-click="delete($index)">
							<span class="glyphicon glyphicon-remove"> </span>
						</button>
					</div>
				</div>
			</div>
		</div>

		<div class="panel-footer text-center">
			<button type="button" class="btn btn-default btn-workflow" onclick="location.href = '<?php echo $cancelUrl; ?>'">
				<span class="glyphicon glyphicon-remove"></span>
				<?php echo __d('net_commons', 'Cancel'); ?>
			</button>

			<?php echo $this->Form->button(__d('net_commons', 'OK'), array(
					'class' => 'btn btn-primary btn-workflow',
					'name' => 'save',
				)); ?>
		</div>
	</div>

<?php echo $this->Form->end();

