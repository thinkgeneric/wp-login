const path = require('path');
const { argv } = require('yargs');

const UglifyJSPlugin = require('uglifyjs-webpack-plugin');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const { default: ImageminPlugin } = require('imagemin-webpack-plugin');
const imageminMozjpeg = require('imagemin-mozjpeg');
const CopyWebpackPlugin = require('copy-webpack-plugin');

const rootPath = process.cwd();
const isProduction = !!((argv.env && argv.env.production) || argv.p);
const config = {
  cacheBusting: '[name].min',
  copy: 'images/**/*',
  paths: {
    root: rootPath,
    assets: path.join(rootPath, 'assets'),
    dist: path.join(rootPath, 'dist'),
  },
  enabled: {
    sourceMaps: !isProduction,
    optimize: isProduction,
    cacheBusting: isProduction,
    watcher: !!argv.watch,
  },
};
const assetsFilenames = (config.enabled.cacheBusting) ? config.cacheBusting : '[name]';

module.exports = {
  entry: {
    app: ['./assets/scss/app.scss'],
  },
  output: {
    filename: `scripts/${assetsFilenames}.js`,
    path: path.resolve(__dirname, 'dist')
  },
  module: {
    rules: [
      {test: /\.js$/, exclude: /node_modules/, loader: "babel-loader"},
      {
        test: /\.css$/,
        include: config.paths.assets,
        use: ExtractTextPlugin.extract({
          fallback: 'style-loader',
          use: [
            {loader: 'cache-loader'},
            {loader: 'css-loader', options: {sourceMap: config.enabled.sourceMaps}},
            {
              loader: 'postcss-loader', options: {
                config: {path: __dirname, ctx: config},
                sourceMap: config.enabled.sourceMaps,
              },
            },
          ],
        }),
      },
      {
        test: /\.scss$/,
        include: config.paths.assets,
        use: ExtractTextPlugin.extract({
          fallback: 'style-loader',
          use: [
            {loader: 'cache-loader'},
            {loader: 'css-loader', options: {sourceMap: config.enabled.sourceMaps}},
            {
              loader: 'postcss-loader', options: {
                config: {path: __dirname, ctx: config},
                sourceMap: config.enabled.sourceMaps,
              },
            },
            {loader: 'resolve-url-loader', options: {sourceMap: config.enabled.sourceMaps}},
            {
              loader: 'sass-loader', options: {
                sourceMap: config.enabled.sourceMaps,
                sourceComments: true,
              },
            },
          ],
        }),
      },
      {
        test: /\.(ttf|otf|eot|woff2?|png|jpe?g|gif|svg|ico)$/,
        include: config.paths.assets,
        loader: 'url-loader',
        options: {
          limit: 4096,
          name: `[path]${assetsFilenames}.[ext]`,
        },
      },
      {
        test: /\.(ttf|otf|eot|woff2?|png|jpe?g|gif|svg|ico)$/,
        include: /node_modules/,
        loader: 'url-loader',
        options: {
          limit: 4096,
          outputPath: 'vendor/',
          name: `[name].[ext]`,
        },
      },
    ]
  },
  plugins: [
    new UglifyJSPlugin({sourceMap: true}),
    new ExtractTextPlugin({
      filename: `styles/${assetsFilenames}.css`,
      allChunks: true,
      disable: (config.enabled.watcher),
    }),
    new ImageminPlugin({
      optipng: { optimizationLevel: 7 },
      gifsicle: { optimizationLevel: 3 },
      pngquant: { quality: '65-90', speed: 4 },
      svgo: {
        plugins: [
          { removeUnknownsAndDefaults: false },
          { cleanupIDs: false },
          { removeViewBox: false },
        ],
      },
      plugins: [imageminMozjpeg({ quality: 75 })],
      disable: (config.enabled.watcher),
    }),
    new CopyWebpackPlugin([
      { from: 'assets/images/', to: 'images/' },
    ]),
  ]
};
