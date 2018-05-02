<?php

namespace Zipper\Builder;

/**
 * Class ZipperBuilder
 */
class ZipperBuilder
{
    /**
     * @var \ZipArchive
     */
    private $archiver;
    /**
     * @var string
     */
    private $outputFile;
    /**
     * @var string
     */
    private $password;
    /**
     * @var array
     */
    private $files;
    /**
     * @var bool
     */
    private $hasAES;
    
    /**
     * ZipperBuilder constructor.
     *
     * @param \ZipArchive|null $archive
     */
    private function __construct(\ZipArchive $archive = null)
    {
        $this->archiver = $archive ?? new \ZipArchive();
        $this->files = [];
        $this->hasAES = false;
    }
    
    /**
     * @param string $file
     *
     * @return ZipperBuilder
     */
    public function withOutput(string $file): ZipperBuilder
    {
        $this->outputFile = $file;
        
        return $this;
    }
    
    /**
     * @param string $password
     *
     * @return ZipperBuilder
     */
    public function withPassword(string $password): ZipperBuilder
    {
        $this->password = $password;
        
        return $this;
    }
    
    /**
     * @param string $file
     *
     * @return ZipperBuilder
     */
    public function addFile(string $file): ZipperBuilder
    {
        $this->files[] = $file;
        
        return $this;
    }
    
    /**
     * @param bool $encrypted
     *
     * @return ZipperBuilder
     */
    public function withAESEncryption(bool $encrypted): ZipperBuilder
    {
        $this->hasAES = $encrypted;
        
        return $this;
    }
    
    /**
     * @return ZipperBuilder
     */
    public static function aZip(): ZipperBuilder
    {
        return new self();
    }
    
    /**
     * @throws \RuntimeException
     */
    public function archive(): void
    {
        $status = $this->archiver->open($this->outputFile, \ZipArchive::CREATE);
        if ($status !== true) {
            throw new \RuntimeException(sprintf('Failed to create zip archive. (Status code: %s)', $status));
        }
    
        if (!$this->archiver->setPassword($this->password)) {
            throw new \RuntimeException('Set password failed');
        }
        
        foreach ($this->files as $file) {
            $location = basename($file);
            if (!$this->archiver->addFile($file, $location)) {
                throw new \RuntimeException(sprintf('Add file failed: %s', $file));
            }
    
            if ($this->hasAES) {
                // encrypt the file with AES-256
                if (!$this->archiver->setEncryptionName($location, \ZipArchive::EM_AES_256)) {
                    throw new \RuntimeException(sprintf('Set encryption failed: %s', $location));
                }
            }
        }
    
        $this->archiver->close();
    
    }
}