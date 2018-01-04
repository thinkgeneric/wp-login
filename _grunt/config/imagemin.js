module.exports = function(grunt) {
  grunt.config(['imagemin', 'dynamic'], {
    files: [{
      expand: true,
      cwd: '<%= directories.images %>',
      src: ['**/*.{png,jpg,gif,svg}'],
      dest: '<%= directories.build %>/images'
    }]
  });

  grunt.loadNpmTasks('grunt-contrib-imagemin');
};