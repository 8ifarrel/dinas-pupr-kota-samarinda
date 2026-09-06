# Test API laporan dengan TensorFlow.js prediction
$testImagePath = "public/test-road-damage.jpg"
$apiUrl = "https://uptdjb.test/api/laporan/upload"
$apiKey = "test-api-key-12345"

if (!(Test-Path $testImagePath)) {
    Write-Host "ERROR: Test image not found at $testImagePath" -ForegroundColor Red
    exit 1
}

Write-Host "Testing Laporan API with TensorFlow.js prediction..." -ForegroundColor Green
Write-Host "Image: $testImagePath"
Write-Host "URL: $apiUrl"
Write-Host "API Key: $apiKey"
Write-Host ""

try {
    # Create form data untuk laporan
    $formData = @{
        nama_pelapor = "Test User TensorFlow"
        nomor_telepon = "081234567890"
        email_pelapor = "test.tensorflow@example.com"
        alamat_pelapor = "Jl. Test TensorFlow No. 123"
        kecamatan_pelapor_id = "3139"
        kelurahan_pelapor_id = "44461"
        deskripsi_kerusakan = "Kerusakan jalan yang akan dideteksi otomatis menggunakan TensorFlow.js"
        alamat_lengkap_kerusakan = "Jl. Test Road Damage, RT 01/RW 02"
        kecamatan_id = "3139"
        kelurahan_id = "44461" 
        latitude = "-0.4942"
        longitude = "117.1436"
        rating_kepuasan = "5"
        feedback = "Testing server-side TensorFlow.js prediction"
    }
    
    # Create multipart form dengan gambar
    $boundary = [System.Guid]::NewGuid().ToString()
    $bodyLines = @()
    
    # Add form fields
    foreach ($key in $formData.Keys) {
        $bodyLines += "--$boundary"
        $bodyLines += "Content-Disposition: form-data; name=`"$key`""
        $bodyLines += ""
        $bodyLines += $formData[$key]
    }
    
    # Add image file
    $bodyLines += "--$boundary"
    $bodyLines += 'Content-Disposition: form-data; name="foto_kerusakan[]"; filename="test-road-damage.jpg"'
    $bodyLines += 'Content-Type: image/jpeg'
    $bodyLines += ''
    
    $imageBytes = [System.IO.File]::ReadAllBytes($testImagePath)
    $imageString = [System.Text.Encoding]::GetEncoding("iso-8859-1").GetString($imageBytes)
    
    $bodyLines += $imageString
    $bodyLines += "--$boundary--"
    
    $body = [System.Text.Encoding]::GetEncoding("iso-8859-1").GetBytes(($bodyLines -join "`r`n"))
    
    # Setup headers
    $headers = @{
        "X-API-KEY" = $apiKey
    }
    
    # Make request
    Write-Host "Sending request..." -ForegroundColor Yellow
    $response = Invoke-WebRequest -Uri $apiUrl -Method POST -Body $body -ContentType "multipart/form-data; boundary=$boundary" -Headers $headers -TimeoutSec 60
    
    Write-Host "Response Status: $($response.StatusCode)" -ForegroundColor Green
    Write-Host "Response Content:" -ForegroundColor Yellow
    $responseJson = $response.Content | ConvertFrom-Json
    $responseJson | ConvertTo-Json -Depth 10 | Write-Host
    
    # Check prediction result
    if ($responseJson.data.jenis_kerusakan_detected -ne "Tidak Terdeteksi") {
        Write-Host "`n✅ SUCCESS: TensorFlow.js prediction worked!" -ForegroundColor Green
        Write-Host "Detected Jenis: $($responseJson.data.jenis_kerusakan_detected)" -ForegroundColor Cyan
        Write-Host "Detected Tingkat: $($responseJson.data.tingkat_kerusakan_detected)" -ForegroundColor Cyan
        Write-Host "Prediction Source: $($responseJson.data.prediction_source)" -ForegroundColor Cyan
    } else {
        Write-Host "`n❌ FAILED: TensorFlow.js prediction not working" -ForegroundColor Red
        Write-Host "Prediction Source: $($responseJson.data.prediction_source)" -ForegroundColor Red
    }
    
} catch {
    Write-Host "ERROR: $($_.Exception.Message)" -ForegroundColor Red
    if ($_.Exception.Response) {
        Write-Host "Response Status: $($_.Exception.Response.StatusCode)" -ForegroundColor Red
        try {
            $errorContent = $_.Exception.Response.GetResponseStream()
            $reader = New-Object System.IO.StreamReader($errorContent)
            $responseBody = $reader.ReadToEnd()
            Write-Host "Response Content: $responseBody" -ForegroundColor Red
        } catch {
            Write-Host "Could not read error response" -ForegroundColor Red
        }
    }
}
