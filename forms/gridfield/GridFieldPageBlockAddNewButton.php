<?php

/**
 * This component provides a button for opening the add new form provided by 
 * {@link GridFieldDetailForm}.
 *
 * Only returns a button if {@link DataObject->canCreate()} for this record 
 * returns true.
 *
 * @package framework
 * @subpackage fields-gridfield
 *
 * @author Michael Strong <github@michaelstrong.co.uk>
 */
class GridFieldPageBlockAddNewButton extends GridFieldAddNewButton 
	implements GridField_ActionProvider {

	public function getHTMLFragments($gridField) {

		$singleton = singleton($gridField->getModelClass());

		if(!$singleton->canCreate()) {
			return array();
		}

		$parent = SiteTree::get()->byId(Controller::curr()->currentPageID());
		$BlockTypeList = ClassInfo::subClassesFor("PageBlock");
		unset($BlockTypeList["PageBlock"]);					 
		$first_key = key($BlockTypeList);
		// echo '<pre>' . print_r($BlockTypeList[$first_key], true) . '</pre>';
		// die();
					 
		if(!$this->buttonName) {
			// provide a default button name, can be changed by calling {@link setButtonName()} on this component
			$objectName = $singleton->i18n_singular_name();
			$this->buttonName = _t('GridFieldSiteTreeAddNewButton.Add', 'Add {name}', "Add button text", array('name' => $singleton->i18n_singular_name()));
		}

		$state = $gridField->State->GridFieldSiteTreeAddNewButton;
		$state->currentPageID = $parent->ID;
		$state->blockType = $BlockTypeList[$first_key];

		$addAction = new GridField_FormAction($gridField, 
			'add',
			$this->buttonName, 
			'add', 
			'add'
		);
		$addAction->setAttribute('data-icon', 'add')->addExtraClass("no-ajax");

		$blockTypes = array();
		foreach($BlockTypeList as $block) {
			if ($block == "PageBlock"){
				//don't want to show the base class
				continue;
			}
			$blockTypes[$block] = singleton($block)->i18n_singular_name();
		}

		$BlockTypesField = DropdownField::create(
			"BlockType", 
			"Block Type",
			$blockTypes
		);
		$BlockTypesField->setFieldHolderTemplate("BlogDropdownField_holder")
			->addExtraClass("gridfield-dropdown no-change-track");

		$forTemplate = new ArrayData(array());
		$forTemplate->Fields = new ArrayList();
		$forTemplate->Fields->push($BlockTypesField);
		$forTemplate->Fields->push($addAction);
		// echo '<pre>' . print_r(blockBuilder_dir() . "/css/cms.css", true) . '</pre>';
		// die();
					 
		Requirements::css(blockBuilder_dir() . "/css/cms.css");
		Requirements::javascript(blockBuilder_dir() . "/javascript/GridField.js");
// die('yo');
		return array(
			$this->targetFragment => $forTemplate->renderWith("GridFieldSiteTreeAddNewButton")
		);
	}



	/**
	 * Provide actions to this component.
	 *
	 * @param $gridField GridField
	 *
	 * @return array
	**/
	public function getActions($gridField) {
		return array("add");
	}



	/**
	 * Handles the add action, but only acts as a wrapper for {@link CMSPageAddController::doAdd()}
	 *
	 * @param $gridFIeld GridFIeld
	 * @param $actionName string
	 * @param $arguments mixed
	 * @param $data array
	**/
	public function handleAction(GridField $gridField, $actionName, $arguments, $data) {
		// echo '<pre>' . print_r(Controller::curr(), true) . '</pre>';
		// die();
		if($actionName == "add") {
			$tmpData = json_decode($data['PageBlocks']['GridState'], true);
			$tmpData = $tmpData['GridFieldSiteTreeAddNewButton'];
			
			$data = array(
				"ParentID" => $tmpData['currentPageID'],
				"blockType" => $tmpData['blockType']
			);

			//create a new pageBlock of the selected type
			$newBlock = new $data["blockType"];
			$newBlock->PageID = $data["ParentID"];
			$newBlock->Name = "New " . $newBlock->i18n_singular_name();
			$newBlock->write();
			// echo '<pre>' . print_r($newBlock, true) . '</pre>';
			// die();
						 
			//link to the current page.
			//reload gridfield?

			$controller = Controller::curr();
			// echo '<pre>' . print_r($controller, true) . '</pre>';
			// die();
			
			$controller = Injector::inst()->create("CMSPageAddController");

			$form = $controller->AddForm();
			$form->loadDataFrom($data);

			// $controller->doAdd($data, $form);
			$response = $controller->getResponseNegotiator()->getResponse();
			// echo '<pre>' . print_r($response, true) . '</pre>';
			// die();
						 
			// $response = $controller->getResponseNegotiator()->getResponse();

			// Get the current record
			$record = SiteTree::get()->byId($controller->currentPageID());
			// echo '<pre>' . print_r($gridField->Link('item'), true) . '</pre>';
			// die();
			$Link = Controller::join_links($gridField->Link('item'), $newBlock->ID);
			// echo '<pre>' . print_r($Link, true) . '</pre>';
			// die();
						 
			if($record) {
				$response->redirect('/' . $Link, 301);
			}
			return $response;

		}
	}

}
