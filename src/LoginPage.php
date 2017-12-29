<?php

namespace Gearhead\Login;

class LoginPage {
	public function register_hooks() {
		add_action('login_enqueue_scripts', [$this, 'enqueue_styles']);
	}

	public function enqueue_styles() {
		$path = dirname(dirname(__FILE__));
		$file = $path . '/Assets/css/login.css';
		wp_enqueue_style('gearhead-login', $file);
	}
}