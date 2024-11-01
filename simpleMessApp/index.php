<!--
Copyright © 2024 Phan Xuan Dung. All rights reserved.
-->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Say Hello App</title>
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <style>
        /* Global styling */
        html, body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Container for chat app */
        .chat-container {
            width: 100%;
            max-width: 400px;
            display: flex;
            flex-direction: column;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Chat output container */
        .output-container {
            flex-grow: 1;
            padding: 10px;
            overflow-y: auto;
            display: flex;
            flex-direction: column; /* Tin nhắn xếp theo cột bình thường */
            max-height: 70vh;
        }

        /* Chat message styling */
        .output {
            display: flex;
            align-items: center;
            margin: 5px 0;
            opacity: 0;
            animation: fadeIn 0.5s forwards;
            background-color: randomColor(); /* Màu nền ngẫu nhiên */
            padding: 8px 12px;
            border-radius: 15px;
            color: white;
            max-width: 70%; /* Để tránh tin nhắn quá dài */
        }

        .emoji {
            font-size: 24px;
            margin-right: 8px;
        }

        /* Input area styling */
        .input-area {
            display: flex;
            align-items: center;
            padding: 10px;
            background-color: #f0f0f0;
            border-top: 1px solid #ddd;
        }

        #emojiSelector {
            font-size: 1.2rem;
            margin-right: 10px;
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .question-input-box {
            flex-grow: 1;
            padding: 10px;
            border-radius: 20px;
            border: 1px solid #ddd;
            font-size: 0.95rem;
        }

        .submit-button {
            background-color: #2196f3;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 10px 15px;
            margin-left: 10px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .submit-button:hover {
            background-color: #1976d2;
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    <script>
        // Hàm tạo màu sắc ngẫu nhiên
        function randomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
    </script>
</head>
<body>
    <div class="chat-container">
        <div class="output-container" id="outputContainer">
            <?php
            if (file_exists('messages.json')) {
                $messages = json_decode(file_get_contents('messages.json'), true);
                foreach ($messages as $message) {
                    echo '<div class="output" style="background-color: ' . sprintf('#%06X', mt_rand(0, 0xFFFFFF)) . ';">';
                    $emoji = isset($message['emoji']) ? htmlspecialchars($message['emoji']) : '😊';
                    echo '<span class="emoji">' . $emoji . '</span>';
                    echo '<div>' . htmlspecialchars($message['text']) . ' <small>(' . $message['time'] . ')</small></div>';
                    echo '</div>';
                }
            }
            ?>
        </div>

        <!-- Input area for emoji, text, and send button -->
        <div class="input-area">
            <select id="emojiSelector">
                <option value="😊">😊</option>
                <option value="😎">😎</option>
                <option value="😇">😇</option>
                <option value="😂">😂</option>
            </select>
            <input class="question-input-box" type="text" id="textInput" placeholder="Type your message" maxlength="20">
            <button class="submit-button" id="submitButton">Send</button>
        </div>
    </div>

    <script>
        const textInput = document.getElementById('textInput');
        const outputContainer = document.getElementById('outputContainer');
        const submitButton = document.getElementById('submitButton');
        const emojiSelector = document.getElementById('emojiSelector');

        submitButton.addEventListener('click', function() {
            if (textInput.value.trim() !== "") {
                const formData = new FormData();
                formData.append('message', textInput.value);
                formData.append('emoji', emojiSelector.value);

                fetch('sendMessage.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const newOutput = document.createElement('div');
                        newOutput.classList.add('output');
                        newOutput.style.backgroundColor = randomColor(); // Đặt màu sắc ngẫu nhiên cho tin nhắn mới

                        const emojiElement = document.createElement('span');
                        emojiElement.classList.add('emoji');
                        emojiElement.innerText = emojiSelector.value;

                        const textElement = document.createElement('div');
                        textElement.innerText = textInput.value + " (" + new Date().toLocaleTimeString() + ")";

                        newOutput.appendChild(emojiElement);
                        newOutput.appendChild(textElement);
                        outputContainer.appendChild(newOutput); // Thêm tin nhắn vào cuối

                        // Tự động cuộn xuống dưới cùng của khung chat
                        outputContainer.scrollTop = outputContainer.scrollHeight;

                        textInput.value = "";
                        emojiSelector.selectedIndex = 0;
                    } else {
                        alert(data.message);
                    }
                });
            }
        });

    </script>
</body>
</html>
