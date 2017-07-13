const fs = require('fs');
const prompt = require('prompt');
const optimist = require('optimist');
const config = require('../../config');
const replace = require("replace");
var chalk = require('chalk');

var chalkSuccess = chalk.green;
var chalkProcessing = chalk.blue;
var chalkWarn = chalk.red;

function updateConfig(responses) {

  console.log(chalkProcessing('Updating config settings:'));

  responses.forEach(res => {
    // update package.json with the user's values
    replace({
      regex: `("${res.key}"): "(.*?)"`,
      replacement: `$1: "${res.value}"`,
      paths: ['package.json'],
      recursive: false,
      silent: true
    });

    // update style.css with the user's values
    if (res.styleKey) {
      replace({
        regex: `(${res.styleKey}): (.*)`,
        replacement: `$1: ${res.value}`,
        paths: ['src/style.css'],
        recursive: false,
        silent: true
      });
    }


    if (res.key == 'name') {
      // update site.yml with the user's values

      // replace({
      //   regex: `(wp_siteurl): (.*)`,
      //   replacement: `$1: 'http://${res.value}.dev'`,
      //   paths: ['site.yml'],
      //   recursive: false,
      //   silent: true
      // });

      // replace({
      //   regex: `(wp_home): (.*)`,
      //   replacement: `$1: 'http://${res.value}.dev'`,
      //   paths: ['site.yml'],
      //   recursive: false,
      //   silent: true
      // });

      replace({
        regex: `(db_name): (.*)`,
        replacement: `$1: ${res.value.replace('-', '_').toLowerCase()}`,
        paths: ['site.yml'],
        recursive: false,
        silent: true
      });

    } else if (res.key == 'description') {
      replace({
        regex: `(${res.key}): (.*)`,
        replacement: `$1: '${res.value}'`,
        paths: ['site.yml'],
        recursive: false,
        silent: true
      });
    } else if (res.key != 'version') {
      replace({
        regex: `(${res.key}): (.*)`,
        replacement: `$1: ${res.value}`,
        paths: ['site.yml'],
        recursive: false,
        silent: true
      });
    }

  });

  // remove create script from package.json
  // replace({
  //   regex: /\s*"create":.*,/,
  //   replacement: "",
  //   paths: ['package.json'],
  //   recursive: false,
  //   silent: true
  // });

  // remove all create scripts from the 'tools' folder
  // rimraf('./tools/create', error => {
  //   if (error) throw new Error(error);
  // });

}

const schema = require('./createPrompts');

prompt.override = optimist.argv;

prompt.start();

prompt.get(schema, function (err, result) {

  const responses = [
    {
      key: 'name',
      styleKey: 'Theme Name',
      value: result.name
    },
    {
      key: 'text_domain',
      styleKey: 'Text Domain',
      value: result.name
    },
    {
      key: 'hostname',
      value: result.name + '.dev'
    },
    {
      key: 'ip',
      value: result.ip
    },
    {
      key: 'title',
      value: result.title
    },
    {
      key: 'theme_uri',
      styleKey: 'Theme URI',
      value: 'http://' + result.name + '.dev'
    },
    {
      key: 'version',
      styleKey: 'Version',
      value: result.version
    },
    {
      key: 'admin_user',
      value: result.admin_user
    },
    {
      key: 'admin_pass',
      value: result.admin_pass
    },
    {
      key: 'admin_email',
      value: result.admin_email
    },
    {
      key: 'author',
      styleKey: 'Author',
      value: result.author
    },
    {
      key: 'authorURI',
      styleKey: 'Author URI',
      value: result.authorURI
    },
    {
      key: 'license',
      styleKey: 'License',
      value: result.license
    },
    {
      key: 'licenseURI',
      styleKey: 'License URI',
      value: result.licenseURI
    },
    {
      key: 'description',
      styleKey: 'Description',
      value: result.description
    }
  ];

  //Update package.json, site.yml, and style.css files with prompt data
  updateConfig(responses);

  //Write provision post script that activates this theme after setup
  fs.writeFileSync('provision-post.sh', '#!/usr/bin/env bash\n\nsudo -u vagrant -- wp theme activate ' + result.name);

  //Success Message
  console.log(chalkSuccess('\nSetup complete! Run \'yarn setup\' to complete setup.\n'));
});
