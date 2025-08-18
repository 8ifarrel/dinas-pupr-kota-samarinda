<?php

// Debug script untuk test ServerTensorFlowService
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/bootstrap/app.php';

use App\Services\ServerTensorFlowService;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\File\UploadedFile as SymfonyUploadedFile;

try {
    echo "=== Testing ServerTensorFlowService ===\n";
    
    $service = new ServerTensorFlowService();
    
    // Check status
    echo "Service Status:\n";
    $status = $service->getStatus();
    foreach ($status as $key => $value) {
        echo "  $key: " . ($value ? 'true' : 'false') . "\n";
    }
    
    echo "\nService Available: " . ($service->isAvailable() ? 'YES' : 'NO') . "\n";
    
    // Test dengan gambar dummy dari services
    $testImagePath = __DIR__ . '/services/test-damage.png';
    
    if (file_exists($testImagePath)) {
        echo "\nTesting prediction with test image...\n";
        
        // Create mock UploadedFile
        $uploadedFile = new UploadedFile(
            $testImagePath,
            'test-damage.png',
            'image/png',
            null,
            true
        );
        
        $result = $service->predict($uploadedFile);
        
        echo "Prediction Result:\n";
        foreach ($result as $key => $value) {
            echo "  $key: $value\n";
        }
        
    } else {
        echo "\nTest image not found at: $testImagePath\n";
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
