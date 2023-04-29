<?php

namespace Wassa\GladyApiClient;

class HttpClient
{
    private string $baseUrl;
    private string $clientId;
    private string $clientSecret;
    private bool $demo;

    /**
     * HttpClient constructor.
     * @param string $clientId
     * @param string $clientSecret
     * @param bool $demo
     */
    public function __construct(string $clientId, string $clientSecret, bool $demo = false)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->demo = $demo;
        $this->baseUrl = $this->demo ? "https://clients-api.demo.tech.glady.com/" : "https://clients-api.prod.tech.glady.com/";
    }

    /**
     * @param string $url
     * @return mixed
     * @throws \Exception
     */
    public function get(string $url)
    {
        $options = [
            "method" => "GET",
        ];
        return $this->request($url, $options);
    }

    /**
     * @param string $url
     * @param null $body
     * @return mixed
     * @throws \Exception
     */
    public function post(string $url, $body = null)
    {
        $options = [
            "method" => "POST",
            "body" => json_encode($body),
        ];
        return $this->request($url, $options);
    }

    /**
     * @param string $url
     * @param null $body
     * @return mixed
     * @throws \Exception
     */
    public function put(string $url, $body = null)
    {
        $options = [
            "method" => "PUT",
            "body" => json_encode($body),
        ];
        return $this->request($url, $options);
    }

    /**
     * @param string $url
     * @param null $body
     * @return mixed
     * @throws \Exception
     */
    public function patch(string $url, $body = null)
    {
        $options = [
            "method" => "PATCH",
            "body" => json_encode($body),
        ];
        return $this->request($url, $options);
    }

    /**
     * @param string $url
     * @param null $body
     * @return mixed
     * @throws \Exception
     */
    public function delete(string $url, $body = null)
    {
        $options = [
            "method" => "DELETE",
            "body" => json_encode($body),
        ];
        return $this->request($url, $options);
    }

    /**
     * @param string $url
     * @param array $options
     * @return mixed
     * @throws \Exception
     */
    private function request(string $url, array $options)
    {
        $headers = [
            "Content-Type: application/json",
            "client_id: {$this->clientId}",
            "client_secret: {$this->clientSecret}",
        ];

        $curlOptions = [
            CURLOPT_URL => $this->baseUrl . $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_CUSTOMREQUEST => $options['method'],
            CURLOPT_HTTPHEADER => $headers,
        ];

        if ($options['method'] != 'GET') {
            $curlOptions += [
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $options['body'],
            ];
        }

        $ch = curl_init();
        curl_setopt_array($ch, $curlOptions);
        $response = curl_exec($ch);

        $status_code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);

        curl_close($ch);

        if ($status_code >= 400) {
            throw new \Exception($response);
        }

        return json_decode($response);
    }
}
