<?php

namespace App\Http\Controllers;

use App\Models\Laboratorium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LaboratoriumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $laboratoriums = Laboratorium::all();

        return response()->json([
            'success' => true,
            'data' => $laboratoriums,
            'message' => 'Data laboratorium berhasil diambil'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_name' => 'required|string|max:100',
            'is_available' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $laboratorium = Laboratorium::create([
            'room_name' => $request->room_name,
            'is_available' => $request->is_available ?? true
        ]);

        return response()->json([
            'success' => true,
            'data' => $laboratorium,
            'message' => 'Laboratorium berhasil ditambahkan'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Laboratorium $laboratorium)
    {
        return response()->json([
            'success' => true,
            'data' => $laboratorium,
            'message' => 'Data laboratorium berhasil diambil'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Laboratorium $laboratorium)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Laboratorium $laboratorium)
    {
        $validator = Validator::make($request->all(), [
            'room_name' => 'string|max:100',
            'is_available' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $laboratorium->update($request->only(['room_name', 'is_available']));

        return response()->json([
            'success' => true,
            'data' => $laboratorium->fresh(),
            'message' => 'Laboratorium berhasil diperbarui'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Laboratorium $laboratorium)
    {
        $laboratorium->delete();

        return response()->json([
            'success' => true,
            'message' => 'Laboratorium berhasil dihapus'
        ]);
    }
}
