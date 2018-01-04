module.exports = function(grunt) {
  grunt.config(['watch'], {
    files: [
      '<%= directories.scss %>/**/*.scss',
    ],
    tasks: [
      'sass:develop',
      'concat'
    ]
  });
  grunt.loadNpmTasks('grunt-contrib-watch');
};