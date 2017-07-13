const config = require('./config')
const path = require('path')
const webpack = require('webpack')
const WriteFilePlugin = require('write-file-webpack-plugin')

const isDebug = !process.argv.includes('--production')
const isVerbose = process.argv.includes('--verbose') || process.argv.includes('-v')

const webpackConfig = {
  debug: isDebug,
  devtool: isDebug ? 'source-map' : false,
  entry: {
    bundle: [
      'babel-polyfill',
      config.dirs.src + '/client/index.js'
    ]
  },
  output: {
    path: path.join(__dirname, config.dirs.dest),
    publicPath: `/wp-content/themes/${config.themeName}/`,
    filename: "[name].js",
    sourceMapFileName:"[file].map"
  },
  module: {
    preLoaders: [
      {
        test: /\.js$/,
        loader: 'standard',
        exclude: /node_modules/
      }
    ],
    loaders: [
      {
        test: /\.jsx?$/,
        loader: 'babel',
        exclude: /node_modules/
      },
      {
        test: /\.json$/,
        loader: 'json-loader'
      }
    ]
  },
  resolve: {
    extensions: [
      '',
      '.js',
      '.jsx',
      '.css'
    ],
    root: [
      path.join(__dirname, `${config.dirs.src}/client`)
    ]
  },
  stats: {
    colors: true,
    reasons: isDebug,
    hash: isVerbose,
    version: isVerbose,
    timings: true,
    chunks: isVerbose,
    chunkModules: isVerbose,
    cached: isVerbose,
    cachedAssets: isVerbose
  },
  plugins: [
    new webpack.DefinePlugin({
      'process.env.NODE_ENV': isDebug ? '"development"' : '"production"'
    })
  ]
}

if (isDebug) {
  webpackConfig.entry.bundle.unshift('react-hot-loader/patch', `webpack-hot-middleware/client?http://localhost:${config.port}&reload=true`)
  webpackConfig.plugins.push(new webpack.optimize.OccurenceOrderPlugin())
  webpackConfig.plugins.push(new webpack.HotModuleReplacementPlugin())
  webpackConfig.plugins.push(new webpack.NoErrorsPlugin())
  webpackConfig.plugins.push(new WriteFilePlugin())
} else {
  webpackConfig.plugins.push(new webpack.optimize.DedupePlugin())
  webpackConfig.plugins.push(new webpack.optimize.UglifyJsPlugin({ compress: { warnings: isVerbose } }))
  webpackConfig.plugins.push(new webpack.optimize.AggressiveMergingPlugin())
}

module.exports = webpackConfig
