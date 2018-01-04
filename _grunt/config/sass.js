module.exports = function(grunt) {
  grunt.config(['sass', 'build'], {
    files: [{
      expand: true,
      cwd: '<%= directories.scss %>',
      src: ['*.scss'],
      dest: '<%= directories.build %>/css',
      ext: '.css'
    }]
  });

  grunt.config(['sass', 'develop'], {
    files: [{
      expand: true,
      cwd: '<%= directories.scss %>',
      src: ['*.scss'],
      dest: '<%= directories.build %>/css',
      ext: '.css'
    }]
  });
  grunt.loadNpmTasks('grunt-contrib-sass');
};