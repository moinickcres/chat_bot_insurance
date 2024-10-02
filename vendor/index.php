
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insurance Chatbot</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .chat-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }
        .chat-box {
            margin-top: 20px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
        }
        .response {
            margin-top: 10px;
            padding: 10px;
            background-color: #f9f9f9;
            border-left: 5px solid #ccc;
        }
        .flag-btn {
            background-color: red;
            color: white;
            padding: 5px;
            border: none;
            cursor: pointer;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <h1>Insurance Chatbot</h1>
        <div class="chat-box">
            <input type="text" id="query" placeholder="Ask me about our insurance services...">
            <button id="sendBtn">Send</button>
        </div>
        <div id="responseContainer"></div>
    </div>

    <script>
        document.getElementById('sendBtn').addEventListener('click', function() {
            const query = document.getElementById('query').value;

            fetch('../api/chatbot.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ query: query })
            })
            .then(response => response.json())
            .then(data => {
                const responseDiv = document.createElement('div');
                responseDiv.classList.add('response');
                console.log(data.sentence);
                responseDiv.innerHTML = `${data.sentence} <br><button class="flag-btn" onclick="flagResponse(${data.id})">Flag as Incorrect</button>`;
                document.getElementById('responseContainer').appendChild(responseDiv);
            });
        });

        function flagResponse(queryId) {

            fetch('../responses/flag.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ query_id: queryId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Response flagged!");
                }
            });
        }
    </script>
</body>
</html>
