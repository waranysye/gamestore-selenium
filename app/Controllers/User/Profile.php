<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Profile extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * PROFILE PAGE (ROLE USER ONLY)
     */
    public function index()
    {
        $userId = session()->get('user_id');
        $role   = session()->get('role');

        if (!$userId || $role !== 'user') {
            return redirect()->to('/login');
        }

        $user = $this->userModel
            ->where('id', $userId)
            ->where('role', 'user')
            ->first();

        // Jika admin sudah delete akun
        if (!$user) {
            session()->destroy();
            return redirect()->to('/login');
        }

        return view('User/profile', [
            'user'       => $user,
            'activePage' => 'profile'
        ]);
    }

    /**
     * UPDATE PROFILE
     */
    public function update()
    {
        $userId = session()->get('user_id');
        $role   = session()->get('role');

        if (!$userId || $role !== 'user') {
            return redirect()->to('/login');
        }

        $user = $this->userModel->find($userId);

        if (!$user) {
            session()->destroy();
            return redirect()->to('/login');
        }

        /* ===============================
           VALIDATION
        =============================== */
        $rules = [
            'email' => "required|valid_email|is_unique[users.email,id,{$userId}]",
            'password' => 'permit_empty|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->validator->getErrors());
        }

        $data = [
            'email' => $this->request->getPost('email')
        ];

        // Update password (optional)
        if ($this->request->getPost('password')) {
            $data['password'] = password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            );
        }

        /* ===============================
           UPLOAD PHOTO
        =============================== */
        $file = $this->request->getFile('photo');
        $uploadPath = FCPATH . 'uploads/profile/';

        if ($file && $file->isValid() && !$file->hasMoved()) {

            if (!empty($user['photo'])) {
                $oldPath = $uploadPath . $user['photo'];
                if (is_file($oldPath)) {
                    unlink($oldPath);
                }
            }

            $newName = $file->getRandomName();
            $file->move($uploadPath, $newName);

            $data['photo'] = $newName;
        }

        $db = \Config\Database::connect();
        $db->table('users')
           ->where('id', $userId)
           ->update($data);
           
        session()->set('email', $data['email']);
        // Redirect balik ke profile, jangan ke '/' (Home)
        return redirect()->to('/profile')->with('success', 'Profile updated successfully');
    }
}