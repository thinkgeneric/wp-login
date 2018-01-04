module.exports = function(grunt) {
  grunt.registerTask('develop', 'Build local assets and watch', function () {
    grunt.task.run([
      'sass:develop',
      'watch'
    ]);
  });
};