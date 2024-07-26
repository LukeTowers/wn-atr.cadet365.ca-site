<?php

namespace ACFP\ATR\Models;

use Illuminate\Support\Facades\Crypt;
use Winter\Storm\Support\Facades\File as FileHelper;

/**
 * Stores file contents encrypted with the application key
 * @author LukeTowers
 */
class EncryptedFile extends \System\Models\File
{
    /**
     * Encrypt the provided data
     * @param mixed $data
     * @return mixed $data
     */
    protected function encrypt($data)
    {
        if ($this->attachment) {
            $this->attachment->fireEvent($this->field . '.encrypting', [$this]);
        }
        return Crypt::encrypt($data);
    }

    /**
     * Decrypt the provided data
     *
     * @param mixed $data
     * @return mixed $data
     */
    protected function decrypt($data)
    {
        if ($this->attachment) {
            $this->attachment->fireEvent($this->field . '.decrypting', [$this]);
        }
        return Crypt::decrypt($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getContents($fileName = null)
    {
        return $this->decrypt(parent::getContents($fileName));
    }

    /**
     * {@inheritdoc}
     */
    public function fromData($data, $fileName)
    {
        if ($data === null) {
            return;
        }

        return parent::fromData($this->encrypt($data), $fileName);
    }

    /**
     * {@inheritdoc}
     */
    protected function putFile($sourcePath, $destinationFileName = null)
    {
        // Encrypt the contents of the $sourcePath
        FileHelper::put($sourcePath, $this->encrypt(FileHelper::get($sourcePath)));

        return parent::putFile($sourcePath, $destinationFileName);
    }

    /**
     * Disable thumbs
     */
    public function isImage() {
        return false;
    }
}
