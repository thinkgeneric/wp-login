<?php

namespace Gearhead\Login;

class LoginPage {

	protected $background_image;
	protected $path;

	public function __construct() {
		$this->path = dirname(dirname(__FILE__));
	}

	public function register_hooks() {
		add_action('login_enqueue_scripts', [$this, 'enqueue_styles']);
		add_action('login_header', [$this, 'add_background_image']);
	}

	public function enqueue_styles() {
		$file = $this->path . '/Assets/css/login.css';
		wp_enqueue_style('gearhead-login', $file);
	}

	public function add_background_image() {
		$classes = '';
		$background_image = $this->background_image();
		echo sprintf("<div class='background-image'><img src='%s' class='%s'></div>", $background_image, $classes);
	}

	public function background_image() {
		$background_image = $this->background_image;

		if (!$this->background_image) {
			$background_image = 'forest.jpg';
		}

		return $this->path . '/Assets/images/' . $background_image;

	}
}