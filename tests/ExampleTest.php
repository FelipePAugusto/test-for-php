<?php

declare(strict_types=1);

namespace Tests;
use App\HttpClient;
use App\HttpRequest;
use App\MemoryCache;

class ExampleTest extends TestCase
{
    private $httpClient;

    protected function setUp(): void
    {
        $httpRequest = new HttpRequest();
        $cache = new MemoryCache();
        $this->httpClient = new HttpClient($httpRequest, $cache);
    }

    public function testGetPosts(): void
    {
        $response = $this->httpClient->get('https://jsonplaceholder.typicode.com/posts');
        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
        $this->assertEquals('200', $response[1]);
    }

    public function testGetPostById(): void
    {
        $response = $this->httpClient->get('https://jsonplaceholder.typicode.com/posts/1');
        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
        $this->assertEquals('200', $response[1]);
    }

    public function testCreatePost(): void
    {
        $post = [
            'title' => 'Teste PHP Autodoc Post',
            'body' => 'Corpo do Teste.',
            'userId' => 1
        ];

        $response = $this->httpClient->post('https://jsonplaceholder.typicode.com/posts', null, $post);
        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
        $this->assertEquals($post['title'], $response[0]['title']);
        $this->assertEquals($post['body'], $response[0]['body']);
        $this->assertEquals($post['userId'], $response[0]['userId']);
        $this->assertEquals('201', $response[1]);
    }

    public function testUpdatePost(): void
    {
        $post = [
            'title' => 'Teste PHP Autodoc Atualizando Post',
            'body' => 'Corpo do Teste Atualizando.',
            'userId' => 1
        ];

        $response = $this->httpClient->put('https://jsonplaceholder.typicode.com/posts/1', null, $post);
        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
        $this->assertEquals($post['title'], $response[0]['title']);
        $this->assertEquals($post['body'], $response[0]['body']);
        $this->assertEquals($post['userId'], $response[0]['userId']);
        $this->assertEquals('200', $response[1]);
    }

    public function testDeletePost(): void
    {
        $response = $this->httpClient->delete('https://jsonplaceholder.typicode.com/posts/1');
        $this->assertIsArray($response);
        $this->assertEquals('200', $response[1]);
    }    
}
