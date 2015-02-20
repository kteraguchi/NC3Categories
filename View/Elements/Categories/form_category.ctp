<?php
/**
 * FaqCategories form category element template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>
<div class="row form-group"
	 ng-repeat="c in categoryList.list track by $index">
	<div class="col-xs-12 col-md-12">
		<div class="input-group">
			<div class="input-group-btn">
				<button class="btn btn-default"
						ng-click="sortCategory('up', $index)"
						ng-disabled="$first">
					<span class="glyphicon glyphicon-arrow-up"></span>
				</button>
				<button class="btn btn-default"
						ng-click="sortCategory('down', $index)"
						ng-disabled="$last">
					<span class="glyphicon glyphicon-arrow-down"></span>
				</button>
			</div>
			<input type="text" name="name{{$index}}" class="form-control" required
				   ng-model="c.category.name"/>
			<div class="input-group-btn">
				<button class="btn btn-default"
						tooltip="<?php echo __d('faqs', 'Delete'); ?>"
						ng-click="deleteCategory($index)">

					<span class="glyphicon glyphicon-remove"> </span>
				</button>
			</div>
		</div>
	</div>
</div>

<div class="text-center">
	<button class="btn btn-success" ng-click="addCategory()">
		<span class="glyphicon glyphicon-plus"></span>
		<?php echo __d('faqs', 'Add category'); ?>
	</button>
</div>
