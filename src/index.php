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
            background-color: #f8f9fa;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        select, input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .preview {
            margin: 20px 0;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: white;
        }
        .code {
            background: #1e1e1e;
            color: #fff;
            padding: 15px;
            border-radius: 4px;
            overflow-x: auto;
            font-family: 'Courier New', monospace;
        }
        button {
            background: #4caf50;
            color: white;
            border: none;
            padding: 12px 24px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
            transition: background 0.3s;
        }
        button:hover {
            background: #45a049;
        }
        .tab-container {
            margin-top: 20px;
        }
        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }
        .tab {
            padding: 10px 20px;
            cursor: pointer;
            background: #eee;
            border: none;
            border-radius: 4px;
            transition: background 0.3s;
        }
        .tab.active {
            background: #4caf50;
            color: white;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
        h1, h3 {
            color: #2c3e50;
        }
    </style>
</head>
<body>
    <div class="container">
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

        <div class="tab-container">
            <h3>Code Examples:</h3>
            <div class="tabs">
                <button class="tab active" onclick="showTab('js')">JavaScript</button>
                <button class="tab" onclick="showTab('python')">Python</button>
                <button class="tab" onclick="showTab('curl')">cURL</button>
            </div>
            <div id="js" class="tab-content code active"></div>
            <div id="python" class="tab-content code"></div>
            <div id="curl" class="tab-content code"></div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Hide all tabs and remove active class
            document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
            document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
            
            // Show selected tab and add active class
            document.getElementById(tabName).classList.add('active');
            document.querySelector(`.tab[onclick="showTab('${tabName}')"]`).classList.add('active');
            
            updateCodeExamples();
        }

        function updateCodeExamples() {
            const apiUrl = document.getElementById('api-url').textContent;
            
            // JavaScript example
            const jsCode = `fetch('${apiUrl}')
    .then(response => response.json())
    .then(data => {
        document.getElementById('container').innerHTML = data.html;
    })
    .catch(error => console.error('Error:', error));`;
            
            // Python example
            const pythonCode = `import requests

response = requests.get('${apiUrl}')
data = response.json()
progress_bar_html = data['html']`;
            
            // cURL example
            const curlCode = `curl '${apiUrl}'`;
            
            document.getElementById('js').textContent = jsCode;
            document.getElementById('python').textContent = pythonCode;
            document.getElementById('curl').textContent = curlCode;
        }

        function updateProgressBar() {
            const type = document.getElementById('type').value;
            const progress = document.getElementById('progress').value;
            const color = document.getElementById('color').value;
            const height = document.getElementById('height').value;
            const width = document.getElementById('width').value;

            const apiUrl = `/api/progress-bar.php?type=${type}&progress=${progress}&color=${encodeURIComponent(color)}&height=${height}&width=${width}`;
            
            // Update API URL display
            document.getElementById('api-url').textContent = apiUrl;

            // Update code examples
            updateCodeExamples();

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