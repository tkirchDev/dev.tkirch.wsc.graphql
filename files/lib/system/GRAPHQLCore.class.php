<?php
namespace graphql\system;

use wcf\system\application\AbstractApplication;

class GRAPHQLCore extends AbstractApplication
{
    /**
     * @inheritDoc
     */
    protected $primaryController = IndexPage::class;
}
