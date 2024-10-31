<?php
// Đường dẫn đến file JSON
$file = 'messages.json';

// Đọc dữ liệu hiện có trong file JSON (nếu có)
$messages = [];
if (file_exists($file)) {
    $messages = json_decode(file_get_contents($file), true);
}

// Kiểm tra xem yêu cầu POST có chứa 'message' không
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    // Lấy nội dung tin nhắn từ POST và lọc dữ liệu để tránh mã độc
    $message = htmlspecialchars($_POST['message']);
    
    // Thêm tin nhắn mới vào danh sách
    $messages[] = [
        'text' => $message,
        'time' => date("H:i:s")  // Thêm thời gian gửi tin nhắn
    ];

    // Ghi lại dữ liệu vào file JSON
    file_put_contents($file, json_encode($messages));
    
    // Trả về phản hồi thành công
    echo json_encode(['status' => 'success']);
} else {
    // Trả về lỗi nếu không có tin nhắn nào được gửi
    echo json_encode(['status' => 'error', 'message' => 'No message provided']);
}
?>
