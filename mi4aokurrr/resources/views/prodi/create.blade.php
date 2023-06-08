

@extends('layout.main')
@section('judul_halaman', 'Halaman Prodi')

@section('content')
     <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Tambah Prodi</h4>
                  <p class="card-description">
                    Formulir tambah data Prodi
                  </p>
                  <form action = "{{route('prodi.store')}}" method = "POST" class="forms-sample">
                    @csrf
                    <div class="form-group">
                      <label for="nama_fakultas">Nama Fakultas</label>
                      <select name="fakultas_id" class="form-control">
                        @foreach ($fakultas as $item)
                        <option value="{{$item->id}}">{{$item->nama_fakultas}}</option>   
                        @endforeach
                      </select>
                      @error('fakultas_id')
                      <span class = "txt-danger">{{$message}} </span>
                      @enderror
                    </div>

                    <div class="form-group">
                      <label for="nama_prodi">Nama Program Studi</label>
                      <input type="text" class="form-control" name="nama_prodi" placeholder="Nama Prodi"
                      value = "{{old('nama_prodi')}}">
                      @error('nama_prodi')
                      <span class = "txt-danger">{{$message}} </span>
                      @enderror
                    </div>
                 
                   
                    <button type="submit" class="btn btn-info mr-2 btn-rounded">Submit</button>
                    <a href = "{{route('fakultas.index')}}" class="btn btn-light btn-rounded">Cancel</button>
                  </form>
                </div>
              </div>
            </div>
        </div>
    
@endsection