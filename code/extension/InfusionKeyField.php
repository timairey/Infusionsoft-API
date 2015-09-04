<?php 
class InfusionKeyField extends DataExtension {
     
    private static $db = array(
        "InfusionSoftAPIKey"    => 'Varchar(255)',
        'InfusionSoftAPIURL'    => 'Varchar(255)'
    );

    public static $has_one = array(
    );

    private static $has_many = array(
        // "InfusionForms" => "InfusionForm"
        // "PageBlocks"    => 'PageBlock'
    );
 
    public function updateCMSFields(FieldList $fields) {                 
        // only show API integration on selected pages
        // if all pages want API integration, then set the var on SiteTree.
        $fields->addFieldToTab("Root.InfusionSoft", new TextField("InfusionSoftAPIKey", "API Key"));
        $fields->addFieldToTab("Root.InfusionSoft", $APIField = new TextField("InfusionSoftAPIURL", "Account API URL"));
        $APIField->setRightTitle("Include HTTPS://");
    }

}