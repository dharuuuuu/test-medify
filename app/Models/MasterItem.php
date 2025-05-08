<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'master_items';

    protected $fillable = [
        'kode',
        'nama',
        'harga_beli',
        'laba',
        'supplier',
        'jenis',
        'foto',
        'item_kategori_id',
    ];

    public function kategoriItems()
    {
        return $this->belongsTo(KategoriItem::class, 'kategori_item_id', 'id');
    }
}
