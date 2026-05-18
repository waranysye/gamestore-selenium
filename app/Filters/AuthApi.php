<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class AuthApi implements FilterInterface
{
    /**
     * Logika autentikasi untuk API (misal: cek Bearer Token)
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getHeaderLine('Authorization');

        // Contoh pengecekan: Jika header Authorization kosong
        if (empty($authHeader)) {
            return Services::response()
                ->setJSON([
                    'status'  => 401,
                    'message' => 'Token tidak ditemukan. Silakan login terlebih dahulu.'
                ])
                ->setStatusCode(401);
        }

        // Catatan: Di sini kamu nantinya bisa menambahkan logika verifikasi JWT 
        // atau mengecek token di database.
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Biasanya dibiarkan kosong
    }
}