module.exports = function(grunt) {
  require('load-grunt-tasks')(grunt);

  var themeJs = [
    'assets/js/popper.js',
    'assets/js/bootstrap.min.js',
    'assets/js/theme.js',
  ];

  var config = {
    // Load data from package.json
    pkg: grunt.file.readJSON('package.json'),

    concat: {
      themeJs: {
        files: {
          'dist/js/built.js': themeJs
        }
      },
    },
    uglify: {
      options: {
        sourceMap: false
      },
      themeJs: {
        files: {
          'dist/js/built.min.js': 'dist/js/built.js'
        }
      }
    },
    watch: {
      sass: {
        files: 'assets/style/**/*.scss',
        tasks: ['sass:dev'],
        options: {
          livereload: true
        }
      },
    },
    sass: {
      dev: {
        options: {
          lineNumbers: true,
          sourcemap: true,
          sourceComments: "sass",
          outputStyle: 'nested'
        },
        files: {
          'dist/css/built.css': 'assets/style/main.scss',
        }
      },
      dist: {
        options: {
          compressed: true
        },
        files: {
          'dist/css/built.css': 'assets/style/main.scss'
        }
      }
    },
    postcss: {
      options: {
        map: true,
        processors: [
          require('autoprefixer')({safe: true})
        ]
      },
      dist: {
        src: 'dist/css/built.css'
      }
    },
    cssmin: {
      css:{
        src: 'dist/css/built.css',
        dest: 'dist/css/built.min.css'
      }
    }
  };

  // Initialize the configuration.
  grunt.initConfig(config);

  grunt.registerTask("prodbuild", ['sass:dist', 'concat', 'uglify', 'postcss', 'cssmin']);
  grunt.registerTask("devbuild", ['sass:dev', 'concat', 'uglify', 'postcss', 'cssmin']);
  grunt.registerTask("default", ['devbuild']);
};
