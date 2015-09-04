<?php
class InfusionFormAction extends DataObject {
	static $db = array(
        "Name"          => 'Varchar(255)',
        // "IntegrationID" => 'Varchar(255)'
	);

    static $has_one = array(
    );

    static $has_many = array(
        'Pages'  => "SiteTree"
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

    function Action($data){

    }


//    static $casting = array("CreatedText" => "Text");

//    public function CreatedText() { 
//       return $this->Created; 
//    }
   
//    public function onBeforeWrite() { 
//       parent::onBeforeWrite();
//       $this->MemberID = Member::currentUserID(); 
//    }

    // function getCMSFields() { 
    //     $fields->removeByName("Content");
                        
    //     $gridFieldConfig = GridFieldConfig_RecordEditor::create();   
    //     $gridFieldConfig->addComponent(new GridFieldSortableRows('SortOrder'));
    //     $Form = DataObject::get("InfusionForm")->filter(array("PageID" => $this->owner->ID))->sort("SortOrder");
    //     $grid = new GridField('InfusionForms','InfusionForms', $Form ,$gridFieldConfig); 
    //     // $grid->getConfig()->getComponentByType('GridFieldDetailForm')->setValidator(singleton('InfusionForm')->getCMSValidator()); 
    //     $fields->addFieldToTab('Root.InfusionSoft', $grid);
    // }    
}
?>
