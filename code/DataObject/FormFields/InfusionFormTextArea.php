<?php
class InfusionFormTextArea extends InfusionFormField {
	static $db = array(
        "Name"      => "Varchar(255)",
        "MergeTag"  => "Varchar(255)"
	);

    static $has_one = array(
      // "InfusionForm" => "InfusionForm"
    );

    // static $many_many = array(
    //     "FormClasses"   => "InfusionFormClass"
    // );

    private static $singular_name = "Text Area";
    
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

//     function getCMSFields() { 
//         $fields = parent::getCMSFields(); 
//         $fields->removeByName('Member');
//         $fields->removeByName('Ticket');
//         $fields->removeByName('Lead');
//         return $fields; 
//     }
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
