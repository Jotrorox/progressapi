<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Bar API Demo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        .preview {
            margin: 20px 0;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .code {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 4px;
            overflow-x: auto;
        }
        button {
            background: #4caf50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
        }
        button:hover {
            background: #45a049;
        }
    </style>
</head>
<body>
    <h1>Progress Bar API Demo</h1>
    
    <div class="form-group">
        <label for="type">Type:</label>
        <select id="type">
            <option value="default">Default</option>
            <option value="striped">Striped</option>
            <option value="animated">Animated</option>
        </select>
    </div>

    <div class="form-group">
        <label for="progress">Progress (0-100):</label>
        <input type="number" id="progress" value="50" min="0" max="100">
    </div>

    <div class="form-group">
        <label for="color">Color:</label>
        <input type="color" id="color" value="#4caf50">
    </div>

    <div class="form-group">
        <label for="height">Height (px):</label>
        <input type="number" id="height" value="20" min="1">
    </div>

    <div class="form-group">
        <label for="width">Width (px):</label>
        <input type="number" id="width" value="300" min="1">
    </div>

    <button onclick="updateProgressBar()">Generate Progress Bar</button>

    <div class="preview">
        <h3>Preview:</h3>
        <div id="preview-container"></div>
    </div>

    <div class="api-url">
        <h3>API URL:</h3>
        <div class="code" id="api-url"></div>
    </div>

    <script>
        function updateProgressBar() {
            const type = document.getElementById('type').value;
            const progress = document.getElementById('progress').value;
            const color = document.getElementById('color').value;
            const height = document.getElementById('height').value;
            const width = document.getElementById('width').value;

            const apiUrl = `/api/progress-bar.php?type=${type}&progress=${progress}&color=${encodeURIComponent(color)}&height=${height}&width=${width}`;
            
            // Update API URL display
            document.getElementById('api-url').textContent = apiUrl;

            // Fetch and display progress bar
            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('preview-container').innerHTML = data.html;
                })
                .catch(error => console.error('Error:', error));
        }

        // Initial load
        updateProgressBar();
    </script>
</body>
</html>