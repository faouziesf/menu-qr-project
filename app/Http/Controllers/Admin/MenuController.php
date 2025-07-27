<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MenuController extends Controller
{
    public function create()
    {
        return view('admin.menus.create-step1');
    }

    public function storeStep1(Request $request)
    {
        $request->validate([
            'type' => 'required|in:pdf,image,html'
        ]);

        session(['menu_data' => ['type' => $request->type]]);
        return redirect()->route('admin.menus.create.step2');
    }

    public function createStep2()
    {
        if (!session('menu_data')) {
            return redirect()->route('admin.menus.create');
        }

        $templates = ['blank' => 'Page vierge', 'modern' => 'Moderne', 'classic' => 'Classique'];
        return view('admin.menus.create-step2', compact('templates'));
    }

    public function storeStep2(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'template' => 'required|string'
        ]);

        $menuData = session('menu_data', []);
        $menuData['name'] = $request->name;
        $menuData['template'] = $request->template;
        session(['menu_data' => $menuData]);

        return redirect()->route('admin.menus.create.step3');
    }

    public function createStep3()
    {
        $menuData = session('menu_data');
        if (!$menuData) {
            return redirect()->route('admin.menus.create');
        }

        return view('admin.menus.create-step3', compact('menuData'));
    }

    public function store(Request $request)
    {
        $menuData = session('menu_data');
        if (!$menuData) {
            return redirect()->route('admin.menus.create');
        }

        $validationRules = [];
        switch ($menuData['type']) {
            case 'pdf':
                $validationRules['file'] = 'required|mimes:pdf|max:10240';
                break;
            case 'image':
                $validationRules['file'] = 'required|image|mimes:jpeg,png,jpg,gif|max:5120';
                break;
            case 'html':
                $validationRules['content'] = 'required|string';
                break;
        }

        $request->validate($validationRules);

        // Créer le menu
        $menu = new Menu();
        $menu->name = $menuData['name'];
        $menu->type = $menuData['type'];
        $menu->template = $menuData['template'];
        $menu->slug = Str::slug($menuData['name']) . '-' . uniqid();
        $menu->is_published = true; // Publier automatiquement

        // Gérer le contenu selon le type
        if ($menuData['type'] === 'html') {
            $menu->content = $request->content;
        } else {
            // Upload du fichier
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('menus', $fileName, 'public');
            $menu->file_path = $filePath;
        }

        $menu->save();

        // Générer le QR Code
        $this->generateQrCode($menu);

        // Nettoyer la session
        session()->forget('menu_data');

        return redirect()->route('admin.dashboard')->with('success', 'Menu créé avec succès !');
    }

    public function edit(Menu $menu)
    {
        return view('admin.menus.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'template' => 'required|string',
            'is_published' => 'boolean'
        ]);

        $menu->update([
            'name' => $request->name,
            'template' => $request->template,
            'is_published' => $request->has('is_published')
        ]);

        // Mettre à jour le contenu selon le type
        if ($menu->type === 'html' && $request->has('content')) {
            $menu->content = $request->content;
        }

        // Gérer le nouveau fichier si uploadé
        if ($request->hasFile('file')) {
            $validationRules = $menu->type === 'pdf' ? 'mimes:pdf|max:10240' : 'image|mimes:jpeg,png,jpg,gif|max:5120';
            $request->validate(['file' => $validationRules]);

            // Supprimer l'ancien fichier
            if ($menu->file_path) {
                Storage::disk('public')->delete($menu->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('menus', $fileName, 'public');
            $menu->file_path = $filePath;
        }

        $menu->save();

        return redirect()->route('admin.dashboard')->with('success', 'Menu modifié avec succès !');
    }

    public function destroy(Menu $menu)
    {
        // Supprimer les fichiers associés
        if ($menu->file_path) {
            Storage::disk('public')->delete($menu->file_path);
        }
        if ($menu->qr_code_path) {
            Storage::disk('public')->delete($menu->qr_code_path);
        }

        $menu->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Menu supprimé avec succès !');
    }

    private function generateQrCode(Menu $menu)
    {
        $qrCodePath = 'qrcodes/menu-' . $menu->slug . '.svg';
        
        if (!Storage::disk('public')->exists('qrcodes')) {
            Storage::disk('public')->makeDirectory('qrcodes');
        }

        QrCode::format('svg')
              ->size(300)
              ->generate($menu->public_url, storage_path('app/public/' . $qrCodePath));

        $menu->qr_code_path = $qrCodePath;
        $menu->save();
    }
}