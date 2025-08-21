<?php

// Simple test tanpa Laravel facades
$testImagePath = __DIR__ . '/services/test-damage.png';
$nodeScriptPath = __DIR__ . '/services/predict.js';

echo "=== Direct Node.js Test ===\n";
echo "Test image: $testImagePath\n";
echo "Script path: $nodeScriptPath\n";

if (!file_exists($testImagePath)) {
    echo "ERROR: Test image not found!\n";
    exit(1);
}

if (!file_exists($nodeScriptPath)) {
    echo "ERROR: Node script not found!\n";
    exit(1);
}

// Test Node.js availability
exec('node --version 2>&1', $nodeOutput, $nodeReturnCode);
echo "Node.js version: " . implode("", $nodeOutput) . "\n";

if ($nodeReturnCode !== 0) {
    echo "ERROR: Node.js not available!\n";
    exit(1);
}

// Execute prediction
$command = sprintf(
    'node %s %s 2>&1',
    escapeshellarg($nodeScriptPath),
    escapeshellarg($testImagePath)
);

echo "\nExecuting: $command\n";
echo "=== Output ===\n";

exec($command, $output, $returnCode);

echo "Return code: $returnCode\n";
echo "Output:\n";
foreach ($output as $line) {
    echo "$line\n";
}

if ($returnCode === 0) {
    echo "\n=== Parsing JSON ===\n";
    $jsonOutput = implode("\n", $output);
    
    // Find JSON part (skip stderr messages)
    $lines = explode("\n", $jsonOutput);
    foreach ($lines as $line) {
        if (trim($line) && $line[0] === '{') {
            $result = json_decode($line, true);
            if ($result) {
                echo "Prediction successful!\n";
                echo "Jenis: " . $result['jenis'] . " (confidence: " . $result['confidence_jenis'] . ")\n";
                echo "Tingkat: " . $result['tingkat'] . " (confidence: " . $result['confidence_tingkat'] . ")\n";
                echo "Method: " . $result['method'] . "\n";
                break;
            }
        }
    }
}
