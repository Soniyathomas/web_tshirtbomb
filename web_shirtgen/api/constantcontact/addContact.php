<?php
// require the autoloader
require_once 'src/Ctct/autoload.php';

use Ctct\ConstantContact;
use Ctct\Components\Contacts\Contact;
use Ctct\Components\Contacts\ContactList;
use Ctct\Components\Contacts\EmailAddress;
use Ctct\Exceptions\CtctException;

class contactAddList{
	public $apiKey;
	public $apisecret;
	public $apitoken;
	public $contact;
	public $constantcontact;
	 public function __construct($apiKey,$apisecret,$apitoken)
    {
        $this->apiKey = $apiKey;
		$this->apisecret = $apisecret;
		$this->apitoken = $apitoken;
        $this->constantcontact = new ConstantContact($apiKey);
		$this->contact = new Contact();
        
    }
	public function addContactList($args)
    {
        // check if the form was submitted
		if (isset($args['email']) && strlen($args['email']) > 1) 
		{
			$action = "Getting Contact By Email Address";
			try 
			{
				// check to see if a contact with the email addess already exists in the account
				$response = $this->constantcontact->getContactByEmail($this->apitoken, $args['email']);

				// create a new contact if one does not exist
				if (empty($response->results)) {
					$action = "Creating Contact";

					$this->contact->addEmail($args['email']);
					$this->contact->addList($args['list']);
					$this->contact->first_name = $args['first_name'];
					
					/*
					 * The third parameter of addContact defaults to false, but if this were set to true it would tell Constant
					 * Contact that this action is being performed by the contact themselves, and gives the ability to
					 * opt contacts back in and trigger Welcome/Change-of-interest emails.
					 *
					 * See: http://developer.constantcontact.com/docs/contacts-api/contacts-index.html#opt_in
					 */
					$returnContact = $this->constantcontact->addContact($this->apitoken,$this->contact, true);

					// update the existing contact if address already existed
				}
				else 
				{
					$action = "Updating Contact";

					$this->contact = $response->results[0];
					$this->contact->addList($args['list']);
					$this->contact->first_name = $args['first_name'];
					
					/*
					 * The third parameter of updateContact defaults to false, but if this were set to true it would tell
					 * Constant Contact that this action is being performed by the contact themselves, and gives the ability to
					 * opt contacts back in and trigger Welcome/Change-of-interest emails.
					 *
					 * See: http://developer.constantcontact.com/docs/contacts-api/contacts-index.html#opt_in
					 */
					$returnContact = $this->constantcontact->updateContact($this->apitoken,$this->contact, true);
				}

				// catch any exceptions thrown during the process and print the errors to screen
			} 
			catch (CtctException $ex) 
			{
				echo '<span class="label label-important">Error ' . $action . '</span>';
				echo '<div class="container alert-error"><pre class="failure-pre">';
				print_r($ex->getErrors());
				echo '</pre></div>';
				die();
			}
		}
    }


}

?>