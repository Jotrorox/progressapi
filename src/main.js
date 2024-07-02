const express = require('express');
const app = express();

app.get('/', (req, res) => {
    const percentage = parseInt(req.query.percentage || '0', 10);
    const height = parseInt(req.query.height || '20', 10);
    const width = parseInt(req.query.width || '200', 10);
    const fillColor = req.query.fillColor || '#00FF00';
    const emptyColor = req.query.emptyColor || '#CCCCCC';
    
    if (isNaN(percentage) || percentage < 0 || percentage > 100) {
        res.status(400).send('Invalid percentage value');
        return;
    }
    
    const svg = generateProgressBarSVG(percentage, height, width, fillColor, emptyColor);
    
    res.setHeader('Content-Type', 'image/svg+xml');
    res.send(svg);
});

function generateProgressBarSVG(percentage, height, width, fillColor, emptyColor) {
    let svg = `<svg xmlns="http://www.w3.org/2000/svg" width="${width}" height="${height}">
                 <rect x="0" y="0" width="${width}" height="${height}" fill="${emptyColor}" />
                 <rect x="0" y="0" width="${percentage * width / 100}" height="${height}" fill="${fillColor}" />
               </svg>`;
    
    return svg;
}

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Server running at http://localhost:${PORT}/`);
});
