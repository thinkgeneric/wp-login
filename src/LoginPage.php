<?php

namespace Gearhead\Login;

class LoginPage {

	protected $background_image;
	protected $path;
	protected $enable_caption = false;
	protected $caption;
	protected $caption_title;

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
		$caption = $this->login_caption();
		echo sprintf("<div class='background-image'><img src='%s' class='%s'>%s</div>", $background_image, $classes, $caption);
	}

	public function login_caption() {
		if (!$this->enable_caption) {
			return '';
		}

		$message = 'Customize your login page as you see fit.';
		$afterthought = 'The best WordPress experience by passionate developers.';
		return sprintf("<div class='bg-caption text-white text-shadow'><h2 class='semi-bold text-white'>%s</h2><p class='small'>%s</p></div>", $message, $afterthought);
	}

	public function get_caption_title() {
		$caption_title = $this->caption_title;

		if ($caption_title == '') {
			$caption_title = 'Customize your login page as you see fit.';
		}

		return $caption_title;
	}

	public function get_caption() {
		$caption = $this->caption;

		if ($caption == '') {
			$caption = 'The best WordPress experience by passionate developers.';
		}

		return $caption;
	}

	public function caption_title($title) {
		$this->caption_title = $title; // todo esc_html or whatever
		if (!$this->enable_caption) {
			$this->enable_caption = true;
		}
		return $this;
	}

	public function caption($caption) {
		$this->caption = $caption; // todo esc_html or whatever
		if (!$this->enable_caption) {
			$this->enable_caption = true;
		}
		return $this;
	}

	public function background_image() {
		$background_image = $this->background_image;

		if (!$this->background_image) {
			$background_image = 'forest.jpg';
		}

		return $this->path . '/Assets/images/' . $background_image;
	}
}