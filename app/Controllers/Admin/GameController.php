<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GameModel;
use App\Models\CategoryModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class GameController extends BaseController
{
    protected GameModel $gameModel;
    protected CategoryModel $categoryModel;

    public function __construct()
    {
        $this->gameModel     = new GameModel();
        $this->categoryModel = new CategoryModel();
    }

    /**
     * LIST GAME
     * GET /admin/game
     */
    public function index()
    {
        $games = $this->gameModel
            ->select('games.*, categories.name AS category_name')
            ->join('categories', 'categories.id = games.category_id')
            ->findAll();

        return view('admin/games/index', [
            'games'  => $games,
            'active' => 'games'
        ]);
    }

    public function save()
{
    $file = $this->request->getFile('cover_image');

    if ($file->isValid() && !$file->hasMoved()) {
        $fileName = $file->getRandomName();
        $file->move(ROOTPATH . 'public/uploads/games', $fileName);

        $this->gameModel->save([
            'title'       => $this->request->getPost('title'),
            'price'       => $this->request->getPost('price'),
            'genre'       => $this->request->getPost('genre'),
            'cover_image' => $fileName
        ]);
    }

    return redirect()->to('/admin/games');
}

    /**
     * FORM CREATE
     * GET /admin/game/new
     */
    public function new()
    {
        $categories = $this->categoryModel->findAll();
        return view('admin/games/create', compact('categories'));
    }

    /**
     * STORE DATA
     * POST /admin/game
     */
    public function create()
    {
        // VALIDATION
        $rules = [
            'title'       => 'required|min_length[3]',
            'description' => 'required',
            'price'       => 'required|numeric',
            'category_id' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $file     = $this->request->getFile('cover_image');
        $fileName = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/games', $fileName);
        }

        $this->gameModel->insert([
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'price'       => $this->request->getPost('price'),
            'game_file'   => $this->request->getPost('game_file'),
            'cover_image' => $fileName,
            'category_id' => $this->request->getPost('category_id'),
        ]);

        return redirect()->to('/admin/games')
            ->with('success', 'Game berhasil ditambahkan');
    }

    /**
     * FORM EDIT
     * GET /admin/game/{id}/edit
     */
    public function edit($id)
    {
        $game = $this->gameModel->find($id);

        if (!$game) {
            throw new PageNotFoundException('Game tidak ditemukan');
        }

        $categories = $this->categoryModel->findAll();

        return view('admin/games/edit', compact('game', 'categories'));
    }

    /**
     * UPDATE DATA
     * PUT /admin/game/{id}
     */
    public function update($id)
    {
        $game = $this->gameModel->find($id);

        if (!$game) {
            throw new PageNotFoundException('Game tidak ditemukan');
        }

        // VALIDATION
        $rules = [
            'title'       => 'required|min_length[3]',
            'description' => 'required',
            'price'       => 'required|numeric',
            'category_id' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $file     = $this->request->getFile('cover_image');
        $fileName = $game['cover_image'];

        if ($file && $file->isValid() && !$file->hasMoved()) {

            if ($fileName && file_exists('uploads/games/' . $fileName)) {
                unlink('uploads/games/' . $fileName);
            }

            $fileName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/games', $fileName);
        }

        $this->gameModel->update($id, [
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'price'       => $this->request->getPost('price'),
            'game_file'   => $this->request->getPost('game_file'),
            'cover_image' => $fileName,
            'category_id' => $this->request->getPost('category_id'),
        ]);

        return redirect()->to('/admin/games')
            ->with('success', 'Game berhasil diupdate');
    }

    /**
     * DELETE
     * DELETE /admin/game/{id}
     */
    public function delete($id)
    {
        $game = $this->gameModel->find($id);

        if (!$game) {
            throw new PageNotFoundException('Game tidak ditemukan');
        }

        if ($game['cover_image'] && file_exists(ROOTPATH . 'public/uploads/games/' . $game['cover_image'])) {
    unlink(ROOTPATH . 'public/uploads/games/' . $game['cover_image']);
}

        $this->gameModel->delete($id);

        return redirect()->to('/admin/game')
            ->with('success', 'Game berhasil dihapus');
    }
}