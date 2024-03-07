<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    public function listMenu()
    {
        $dataMenu = Menu::get();

        return response()->json(['message' => 'success', 'data' => $dataMenu]);
    }

    public function createMenu(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'nama_menu' => 'required',
            'deskripsi_menu' => 'required',
            'harga_menu' => 'required',
            'jenis_menu' => 'required',
            'gambar_menu' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Sesuaikan dengan kebutuhan
        ]);
    
        // Simpan gambar ke storage
        $gambarMenuFileName = $request->file('gambar_menu')->getClientOriginalName(); // Mendapatkan nama file gambar
    
        // Pindahkan file gambar ke direktori yang diinginkan
        $request->file('gambar_menu')->storeAs('public/menu_images', $gambarMenuFileName);
    
        // Buat entri menu baru
        $menu = new Menu();
        $menu->nama_menu = $validatedData['nama_menu'];
        $menu->deskripsi_menu = $validatedData['deskripsi_menu'];
        $menu->harga_menu = $validatedData['harga_menu'];
        $menu->jenis_menu = $validatedData['jenis_menu'];
        $menu->gambar_menu = $gambarMenuFileName; // Simpan nama file gambar ke database
        $menu->save();
    
        return response()->json(['message' => 'success']);
    }
    

    public function updateMenu(Request $request, $id)
    {
        // Validasi data
        $validatedData = $request->validate([
            'nama_menu' => 'required',
            'deskripsi_menu' => 'required',
            'harga_menu' => 'required',
            'jenis_menu' => 'required',
            'gambar_menu' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Bisa nullable
        ]);

        // Ambil data menu dari database
        $menu = Menu::find($id);

        if (!$menu) {
            return response()->json(['message' => 'Menu not found'], 404);
        }

        // Periksa apakah ada file gambar baru yang diunggah
        if ($request->hasFile('gambar_menu')) {
            // Hapus gambar lama dari storage
            Storage::delete($menu->gambar_menu);

            // Simpan gambar baru ke storage
            $gambarMenuPath = $request->file('gambar_menu')->store('public/menu_images');
            $menu->gambar_menu = $gambarMenuPath;
        }

        // Update data menu
        $menu->nama_menu = $validatedData['nama_menu'];
        $menu->deskripsi_menu = $validatedData['deskripsi_menu'];
        $menu->harga_menu = $validatedData['harga_menu'];
        $menu->jenis_menu = $validatedData['jenis_menu'];
        $menu->save();

        return response()->json(['message' => 'success']);
    }

    public function deleteMenu($id)
    {
        // Ambil data menu dari database
        $menu = Menu::find($id);

        if (!$menu) {
            return response()->json(['message' => 'Menu not found'], 404);
        }

        // Hapus gambar dari storage
        Storage::delete($menu->gambar_menu);

        // Hapus data menu dari database
        $menu->delete();

        return response()->json(['message' => 'success']);
    }
}
