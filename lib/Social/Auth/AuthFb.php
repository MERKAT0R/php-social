<?php

namespace Social\Auth;


use Social\Type;

class AuthFb extends OAuth2
{
    const AUTH_URL_FB = 'https://graph.facebook.com/oauth/authorize';
    const TOKEN_URL_FB = 'https://graph.facebook.com/oauth/access_token';

    public function __construct($id, $secret, $scope = '')
    {
        parent::__construct(self::AUTH_URL_FB, $id, $secret, self::TOKEN_URL_FB, $scope);
    }

    public function isValidToken($token)
    {
        $token = $this->parseToken($token);

        return !empty($token['access_token']) && isset($token['expires']);
    }

    protected function createToken($token)
    {
        $token = $this->parseToken($token);
        return new Token($this->getType(), $token['access_token'], -1, $token['expires']);
    }

    public function getType()
    {
        return Type::FB;
    }

    private function parseToken($token)
    {
        if (is_string($token)) {
            return Utils::parseStr($token);
        }

        return $token;
    }
}