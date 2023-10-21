<?php
require('vendor/autoload.php');

use PHPUnit\Framework\TestCase;
use Mgcodeur\SuperTranslator\GoogleTranslate;

class GoogleTranslateTest extends TestCase {
    public function testTranslate()
    {
        $from = 'auto';
        $to = 'fr';
        $text = "Hello everyone";

        $response = GoogleTranslate::translate($from, $to, $text);
        $this->assertEquals("Bonjour à tous", $response);
    }

    public function testTranslateAuto()
    {
        $to = 'fr';
        $text = "Hello everyone";

        $response = GoogleTranslate::translateAuto($to, $text);
        $this->assertEquals("Bonjour à tous", $response);
    }

    public function testTranslateWithEmptyText()
    {
        $from = 'auto';
        $to = 'fr';
        $text = "";

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Text cannot be empty");
        GoogleTranslate::translate($from, $to, $text);
    }

    public function testTranslateAutoWithEmptyText()
    {
        $to = 'fr';
        $text = "";

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Text cannot be empty");
        GoogleTranslate::translateAuto($to, $text);
    }

    public function testCanTranslateTags()
    {
        $from = 'auto';
        $to = 'fr';
        $text = "<h1>Hello everyone</h1>";

        $response = GoogleTranslate::translate($from, $to, $text);
        $this->assertEquals("<h1>Bonjour à tous</h1>", $response);
    }

    public function testCanTranslateTagsWithAttributes()
    {
        $from = 'auto';
        $to = 'fr';
        $text = "<h1 class='title'>Hello everyone</h1>";

        $response = GoogleTranslate::translate($from, $to, $text);
        $this->assertEquals("<h1 class='title'>Bonjour à tous</h1>", $response);
    }

    public function testCanTranslateTagsWithAttributesAndDoubleQuotes()
    {
        $from = 'auto';
        $to = 'fr';
        $text = "<h1 class=\"title\">Hello everyone</h1>";

        $response = GoogleTranslate::translate($from, $to, $text);
        $this->assertEquals("<h1 class=\"title\">Bonjour à tous</h1>", $response);
    }

    public function testCanTranslateMoreThan5000Characters()
    {
        $from = 'auto';
        $to = 'fr';
        $text = 'hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello. hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello. hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello hello';
        $response = GoogleTranslate::translate($from, $to, $text);

        $this->assertIsString($response);
        $this->assertNotEmpty($response);        
    }

    public function testCanTranslateManyLanguages()
    {
        $from = 'auto';
        $to = ['fr', 'en', 'it', 'es', 'pt'];
        $text = "Hello everyone";

        $response = GoogleTranslate::translate($from, $to, $text);

        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('fr', $response);
        $this->assertArrayHasKey('en', $response);
        $this->assertArrayHasKey('it', $response);
        $this->assertArrayHasKey('es', $response);
        $this->assertArrayHasKey('pt', $response);
    }

    public function testCanTranslateAutoManyLanguages()
    {
        $to = ['fr', 'en', 'it', 'es', 'pt'];
        $text = "Hello everyone";

        $response = GoogleTranslate::translateAuto($to, $text);

        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('fr', $response);
        $this->assertArrayHasKey('en', $response);
        $this->assertArrayHasKey('it', $response);
        $this->assertArrayHasKey('es', $response);
        $this->assertArrayHasKey('pt', $response);
    }
}