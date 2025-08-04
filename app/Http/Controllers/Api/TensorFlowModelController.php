<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class TensorFlowModelController extends Controller
{
    /**
     * Provide TensorFlow.js model information for API clients
     */
    public function getModelInfo()
    {
        return response()->json([
            'success' => true,
            'message' => 'TensorFlow.js model information for road damage detection',
            'data' => [
                'model_url' => asset('model/model.json'),
                'model_version' => '1.0.0',
                'input_shape' => [128, 128, 3],
                'input_preprocessing' => [
                    'resize' => '128x128',
                    'normalize' => 'divide by 255',
                    'color_mode' => 'RGB'
                ],
                'outputs' => [
                    'jenis_output' => [
                        'classes' => ['Retak Buaya', 'Lubang-lubang', 'Longsor'],
                        'description' => 'Type of road damage'
                    ],
                    'tingkat_output' => [
                        'classes' => ['Ringan', 'Sedang', 'Berat'],
                        'description' => 'Severity level of damage'
                    ]
                ],
                'usage_example' => [
                    'javascript' => [
                        '// Load model',
                        'const model = await tf.loadLayersModel("' . asset('model/model.json') . '");',
                        '',
                        '// Preprocess image',
                        'const tensor = tf.browser.fromPixels(imageElement)',
                        '  .resizeNearestNeighbor([128, 128])',
                        '  .toFloat()',
                        '  .div(255.0)',
                        '  .expandDims();',
                        '',
                        '// Predict',
                        'const prediction = model.predict(tensor);',
                        'const jenisIndex = prediction[0].argMax(1).dataSync()[0];',
                        'const tingkatIndex = prediction[1].argMax(1).dataSync()[0];',
                        '',
                        '// Get class names',
                        'const jenisClasses = ["Retak Buaya", "Lubang-lubang", "Longsor"];',
                        'const tingkatClasses = ["Ringan", "Sedang", "Berat"];',
                        'const detectedJenis = jenisClasses[jenisIndex];',
                        'const detectedTingkat = tingkatClasses[tingkatIndex];'
                    ]
                ],
                'integration_guide' => [
                    'step_1' => 'Load TensorFlow.js library in your application',
                    'step_2' => 'Fetch model from model_url endpoint',
                    'step_3' => 'Preprocess user uploaded image (resize to 128x128, normalize)',
                    'step_4' => 'Run model prediction to get jenis and tingkat',
                    'step_5' => 'Send prediction results along with form data to API endpoint',
                    'api_endpoint' => route('api.laporan.store')
                ]
            ]
        ]);
    }

    /**
     * Health check for model availability
     */
    public function checkModelHealth()
    {
        $modelPath = public_path('model/model.json');
        $weightsPath = public_path('model/model_weights.bin');
        
        $modelExists = file_exists($modelPath);
        $weightsExist = file_exists($weightsPath);
        
        return response()->json([
            'success' => $modelExists && $weightsExist,
            'message' => $modelExists && $weightsExist 
                ? 'TensorFlow.js model is available and ready'
                : 'TensorFlow.js model files are missing',
            'data' => [
                'model_json_exists' => $modelExists,
                'model_weights_exist' => $weightsExist,
                'model_url' => asset('model/model.json'),
                'last_checked' => now()->toISOString()
            ]
        ], $modelExists && $weightsExist ? 200 : 503);
    }
}
