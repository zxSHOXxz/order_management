<?php

namespace App\Http\Controllers\Apps;

use App\DataTables\PermissionsDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermissionManagementController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:read role', ['only' => ['create', 'store']]);
        $this->middleware('can:read role', ['only' => ['show', 'index']]);
        $this->middleware('can:read role', ['only' => ['edit', 'update']]);
        $this->middleware('can:read role', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(PermissionsDataTable $dataTable)
    {
        return $dataTable->render('pages/apps.user-management.permissions.list');
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
