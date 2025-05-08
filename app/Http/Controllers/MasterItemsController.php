<?php

namespace App\Http\Controllers;

use App\Models\MasterItem;
use App\Models\KategoriItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MasterItemsController extends Controller
{
    public function index()
    {
        return view('master_items.index.index');
    }

    public function search(Request $request)
    {
        $kode = $request->kode;
        $nama = $request->nama;
        $hargamin = $request->hargamin;
        $hargamax = $request->hargamax;

        $data_search = MasterItem::query();

        if (!empty($kode)) $data_search = $data_search->where('kode', $kode);
        if (!empty($nama)) $data_search = $data_search->where('nama', 'LIKE', '%' . $nama . '%');
        if (!empty($hargamin) && !empty($hargamax)) {
            $data_search = $data_search->whereBetween('harga_beli', [$hargamin, $hargamax]);
        } elseif (!empty($hargamin)) {
            $data_search = $data_search->where('harga_beli', '>=', $hargamin);
        } elseif (!empty($hargamax)) {
            $data_search = $data_search->where('harga_beli', '<=', $hargamax);
        }

        $data_search = $data_search->with('kategoriItems')->select('kode', 'nama', 'jenis', 'harga_beli', 'laba', 'supplier', 'kategori_item_id', 'foto')->orderBy('id')->get();


        return json_encode([
            'status' => 200,
            'data' => $data_search
        ]);
    }

    public function formView($method, $id = 0)
    {
        if ($method == 'new') {
            $item = [];
        } else {
            $item = MasterItem::find($id);
        }
        $data['item'] = $item;
        $data['method'] = $method;
        $data['kategori_items'] = KategoriItem::orderBy('nama')->get();
        return view('master_items.form.index', $data);
    }

    public function singleView($kode)
    {
        $data['data'] = MasterItem::with('kategoriItems')->where('kode', $kode)->first();
        return view('master_items.single.index', $data);
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        if ($method == 'new') {
            $data_item = new MasterItem;
            $kode = MasterItem::count('id') + 1;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);
            sleep(3);
        } else {
            $data_item = MasterItem::find($id);
            $kode = $data_item->kode;
        }

        $data_item->nama = $request->nama;
        $data_item->harga_beli = $request->harga_beli;
        $data_item->laba = $request->laba;
        $data_item->kode = $kode;
        $data_item->supplier = $request->supplier;
        $data_item->jenis = $request->jenis;
        $data_item->kategori_item_id = $request->kategori_item_id;

        if ($request->hasFile('foto')) {
            $request->validate([
                'foto' => 'image|mimes:jpeg,jpg,png,svg|max:2048',
            ]);

            if ($method != 'new' && $data_item->foto && Storage::exists('public/' . $data_item->foto)) {
                Storage::delete('public/' . $data_item->foto);
            }

            $extension = $request->foto->getClientOriginalExtension();
            $fotoName = $kode . '.' . $extension;
            $request->foto->storeAs('public/foto_items', $fotoName);

            $data_item->foto = 'foto_items/' . $fotoName;
        }

        $data_item->save();

        return redirect('master-items');
    }

    public function delete($id)
    {
        MasterItem::find($id)->delete();
        return redirect('master-items');
    }

    public function updateRandomData()
    {
        $kategori_ids = \App\Models\KategoriItem::pluck('id')->toArray();
        $data = MasterItem::get();

        foreach($data as $item)
        {
            $kode = $item->id;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);

            $item->harga_beli = rand(100,1000000);
            $item->laba = rand(10,99);
            $item->kode = $kode;
            $item->supplier = $this->getRandomSupplier();
            $item->jenis = $this->getRandomJenis();
            $item->kategori_item_id = $kategori_ids[array_rand($kategori_ids)];
            $item->save();
        }
    }

    private function getRandomSupplier()
    {
        $array = ['Tokopaedi','Bukulapuk','TokoBagas','E Commurz','Blublu'];
        $random = rand(0,4);
        return $array[$random];
    }

    private function getRandomJenis()
    {
        $array = ['Obat','Alkes','Matkes','Umum','ATK'];
        $random = rand(0,4);
        return $array[$random];
    }

    public function getKategoriItems()
    {
        $kategori = KategoriItem::select('id', 'nama')->orderBy('nama')->get();
        return response()->json($kategori);
    }
}
