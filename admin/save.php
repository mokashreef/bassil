<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dataFile = '../data.json';
    
    // Read the current data to preserve any fields not in the form (if any)
    $currentData = [];
    if (file_exists($dataFile)) {
        $currentData = json_decode(file_get_contents($dataFile), true) ?: [];
    }

    // Update with new data from POST
    foreach ($_POST as $key => $value) {
        $currentData[$key] = $value;
    }

    // Re-index services array to fix any gaps if items were deleted
    if (isset($currentData['services']) && is_array($currentData['services'])) {
        $currentData['services'] = array_values($currentData['services']);
    }

    // Re-index portfolio_images array to fix gaps
    if (isset($currentData['portfolio_images']) && is_array($currentData['portfolio_images'])) {
        $currentData['portfolio_images'] = array_values($currentData['portfolio_images']);
    }

    // Save to file
    $result = file_put_contents($dataFile, json_encode($currentData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

    if ($result !== false) {
        // Redirect back with success message
        echo "<script>alert('تم حفظ التغييرات بنجاح وتحديث الموقع!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('حدث خطأ أثناء حفظ الملف.'); window.history.back();</script>";
    }
} else {
    header("Location: index.php");
}
?>
