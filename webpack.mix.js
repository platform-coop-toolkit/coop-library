const mix = require('laravel-mix');
            require('laravel-mix-purgecss');
            require('laravel-mix-copy-watched');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Sage application. By default, we are compiling the Sass file
 | for your application, as well as bundling up your JS files.
 |
 */

mix.setPublicPath('./dist')
   .browserSync('commons.platform.coop.test');

mix.sass('resources/assets/styles/main.scss', 'styles')
   .purgeCss({
      globs: [
        path.join(__dirname, 'node_modules/@platform-coop-toolkit/pinecone/src/assets/scripts/**/*.js'),
      ],
   });

mix.js('resources/assets/scripts/main.js', 'scripts')
   .js('resources/assets/scripts/customizer.js', 'scripts')
   .extract();

mix.copyWatched('resources/assets/images', 'dist/images')
   .copyWatched('resources/assets/fonts', 'dist/fonts')
   .copyWatched('node_modules/@platform-coop-toolkit/pinecone/src/assets/images', 'dist/images')
   .copyWatched('node_modules/@platform-coop-toolkit/pinecone/src/assets/fonts', 'dist/fonts');

mix.options({
  processCssUrls: false,
});

mix.sourceMaps(false, 'source-map')
   .version();

mix.then(() => {
  const manifest = File.find('./dist/mix-manifest.json');
  const json = JSON.parse(manifest.read());
  Object.keys(json).forEach(key => {
    const hashed = json[key];
    delete json[key];
    json[key.replace(/^\/+/g, '')] = hashed.replace(/^\/+/g, '');
  });
  manifest.write(JSON.stringify(json, null, 2));
});
