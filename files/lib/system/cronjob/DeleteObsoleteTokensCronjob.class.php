<?php

namespace graphql\system\cronjob;

use wcf\data\cronjob\Cronjob;
use wcf\system\cronjob\AbstractCronjob;
use wcf\system\WCF;

class DeleteObsoleteTokensCronjob extends AbstractCronjob
{

    /**
     * @inheritDoc
     */
    public function execute(Cronjob $cronjob)
    {
        parent::execute($cronjob);

        $sql = "DELETE FROM  graphql" . WCF_N . "_credential_token WHERE validUntil < ?";
        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute([time()]);
    }
}
