import WPAPI from 'wpapi'
import {
  WP_API,
  WP_NONCE
} from './constants'

var apiRootJSON = require('./default-routes.json');

const config = {
    endpoint: WP_API,
    routes: apiRootJSON,
    nonce: WP_NONCE
};

const wp = window.wp = new WPAPI(config)

export default wp
