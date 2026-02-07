<?php
/**
 * Simple API Client using cURL
 * @category  Library
 * @package   ApiClient
 * */

declare(strict_types=1);

class ApiClient
{
    protected string $apiUrl;
    protected string $apiToken;
    protected int $timeout;

    public function __construct(string $apiUrl, string $apiToken, int $timeout = 30)
    {
        $this->apiUrl   = rtrim($apiUrl, '/');
        $this->apiToken = $apiToken;
        $this->timeout  = $timeout;
    }

    /**
     * Método central de comunicación HTTP
     */
    protected function request(string $method, string $endpoint, array $data = []): array
    {
        $url = $this->apiUrl . '/' . ltrim($endpoint, '/');

        $ch = curl_init();

        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            'DOLAPIKEY: ' . $this->apiToken,
        ];

        $options = [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => true,
            CURLOPT_CUSTOMREQUEST  => strtoupper($method),
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_TIMEOUT        => $this->timeout,
            CURLOPT_CONNECTTIMEOUT => 10,
        ];

        // Envío de datos solo si aplica
        if (in_array(strtoupper($method), ['POST', 'PUT', 'PATCH'], true) && !empty($data)) {
            $options[CURLOPT_POSTFIELDS] = json_encode($data, JSON_UNESCAPED_UNICODE);
        }

        curl_setopt_array($ch, $options);

        $rawResponse = curl_exec($ch);

        $curlError   = curl_error($ch);
        $curlErrno   = curl_errno($ch);
        $statusCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headerSize  = curl_getinfo($ch, CURLINFO_HEADER_SIZE);

        curl_close($ch);

        // Error de red / transporte
        if ($rawResponse === false) {
            return [
                'success'    => false,
                'statusCode' => 0,
                'error'      => 'cURL Error (' . $curlErrno . '): ' . $curlError,
                'headers'    => [],
                'body'       => null,
                'raw'        => null,
            ];
        }

        $rawHeaders = substr($rawResponse, 0, $headerSize);
        $rawBody    = substr($rawResponse, $headerSize);

        $decodedBody = json_decode($rawBody, true);

        // Error HTTP
        if ($statusCode >= 400) {
            return [
                'success'    => false,
                'statusCode' => $statusCode,
                'error'      => $decodedBody['error']['message'] 
                                ?? $decodedBody['message'] 
                                ?? 'HTTP Error ' . $statusCode,
                'headers'    => $this->parseHeaders($rawHeaders),
                'body'       => $decodedBody,
                'raw'        => $rawBody,
            ];
        }

        // Error lógico del API (Dolibarr-style)
        if (is_array($decodedBody) && isset($decodedBody['error'])) {
            return [
                'success'    => false,
                'statusCode' => $statusCode,
                'error'      => $decodedBody['error']['message'] ?? 'API Logical Error',
                'headers'    => $this->parseHeaders($rawHeaders),
                'body'       => $decodedBody,
                'raw'        => $rawBody,
            ];
        }

        // Respuesta exitosa
        return [
            'success'    => true,
            'statusCode' => $statusCode,
            'error'      => null,
            'headers'    => $this->parseHeaders($rawHeaders),
            'body'       => $decodedBody,
            'raw'        => $rawBody,
        ];
    }

    /**
     * Parseo de headers HTTP
     */
    protected function parseHeaders(string $rawHeaders): array
    {
        $headers = [];
        $lines = explode("\r\n", trim($rawHeaders));

        foreach ($lines as $line) {
            if (strpos($line, ':') !== false) {
                [$key, $value] = explode(':', $line, 2);
                $headers[trim($key)] = trim($value);
            }
        }

        return $headers;
    }

    /* ===========================
       Métodos públicos REST
       =========================== */

    public function get(string $endpoint): array
    {
        return $this->request('GET', $endpoint);
    }

    public function post(string $endpoint, array $data = []): array
    {
        return $this->request('POST', $endpoint, $data);
    }

    public function put(string $endpoint, array $data = []): array
    {
        return $this->request('PUT', $endpoint, $data);
    }

    public function patch(string $endpoint, array $data = []): array
    {
        return $this->request('PATCH', $endpoint, $data);
    }

    public function delete(string $endpoint): array
    {
        return $this->request('DELETE', $endpoint);
    }

    public function update(string $endpoint, array $data = []): array
    {
        return $this->put($endpoint, $data);
    }
}