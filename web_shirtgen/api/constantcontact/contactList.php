

<?php
// require the autoloader
require_once 'src/Ctct/autoload.php';

use Ctct\ConstantContact;


class contactList{
	public $apiKey;
	public $constantcontact;
	 public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        $this->constantcontact = new ConstantContact($apiKey);
        
    }
	public function getContactList($accessToken)
    {
        return $this->constantcontact->getLists($accessToken);
    }


}
?>
