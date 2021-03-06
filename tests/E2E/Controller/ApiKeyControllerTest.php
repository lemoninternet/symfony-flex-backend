<?php
declare(strict_types=1);
/**
 * /tests/E2E/Controller/ApiKeyControllerTest.php
 *
 * @author  TLe, Tarmo Leppänen <tarmo.leppanen@protacon.com>
 */
namespace App\Tests\E2E\Controller;

use App\Utils\Tests\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ApiKeyControllerTest
 *
 * @package App\Tests\E2E\Controller
 * @author  TLe, Tarmo Leppänen <tarmo.leppanen@protacon.com>
 */
class ApiKeyControllerTest extends WebTestCase
{
    private $baseUrl = '/api_key';

    /**
     * @throws \Exception
     */
    public function testThatGetBaseRouteReturn401(): void
    {
        $client = $this->getClient();
        $client->request('GET', $this->baseUrl);

        $response = $client->getResponse();

        static::assertInstanceOf(Response::class, $response);

        /** @noinspection NullPointerExceptionInspection */
        static::assertSame(401, $response->getStatusCode());

        unset($response, $client);
    }

    /**
     * @dataProvider dataProviderTestThatFindActionWorksAsExpected
     *
     * @param string $username
     * @param string $password
     * @param int    $expectedStatus
     *
     * @throws \Exception
     */
    public function testThatFindActionWorksAsExpected(string $username, string $password, int $expectedStatus): void
    {
        $client = $this->getClient($username, $password);
        $client->request('GET', $this->baseUrl);

        $response = $client->getResponse();

        static::assertInstanceOf(Response::class, $response);

        /** @noinspection NullPointerExceptionInspection */
        static::assertSame($expectedStatus, $response->getStatusCode(), $response->getContent());

        unset($response, $client);
    }

    /**
     * @return array
     */
    public function dataProviderTestThatFindActionWorksAsExpected(): array
    {
        return [
            /*
            ['john',        'password',         403],
            ['john-api',    'password-api',     403],
            ['john-logged', 'password-logged',  403],
            ['john-user',   'password-user',    403],
            */
            ['john-admin',  'password-admin',   403],
            ['john-root',   'password-root',    200],
        ];
    }
}
