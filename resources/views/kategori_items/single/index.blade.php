@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-group mb-2">
                <a href="{{ url('kategori-items') }}" class="btn btn-secondary">Kembali ke Daftar Kategori Item</a>
            </div>
            <div class="card">
                <div class="card-header">Kategori Item</div>

                <div class="card-body">
                    <table>
                        <tr>
                            <th>Nama</th>
                            <td>:</td>
                            <td>{{ $data->nama }}</td>
                        </tr>
                    </table>

                    <h6 class="mt-4">Daftar Item</h6>
                    @if($master_items->count() > 0)
                        <ul style="padding-left: 20px;">
                            @foreach($master_items as $item)
                                <li>{{ $item->nama }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Tidak ada item yang terkait.</p>
                    @endif

                    <a class="btn btn-info mt-3" href="{{ url('kategori-items/form/edit/' . $data->id) }}">Edit</a>
                    <a class="btn btn-danger mt-3" href="{{ url('kategori-items/delete/' . $data->id) }}" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
