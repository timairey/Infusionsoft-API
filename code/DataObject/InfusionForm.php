<?php
class InfusionForm extends DataObject {
	static $db = array(
    "Title"       => "Varchar(255)",
    "Description" => "HTMLText",
    "ButtonText"  => 'Varchar(255)',
    // "Action"    => 'Varchar(255)'
	);

    static $has_one = array(
      "ThankyouPage"        => "SiteTree",
      'InfusionFormAction'  => "InfusionFormAction",
      'Page'                => 'SiteTree'
    );

    static $has_many = array(
        "FormFields"    => "InfusionFormField",
        "FormClasses"   => "InfusionFormClass"
    );
    
    static $summary_fields = array(
            // 'Note',
            // 'Member.Title',
            // 'CreatedText',
    );
    
    static $field_labels = array( 
        // "Member.Title"          => "Member",
        // "CreatedText"           => "Created"
    );


//    static $casting = array("CreatedText" => "Text");

//    public function CreatedText() { 
//       return $this->Created; 
//    }
   
//    public function onBeforeWrite() { 
//       parent::onBeforeWrite();
//       $this->MemberID = Member::currentUserID(); 
//    }

    public function getCMSFields() { 
        $fields = parent::getCMSFields();
        // $fields->removeByName("PageID");
        // $fields->removeByName("ThankyouPageID");
        $fields->addFieldToTab("Root.Main", new TextField("Title"));
        $fields->addFieldToTab("Root.Main", new HTMLEditorField("Description"));
        $fields->addFieldToTab("Root.Main", new TextField("ButtonText"));
        $fields->addFieldToTab("Root.Main", new TreeDropdownField("ThankyouPageID", "Thank you page", "SiteTree"));
        $gridFieldConfig = GridFieldConfig_InfusionFieldCreator::create();   
        // $gridFieldConfig->addComponent(new GridFieldSortableRows('SortOrder'));
        // $Form = DataObject::get("InfusionForm")->filter(array("PageID" => $this->owner->ID))->sort("SortOrder");
        $grid = new GridField('FormFields','FormFields', $this->FormFields() ,$gridFieldConfig); 
        // $grid->getConfig()->getComponentByType('GridFieldDetailForm')->setValidator(singleton('InfusionForm')->getCMSValidator()); 
        $fields->addFieldToTab('Root.FormFields', $grid);
        return $fields;
    }
// //    
// //    function canEdit(){
// //        return false;
// //    } 
    
//     function canDelete($member = null){
//         return false;
//     } 
    
//     public function canView($member = null) {
//        return true;
//    }
   
//    public function canEdit($member = null) {
//        return true;
//    }
    
}
?>
