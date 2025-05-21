<?php

namespace App\Services;

/**
 * Class ServiceResponse
 *
 * Digunakan untuk standarisasi respon dari Service Layer,
 * agar semua service mengembalikan format yang konsisten.
 */
class ServiceResponse
{
    /**
     * Status operasi, true jika berhasil, false jika gagal
     *
     * @var bool
     */
    public bool $status;

    /**
     * Pesan untuk menjelaskan hasil operasi
     *
     * @var string
     */
    public string $message;

    /**
     * Data tambahan (opsional) yang dikembalikan
     *
     * @var mixed
     */
    public mixed $data;

    /**
     * Constructor private untuk memaksa penggunaan static method
     *
     * @param bool $status
     * @param string $message
     * @param mixed $data
     */
    private function __construct(bool $status, string $message, mixed $data = null)
    {
        $this->status = $status;
        $this->message = $message;
        $this->data = $data;
    }

    /**
     * Digunakan saat operasi berhasil
     *
     * @param string $message
     * @param mixed $data
     * @return self
     */
    public static function success(string $message, mixed $data = null): self
    {
        return new self(true, $message, $data);
    }

    /**
     * Digunakan saat operasi gagal
     *
     * @param string $message
     * @param mixed $data
     * @return self
     */
    public static function error(string $message, mixed $data = null): self
    {
        return new self(false, $message, $data);
    }

    /**
     * Mengubah objek ke bentuk array untuk digunakan di controller atau response
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->data
        ];
    }
}
