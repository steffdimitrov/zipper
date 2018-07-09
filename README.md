# This is Zipper library.

## Description
* It provides availability for archive (zip) files protected with password.

* It uses php zip (ZipArchive) library.

# Examples
For archivе files with password:
#### Usage
```php
$zipFile = __DIR__ . '/../../archive.zip';
$zipper = ZipperBuilder::aZip()->withOutput($zipFile)
    ->addFile(__DIR__ . '/file1.txt')
    ->addFile(__DIR__ . '/file2.doc')
    ->addFile(__DIR__ . '/file3.png')
    ->withPassword('MegaStrongPassword')
    ->withAESEncryption(true)
    ->archive();
```

### Method Description
```php
ZipperBuilder::aZip() // return instance of Builder class
 ->withOutput($path) // set ouput archive file
 ->addFile($file) // adding file to collection that will be archive
 ->withPassword($password) // optional if you want to set password for archive
 ->withAESEncryption(true) // optional (default value is false) set whether you want AES-256 encryption (supported by php 7.2 and upper)
 ->archive() // void method that performs necessary checks and creates zip archive
```

## Resources
* http://php.net/manual/en/ziparchive.setencryptionname.php
* https://gist.github.com/odan/890ee6bb265b2c836e4eb87d482fb948#creating-encrypted-zip-files-with-password-in-php