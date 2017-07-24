/*
 * https://github.com/kriasoft/react-static-boilerplate/blob/master/run.js
 */

const fs = require('fs');
const path = require('path');
const config = require('./config');
const webpack = require('webpack');
const webpackConfig = (process.env.NODE_ENV === 'production') ? require('./webpack.config.prod') : require('./webpack.config.dev');
var cmd=require('node-cmd');

const tasks = new Map();

function run (task) {
  const start = new Date()
  console.log(`Starting '${task}'...`)
  return Promise.resolve().then(() => tasks.get(task)()).then(() => {
    console.log(`Finished '${task}' after ${new Date().getTime() - start.getTime()}ms`)
  }, err => console.error(err.stack))
}

tasks.set('clean', () => require('del')([ config.dirs.dest ], { dot: true }));

tasks.set('copy', (cb) => {
  const copy = require('copy')
  const wpThemeFiles = [
    `${config.dirs.src}/*.{css,php,png,json,lock}`,
    `${config.dirs.src}/inc/**/*.*`,
    `${config.dirs.src}/vendor/**/*.*`
  ]

  copy(wpThemeFiles, config.dirs.dest, cb)
});

tasks.set('bundle', () => {
  return new Promise((resolve, reject) => {
    webpack(webpackConfig).run((err, stats) => {
      if (err) {
        reject(err)
      } else {
        console.log(stats.toString(webpackConfig.stats))
        resolve()
      }
    })
  })
});

tasks.set('devServer', () => {
  return new Promise((resolve, reject) => {
    const browserSync = require('browser-sync').create()
    const bsHtmlInjector = require('bs-html-injector')
    const webpackDevMiddleware = require('webpack-dev-middleware')
    const webpackHotMiddleware = require('webpack-hot-middleware')
    const bundler = webpack(webpackConfig)

    browserSync.use(bsHtmlInjector)

    browserSync.init({
      port: `${config.port}`,
      files: [
        `${config.dirs.dest}/index.php`,
        // `${config.dirs.dest}/main.global.css`,
        // `${config.dirs.dest}/main.css`,
        {
          match: [
            'src/**/*.!(scss|css|js|jsx)'
          ],
          fn: function (event, file) {
            if (file.endsWith('php')) bsHtmlInjector()
          }
        }
      ],
      host: '',
      proxy: {
        target: config.url,
        middleware: [
          webpackDevMiddleware(bundler, {
            publicPath: webpackConfig.output.publicPath,
            noInfo: true
          }),
          webpackHotMiddleware(bundler)
        ]
      }
    })
  })
});

tasks.set('watch', () => {
  const chokidar = require('chokidar')
  const staticFiles = [
    `${config.dirs.src}/*.{css,php,png,json,lock}`,
    `${config.dirs.src}/inc/**/*.*`,
    `${config.dirs.src}/vendor/**/*.*`
  ]
  const staticFilesWatcher = chokidar.watch(staticFiles)

  staticFilesWatcher.on('change', () => {
    run('copy')
  })
});

tasks.set('bootstrapRoutes', () => {
  const cmd=require('node-cmd');

  const scriptPath = path.join(__dirname, 'node_modules/wpapi/lib/data/update-default-routes-json.js');
  const endpoint = 'http://' + config.url + '/wp-json/';
  const output = path.join(__dirname, 'src/client');
  const filename = 'default-routes.json';
  const cmdScript = scriptPath + ' --output=' + output + ' --file=' + filename + ' --endpoint=' + endpoint;

  cmd.run(cmdScript);

});

tasks.set('build', () => {
  return Promise.resolve()
    .then(() => run('clean'))
    .then(() => run('copy'))
    .then(() => run('bootstrapRoutes'))
    .then(() => run('bundle'))
});

tasks.set('start', () => {
  return Promise.resolve()
    .then(() => run('build'))
    .then(() => run('watch'))
    .then(() => run('devServer'))
});

run(/^\w/.test(process.argv[2] || '') ? process.argv[2] : 'start');
