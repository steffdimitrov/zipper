<?php

namespace ZipperTest\system\Builder;

use Zipper\Builder\ZipperBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Class ZipperBuilderTest
 * @package ZipperTest\system\Builder
 */
class ZipperBuilderTest extends TestCase
{
    /**
     * @var ZipperBuilder
     */
    private $zipper;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->zipper = ZipperBuilder::aZip();
    }
    
    public function testMustBeInstanceOfZipperBuilder()
    {
        $this->assertInstanceOf(ZipperBuilder::class, $this->zipper);
    }
    
    public function testMustCreateZipFromDodgePdf()
    {
        $zipFile = __DIR__ . '/../../mock/dodge.zip';
        $this->zipper->withOutput($zipFile)
            ->addFile(__DIR__ . '/../../mock/dodge.pdf')
            ->withPassword('TheSecretOfTheDodge')
            ->withAESEncryption(true)
            ->archive();
        
        $this->assertFileExists($zipFile);
        $this->assertFileIsReadable($zipFile);
    }
}
