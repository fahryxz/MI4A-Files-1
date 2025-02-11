<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Http\Request;

class MahasiswaController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $mahasiswas = Mahasiswa::all();
        return $this->sendSuccess($mahasiswas, 'Data Mahasiswa', 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $prodi = Prodi::all();
        return view('mahasiswa.create') -> with ('prodi', $prodi);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $validasi = $request->validate([
            'npm' => 'required|unique:mahasiswas',
            'nama' => 'required',
            'tanggal' => 'required',
            'foto' => 'required|file|image',
            'prodi_id' => 'required'
        ]);

        $ext = $request -> foto -> getClientOriginalExtension();
        $new_filename = $request->npm . '.' . $ext;
        $file = $request->file('foto');
        $file ->move('public', $new_filename);

        $validasi['foto'] = $new_filename;

        $result = Mahasiswa::create($validasi);
        if($result){
            return $this->sendSuccess($result,
            'mahasiswa berhasil ditambahkan', 201);
        }else {
            return $this->sendError('','Data gagal disimpan', 400);
        }

        $mahasiswa = new Mahasiswa();
        $mahasiswa->npm = $validasi['npm'];
        $mahasiswa->nama = $validasi['nama'];
        $mahasiswa->tanggal = $validasi['tanggal'];
        $mahasiswa->prodi_id = $validasi['prodi_id'];

        // upload foto

        // $ext = $request -> foto -> getClientOriginalExtension();
        // $new_filename = $request->npm . '.' . $ext;
        // $file = $request->file('foto');
        // $request ->move('public', $new_filename);

        // $validasi['foto'] = $new_filename;
        // $fileName = time() . '.' . $request->image->extension();
        // $request->image->storeAs('public/images', $fileName);
        
        // $mahasiswa = new Mahasiswa;
        // $mahasiswa->npm = $request->input('npm');
        // $mahasiswa->nama = $request->input('nama');
        // $mahasiswa->tanggal = $request->input('tanggal');
        // if($request->hasfile('foto'))
        // {
        //     $file = $request->file('foto');
        //     $extention = $file->getClientOriginalExtension();
        //     $filename = time().'.'.$extention;
        //     $file->move('public/images/', $filename);
        //     $mahasiswa->foto = $filename;
        // }
        // $mahasiswa->prodi_id = $request-> input('prodi_id');
        // $mahasiswa->save();
        
        return redirect() -> route ('mahasiswa.index') -> with('success', 'Data berhasil disimpan' . $validasi['nama']);  
        
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        //
        $prodi = Prodi::orderBy('nama_prodi', 'ASC') -> get();
        return view('mahasiswa.edit')
        ->with('mahasiswa', $mahasiswa)
        ->with('prodi', $prodi);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $validasi = $request->validate([
            // 'npm' => 'required|unique:mahasiswas',
            'nama' => '',
            'tanggal' => '',
            'foto' => '|file|image',
            'prodi_id' => ''
        ]);

        $result = Mahasiswa::where('id', $id);
        if(isset($request->foto)){

            $ext = $request -> foto -> getClientOriginalExtension();
            $new_filename = $result->first()->npm . '.' . $ext;
            $file = $request->file('foto');
            $file ->move('public', $new_filename);
            $validasi['foto'] = $new_filename;
            }
        $result->update($validasi);
        return $this->sendError($result->first(),'Mahasiswa berhasil diubah', 200);
        

        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $mahasiswa = Mahasiswa::where('id', $id);
        unlink(public_path("public/".$mahasiswa->first()->foto));
        if($mahasiswa->delete()){
            return $this->sendSuccess([],'Data Mahasiswa Berhasil Di Hapus', 303);
        }else{
            return $this->sendError('','Data Mahasiswa gaga dihapus',404);
        }
    }
}