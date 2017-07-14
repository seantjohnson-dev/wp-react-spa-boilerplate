const webpack = require('webpack');
const path = require('path');
const config = require('./config');
const WebpackMd5Hash = require('webpack-md5-hash');

const isDebug = !process.argv.includes('--production');
const isVerbose = process.argv.includes('--verbose') || process.argv.includes('-v');

const ExtractTextPlugin = require("extract-text-webpack-plugin");

var extractSASS = new ExtractTextPlugin({
  filename: "[name].css",
  allChunks: true
});

const webpackConfig = {
  resolve: {
    extensions: ['*', '.js', '.jsx', '.json', '.css']
  },
  devtool: isDebug ? 'source-map' : false,
  entry: {
    bundle: [
      // must be first entry to properly set public path
      "babel-polyfill",
      'react-hot-loader/patch',
      'webpack-hot-middleware/client?http://localhost:' + config.port + 'reload=true',
      path.resolve(__dirname, 'src/client/index.js'), // Defining path seems necessary for this to work consistently on Windows machines.
      path.resolve(__dirname, 'src/client/styles/global.scss')
    ]
  },
  target: 'web', // necessary per https://webpack.github.io/docs/testing.html#compile-and-test
  output: {
    path: path.join(__dirname, config.dirs.dest),
    publicPath: `/wp-content/themes/${config.themeName}/`,
    filename: "[name].js",
    sourceMapFilename:"[file].map"
  },
  plugins: [
    new webpack.DefinePlugin({
      'process.env.NODE_ENV': isDebug ? '"development"' : '"production"',
      __DEV__: isDebug
    }),
    new webpack.HotModuleReplacementPlugin(),
    new webpack.NoEmitOnErrorsPlugin(),
    // extractSASS
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
        test: /\.ico$/,
        loader: 'file-loader?name=[name].[ext]'
      },
      {
        test: /(\.css|\.scss|\.sass)$/,
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
      // {
      //   test: /(\.css|\.scss|\.sass)$/,
      //   use: extractSASS.extract({
      //     fallback: 'style-loader?sourceMap',
      //     use: ['css-loader?sourceMap&modules&importLoaders=2&localIdentName=[name]__[local]__[hash:base64:5]','postcss-loader?sourceMap', 'sass-loader?sourceMap']
      //   })
      // }
    ]
  },
  stats: {
    assets: false,
    colors: true,
    reasons: isDebug,
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

if (isDebug) {

  webpackConfig.stats = {
    assets: false,
    colors: true,
    reasons: isDebug,
    hash: isVerbose,
    version: isVerbose,
    timings: true,
    chunks: isVerbose,
    chunkModules: isVerbose,
    cached: isVerbose,
    cachedAssets: isVerbose,
    children: isVerbose
  };

  // webpackConfig.plugins.push(new webpack.HotModuleReplacementPlugin());
  // webpackConfig.plugins.push(new webpack.NoEmitOnErrorsPlugin());

  // webpackConfig.module.rules.push({
  //   test: /(\.css|\.scss|\.sass)$/,
  //   use: [
  //     {
  //       loader: 'style-loader',
  //       options: {
  //         sourceMap: true
  //       }
  //     },
  //     {
  //       loader: 'css-loader',
  //       options: {
  //         sourceMap: true,
  //         modules: true,
  //         importLoaders: 2,
  //         localIdentName: '[name]__[local]__[hash:base64:5]'
  //       }
  //     },
  //     {
  //       loader: 'postcss-loader',
  //       options: {
  //         sourceMap: true
  //       }
  //     },
  //     {
  //       loader: 'sass-loader',
  //       options: {
  //         sourceMap: true
  //       }
  //     }
  //   ]
  // });
} else {

  // webpackConfig.stats = {
  //   assets: false,
  //   colors: true,
  //   reasons: isDebug,
  //   hash: isVerbose,
  //   version: isVerbose,
  //   timings: true,
  //   chunks: true,
  //   chunkModules: true,
  //   cached: isVerbose,
  //   cachedAssets: isVerbose,
  //   children: isVerbose
  // };

  // webpackConfig.module.rules.push({
  //   test: /(\.css|\.scss|\.sass)$/,
  //   use: extractSASS.extract({
  //     fallback: 'style-loader?sourceMap',
  //     use: ['css-loader?sourceMap&modules&importLoaders=2&localIdentName=[name]__[local]__[hash:base64:5]','postcss-loader?sourceMap', 'sass-loader?sourceMap']
  //   })
  // });

  // webpackConfig.plugins.push(new WebpackMd5Hash());
  // webpackConfig.plugins.push(new webpack.optimize.UglifyJsPlugin({ compress: { warnings: isVerbose } }));
  // webpackConfig.plugins.push(extractSASS);
}

module.exports = webpackConfig
