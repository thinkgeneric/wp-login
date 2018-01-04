module.exports = function(grunt) {
  grunt.config(['postcss', 'build'], {
    options: {
      map: true,
      processors: [
        require('autoprefixer')({browsers: 'last 2 versions'}), // add vendor prefixing
        require('cssnano')() // minifies the css
      ]
    },
    files: [{
      expand: true,
      cwd: '<%= directories.build %>/css',
      src: ['**/*.css', '!*.min.css'],
      dest: '<%= directories.build %>/css',
      ext: '.min.css'
    }]
  });
  grunt.loadNpmTasks('grunt-postcss');
};