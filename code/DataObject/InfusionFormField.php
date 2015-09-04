<?php
class InfusionFormField extends DataObject {
	static $db = array(
        "FieldName" => 'Varchar(255)',
        "Name"      => "Varchar(255)",
        "MergeTag"  => "Varchar(255)",
        "IsEmail"   => 'Boolean',
        "IsDouble"  => 'Boolean',
        "SortOrder" => 'Int'
	);

    static $has_one = array(
      "Page" => "SiteTree"
    );

    static $many_many = array(
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

    public function Output(){
      return $this->renderWith($this->ClassName);
    }
}
?>
