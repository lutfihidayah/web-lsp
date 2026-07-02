const fs = require('fs');
const path = require('path');

function walk(dir, callback) {
    fs.readdirSync(dir).forEach(f => {
        let dirPath = path.join(dir, f);
        let isDirectory = fs.statSync(dirPath).isDirectory();
        isDirectory ? walk(dirPath, callback) : callback(path.join(dir, f));
    });
}

walk('C:/laragon/www/web-lsp/resources/views', function(filePath) {
    if (filePath.endsWith('.blade.php') && !filePath.includes('layouts') && !filePath.includes('welcome.blade.php')) {
        let content = fs.readFileSync(filePath, 'utf8');
        let originalContent = content;

        // Replace flex headers
        content = content.replace(/class="flex items-center justify-between mb-6"/g, 'class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6"');
        content = content.replace(/class="flex items-center justify-between mb-4"/g, 'class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-4"');
        
        // Enhance existing wrappers
        content = content.replace(/class="overflow-x-auto"/g, 'class="overflow-x-auto w-full"');
        
        // Ensure tables have a min-width so they scroll instead of squishing
        content = content.replace(/<table class="([^"]+)"/g, function(match, classes) {
            if (!classes.includes('min-w-')) {
                return `<table class="${classes} min-w-[800px]"`;
            }
            return match;
        });
        
        // Update the action buttons div to wrap on small screens
        content = content.replace(/class="flex items-center gap-2 no-print"/g, 'class="flex flex-wrap items-center gap-2 no-print w-full sm:w-auto mt-2 sm:mt-0"');
        
        if (content !== originalContent) {
            fs.writeFileSync(filePath, content, 'utf8');
            console.log('Updated: ' + filePath);
        }
    }
});
