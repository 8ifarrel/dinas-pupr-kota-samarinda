<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ApiKeyController extends Controller
{
    /**
     * Display a listing of all API keys (for admin view)
     */
    public function index()
    {
        try {
            $apiKeys = ApiKey::with('generator:id,name,email')
                ->select('id', 'key', 'name', 'is_active', 'generated_by_user_id', 'created_at', 'updated_at')
                ->orderBy('created_at', 'desc')
                ->get();

            // Mask the API keys for security (show only first 8 and last 4 characters)
            $apiKeys->transform(function ($apiKey) {
                $key = $apiKey->key;
                $maskedKey = substr($key, 0, 8) . str_repeat('*', max(0, strlen($key) - 12)) . substr($key, -4);
                $apiKey->masked_key = $maskedKey;
                return $apiKey;
            });

            return response()->json([
                'success' => true,
                'message' => 'API keys retrieved successfully',
                'data' => $apiKeys,
                'total' => $apiKeys->count()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve API keys',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created API key
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'generated_by_user_id' => 'nullable|integer|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $apiKey = ApiKey::create([
                'key' => 'uptdjb-' . Str::random(32),
                'name' => $request->name,
                'is_active' => true,
                'generated_by_user_id' => $request->generated_by_user_id ?? 1
            ]);

            return response()->json([
                'success' => true,
                'message' => 'API key created successfully',
                'data' => [
                    'id' => $apiKey->id,
                    'key' => $apiKey->key, // Return full key only on creation
                    'name' => $apiKey->name,
                    'is_active' => $apiKey->is_active,
                    'created_at' => $apiKey->created_at,
                    'warning' => 'Please save this API key securely. It will not be shown again in full.'
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create API key',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified API key
     */
    public function show($id)
    {
        try {
            $apiKey = ApiKey::with('generator:id,name,email')->findOrFail($id);

            // Mask the API key for security
            $key = $apiKey->key;
            $maskedKey = substr($key, 0, 8) . str_repeat('*', max(0, strlen($key) - 12)) . substr($key, -4);

            return response()->json([
                'success' => true,
                'message' => 'API key retrieved successfully',
                'data' => [
                    'id' => $apiKey->id,
                    'masked_key' => $maskedKey,
                    'name' => $apiKey->name,
                    'is_active' => $apiKey->is_active,
                    'generated_by_user_id' => $apiKey->generated_by_user_id,
                    'generator' => $apiKey->generator,
                    'created_at' => $apiKey->created_at,
                    'updated_at' => $apiKey->updated_at
                ]
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'API key not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve API key',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified API key
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'is_active' => 'sometimes|required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $apiKey = ApiKey::findOrFail($id);
            
            $apiKey->update($request->only(['name', 'is_active']));

            return response()->json([
                'success' => true,
                'message' => 'API key updated successfully',
                'data' => [
                    'id' => $apiKey->id,
                    'name' => $apiKey->name,
                    'is_active' => $apiKey->is_active,
                    'updated_at' => $apiKey->updated_at
                ]
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'API key not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update API key',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified API key
     */
    public function destroy($id)
    {
        try {
            $apiKey = ApiKey::findOrFail($id);
            $apiKey->delete();

            return response()->json([
                'success' => true,
                'message' => 'API key deleted successfully'
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'API key not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete API key',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Regenerate API key
     */
    public function regenerate($id)
    {
        try {
            $apiKey = ApiKey::findOrFail($id);
            
            $newKey = 'uptdjb-' . Str::random(32);
            $apiKey->update(['key' => $newKey]);

            return response()->json([
                'success' => true,
                'message' => 'API key regenerated successfully',
                'data' => [
                    'id' => $apiKey->id,
                    'key' => $newKey, // Return full key only on regeneration
                    'name' => $apiKey->name,
                    'is_active' => $apiKey->is_active,
                    'updated_at' => $apiKey->updated_at,
                    'warning' => 'Please save this new API key securely. The old key is now invalid.'
                ]
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'API key not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to regenerate API key',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Validate API key (for testing purposes)
     */
    public function validate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'api_key' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'API key is required',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $apiKey = ApiKey::where('key', $request->api_key)
                ->where('is_active', true)
                ->first();

            if (!$apiKey) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid or inactive API key',
                    'valid' => false
                ], 401);
            }

            return response()->json([
                'success' => true,
                'message' => 'API key is valid',
                'valid' => true,
                'data' => [
                    'key_name' => $apiKey->name,
                    'created_at' => $apiKey->created_at
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to validate API key',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get API usage statistics
     */
    public function getUsageStats($id)
    {
        try {
            $apiKey = ApiKey::findOrFail($id);

            // Here you can implement usage tracking if needed
            // For now, return basic info
            return response()->json([
                'success' => true,
                'message' => 'API key usage statistics',
                'data' => [
                    'api_key_id' => $apiKey->id,
                    'api_key_name' => $apiKey->name,
                    'is_active' => $apiKey->is_active,
                    'created_at' => $apiKey->created_at,
                    'last_used' => null, // Implement if you track usage
                    'total_requests' => 0, // Implement if you track usage
                    'note' => 'Usage tracking can be implemented if needed'
                ]
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'API key not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve usage statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
