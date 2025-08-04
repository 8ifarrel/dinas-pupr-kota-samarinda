# Test TensorFlow.js API endpoint
$testImagePath = "public/test-road-damage.jpg"
$apiUrl = "https://uptdjb.test/api/tensorflow/predict"

if (!(Test-Path $testImagePath)) {
    Write-Host "ERROR: Test image not found at $testImagePath" -ForegroundColor Red
    exit 1
}

Write-Host "Testing TensorFlow.js API endpoint..." -ForegroundColor Green
Write-Host "Image: $testImagePath"
Write-Host "URL: $apiUrl"
Write-Host ""

try {
    # Create multipart form data
    $boundary = [System.Guid]::NewGuid().ToString()
    $bodyLines = @()
    $bodyLines += "--$boundary"
    $bodyLines += 'Content-Disposition: form-data; name="image"; filename="test-road-damage.jpg"'
    $bodyLines += 'Content-Type: image/jpeg'
    $bodyLines += ''
    
    # Read image file
    $imageBytes = [System.IO.File]::ReadAllBytes($testImagePath)
    $imageString = [System.Text.Encoding]::GetEncoding("iso-8859-1").GetString($imageBytes)
    
    $bodyLines += $imageString
    $bodyLines += "--$boundary--"
    
    $body = [System.Text.Encoding]::GetEncoding("iso-8859-1").GetBytes(($bodyLines -join "`r`n"))
    
    # Make request
    $response = Invoke-WebRequest -Uri $apiUrl -Method POST -Body $body -ContentType "multipart/form-data; boundary=$boundary" -TimeoutSec 30
    
    Write-Host "Response Status: $($response.StatusCode)" -ForegroundColor Green
    Write-Host "Response Content:" -ForegroundColor Yellow
    $response.Content | ConvertFrom-Json | ConvertTo-Json -Depth 10 | Write-Host
    
} catch {
    Write-Host "ERROR: $($_.Exception.Message)" -ForegroundColor Red
    if ($_.Exception.Response) {
        Write-Host "Response Status: $($_.Exception.Response.StatusCode)" -ForegroundColor Red
        Write-Host "Response Content: $($_.Exception.Response.Content)" -ForegroundColor Red
    }
}
