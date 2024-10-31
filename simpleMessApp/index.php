<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Chat App</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <p>Say Hello to World!</p>

    <div class="emoji" id="userEmoji">&#128530</div>

    <input class="question-input-box" type="text" name="name" placeholder="Input text here" id="textInput" maxlength="20">
    <button class="submit-button" id="submitButton">Send</button>
    <div class="output-container" id="outputContainer"></div>

    <script src="app.js"></script>
</body>
</html>
