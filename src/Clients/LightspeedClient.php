<?php declare(strict_types=1);

namespace ModularLightspeed\ModularLightspeed\Clients;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use ModularLightspeed\ModularLightspeed\API\lightspeedRequestData;
use function config;

final class lightspeedClient
{
    protected string $url;
    protected array $options;
    protected array $body;

    public function __construct(
        protected string $apiUrl
    ) {

    }

    protected function getUrl(string $path, string $language): string
    {
        return $this->apiUrl. '/' . $language . '/' . $path . '.json';
    }

    public function makeRequest(lightspeedRequestData $requestData): array|string|null|\Illuminate\Support\Collection
    {
        $response = match ($requestData->getType()) {
            'get' => $this->makeGetRequest(
                $requestData->getHeaders(),
                $requestData->getAuth(),
                $this->getUrl(
                    $requestData->getPath(),
                    $requestData->getLanguage()
                ),
                $requestData->getParams()
            )->json(),
            'post' => $this->makePostRequest(
                $requestData->getHeaders(),
                $requestData->getAuth(),
                $this->getUrl(
                    $requestData->getPath(),
                    $requestData->getLanguage()
                ),
                $requestData->getJson()
            ),
            'put' => $this->makePutRequest(
                $requestData->getHeaders(),
                $requestData->getAuth(),
                $this->getUrl(
                    $requestData->getPath(),
                    $requestData->getLanguage()
                ),
                $requestData->getJson()
            ),
            'delete' => $this->makeDeleteRequest(
                $requestData->getHeaders(),
                $requestData->getAuth(),
                $this->getUrl(
                    $requestData->getPath(),
                    $requestData->getLanguage()
                ),
                $requestData->getParams()
            )->json()
        };

        if (!$response) {
            return null;
        }

        return $requestData->toResponse($response);
    }

    public function makeGetRequest(array $headers, string $token, string $path, array $params): Response
    {
        return Http::withHeaders($headers)
            ->withBasicAuth(config('lightspeed.app_key'), md5($token . config('lightspeed.app_secret')))
            ->get(
                $path,
                $params
            );
    }

    public function makeDeleteRequest(array $headers, string $token, string $path, array $params): Response
    {
        return Http::withHeaders($headers)
            ->withBasicAuth(config('lightspeed.app_key'), md5($token . config('lightspeed.app_secret')))
            ->delete(
                $path,
                $params
            );
    }

    public function makePostRequest(array $headers, string $token, string $path, array $json): Response
    {
        return Http::withHeaders($headers)
            ->withBasicAuth(config('lightspeed.app_key'), md5($token . config('lightspeed.app_secret')))
            ->post(
                $path,
                $json
            );
    }
    public function makePutRequest(array $headers, string $token, string $path, array $json): Response
    {
        return Http::withHeaders($headers)
            ->withBasicAuth(config('lightspeed.app_key'), md5($token . config('lightspeed.app_secret')))
            ->put(
                $path,
                $json
            );
    }
}
