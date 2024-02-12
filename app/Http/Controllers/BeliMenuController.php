<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BeliMenu;
use App\Models\Menu;

class BeliMenuController extends Controller
{
    public function listPembelian()
    {
        $dataPembelian = BeliMenu::get();
        return response()->json(['message' => 'success', 'data' => $dataPembelian]);
    }

    public function createPembelian(Request $request)
    {
        $validateData = $request->validate([
            '*.jumlah_beli' => 'required|integer|min:1', // Validasi jumlah_beli untuk setiap item
            '*.menu_id' => 'required|exists:menus,id', // Validasi menu_id untuk setiap item
        ]);
    
        $totalPembayaran = 0; // Inisialisasi total pembayaran
    
        foreach ($validateData as $item) {
            $pembelian = new BeliMenu();
            $pembelian->jumlah_beli = $item['jumlah_beli'];
            $pembelian->menu_id = $item['menu_id'];
            $pembelian->save();
    
            // Hitung total pembayaran untuk setiap pembelian
            $menu = Menu::find($item['menu_id']);
            $totalPembayaran += $menu->harga_menu * $item['jumlah_beli'];
        }
    
        return response()->json(['message' => 'success', 'total_pembayaran' => $totalPembayaran]);
    }

    public function updatePembelian(Request $request, $id)
    {
        $validateData = $request->validate([
            'jumlah_beli' => 'required',
            'menu_id' => 'required'
        ]);

        $pembelian = BeliMenu::find($id);
        $pembelian->jumlah_beli = $validateData['jumlah_beli'];
        $pembelian->menu_id = $validateData['menu_id'];
        $pembelian->save();
        return response()->json(['message' => 'success']);
    }

    public function deletePembelian($id)
    {
        $pembelian = BeliMenu::find($id);
        $pembelian->delete();
        return response()->json(['message' => 'success']);
    }
}

