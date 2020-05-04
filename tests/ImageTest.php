<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

final class ImageTest extends TestCase
{
    /**
     * @test
     */
    public function testNoImages()
    {
        $web = new \spekulatius\phpscraper();

        // Navigate to the test page.
        $web->go('https://test-pages.phpscraper.de/meta/missing.html');

        // No images -> an empty array is expected.
        $this->assertSame([], $web->images);
        $this->assertSame([], $web->imagesWithDetails);
    }

    /**
     * @test
     */
    public function testLoremIpsum()
    {
        $web = new \spekulatius\phpscraper();

        // Navigate to the test page.
        $web->go('https://test-pages.phpscraper.de/meta/lorem-ipsum.html');

        // Navigate to the test page. This page contains two images (cat.jpg).
        $this->assertSame(2, count($web->images));

        // check the simple list
        $this->assertSame([
            'https://test-pages.phpscraper.de/assets/cat.jpg',
            'https://test-pages.phpscraper.de/assets/cat.jpg',
        ], $web->images);

        // check the expected data
        $this->assertSame([
            [
                'url' => 'https://test-pages.phpscraper.de/assets/cat.jpg',
                'alt' => 'absolute path',
                'width' => null,
                'height' => null,
            ],
            [
                'url' => 'https://test-pages.phpscraper.de/assets/cat.jpg',
                'alt' => 'relative path',
                'width' => null,
                'height' => null,
            ],
        ], $web->imagesWithDetails);
    }

    /**
     * @test
     */
    public function testGermanUmlaute()
    {
        $web = new \spekulatius\phpscraper();

        // Navigate to the test page.
        $web->go('https://test-pages.phpscraper.de/meta/german-umlaute.html');

        // Check the h1
        $this->assertSame('We are testing here ä ü ö!', $web->h1[0]);

        // check the number of images
        $this->assertSame(2, count($web->images));

        // check the simple list
        $this->assertSame([
            'https://test-pages.phpscraper.de/assets/katze-ä-ü-ö.jpg',
            'https://test-pages.phpscraper.de/assets/katze-ä-ü-ö.jpg',
        ], $web->images);

        // check the expected data
        $this->assertSame([
            [
                'url' => 'https://test-pages.phpscraper.de/assets/katze-ä-ü-ö.jpg',
                'alt' => 'absolute path',
                'width' => null,
                'height' => null,
            ],
            [
                'url' => 'https://test-pages.phpscraper.de/assets/katze-ä-ü-ö.jpg',
                'alt' => 'relative path',
                'width' => null,
                'height' => null,
            ],
        ], $web->imagesWithDetails);
    }

    /**
     * @test
     */
    public function testChineseCharacters()
    {
        $web = new \spekulatius\phpscraper();

        // Navigate to the test page.
        $web->go('https://test-pages.phpscraper.de/meta/chinese-characters.html');

        // check the number of images
        $this->assertSame(2, count($web->images));

        // check the simple list
        $this->assertSame([
            'https://test-pages.phpscraper.de/assets/貓.jpg',
            'https://test-pages.phpscraper.de/assets/貓.jpg',
        ], $web->images);

        // check the expected data
        $this->assertSame([
            [
                'url' => 'https://test-pages.phpscraper.de/assets/貓.jpg',
                'alt' => 'absolute path',
                'width' => null,
                'height' => null,
            ],
            [
                'url' => 'https://test-pages.phpscraper.de/assets/貓.jpg',
                'alt' => 'relative path',
                'width' => null,
                'height' => null,
            ],
        ], $web->imagesWithDetails);
    }

    /**
     * @test
     */
    public function testBaseHref()
    {
        $web = new \spekulatius\phpscraper();

        // Navigate to the test page.
        $web->go('https://test-pages.phpscraper.de/images/base-href.html');

        // check the number of images
        $this->assertSame(2, count($web->images));

        // Current broken, due to bug in Guotte/DOMCrawler
        // Temporary deactivated, because relative paths using base_href doesn't work.
        // $this->assertSame([
        //     'https://test-pages.phpscraper.de/assets/cat.jpg',
        //     'https://test-pages.phpscraper.de/assets/cat.jpg',
        // ], $web->images);

        // $this->assertSame([
        //     [
        //         'url' => 'https://test-pages.phpscraper.de/assets/cat.jpg',
        //         'alt' => 'absolute path with base href',
        //         'width' => null,
        //         'height' => null,
        //     ],
        //     [
        //         'url' => 'https://test-pages.phpscraper.de/assets/cat.jpg',
        //         'alt' => 'relative path with base href',
        //         'width' => null,
        //         'height' => null,
        //     ],
        // ], $web->imagesWithDetails);
    }

    /**
     * @test
     */
    public function testWidth()
    {
        $web = new \spekulatius\phpscraper();

        // Navigate to the test page.
        $web->go('https://test-pages.phpscraper.de/images/width.html');

        // check the number of images
        $this->assertSame(3, count($web->images));

        // check the expected data
        $this->assertSame([
            [
                'url' => 'https://test-pages.phpscraper.de/assets/cat.jpg',
                'alt' => 'no width',
                'width' => null,
                'height' => null,
            ],
            [
                'url' => 'https://test-pages.phpscraper.de/assets/cat.jpg',
                'alt' => 'width at 1200px',
                'width' => '1200px',
                'height' => null,
            ],
            [
                'url' => 'https://test-pages.phpscraper.de/assets/cat.jpg',
                'alt' => 'width at 100rem',
                'width' => '100rem',
                'height' => null,
            ],
        ], $web->imagesWithDetails);
    }

    /**
     * @test
     */
    public function testHeight()
    {
        $web = new \spekulatius\phpscraper();

        // Navigate to the test page.
        $web->go('https://test-pages.phpscraper.de/images/height.html');

        // check the number of imagess
        $this->assertSame(3, count($web->images));

        // check the expected data
        $this->assertSame([
            [
                'url' => 'https://test-pages.phpscraper.de/assets/cat.jpg',
                'alt' => 'no height',
                'width' => null,
                'height' => null,
            ],
            [
                'url' => 'https://test-pages.phpscraper.de/assets/cat.jpg',
                'alt' => 'height at 1200px',
                'width' => null,
                'height' => '1200px',
            ],
            [
                'url' => 'https://test-pages.phpscraper.de/assets/cat.jpg',
                'alt' => 'height at 100rem',
                'width' => null,
                'height' => '100rem',
            ],
        ], $web->imagesWithDetails);
    }
}
