const {spawn} = require('child_process');
const cmd = spawn('npx', ['esbuild','assets/js/editor-src.js','--bundle','--outfile=build/editor.js','--sourcemap','--watch'], {stdio:'inherit'});
cmd.on('close', () => process.exit(0));
