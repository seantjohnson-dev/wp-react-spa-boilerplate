// Define prompts for use with npm 'prompt' module in setup script
module.exports = {
  properties: {
    name: {
      description: 'Project Name',
      type: 'string',
      default: 'wp-react-spa-boilerplate',
      pattern: /^[a-zA-Z0-9\-_]+$/,
      message: 'Only letters, numbers, underscores and dashes are allowed.',
      required: true
    },
    title: {
      description: 'Site Title',
      type: 'string',
      default: 'WRSB',
      pattern: /^.+$/,
      message: 'A site title is required.',
      required: true
    },
    description: {
      description: 'Description',
      type: 'string',
      default: 'Theme boilerplate for WordPress using WP REST API and React.js',
      pattern: /^.*$/,
      message: 'A theme description is required.',
      required: false
    },
    version: {
      description: 'Version',
      type: 'string',
      default: '0.1.0',
      pattern: /^[0-9\.]+$/,
      message: 'A theme version is required.',
      required: false
    },
    author: {
      description: 'Author',
      type: 'string',
      default: 'blivesta',
      pattern: /^.*$/,
      message: 'An author name is required.',
      required: false
    },
    authorURI: {
      description: 'Author URI',
      type: 'string',
      default: 'https://blivesta.com',
      pattern: /^.*$/,
      message: 'An author URI is required.',
      required: false
    },
    license: {
      description: 'License',
      type: 'string',
      default: 'GNU General Public License v2 or later',
      pattern: /^.*$/,
      message: 'A license is required.',
      required: false
    },
    licenseURI: {
      description: 'License URI',
      type: 'string',
      default: 'http://www.gnu.org/licenses/gpl-2.0.html',
      pattern: /^.*$/,
      message: 'A license URI is required.',
      required: false
    },
    admin_user: {
      description: 'Admin Username',
      type: 'string',
      default: 'admin',
      pattern: /^[a-zA-Z0-9\-_]+$/,
      message: 'Only letters, numbers, underscores and dashes are allowed.',
      required: true
    },
    admin_pass: {
      description: 'Admin Password',
      type: 'string',
      default: 'admin',
      pattern: /^[.\S]+$/,
      message: 'Password cannot be empty.',
      required: true
    },
    admin_email: {
      description: 'Admin Email',
      type: 'string',
      default: 'vccw@example.com',
      format: 'email',
      required: true
    },
    db_user: {
      description: 'Database Username',
      type: 'string',
      default: 'wordpress',
      pattern: /^[a-zA-Z0-9\-_]+$/,
      message: 'Only letters, numbers, underscores and dashes are allowed.',
      required: true
    },
    db_pass: {
      description: 'Database Password',
      type: 'string',
      default: 'wordpress',
      pattern: /^[.\S]+$/,
      message: 'Password cannot be empty.',
      required: true
    },
    db_prefix: {
      description: 'Database Prefix',
      type: 'string',
      default: 'wp_',
      pattern: /^[a-zA-Z0-9]+_$/,
      message: 'Database prefix is required.',
      required: true
    },
    ip: {
      description: 'IP Address',
      type: 'string',
      default: '192.168.33.168',
      format: 'ip-address',
      required: false
    }
  }
};
