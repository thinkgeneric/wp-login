module.exports = function(grunt) {
  grunt.registerTask('build', 'Build the Login assets', function() {
    grunt.task.run([
      'sass:build',
      'postcss',
      'imagemin:dynamic'
    ]);
  });
};