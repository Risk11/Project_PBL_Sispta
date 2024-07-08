<?php

namespace App\Http\Controllers;

use App\Models\ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangan = ruangan::all();

        return view('pages.ruangan', compact('ruangan'));
    }
    public function create()
    {
        return view('crud.ruangancreate');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $ruangan = ruangan::create($request->all());
        $activityLogController = new ActivityLogController();
        $activityLogController->store('Menambahkan data ruangan dengan id = ' . $ruangan->id);
        return redirect()->route('ruangan.index')->with('success', 'ruangan created successfully!');
    }
    public function show(Ruangan $ruangan)
    {
        return view('crud.ruanganshow', compact('ruangan'));
    }
    public function edit(ruangan $ruangan)
    {
        return view('crud.ruanganedit', compact('ruangan')); // Assuming a view exists
    }
    public function update(Request $request, ruangan $ruangan)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $ruangan->update($request->all());
        $activityLogController = new ActivityLogController();
        $activityLogController->store('Mempembaharui data ruangan dengan id = ' . $ruangan->id);
        return redirect()->route('ruangan.index')->with('success', 'ruangan updated successfully!');
    }
    public function destroy(ruangan $ruangan)
    {
        $ruangan->delete();
        $activityLogController = new ActivityLogController();
        $activityLogController->store('Menghapus data ruangan dengan id = ' . $ruangan->id);
        return redirect()->route('ruangan.index')->with('success', 'ruangan deleted successfully!');
    }
}
