<?php
namespace graphql\acp\page;

use graphql\data\credential\Credential;
use wcf\page\AbstractPage;
use wcf\system\exception\IllegalLinkException;
use wcf\system\WCF;

class CredentialPage extends AbstractPage
{

    /**
     * @inheritDoc
     */
    public $activeMenuItem = 'graphql.acp.menu.link.credential.list';

    /**
     * @inheritDoc
     */
    public $neededPermissions = ['admin.graphql.canManageCredential'];

    /**
     * store the credential
     *
     * @var Credential
     */
    public $credential;

    /**
     * @inheritDoc
     */
    public function readParameters()
    {
        parent::readParameters();

        if (isset($_REQUEST['id'])) {
            $this->credential = new Credential(intval($_REQUEST['id']));
            if (!$this->credential->credentialID) {
                throw new IllegalLinkException();
            }
        } else {
            throw new IllegalLinkException();
        }
    }

    /**
     * @inheritDoc
     */
    public function assignVariables()
    {
        parent::assignVariables();

        // assign parameters
        WCF::getTPL()->assign([
            'credential' => $this->credential,
        ]);
    }
}
