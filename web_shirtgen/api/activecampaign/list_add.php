<?php

// By default, this sample code is designed to get the result from your ActiveCampaign installation and print out the result
$url = 'http://account.api-us1.com';


$params = array(

    // the API Key can be found on the "Your Settings" page under the "API" tab.
    // replace this with your API Key
    'api_key'      => 'YOUR_API_KEY',

    // this is the action that adds a list
    'api_action'   => 'list_add',

    // define the type of output you wish to get back
    // possible values:
    // - 'xml'  :      you have to write your own XML parser
    // - 'json' :      data is returned in JSON format and can be decoded with
    //                 json_decode() function (included in PHP since 5.2.0)
    // - 'serialize' : data is returned in a serialized format and can be decoded with
    //                 a native unserialize() function
    'api_output'   => 'serialize',
);

// here we define the data we are posting in order to perform an update
$post = array(
    //'id'                     => 0, // adds a new one
    'name'                     => 'List Name', // list name
    'subscription_notify'      => '', // comma-separated list of email addresses to notify on new subscriptions to this list
    'unsubscription_notify'    => '', // comma-separated list of email addresses to notify on any unsubscriptions from this list
    'to_name'                  => "Recipient", // if contact doesn't enter a name, use this
    'carboncopy'               => '', // comma-separated list of email addresses to send a copy of all mailings to upon send
    //'p_use_captcha'          => 1, // uncomment to require CAPTCHA ("enter text on image" field) for this list
    //'get_unsubscribe_reason' => 1, // uncomment to ask for reason when unsubscribing
    //'send_last_broadcast'    => 1, // uncomment to send the last broadcast campaign when subscribing
    //'require_name'           => 1, // uncomment to require name with email when subscribing

    // Sender information (all fields below) required
    //'sender_name'       => '', // Company (or Organization)
    //'sender_addr1'      => '', // Address
    //'sender_zip'       => '', // Zip or Postal Code
    //'sender_city'       => '', // City
    //'sender_country'      => '', // Country
    //'sender_url'        => '', // URL
    //'sender_reminder'       => 'You subscribed on our web site', // Sender's reminder to contacts
);
?>