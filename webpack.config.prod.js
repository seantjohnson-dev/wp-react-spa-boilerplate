const webpack = require('webpack');
const path = require('path');
const config = require('./config');
const WebpackMd5Hash = require('webpack-md5-hash');

const isVerbose = process.argv.includes('--verbose') || process.argv.includes('-v');

const ExtractTextPlugin = require("extract-text-webpack-plugin");

var extractGlobalSASS = new ExtractTextPlugin({
  filename: "[name].global.css",
  allChunks: true
});

var extractSASS = new ExtractTextPlugin({
  filename: "[name].css",
  allChunks: true
});

const webpackConfig = {
  resolve: {
    extensions: ['*', '.js', '.jsx', '.json', '.css']
  },
  devtool: 'source-map',
  entry: {
    main: [
      'babel-polyfill',
      path.join(__dirname, config.dirs.src + '/client/main.js'),
      path.join(__dirname, config.dirs.src + '/styles/main.scss')
    ],
    customizer: [
      'babel-polyfill',
      path.join(__dirname, config.dirs.src + '/client/customizer.js'),
      path.join(__dirname, config.dirs.src + '/styles/customizer.scss')
    ],
    admin: [
      'babel-polyfill',
      path.join(__dirname, config.dirs.src + '/client/admin.js'),
      path.join(__dirname, config.dirs.src + '/styles/admin.scss')
    ]
  },
  target: 'web', // necessary per https://webpack.github.io/docs/testing.html#compile-and-test
  output: {
    path: path.join(__dirname, config.dirs.dest),
    publicPath: `/wp-content/themes/${config.themeName}/`,
    filename: `[name].js`,
    sourceMapFilename: "[file].map"
  },
  plugins: [

    new webpack.DefinePlugin({
      'process.env.NODE_ENV': JSON.stringify('production'),
      __DEV__: false
    }),
    extractGlobalSASS,
    extractSASS,
    new LodashModuleReplacementPlugin(),
    new webpack.optimize.OccurrenceOrderPlugin(),
    new webpack.optimize.UglifyJsPlugin()

  ],
  module: {
    rules: [
      {
        test: /\.json$/,
        loader: 'json-loader'
      },
      {
        test: /\.jsx?$/,
        loader: 'babel-loader',
        exclude: /node_modules/
      },
      {
        test: /\.eot(\?v=\d+.\d+.\d+)?$/,
        loader: 'file-loader'
      },
      {
        test: /\.woff(2)?(\?v=[0-9]\.[0-9]\.[0-9])?$/,
        loader: 'url-loader?limit=10000&mimetype=application/font-woff'
      },
      {
        test: /\.[ot]tf(\?v=\d+.\d+.\d+)?$/,
        loader: 'url-loader?limit=10000&mimetype=application/octet-stream'
      },
      {
        test: /\.svg(\?v=\d+\.\d+\.\d+)?$/,
        loader: 'url-loader?limit=10000&mimetype=image/svg+xml'
      },
      {
        test: /\.(gif|png|jpe?g|svg)$/i,
        exclude: path.join(__dirname, config.dirs.src + "/screenshot.png"),
        loaders: [
          'file-loader?hash=sha512&digest=hex&name=[name]-[hash].[ext]',
          {
            loader: 'image-webpack-loader',
            options: {
              progressive: true,
              bypassOnDebug: true,
              gifsicle: {
                interlaced: false
              },
              mozjpeg: {
                quality: 75,
                progressive: true,
                bypassOnDebug: true
              },
              pngquant:{
                quality: "75-90",
                speed: 4
              },
              svgo:{
                plugins: [
                  {
                    removeViewBox: false
                  },
                  {
                    removeEmptyAttrs: false
                  }
                ]
              }
            }
          }
        ]
      },
      {
        test: /\.ico$/,
        loader: 'file-loader?name=[name].[ext]'
      },
      {
        test: /\.(sass|scss)$/,
        include: path.join(__dirname, config.dirs.src + "/styles/main.scss"),
        use: extractGlobalSASS.extract({
          fallback: 'style-loader?sourceMap',
          use: ['css-loader?sourceMap','postcss-loader?sourceMap', 'sass-loader?sourceMap']
        })
      },
      {
        test: /\.(sass|scss)$/,
        exclude: path.join(__dirname, config.dirs.src + "/styles"),
        use: extractSASS.extract({
          fallback: 'style-loader?sourceMap',
          use: ['css-loader?sourceMap&modules&importLoaders=2&localIdentName=[name]__[local]__[hash:base64:5]','postcss-loader?sourceMap', 'sass-loader?sourceMap']
        })
      }
    ]
  },
  stats: {
    assets: false,
    colors: true,
    reasons: false,
    hash: isVerbose,
    version: isVerbose,
    timings: true,
    chunks: true,
    chunkModules: true,
    cached: isVerbose,
    cachedAssets: isVerbose,
    children: isVerbose
  }
};

module.exports = webpackConfig
