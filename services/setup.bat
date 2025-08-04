@echo off
echo ============================================================
echo Setup Server-side TensorFlow.js Service
echo ============================================================

cd /d "c:\Users\lenov\Herd\uptdjb\services"

echo.
echo Installing Node.js dependencies...
call npm install

echo.
echo ============================================================
echo Testing TensorFlow.js service...
echo ============================================================

rem Test dengan gambar dummy jika ada
if exist "..\public\image\test.jpg" (
    echo Testing with existing test image...
    node predict.js "..\public\image\test.jpg"
) else (
    echo No test image found. Service is ready but needs an image to test.
)

echo.
echo ============================================================
echo Setup completed!
echo ============================================================
echo.
echo Service is ready at: services/predict.js
echo Model path: public/model/model.json
echo.
echo Usage: node predict.js "path/to/image.jpg"
echo.
pause
