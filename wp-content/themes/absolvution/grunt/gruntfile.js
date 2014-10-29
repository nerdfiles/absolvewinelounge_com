module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({

    // Metadata.
    pkg: grunt.file.readJSON('package.json'),
    secret: grunt.file.readJSON('secret.json'),

    banner: '/*! <%= pkg.name %> - v<%= pkg.version %> - ' +
      '<%= grunt.template.today("yyyy-mm-dd") %>\n' +
      '<%= pkg.homepage ? "* " + pkg.homepage + "\\n" : "" %>' +
      '* Copyright (c) <%= grunt.template.today("yyyy") %> <%= pkg.author.name %>;' +
      ' Licensed <%= _.pluck(pkg.licenses, "type").join(", ") %> */\n',
    // Task configuration.

    // compile your sass
		sass: {
			dev: {
				options: {
					style: 'expanded'
				},
				src: ['../scss/style.scss'],
				dest: '../style.css'
			},
			prod: {
				options: {
					style: 'compressed'
				},
				src: ['../scss/style.scss'],
				dest: '../style.css'
			},
			editorstyles: {
				options: {
					style: 'expanded'
				},
				src: ['../scss/wp-editor-style.scss'],
				dest: '../css/wp-editor-style.css'
			}
		},

    coffee: {
      src: {
        options: {
          sourceMap: false
        },
        files: {
          './app/config.js': './app/config.coffee', // 1:1 compile
          './app/main.js': './app/main.coffee' // 1:1 compile
          //'path/to/another.js': ['path/to/sources/*.coffee', 'path/to/more/*.coffee'] // concat then compile into single file
        }
      }
    },

    concat: {
      options: {
        banner: '<%= banner %>',
        stripBanners: true
      },
      dist: {
        src: [
          //'../js/scripts.js',
          // @TODO (AMD == true) ?
          //'bower_components/requirejs/require.js',
          'bower_components/jquery/dist/jquery.min.js',
          'bower_components/jquery-waypoints/waypoints.min.js',
          'app/main.js'
        ],
        dest: 'dist/require.js'
      },
    },

		// concat and minify our JS
		uglify: {
      options: {
        banner: '<%= banner %>'
      },
			dist: {
				files: {
          'dist/require.min.js': [
            '<%= concat.dist.dest %>'
          ]
				}
			}
    },
    qunit: {
      files: ['test/**/*.html']
    },
		// chech our JS
		jshint: {
      /*
			 *all: [
			 *  'gruntfile.js',
			 *  '../js/script.js'
			 *],
       */
      gruntfile: {
        options: {
          jshintrc: '.jshintrc'
        },
        src: 'gruntfile.js'
      },
      app: {
        options: {
          jshintrc: 'app/.jshintrc'
        },
        src: [
          'app/**/*.js'
        ]
      },
      test: {
        options: {
          jshintrc: 'test/.jshintrc'
        },
        src: ['test/**/*.js']
      },
    },
		// watch for changes
		watch: {
			scss: {
				files: ['../scss/**/*.scss'],
				tasks: [
					'sass:dev',
					'sass:editorstyles',
					'notify:scss'
				],
        options: {
          livereload: true,
        }
			},
      gruntfile: {
        files: '<%= jshint.gruntfile.src %>',
        tasks: ['jshint:gruntfile', 'notify:js']
      },
      app: {
        files: 'app/**/*.coffee',
        tasks: [
          'coffee',
          'jshint:app',
          //'qunit',
          'notify:js'
        ],
        options: {
          livereload: true,
        }
      },
      js: {
        files: [
          '<%= jshint.gruntfile.src %>',
          '<%= jshint.app.src %>'
        ],
        tasks: [
          'jshint',
          'concat',
          'uglify',
          'notify:js'
        ]
      },
      test: {
        files: '<%= jshint.test.src %>',
        tasks: [
          'coffee',
          'jshint:test',
          //'qunit',
          'notify:js'
        ]
      },
    },

    requirejs: {
      compile: {
        options: {
          name: 'config',
          mainConfigFile: 'app/config.js',
          out: '<%= concat.dist.dest %>',
          optimize: 'none'
        }
      }
    },

    sshexec: {
      test: {
        command: 'uname && pwd && cd /home2/mccabe56/www/wp && git pull -uf origin master',
        options: {
          showProgress: true,
          host: '<%= secret.host %>',
          username: '<%= secret.username %>',
          password: '<%= secret.password %>',
          port: 2222
        }
      }
    },

		// check your php
		phpcs: {
			application: {
				dir: '../*.php'
			},
			options: {
				bin: '/usr/bin/phpcs'
			}
		},

		// notify cross-OS
		notify: {
			scss: {
				options: {
					title: 'Grunt, grunt!',
					message: 'SCSS is all gravy'
				}
			},
			js: {
				options: {
					title: 'Grunt, grunt!',
					message: 'JS is all good'
				}
			},
			dist: {
				options: {
					title: 'Grunt, grunt!',
					message: 'Theme ready for production'
				}
			}
		},

		clean: {
      files: ['dist'],
			dist: {
				src: ['../dist'],
				options: {
					force: true
				}
			}
		},

		copyto: {
			dist: {
				files: [
					{cwd: '../', src: ['**/*'], dest: '../dist/'}
				],
				options: {
					ignore: [
						'../dist{,/**/*}',
						'../doc{,/**/*}',
						'../grunt{,/**/*}',
						'../scss{,/**/*}'
					]
				}
			}
		}

/*
 *    connect: {
 *      development: {
 *        options: {
 *          keepalive: true,
 *        }
 *      },
 *      production: {
 *        options: {
 *          keepalive: true,
 *          port: 8000,
 *          middleware: function(connect, options) {
 *            return [
 *              // rewrite requirejs to the compiled version
 *              function(req, res, next) {
 *                if (req.url === '/bower_components/requirejs/require.js') {
 *                  req.url = '/dist/require.min.js';
 *                }
 *                next();
 *              },
 *              connect.static(options.base),
 *
 *            ];
 *          }
 *        }
 *      }
 *    }
 */

  });

  // These plugins provide necessary tasks.
  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-contrib-coffee');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-qunit');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-requirejs');
  grunt.loadNpmTasks('grunt-contrib-connect');
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-notify');

  // Load NPM's via matchdep
  require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);

  // Development Suite
  grunt.registerTask('default', [
    'coffee',
    'jshint',
    //'qunit',
    'clean',
    'requirejs',
    'concat',
    'uglify',
    'sass:dev',
    'sass:editorstyles',
    'sshexec'
  ]);

  // Production Suite
  grunt.registerTask('dist', function() {
    grunt.task.run([
      'coffee',
      'jshint',
      'uglify',
      'sass:prod',
      'sass:editorstyles',
      'clean:dist',
      'copyto:dist',
      'notify:dist'
    ]);
  });

  // Review Suite
  /*
   *grunt.registerTask('preview', ['connect:development']);
   *grunt.registerTask('preview-live', ['default', 'connect:production']);
   */

};

