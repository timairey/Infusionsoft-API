<?php
class InfusionActionAddToSequence extends InfusionFormAction {
	static $db = array(
        "Name"      => "Varchar(255)",
        "SequenceID"=> "Varchar"
	);

    static $has_one = array(
      // "InfusionForm" => "InfusionForm"
    );

    // static $many_many = array(
    //     "FormClasses"   => "InfusionFormClass"
    // );

    private static $singular_name = "Add customer to sequence";
    
    static $summary_fields = array(
            // 'Note',
            // 'Member.Title',
            // 'CreatedText',
    );
    
    static $field_labels = array( 
        // "Member.Title"          => "Member",
        // "CreatedText"           => "Created"
    );  

    public function Action($data){
        // echo '<pre>' . print_r('hi there', true) . '</pre>';
        // die();
        $client = new xmlrpc_client(SiteConfig::current_site_config()->InfusionSoftAPIURL . "/api/xmlrpc");
        $call = new xmlrpcmsg("ContactService.addToGroup",array(
            php_xmlrpc_encode(SiteConfig::current_site_config()->InfusionSoftAPIKey),
            php_xmlrpc_encode($data["ClientID"]),
            php_xmlrpc_encode($data["IntegrationID"])
        ));
        $result=$client->send($call);
    }  
}
?>
