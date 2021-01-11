<?php
require_once './global.php';
define('GRAPHQL_DEBUG', true);
wcf\system\request\RequestHandler::getInstance()->handle('graphql');
