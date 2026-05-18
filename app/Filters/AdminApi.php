<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class AdminApi implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Logika sederhana: Cek session atau decode token untuk melihat role.
        // Di sini kita asumsikan kamu menyimpan role di session atau payload token.
        if (session()->get('role') !== 'admin') {
            return Services::response()
                ->setJSON([
                    'status'  => 403,
                    'message' => 'Akses ditolak. Anda bukan admin.'
                ])
                ->setStatusCode(403);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Kosong
    }
}