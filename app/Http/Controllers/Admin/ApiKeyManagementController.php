<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApiKey;
use Illuminate\Http\Request;

class ApiKeyManagementController extends Controller
{
    /**
     * Display the API Key management page
     */
    public function index()
    {
        return view('admin.pages.super-admin.api-key.index', [
            'page_title' => 'API Key Management'
        ]);
    }

    /**
     * Show create API key form
     */
    public function create()
    {
        return view('admin.pages.super-admin.api-key.create', [
            'page_title' => 'Create API Key'
        ]);
    }

    /**
     * Store a new API key (redirect to API controller)
     */
    public function store(Request $request)
    {
        // Redirect to API endpoint for actual creation
        $apiController = new \App\Http\Controllers\Api\ApiKeyController();
        $response = $apiController->store($request);
        
        if ($response->getStatusCode() === 201) {
            $data = json_decode($response->getContent(), true);
            return redirect()->route('admin.super.api-key.index')
                ->with('success', 'API key berhasil dibuat: ' . $data['data']['name']);
        } else {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal membuat API key');
        }
    }

    /**
     * Update API key (redirect to API controller)
     */
    public function update(Request $request, $id)
    {
        $apiController = new \App\Http\Controllers\Api\ApiKeyController();
        $response = $apiController->update($request, $id);
        
        if ($response->getStatusCode() === 200) {
            return redirect()->route('admin.super.api-key.index')
                ->with('success', 'API key berhasil diupdate');
        } else {
            return redirect()->back()
                ->with('error', 'Gagal mengupdate API key');
        }
    }

    /**
     * Delete API key (redirect to API controller)
     */
    public function destroy($id)
    {
        $apiController = new \App\Http\Controllers\Api\ApiKeyController();
        $response = $apiController->destroy($id);
        
        if ($response->getStatusCode() === 200) {
            return redirect()->route('admin.super.api-key.index')
                ->with('success', 'API key berhasil dihapus');
        } else {
            return redirect()->back()
                ->with('error', 'Gagal menghapus API key');
        }
    }

    /**
     * Show API key documentation page
     */
    

    /**
     * Show API testing interface
     */
   
}
