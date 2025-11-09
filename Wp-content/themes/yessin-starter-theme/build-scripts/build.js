const esbuild = require('esbuild');
esbuild.build({
  entryPoints: ['assets/js/editor-src.js'],
  bundle: true,
  outfile: 'build/editor.js',
  sourcemap: true,
  minify: true,
  target: ['es2017']
}).catch(() => process.exit(1));
