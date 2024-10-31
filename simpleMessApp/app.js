const textInput = document.getElementById('textInput');
const outputContainer = document.getElementById('outputContainer');
const submitButton = document.getElementById('submitButton');
const userEmoji = document.getElementById('userEmoji');

// Danh sách các emoji ngẫu nhiên
const emojis = ["😄", "😃", "😊", "😂", "😍", "😎", "😢", "😉", "😜", "😁"];

userEmoji.innerText = emojis[Math.floor(Math.random() * emojis.length)];

submitButton.addEventListener('click', function() {
    if (textInput.value.trim() !== "") {
        // Tạo dữ liệu gửi đi
        const message = textInput.value;
        
        // Sử dụng AJAX để gửi yêu cầu POST đến sendMessage.php
        fetch('sendMessage.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'message=' + encodeURIComponent(message)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Hiển thị tin nhắn trên giao diện
                const newOutput = document.createElement('div'); 
                newOutput.classList.add('output');

                const randomEmoji = emojis[Math.floor(Math.random() * emojis.length)];

                const emojiElement = document.createElement('span');
                emojiElement.classList.add('emoji');
                emojiElement.innerText = randomEmoji;

                const textElement = document.createElement('div');
                textElement.classList.add('ouputText');
                textElement.innerText = message;

                newOutput.appendChild(emojiElement);
                newOutput.appendChild(textElement);

                outputContainer.appendChild(newOutput);

                // Xóa text trong ô nhập liệu
                textInput.value = "";
                userEmoji.innerText = emojis[Math.floor(Math.random() * emojis.length)];
            } else {
                alert("Error: " + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
});
