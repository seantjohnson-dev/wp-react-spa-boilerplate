const webpack = require('webpack');
const path = require('path');
const config = require('./config');

const isVerbose = process.argv.includes('--verbose') || process.argv.includes('-v');

const ExtractTextPlugin = require("extract-text-webpack-plugin");

var extractGlobalSASS = new ExtractTextPlugin({
  filename: "[name].global.css",
  allChunks: true
});

const webpackConfig = {
  resolve: {
    extensions: ['*', '.js', '.jsx', '.json', '.css']
  },
  devtool: 'source-map',
  entry: {
    main: [
      // must be first entry to properly set public path
      "babel-polyfill",
      'react-hot-loader/patch',
      'webpack-hot-middleware/client?name=main&http://localhost:' + config.port + 'reload=true',
      path.join(__dirname, config.dirs.src + '/client/index.js'), // Defining path seems necessary for this to work consistently on Windows machines.
      path.join(__dirname, config.dirs.src + '/styles/main.scss')
    ],
    customizer: [
      // 'babel-polyfill',
      // 'react-hot-loader/patch',
      'webpack-hot-middleware/client?name=customizer&http://localhost:' + config.port + 'reload=true',
      path.join(__dirname, config.dirs.src + '/client/customizer.js'),
      path.join(__dirname, config.dirs.src + '/styles/customizer.scss')
    ],
    admin: [
      // 'babel-polyfill',
      // 'react-hot-loader/patch',
      'webpack-hot-middleware/client?name=admin&http://localhost:' + config.port + 'reload=true',
      path.join(__dirname, config.dirs.src + '/client/admin.js'),
      path.join(__dirname, config.dirs.src + '/styles/admin.scss')
    ]
  },
  target: 'web', // necessary per https://webpack.github.io/docs/testing.html#compile-and-test
  output: {
    path: path.join(__dirname, config.dirs.dest),
    publicPath: `/wp-content/themes/${config.themeName}/`,
    sourceMapFilename: "[file].map",
    filename: "[name].js"
  },
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
        test: /\.ico$/,
        loader: 'file-loader?name=[name].[ext]'
      },
      {
        test: /\.(gif|png|jpe?g|svg)$/i,
        loaders: [
          'file-loader?hash=sha512&digest=hex&name=[hash].[ext]',
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
        test: /\.(sass|scss)$/,
        include: path.join(__dirname, config.dirs.src + "/styles/main.scss"),
        use: extractGlobalSASS.extract({
          fallback: 'style-loader?sourceMap',
          use: ['css-loader?sourceMap','postcss-loader?sourceMap', 'sass-loader?sourceMap']
        })
      },
      {
        test: /\.(sass|scss)$/,
        include: path.join(__dirname, config.dirs.src + "/styles/customizer.scss"),
        use: extractGlobalSASS.extract({
          fallback: 'style-loader?sourceMap',
          use: ['css-loader?sourceMap','postcss-loader?sourceMap', 'sass-loader?sourceMap']
        })
      },
      {
        test: /\.(sass|scss)$/,
        include: path.join(__dirname, config.dirs.src + "/styles/admin.scss"),
        use: extractGlobalSASS.extract({
          fallback: 'style-loader?sourceMap',
          use: ['css-loader?sourceMap','postcss-loader?sourceMap', 'sass-loader?sourceMap']
        })
      },
      {
        test: /\.(sass|scss)$/,
        exclude: path.join(__dirname, config.dirs.src + "/styles"),
        use: [
          {
            loader: 'style-loader',
            options: {
              sourceMap: true
            }
          },
          {
            loader: 'css-loader',
            options: {
              sourceMap: true,
              modules: true,
              importLoaders: 2,
              localIdentName: '[name]__[local]__[hash:base64:5]'
            }
          },
          {
            loader: 'postcss-loader',
            options: {
              sourceMap: true
            }
          },
          {
            loader: 'sass-loader',
            options: {
              sourceMap: true
            }
          }
        ]
      }
    ]
  },
  plugins: [
    new webpack.DefinePlugin({
      'process.env.NODE_ENV': JSON.stringify('development'),
      __DEV__: true
    }),
    extractGlobalSASS,
    new webpack.HotModuleReplacementPlugin(),
    new webpack.NoEmitOnErrorsPlugin()
  ],
  stats: {
    assets: false,
    colors: true,
    reasons: true,
    hash: isVerbose,
    version: isVerbose,
    timings: true,
    chunks: isVerbose,
    chunkModules: isVerbose,
    cached: isVerbose,
    cachedAssets: isVerbose,
    children: isVerbose
  }
};

module.exports = webpackConfig
