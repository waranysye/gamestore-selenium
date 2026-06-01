<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GameImageModel;
use App\Models\GameModel;
use App\Models\CategoryModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class GameController extends BaseController
{
    protected GameModel $gameModel;
    protected CategoryModel $categoryModel;
    protected GameImageModel $gameImageModel;

    public function __construct()
    {
        $this->gameModel       = new GameModel();
        $this->categoryModel   = new CategoryModel();
        $this->gameImageModel  = new GameImageModel();
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

        $gameId = $this->gameModel->insert([
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'price'       => $this->request->getPost('price'),
            'game_file'   => $this->request->getPost('game_file'),
            'size'        => $this->request->getPost('size'),
            'cover_image' => $fileName,
            'category_id' => $this->request->getPost('category_id'),
        ]);

        $this->saveGalleryImages($this->request->getFiles('images'), $gameId);

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
        $images = $this->gameImageModel->where('game_id', $id)->findAll();

        return view('admin/games/edit', compact('game', 'categories', 'images'));
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

            if ($fileName && file_exists(ROOTPATH . 'public/uploads/games/' . $fileName)) {
                unlink(ROOTPATH . 'public/uploads/games/' . $fileName);
            }

            $fileName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/games', $fileName);
        }

        $this->gameModel->update($id, [
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'price'       => $this->request->getPost('price'),
            'game_file'   => $this->request->getPost('game_file'),
            'size'        => $this->request->getPost('size'),
            'cover_image' => $fileName,
            'category_id' => $this->request->getPost('category_id'),
        ]);

        $this->saveGalleryImages($this->request->getFiles('images'), $id);

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

        $galleryDir = ROOTPATH . 'public/uploads/games/gallery/';
        $galleryImages = $this->gameImageModel->where('game_id', $id)->findAll();

        foreach ($galleryImages as $galleryImage) {
            if (!empty($galleryImage['image']) && file_exists($galleryDir . $galleryImage['image'])) {
                unlink($galleryDir . $galleryImage['image']);
            }
        }

        $this->gameImageModel->deleteImagesByGame($id);
        $this->gameModel->delete($id);

        return redirect()->to('/admin/games')
            ->with('success', 'Game berhasil dihapus');
    }

    public function removeImage($imageId)
    {
        $image = $this->gameImageModel->find($imageId);

        if (!$image) {
            return redirect()->back()->with('error', 'Image tidak ditemukan');
        }

        $galleryDir = ROOTPATH . 'public/uploads/games/gallery/';

        if (!empty($image['image']) && file_exists($galleryDir . $image['image'])) {
            unlink($galleryDir . $image['image']);
        }

        $this->gameImageModel->delete($imageId);

        return redirect()->back()->with('success', 'Gallery image berhasil dihapus');
    }

    private function saveGalleryImages(array $files, int $gameId): void
    {
        if (empty($files)) {
            return;
        }

        $galleryDir = ROOTPATH . 'public/uploads/games/gallery/';
        if (!is_dir($galleryDir)) {
            mkdir($galleryDir, 0755, true);
        }

        foreach ($files as $file) {
            if (is_array($file)) {
                foreach ($file as $innerFile) {
                    $this->saveGalleryFile($innerFile, $gameId, $galleryDir);
                }
            } else {
                $this->saveGalleryFile($file, $gameId, $galleryDir);
            }
        }
    }

    private function saveGalleryFile($file, int $gameId, string $galleryDir): void
    {
        if (!is_object($file) || !method_exists($file, 'isValid')) {
            return;
        }

        if ($file->isValid() && !$file->hasMoved()) {
            $imageName = $file->getRandomName();
            $file->move($galleryDir, $imageName);
            $this->gameImageModel->insert([
                'game_id' => $gameId,
                'image'   => $imageName,
            ]);
        }
    }
}