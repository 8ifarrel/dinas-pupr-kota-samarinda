<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * PHP wrapper untuk TensorFlow.js ML Service
 * Menggunakan Node.js untuk menjalankan model yang sama dengan frontend
 */
class ServerTensorFlowService
{
    private $nodeScriptPath;
    private $modelPath;

    public function __construct()
    {
        // Use absolute paths untuk kompatibilitas testing
        $basePath = 'C:\\Users\\PC-GK\\Documents\\UPTD Programming\\uptdjb';
        $publicPath = $basePath . '\\public';
        
        // Fallback ke Laravel helpers jika tersedia
        if (function_exists('base_path')) {
            try {
                $basePath = base_path();
                $publicPath = public_path();
            } catch (\Exception $e) {
                // Use absolute paths sebagai fallback
            }
        }
        
        $this->nodeScriptPath = $basePath . '\\services\\predict.js';
        $this->modelPath = $publicPath . '\\model\\model.json';
    }

    /**
     * Predict menggunakan TensorFlow.js di server-side
     * 
     * @param \Illuminate\Http\UploadedFile $imageFile
     * @return array
     */
    public function predict($imageFile)
    {
        try {
            // Validasi model exists
            if (!file_exists($this->modelPath)) {
                throw new \Exception('TensorFlow.js model not found at: ' . $this->modelPath);
            }

            // Save image temporarily
            $tempImagePath = $this->saveTempImage($imageFile);

            // Run Node.js TensorFlow.js prediction
            $result = $this->runNodePrediction($tempImagePath);

            // Cleanup temp file
            if (file_exists($tempImagePath)) {
                unlink($tempImagePath);
            }

            return $result;

        } catch (\Exception $e) {
            // Log ke file Laravel jika tersedia, fallback ke error_log
            if (class_exists('\Illuminate\Support\Facades\Log')) {
                try {
                    Log::error('ServerTensorFlowService prediction failed:', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                } catch (\Exception $logException) {
                    error_log('ServerTensorFlowService prediction failed: ' . $e->getMessage());
                }
            } else {
                error_log('ServerTensorFlowService prediction failed: ' . $e->getMessage());
            }

            // Return fallback result
            return [
                'jenis' => 'Tidak Terdeteksi',
                'tingkat' => 'Tidak Terdeteksi',
                'confidence_jenis' => 0.1,
                'confidence_tingkat' => 0.1,
                'method' => 'server_fallback_error'
            ];
        }
    }

    /**
     * Save uploaded image to temporary location
     */
    private function saveTempImage($imageFile)
    {
        $tempDir = sys_get_temp_dir();
        $tempFileName = 'ml_prediction_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
        $tempPath = $tempDir . DIRECTORY_SEPARATOR . $tempFileName;

        file_put_contents($tempPath, file_get_contents($imageFile->getPathname()));

        return $tempPath;
    }

    /**
     * Execute Node.js TensorFlow.js prediction script
     */
    private function runNodePrediction($imagePath)
    {
        // Build command untuk execute Node.js script dengan path absolut
        $nodePath = 'C:\\Program Files\\nodejs\\node.exe';
        $command = sprintf(
            '"%s" %s %s 2>&1',
            $nodePath,
            escapeshellarg($this->nodeScriptPath),
            escapeshellarg($imagePath)
        );

        // Execute command
        $output = [];
        $returnCode = 0;
        exec($command, $output, $returnCode);

        if ($returnCode !== 0) {
            throw new \Exception('Node.js prediction failed with code: ' . $returnCode . '. Output: ' . implode("\n", $output));
        }

        // Parse JSON output dari Node.js script
        // Script mengirim JSON di stdout, tapi mungkin ada stderr messages juga
        $jsonOutput = '';
        foreach ($output as $line) {
            $trimmedLine = trim($line);
            // Look for line yang dimulai dengan { (JSON)
            if (!empty($trimmedLine) && $trimmedLine[0] === '{') {
                $jsonOutput = $trimmedLine;
                break;
            }
        }
        
        if (empty($jsonOutput)) {
            throw new \Exception('No JSON output found from Node.js script. Full output: ' . implode("\n", $output));
        }
        
        $result = json_decode($jsonOutput, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Invalid JSON response from Node.js: ' . $jsonOutput . '. JSON Error: ' . json_last_error_msg());
        }

        if (!isset($result['jenis']) || !isset($result['tingkat'])) {
            throw new \Exception('Invalid prediction result structure. Got: ' . json_encode($result));
        }

        return $result;
    }

    /**
     * Check if TensorFlow.js service is available
     */
    public function isAvailable()
    {
        try {
            // Check if Node.js is available dengan path absolut
            $nodePath = 'C:\\Program Files\\nodejs\\node.exe';
            $output = [];
            $returnCode = 0;
            exec('"' . $nodePath . '" --version 2>&1', $output, $returnCode);

            if ($returnCode !== 0) {
                return false;
            }

            // Check if model file exists
            return file_exists($this->modelPath);

        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get service status information
     */
    public function getStatus()
    {
        return [
            'node_available' => $this->isNodeAvailable(),
            'model_exists' => file_exists($this->modelPath),
            'script_exists' => file_exists($this->nodeScriptPath),
            'service_ready' => $this->isAvailable()
        ];
    }

    private function isNodeAvailable()
    {
        try {
            $nodePath = 'C:\\Program Files\\nodejs\\node.exe';
            $output = [];
            $returnCode = 0;
            exec('"' . $nodePath . '" --version 2>&1', $output, $returnCode);
            return $returnCode === 0;
        } catch (\Exception $e) {
            return false;
        }
    }
}
