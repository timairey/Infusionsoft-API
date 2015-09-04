<?php

/**
 * GridField config necessary for managing a SiteTree object.
 *
 * @package silverstripe
 * @subpackage blog
 *
 * @author Michael Strong <github@michaelstrong.co.uk>
**/
class GridFieldConfig_InfusionFieldCreator extends GridFieldConfig {
	
	public function __construct($itemsPerPage = null) {
		parent::__construct($itemsPerPage);
		$this->addComponent(new GridFieldButtonRow('before'));
		$this->addComponent(new GridFieldInfusionFieldAddNewButton('buttons-before-left'));
		$this->addComponent(new GridFieldToolbarHeader());
		$this->addComponent($sort = new GridFieldSortableHeader());
		$this->addComponent($filter = new GridFieldFilterHeader());
		$this->addComponent(new GridFieldDataColumns());
		$this->addComponent(new GridFieldEditButton());
		$this->addComponent(new GridFieldDeleteAction());
		$this->addComponent(new GridFieldPageCount('toolbar-header-right'));
		$this->addComponent($pagination = new GridFieldPaginator($itemsPerPage));
		$this->addComponent(new GridFieldDetailForm());
		// $this->addComponent(new GridFieldEditableColumns());
		$pagination->setThrowExceptionOnBadDataType(true);
	}
}