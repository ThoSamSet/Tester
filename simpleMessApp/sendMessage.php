<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $messageText = isset($_POST['message']) ? trim($_POST['message']) : '';
    $emoji = isset($_POST['emoji']) ? trim($_POST['emoji']) : '😊';

    if ($messageText !== '') {
        $messages = file_exists('messages.json') ? json_decode(file_get_contents('messages.json'), true) : [];
        $newMessage = [
            'text' => $messageText,
            'emoji' => $emoji,
            'time' => date('H:i:s')
        ];

        $messages[] = $newMessage;

        file_put_contents('messages.json', json_encode($messages, JSON_PRETTY_PRINT));

        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Message cannot be empty.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
