<?php

declare(strict_types=1);

namespace Tests;

use App\HttpClient;
use App\HttpResponse;
use App\MemoryCache;
use PHPUnit\Framework\TestCase;

class HttpResponseTest extends TestCase
{
    public function testExample(): void
    {
        $httpClient = $this->createMock(HttpClient::class);
        $httpClient->expects($this->once())
            ->method('call')
            ->with('GET', 'https://jsonplaceholder.typicode.com/posts')
            ->willReturn(['id' => 1, 'title' => 'GET']);

        $cache = new MemoryCache();
        $response = new HttpResponse($httpClient, $cache);

        $result = $response->get('https://jsonplaceholder.typicode.com/posts');
        $expected = ['id' => 1, 'title' => 'GET'];
        $this->assertEquals($expected, $result);

        $result = $response->get('https://jsonplaceholder.typicode.com/posts');
        $expected = ['id' => 1, 'title' => 'GET'];
        $this->assertEquals($expected, $result);

        $cache->set('GET-https://jsonplaceholder.typicode.com/posts', ['id' => 1, 'title' => 'Cache']);
        $result = $response->put('https://jsonplaceholder.typicode.com/posts', null, ['id' => 1, 'title' => 'Update']);
        $expected = ['id' => 1, 'title' => 'Update'];
        $this->assertEquals($expected, $result);
        $this->assertFalse($cache->has('GET-https://jsonplaceholder.typicode.com/posts'));

        $cache->set('GET-https://jsonplaceholder.typicode.com/posts', ['id' => 1, 'title' => 'Cache']);
        $result = $response->delete('https://jsonplaceholder.typicode.com/posts');
        $expected = ['id' => 1, 'title' => 'Delete'];
        $this->assertEquals($expected, $result);
        $this->assertFalse($cache->has('GET-https://jsonplaceholder.typicode.com/posts'));
    }
}
