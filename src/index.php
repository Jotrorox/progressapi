<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Bar API Demo</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/themes/prism-tomorrow.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --bg-color: #f9fafb;
            --text-color: #1f2937;
            --border-color: #e5e7eb;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            background-color: var(--bg-color);
            color: var(--text-color);
            line-height: 1.5;
        }

        .container {
            background: white;
            padding: clamp(20px, 5vw, 40px);
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-group {
            margin-bottom: 24px;
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-10px); }
            to { opacity: 1; transform: translateX(0); }
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-color);
            font-size: 0.95rem;
        }

        select, input:not([type="color"]) {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.2s ease;
            background: white;
        }

        input[type="color"] {
            width: 100%;
            height: 40px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 2px;
        }

        select:focus, input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .preview {
            margin: 24px 0;
            padding: 24px;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            background: white;
            transition: all 0.3s ease;
        }

        .preview:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        button {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 24px;
            cursor: pointer;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        button:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        .tab-container {
            margin-top: 32px;
        }

        .tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }

        .tab {
            padding: 10px 20px;
            cursor: pointer;
            background: #f3f4f6;
            border: none;
            border-radius: 8px;
            transition: all 0.2s ease;
            font-size: 0.95rem;
        }

        .tab.active {
            background: var(--primary-color);
            color: white;
        }

        .tab:hover:not(.active) {
            background: #e5e7eb;
        }

        .tab-content {
            display: none;
            opacity: 0;
            transform: translateY(10px);
        }

        .tab-content.active {
            display: block;
            animation: fadeInUp 0.3s ease forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h1, h3 {
            color: var(--text-color);
            margin-bottom: 24px;
        }

        h1 {
            font-size: clamp(1.5rem, 4vw, 2rem);
        }

        .code {
            position: relative;
            border-radius: 8px;
            margin: 16px 0;
        }

        .copy-button {
            position: absolute;
            top: 8px;
            right: 8px;
            background: rgba(255, 255, 255, 0.1);
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            color: white;
            font-size: 0.8rem;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .code:hover .copy-button {
            opacity: 1;
        }

        @media (max-width: 640px) {
            body {
                padding: 12px;
            }

            .container {
                padding: 20px;
            }

            .tabs {
                gap: 6px;
            }

            .tab {
                padding: 8px 16px;
                font-size: 0.9rem;
            }

            .copy-button {
                opacity: 1;
            }
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/components/prism-javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/components/prism-python.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/components/prism-bash.min.js"></script>
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

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                const button = event.target;
                const originalText = button.textContent;
                button.textContent = 'Copied!';
                setTimeout(() => {
                    button.textContent = originalText;
                }, 2000);
            });
        }

        function updateCodeExamples() {
            const apiUrl = document.getElementById('api-url').textContent;
            
            const jsCode = `// Fetch the progress bar
fetch('${apiUrl}')
    .then(response => response.json())
    .then(data => {
        document.getElementById('container').innerHTML = data.html;
    })
    .catch(error => console.error('Error:', error));`;
            
            const pythonCode = `import requests

# Make the API request
response = requests.get('${apiUrl}')
data = response.json()

# Get the progress bar HTML
progress_bar_html = data['html']`;
            
            const curlCode = `curl '${apiUrl}' \\
    -H 'Accept: application/json'`;
            
            // Update code blocks with syntax highlighting
            ['js', 'python', 'curl'].forEach(lang => {
                const element = document.getElementById(lang);
                const code = lang === 'js' ? jsCode : lang === 'python' ? pythonCode : curlCode;
                const language = lang === 'curl' ? 'bash' : lang;
                
                element.innerHTML = `
                    <button class="copy-button" onclick="copyToClipboard(\`${code}\`)">Copy</button>
                    <pre><code class="language-${language}">${code}</code></pre>
                `;
                Prism.highlightElement(element.querySelector('code'));
            });
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

        // Add input event listeners for real-time updates
        document.querySelectorAll('input, select').forEach(input => {
            input.addEventListener('input', updateProgressBar);
        });

        // Initial load
        updateProgressBar();
    </script>
</body>
</html>