<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KategoriItem extends Model
{
    use SoftDeletes;

    protected $table = 'kategori_items';

    protected $fillable = [
        'nama_kategori',
        'deskripsi'
    ];

    public function masterItems()
    {
        return $this->hasMany(MasterItem::class, 'kategori_item_id', 'id');
    }
}
