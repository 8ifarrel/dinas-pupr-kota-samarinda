<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ServerTensorFlowService;
use Illuminate\Http\Request;

class TensorFlowTestController extends Controller
{
    /**
     * Test endpoint untuk server-side TensorFlow.js service
     */
    public function testService()
    {
        try {
            $tensorFlowService = new ServerTensorFlowService();
            $status = $tensorFlowService->getStatus();
            
            return response()->json([
                'success' => true,
                'message' => 'TensorFlow.js Service Status',
                'status' => $status,
                'service_ready' => $tensorFlowService->isAvailable()
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error checking TensorFlow.js service',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Test prediction dengan upload gambar
     */
    public function testPrediction(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        try {
            $tensorFlowService = new ServerTensorFlowService();
            
            if (!$tensorFlowService->isAvailable()) {
                return response()->json([
                    'success' => false,
                    'message' => 'TensorFlow.js service is not available',
                    'status' => $tensorFlowService->getStatus()
                ], 503);
            }
            
            $prediction = $tensorFlowService->predict($request->file('image'));
            
            return response()->json([
                'success' => true,
                'message' => 'Prediction completed successfully',
                'prediction' => $prediction
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Prediction failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
