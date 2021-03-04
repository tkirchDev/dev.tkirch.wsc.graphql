<?php

namespace graphql\data\schema;

require_once WCF_DIR . 'lib/system/api/graphql-php/autoload.php';

use GraphQL\Language\AST\DocumentNode;
use GraphQL\Language\Parser;
use wcf\data\DatabaseObject;
use wcf\system\request\IRouteController;

class Schema extends DatabaseObject implements IRouteController
{
    /**
     * @inheritDoc
     */
    protected static $databaseTableName = 'schema';

    /**
     * contents of the schema file
     *
     * @var String
     */
    protected $fileContent;

    /**
     * parsed contents of the schema file
     *
     * @var DocumentNode
     */
    protected $parsedFileContent;

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     * @inheritDoc
     */
    public function getTitle()
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public static function getDatabaseTableAlias()
    {
        return null;
    }

    /**
     * returns the content of the schema file
     *
     * @return String
     */
    public function getFileContent()
    {
        if ($this->fileContent === null && file_exists(WCF_DIR . $this->filepath)) {
            $this->fileContent = file_get_contents(WCF_DIR . $this->filepath);
        } else {
            $this->fileContent = '';
        }

        return $this->fileContent;
    }

    /**
     * parses the content of the schema file into DocumentNode.
     *
     * @return DocumentNode
     */
    public function getParsedFileContent()
    {
        if (!$this->parsedFileContent) {
            $this->parsedFileContent = Parser::parse($this->getFileContent());
        }

        return $this->parsedFileContent;
    }
}
