<?php

require_once 'vendor/autoload.php';

use App\Services\ServerTensorFlowService;
use Illuminate\Http\UploadedFile;

echo "=== Testing ServerTensorFlowService ===\n";

try {
    $service = new ServerTensorFlowService();
    
    echo "1. Service availability check:\n";
    $isAvailable = $service->isAvailable();
    echo "   Available: " . ($isAvailable ? "YES" : "NO") . "\n";
    
    echo "\n2. Service status:\n";
    $status = $service->getStatus();
    foreach ($status as $key => $value) {
        echo "   $key: " . ($value ? "YES" : "NO") . "\n";
    }
    
    echo "\n3. Testing prediction with test image:\n";
    $testImagePath = 'public/test-road-damage.jpg';
    
    if (file_exists($testImagePath)) {
        // Create UploadedFile instance for testing
        $uploadedFile = new UploadedFile(
            $testImagePath,
            'test-road-damage.jpg',
            'image/jpeg',
            null,
            true
        );
        
        echo "   Running prediction...\n";
        $result = $service->predict($uploadedFile);
        
        echo "   Prediction Result:\n";
        foreach ($result as $key => $value) {
            if (is_array($value)) {
                echo "     $key: " . json_encode($value) . "\n";
            } else {
                echo "     $key: $value\n";
            }
        }
        
    } else {
        echo "   Test image not found at: $testImagePath\n";
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== Test Complete ===\n";
