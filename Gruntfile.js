var fs = require('fs'),
  path = require('path');

module.exports = function(grunt) {
  var configPath = path.resolve('./_grunt/config'),
    taskPath = path.resolve('./_grunt/tasks');

  grunt.config.set('directories', {
    scss: 'assets/scss',
    js: 'assets/js',
    fonts: 'assets/fonts',
    images: 'assets/images',
    build: 'dist/'
  });

  // Load the configuration files
  fs.readdirSync(configPath).forEach(function(fileName) {
    require(path.join(configPath, fileName))(grunt);
  });

  // Load the tasks
  fs.readdirSync(taskPath).forEach(function(fileName) {
    require(path.join(taskPath, fileName))(grunt);
  });
};