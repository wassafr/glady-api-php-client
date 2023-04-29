<?php

namespace Wassa\GladyApiClient;

use Exception;

class GladyClient
{
    private HttpClient $httpClient;

    public function __construct(string $clientId, string $clientSecret, bool $demo = false)
    {
        $this->httpClient = new HttpClient($clientId, $clientSecret, $demo);
    }

    /**
     * @param array $params
     * @return mixed
     * @throws Exception
     */
    public function ssoCreateToken(array $params)
    {
        return $this->httpClient->post('client/token', [
            'userId' => $params['userId'] ?? null,
            'login' => $params['login'] ?? null,
        ]);
    }

    /**
     * @param string $beneficiaryUuid
     * @return mixed
     * @throws Exception
     */
    public function beneficiariesGetById(string $beneficiaryUuid)
    {
        return $this->httpClient->get("beneficiaries/$beneficiaryUuid");
    }

    /**
     * @param string $login
     * @return mixed
     * @throws Exception
     */
    public function beneficiariesGetByLogin(string $login)
    {
        return $this->httpClient->get("beneficiaries/login/$login");
    }

    /**
     * @param string $beneficiaryUuid
     * @return mixed
     * @throws Exception
     */
    public function beneficiariesGetBalance(string $beneficiaryUuid)
    {
        return $this->httpClient->get("beneficiaries/$beneficiaryUuid/balances");
    }

    /**
     * @param array $params
     * @return mixed
     * @throws Exception
     */
    public function beneficiariesList(array $params)
    {
        return $this->httpClient->get("beneficiaries/?invited={$params['invited']}&pageSize={$params['pageSize']}&pageIndex={$params['pageIndex']}");
    }

    /**
     * @param array $params
     * @return mixed
     * @throws Exception
     */
    public function beneficiariesAdd(array $params)
    {
        return $this->httpClient->put('beneficiaries', $params);
    }

    /**
     * @param string $beneficiaryUuid
     * @param array $params
     * @return mixed
     * @throws Exception
     */
    public function beneficiariesUpdate(string $beneficiaryUuid, array $params)
    {
        return $this->httpClient->patch("beneficiaries/$beneficiaryUuid", $params);
    }

    /**
     * @param array $beneficiaryUuids
     * @return mixed
     * @throws Exception
     */
    public function beneficiariesDelete(array $beneficiaryUuids)
    {
        return $this->httpClient->delete('beneficiaries', $beneficiaryUuids);
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function walletsList()
    {
        return $this->httpClient->get('gift/reasons');
    }

    /**
     * @param array $params
     * @return mixed
     * @throws Exception
     */
    public function walletsCreateReason(array $params)
    {
        return $this->httpClient->put('gift/reason', $params);
    }

    /**
     * @param int $reasonId
     * @param array $params
     * @return mixed
     * @throws Exception
     */
    public function walletsUpdateReason(int $reasonId, array $params)
    {
        return $this->httpClient->patch("gift/reason/$reasonId", $params);
    }

    /**
     * @param int $reasonId
     * @return mixed
     * @throws Exception
     */
    public function walletsDeleteReason(int $reasonId)
    {
        return $this->httpClient->delete("gift/reason/$reasonId");
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function organisationsListDeposits()
    {
        return $this->httpClient->get('organizations/deposits');
    }

    /**
     * @param string $depositId
     * @return mixed
     * @throws Exception
     */
    public function organisationsGetDeposit(string $depositId)
    {
        return $this->httpClient->get("organizations/deposits/$depositId");
    }

    /**
     * @param array $params
     * @return mixed
     * @throws Exception
     */
    public function campaignsCreate(array $params)
    {
        return $this->httpClient->post('gift/campaign', $params);
    }
}
