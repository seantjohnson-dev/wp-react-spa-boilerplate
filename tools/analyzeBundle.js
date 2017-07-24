import webpack from 'webpack';
import {BundleAnalyzerPlugin} from 'webpack-bundle-analyzer';
const config = (process.env.NODE_ENV === 'production') ? require('../webpack.config.prod') : require('../webpack.config.dev');

config.plugins.push(new BundleAnalyzerPlugin());

const compiler = webpack(config);

compiler.run((error, stats) => {
  if (error) {
    throw new Error(error);
  }

  console.log(stats); // eslint-disable-line no-console
});
