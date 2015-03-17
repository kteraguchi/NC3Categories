<?php
/**
 * category form element template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div ng-hide="categoryList.length">
	<p>
		<?php echo __d('categories', 'No category.'); ?>
	</p>
</div>
<div class="form-group"
	 ng-repeat="c in categoryList track by $index">
	<div class="input-group" ng-class="(validationErrors[$index].name) ? ' has-error' : ''">
		<div class="input-group-btn">
			<button type="button" class="btn btn-default"
					ng-click="sortCategory('up', $index)"
					ng-disabled="$first">
				<span class="glyphicon glyphicon-arrow-up"></span>
			</button>
			<button type="button" class="btn btn-default"
					ng-click="sortCategory('down', $index)"
					ng-disabled="$last">
				<span class="glyphicon glyphicon-arrow-down"></span>
			</button>
		</div>
		<input type="hidden" name="data[{{$index}}][Category][id]"   ng-value="c.category.id"/>
		<input type="hidden" name="data[{{$index}}][Category][key]"  ng-value="c.category.key"/>
		<input type="text"   name="data[{{$index}}][Category][name]" ng-model="c.category.name" class="form-control" required/>
		<div class="input-group-btn">
			<button type="button" class="btn btn-default"
					tooltip="<?php echo __d('net_commons', 'Delete'); ?>"
					ng-click="deleteCategory($index)">

				<span class="glyphicon glyphicon-remove"> </span>
			</button>
		</div>
	</div>
</div>

<div class="text-center">
	<button type="button" class="btn btn-success" ng-click="addCategory()">
		<span class="glyphicon glyphicon-plus"></span>
		<?php echo __d('categories', 'Add Category'); ?>
	</button>
</div>

