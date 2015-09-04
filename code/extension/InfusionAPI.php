<?php 
class InfusionAPI extends DataExtension {
     
    private static $db = array(
        "Title"                 => "Varchar(255)",
        "Description"           => "HTMLText",
        "ButtonText"            => 'Varchar(255)',
        "InfusionFormAction"    => 'Varchar(255)',
        "InfusionIntegrationID" => 'Varchar(255)'
    );

    public static $has_one = array(
        "ThankyouPage"        => "SiteTree",
        'InfusionFormAction'  => "InfusionFormAction"
        // "InfusionForm" => "InfusionForm"
    );

    private static $has_many = array(
        "InfusionFormFields" => "InfusionFormField",
        "FormClasses"   => "InfusionFormClass"
    );
 
    public function updateCMSFields(FieldList $fields) {
        // only show API integration on selected pages
        // if all pages want API integration, then set the var on SiteTree.
        if ($this->owner->config()->useInfusionAPI){
            // $fields->removeByName("Content");

            $fields->addFieldToTab("Root.InfusionSoftForm", $ddField = new DropdownField("InfusionFormAction", "Action", $this->getActions()));
            $ddField->setRightTitle("All submissions are automatically added to the chosen contact list");
            $fields->addFieldToTab("Root.InfusionSoftForm", new TextField("InfusionIntegrationID", "Infusionsoft ID for form action"));
            $fields->addFieldToTab("Root.InfusionSoftForm", new TextField("Title"));
            $fields->addFieldToTab("Root.InfusionSoftForm", new HTMLEditorField("Description"));
            $fields->addFieldToTab("Root.InfusionSoftForm", new TextField("ButtonText"));
            $fields->addFieldToTab("Root.InfusionSoftForm", new TreeDropdownField("ThankyouPageID", "Thank you page", "SiteTree"));
            
            $gridFieldConfig = GridFieldConfig_InfusionFieldCreator::create();   
            $grid = new GridField('InfusionForms','InfusionForms', $this->owner->InfusionFormFields() ,$gridFieldConfig); 

            $fields->addFieldToTab('Root.InfusionSoftForm', $grid);
        }
    }

    function getActions(){
        $InfusionFormActionList = ClassInfo::subClassesFor("InfusionFormAction");
        unset($InfusionFormActionList["InfusionFormAction"]);
        $actions = array("" => "No further action");
        foreach($InfusionFormActionList as $InfusionAction){
            if ($InfusionAction == "InfusionFormAction"){
                //don't want to show the base class
                continue;
            }
            $actions[$InfusionAction] = singleton($InfusionAction)->i18n_singular_name();
        }
        return $actions;
    }
}

class InfusionSoftAPI_Controller extends DataExtension {
    private static $allowed_actions = array (
        'form'
    );

    public function form($redirect = true){
        if (!isset($_REQUEST["InfusionField"])){
            // if there are no preset infusion fields, try and find them all.
            $infusionFieldArray = array();
            foreach($_REQUEST as $fieldName => $value){
                if ($field = DataObject::get_one("InfusionFormField", "FieldName='" . $fieldName . "' AND PageID='" . $this->owner->ID . "'")){
                    // echo $field->MergeTag . $value;
                    $infusionFieldArray[$field->ID] = $value;
                }
            }
        } else {
            $infusionFieldArray = $_REQUEST["InfusionField"];
        }
        
        require($_SERVER['DOCUMENT_ROOT'] . "/InfusionSoftIntegration/thirdparty/xmlrpc-2.0/lib/xmlrpc.inc");
        $client = new xmlrpc_client(SiteConfig::current_site_config()->InfusionSoftAPIURL . "/api/xmlrpc");
        $client->return_type = "phpvals";
        $client->setSSLVerifyPeer(FALSE);
        $key = SiteConfig::current_site_config()->InfusionSoftAPIKey;
        $contact = array();         
        foreach($infusionFieldArray as $fieldName => $value){
            if ($field = DataObject::get_one("InfusionFormField", "ID = '" . $fieldName . "'")){
                if (strlen($field->MergeTag)){
                    // check if the field is an email address field.
                    if ($field->IsEmail || (!isset($email) && $fieldName == "Email")){
                        $email = $value;
                    }
                    if ($field->IsDouble){
                        $contact[$field->MergeTag] = (double)$value;
                        // echo '<pre>' . print_r($contact[$field->MergeTag], true) . '</pre>';
                        // die();       
                    } else {
                        $contact[$field->MergeTag] = str_replace("£", "&pound;", $value);
                    }
                }
            }
        }
        // $contact["_Webdesignbudget"] = (double)"55.10";
        $call = new xmlrpcmsg("ContactService.addWithDupCheck",array(
            php_xmlrpc_encode($key),
            php_xmlrpc_encode($contact),
            php_xmlrpc_encode("Email")
        ));
        
        $result1=$client->send($call);
                     
        $customerID = $result1->value();

        $call = new xmlrpcmsg("APIEmailService.optIn",array(
            php_xmlrpc_encode($key),
            php_xmlrpc_encode($email),
            php_xmlrpc_encode("Email")
        ));
        
        $result=$client->send($call);
                     
        if($result1->faultCode()) {
            mail("tim@newedge.co.uk", "Infusionsoft Integration Failure", print_r($result, true) . ', Contact: ' . print_r($contact, true));
        } else {
            // get form action, if there is a follow up action
            if (strlen($this->owner->InfusionFormAction) > 0){
                
                $action = new $this->owner->InfusionFormAction;
                $reply = $action->Action(array("ClientID" => $customerID, "IntegrationID" => $this->owner->InfusionIntegrationID));
            }
        }
        // Since we report the details of the contact, we can redirect to the thanks page anyway regardless of success.
        if ($redirect){
            // allow redirect override for custom forms.
            $controller = Controller::curr();
            $link = $this->owner->ThankyouPage()->Link();
            return $controller->redirect($link);
        }
    }
}