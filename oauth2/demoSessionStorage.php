<?php
/**
 * Session storage interface
 */
class demoSessionStorage implements SessionInterface
{
    /**
     * Get a session from an access token
     * @param  \League\OAuth2\Server\Entity\AccessTokenEntity $accessToken The access token
     * @return \League\OAuth2\Server\Entity\SessionEntity
     */
    public function getByAccessToken(AccessTokenEntity $accessToken);

    /**
     * Get a session from an auth code
     * @param  \League\OAuth2\Server\Entity\AuthCodeEntity $authCode The auth code
     * @return \League\OAuth2\Server\Entity\SessionEntity
     */
    public function getByAuthCode(AuthCodeEntity $authCode);

    /**
     * Get a session's scopes
     * @param  \League\OAuth2\Server\Entity\SessionEntity
     * @return array Array of \League\OAuth2\Server\Entity\ScopeEntity
     */
    public function getScopes(SessionEntity $session);

    /**
     * Create a new session
     * @param  string  $ownerType         Session owner's type (user, client)
     * @param  string  $ownerId           Session owner's ID
     * @param  string  $clientId          Client ID
     * @param  string  $clientRedirectUri Client redirect URI (default = null)
     * @return integer The session's ID
     */
    public function create($ownerType, $ownerId, $clientId, $clientRedirectUri = null)
    {
        
    }

    /**
     * Associate a scope with a session
     * @param  \League\OAuth2\Server\Entity\SessionEntity $scope The scope
     * @param  \League\OAuth2\Server\Entity\ScopeEntity   $scope The scope
     * @return void
     */
    public function associateScope(SessionEntity $session, ScopeEntity $scope);
}

