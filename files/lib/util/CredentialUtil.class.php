<?php
namespace graphql\util;

require_once WCF_DIR . 'lib/system/api/php-jwt/autoload.php';

use Firebase\JWT\JWT;
use graphql\data\credential\Credential;
use graphql\data\credential\token\CredentialToken;
use graphql\data\credential\token\CredentialTokenAction;

class CredentialUtil
{

    /**
     * generate a new token
     *
     * @param String $key
     * @param String $secret
     * @param String $type
     *
     * @throws\Exception
     *
     * @return String
     */
    public static function generateToken(String $key, String $secret, String $type = 'shortlife')
    {
        //get credential by key
        $credential = Credential::getByKey($key);

        //check secret
        if ($credential->credentialID && $credential->checkSecret($secret)) {

            $credentialTokenAction = new CredentialTokenAction([], 'create', [
                'data' => [
                    'credentialID' => $credential->credentialID,
                    'type' => $type,
                ],
            ]);
            $credentialToken = $credentialTokenAction->executeAction()['returnValues'];

            $jwtPayload = array(
                "tokenID" => $credentialToken->credentialTokenID,
                "exp" => $credentialToken->validUntil,
            );
            $encoded = JWT::encode($jwtPayload, SIGNATURE_SECRET);

            return $encoded;
        } else {
            throw new \Exception('invalid credentials');
        }
    }

    /**
     * check a token
     *
     * @param String $token
     *
     * @throws\Exception
     *
     * @return CredentialToken
     */
    public static function checkToken(String $token)
    {
        //decode token
        $decodedToken = JWT::decode(substr($token, 7), SIGNATURE_SECRET, array('HS256'));

        //get token by id
        $token = new CredentialToken($decodedToken->tokenID);

        //check token
        if ($token->credentialTokenID && $token->validUntil >= time()) {
            return $token;
        } else {
            throw new \Exception('invalid token');
        }
    }
}
