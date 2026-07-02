const fs = require('fs');
const path = require('path');

const viewsDir = path.join(__dirname, 'resources', 'views');

function walkDir(dir) {
    let results = [];
    const list = fs.readdirSync(dir);
    list.forEach(file => {
        const fullPath = path.join(dir, file);
        const stat = fs.statSync(fullPath);
        if (stat && stat.isDirectory()) {
            results = results.concat(walkDir(fullPath));
        } else if (file.endsWith('.blade.php')) {
            results.push(fullPath);
        }
    });
    return results;
}

const files = walkDir(viewsDir);

files.forEach(file => {
    let content = fs.readFileSync(file, 'utf8');
    let original = content;

    // Direct text replacements
    content = content.replace(/info@lspprofesional\.id/g, 'info@sertify.id');
    content = content.replace(/LSP Profesional/g, 'Sertify');
    content = content.replace(/LSP PRO/g, 'Sertify');
    content = content.replace(/LSPPro/g, 'Sertify');
    content = content.replace(/Tentang LSP/g, 'Tentang Sertify');
    content = content.replace(/Admin LSP/g, 'Admin Sertify');
    content = content.replace(/Gedung LSP/g, 'Gedung Sertify');
    content = content.replace(/LSP kami/g, 'Sertify');
    
    // HTML-based logo replacements
    content = content.replace(/LSP\s*<\s*span[^>]*>Profesional<\s*\/\s*span\s*>/gi, 'Sertify');
    content = content.replace(/LSP\s*<\s*span[^>]*>PRO<\s*\/\s*span\s*>/gi, 'Sertify');

    if (content !== original) {
        fs.writeFileSync(file, content, 'utf8');
        console.log('Updated:', file);
    }
});
