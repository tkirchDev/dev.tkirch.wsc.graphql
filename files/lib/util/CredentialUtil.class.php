<?php
namespace graphql\util;

require_once WCF_DIR . 'lib/system/api/php-jwt/autoload.php';

use Firebase\JWT\JWT;
use graphql\data\credential\Credential;
use graphql\data\credential\token\CredentialToken;
use graphql\data\credential\token\CredentialTokenAction;
use graphql\system\exception\AuthException;

class CredentialUtil
{

    /**
     * generate a new token
     *
     * @param String $key
     * @param String $secret
     * @param String $type
     *
     * @throws AuthException
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
            throw new AuthException('credential.invalid');
        }
    }

    /**
     * check a token
     *
     * @param String $token
     *
     * @throws AuthException
     *
     * @return CredentialToken
     */
    public static function checkToken(String $token)
    {
        //try decode token
        try {
            $decodedToken = JWT::decode(substr($token, 7), SIGNATURE_SECRET, array('HS256'));
        } catch (\Exception $e) {
            throw new AuthException('token.invalid');
        }

        //get token by id
        $token = new CredentialToken($decodedToken->tokenID);

        //check token
        if ($token->credentialTokenID && $token->validUntil >= time()) {
            return $token;
        } else {
            throw new AuthException('token.invalid');
        }
    }

    /**
     * check if is authenticated by context
     *
     * @param array $context
     * @param bool $autetificationIsRequired
     *
     * @throws AuthException
     *
     * @return boolean
     */
    public static function checkIsAuthenticated(array $context, bool $autetificationIsRequired = false)
    {
        $error = '';
        if (isset($context['token'])) {
            if (!$context['token']->getCredential()->credentialID) {
                $error = 'token.invalid';
            }
        } else {
            $error = 'token.not.set';
        }

        //check return type
        if ($autetificationIsRequired && !empty($error)) {
            throw new AuthException($error);
        } elseif ($error) {
            return false;
        }

        return true;
    }
}
