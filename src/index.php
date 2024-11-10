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
            max-width: 800px;
            margin: 0 auto;
            padding: 16px;
            background-color: var(--bg-color);
            color: var(--text-color);
            line-height: 1.4;
        }

        .container {
            background: white;
            padding: clamp(16px, 3vw, 24px);
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-group {
            margin-bottom: 16px;
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-10px); }
            to { opacity: 1; transform: translateX(0); }
        }

        label {
            display: block;
            margin-bottom: 4px;
            font-weight: 500;
            color: var(--text-color);
            font-size: 0.9rem;
        }

        select, input:not([type="color"]) {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            background: white;
        }

        input[type="color"] {
            width: 100%;
            height: 36px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 2px;
        }

        select:focus, input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .preview {
            margin: 16px 0;
            padding: 16px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
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
            padding: 8px 16px;
            cursor: pointer;
            border-radius: 6px;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        button:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        .tab-container {
            margin-top: 24px;
        }

        .tabs {
            display: flex;
            gap: 6px;
            margin-bottom: 12px;
            flex-wrap: wrap;
        }

        .tab {
            padding: 6px 14px;
            cursor: pointer;
            background: white;
            border: 1px solid #dde1e7;
            border-radius: 6px;
            transition: all 0.2s ease;
            font-size: 0.9rem;
            color: #4b5563;
            font-weight: 500;
        }

        .tab.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
            box-shadow: 0 2px 4px rgba(79, 70, 229, 0.2);
        }

        .tab:hover:not(.active) {
            background: #f8fafc;
            border-color: #c7d2fe;
            color: var(--primary-color);
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
            margin-bottom: 16px;
        }

        h1 {
            font-size: clamp(1.3rem, 3vw, 1.8rem);
        }

        h3 {
            font-size: 1.1rem;
        }

        .code {
            position: relative;
            border-radius: 8px;
            margin: 12px 0;
        }

        .copy-button {
            position: absolute;
            top: 8px;
            right: 8px;
            background: rgba(255, 255, 255, 0.3);
            border: none;
            padding: 4px 8px;
            border-radius: 4px;
            color: white;
            font-size: 0.75rem;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .code:hover .copy-button {
            opacity: 1;
        }

        @media (max-width: 640px) {
            body {
                padding: 8px;
            }

            .container {
                padding: 16px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .tab {
                padding: 6px 12px;
                font-size: 0.85rem;
            }

            .copy-button {
                opacity: 1;
            }
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);  /* 5 columns by default */
            gap: 12px;
            margin-bottom: 16px;
        }

        .form-group {
            margin-bottom: 0;  /* Remove bottom margin since we're using grid gap */
        }

        /* Responsive breakpoints */
        @media (max-width: 900px) {
            .form-grid {
                grid-template-columns: repeat(3, 1fr);  /* 3 columns on medium screens */
            }
        }

        @media (max-width: 640px) {
            .form-grid {
                grid-template-columns: repeat(2, 1fr);  /* 2 columns on smaller screens */
            }
        }

        @media (max-width: 480px) {
            .form-grid {
                grid-template-columns: 1fr;  /* Stack on very small screens */
            }
        }

        /* Alternative table layout */
        .form-table {
            display: table;
            width: 100%;
            border-spacing: 0 12px;
        }

        .form-row {
            display: table-row;
        }

        .form-cell {
            display: table-cell;
            padding-right: 12px;
            vertical-align: top;
        }

        .form-cell:last-child {
            padding-right: 0;
        }

        @media (max-width: 480px) {
            .form-table {
                display: block;
            }
            
            .form-row {
                display: block;
                margin-bottom: 12px;
            }
            
            .form-cell {
                display: block;
                padding-right: 0;
                margin-bottom: 12px;
            }
        }

        /* Make inputs more compact */
        select, input:not([type="color"]) {
            padding: 6px 8px;
        }

        input[type="color"] {
            height: 32px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Progress Bar API Demo</h1>
        
        <div class="form-grid">
            <div class="form-group">
                <label for="type">Type:</label>
                <select id="type">
                    <option value="default">Default</option>
                    <option value="striped">Striped</option>
                    <option value="animated">Animated</option>
                </select>
            </div>

            <div class="form-group">
                <label for="progress">Progress:</label>
                <input type="number" id="progress" value="50" min="0" max="100">
            </div>

            <div class="form-group">
                <label for="color">Color:</label>
                <input type="color" id="color" value="#4caf50">
            </div>

            <div class="form-group">
                <label for="height">Height:</label>
                <input type="number" id="height" value="20" min="1">
            </div>

            <div class="form-group">
                <label for="width">Width:</label>
                <input type="number" id="width" value="300" min="1">
            </div>
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