<?php

namespace Gearhead\Login;

/**
 * Class LoginPage
 * @package Gearhead\Login
 *
 * todo
 * - way to change the logo
 * - clean up
 * - mobile styles
 * - inherit styles from theme
 * - publish to github
 */
class LoginPage {

	/**
	 * @var string The background image url
	 */
	protected $backgroundImage;

	/**
	 * @var string The default background image
	 */
	protected $defaultBackground = 'forest.jpg';

	/**
	 * @var string The path of the gearhead/login package
	 */
	protected $path;

	/**
	 * @var bool Determines whether captions should be visible or not
	 */
	protected $enableCaption = false;

	/**
	 * @var string The caption text to be displayed on the login page
	 */
	protected $caption;

	/**
	 * @var string The title or headline that is displayed with the caption
	 */
	protected $captionTitle;

	/**
	 * @var string The CSS Selector class that is used to style the login forms alignment
	 */
	protected $alignmentClass;

    /**
     * LoginPage constructor.
     */
    public function __construct() {
        $this->path = dirname(dirname(__FILE__));
    }

	/**
	 * Registers the callbacks with the necessary WordPress hooks and filters
	 */
	public function registerHooks() {
		add_action('login_enqueue_scripts', [$this, 'enqueueStyles']);
		add_action('login_header', [$this, 'renderBackgroundImage']);
		add_filter('login_body_class', [$this, 'getBodyClass']);
	}

	/**
	 * Callback function for the login page's enqueue_scripts hook
	 */
	public function enqueueStyles() {
		$file = $this->path . '/dist/styles/app.css';
		wp_enqueue_style('gearhead-login', $file);
	}

	/**
	 * Callback function that returns CSS classes to be added to the login page's
	 * <body> element.
	 *
	 * @param $classes
	 *
	 * @return array
	 */
	public function getBodyClass($classes) {
		$classes[] = $this->alignmentClass;

		return $classes;
	}

	/**
	 * Allows for the alignment of the login form to be changed based
	 * on the option passed
	 *
	 * @param string $alignment The alignment of the form: right, center or left
	 *
	 * @return $this
	 */
	public function align($alignment) {
		if ( ! in_array($alignment, ['right', 'center', 'left'])) {
			return $this;
		}
		$this->alignmentClass = "align-{$alignment}";

		// append the class to the #login
		return $this;
	}

    /**
     * Returns the markup for the background image that is included
     * on the Login Page
     */
    public function renderBackgroundImage() {
        $classes         = '';
        $backgroundImage = $this->backgroundImageURL();
        $caption         = $this->loginCaption();
        $style_attribute = "style='background-image:url({$backgroundImage})'";
        echo sprintf("<div class='background-image login-form-background %s ' %s>%s</div>", $classes, $style_attribute, $caption);
    }

	/**
	 * Callback function that returns the HTML markup for the Login Page caption
	 * @return string
	 */
	public function loginCaption() {
		if ( ! $this->enableCaption) {
			return '';
		}

		$captionTitle = $this->getCaptionTitle();
		$caption      = $this->getCaption();

		return sprintf("<div class='bg-caption text-white text-shadow'><h2 class='semi-bold text-white'>%s</h2><p class='small'>%s</p></div>", $captionTitle, $caption);
	}

	/**
	 * Returns the caption title
	 * @return string
	 */
	public function getCaptionTitle() {
		$captionTitle = $this->captionTitle;

		if ( ! $captionTitle) {
			$captionTitle = 'Customize your login page as you see fit.';
		}

		return $captionTitle;
	}

	/**
	 * Callback function that returns the caption for the login page
	 * @return string
	 */
	public function getCaption() {
		$caption = $this->caption;

		if ( ! $caption) {
			$caption = 'The best WordPress experience by passionate developers.';
		}

		return $caption;
	}

	/**
	 * Set the caption headline
	 *
	 * @param string $title The title of the caption
	 *
	 * @return $this
	 */
	public function captionTitle($title) {
		$this->captionTitle = $title;
		if ( ! $this->enableCaption) {
			$this->enableCaption = true;
		}

		return $this;
	}

	/**
	 * Set the caption for the Login Page
	 *
	 * @param string $caption
	 *
	 * @return $this
	 */
	public function caption($caption) {
		$this->caption = $caption;
		if ( ! $this->enableCaption) {
			$this->enableCaption = true;
		}

		return $this;
	}

	/**
	 * Set the background image
	 *
	 * @param null|string|int $id The ID of the WordPress media attachment to be used for the background image.
	 *
	 * @return $this
	 */
	public function backgroundImage($id = null) {
		if ( ! is_numeric($id) && ! $id) {
			return $this;
		}

		$this->background_image = wp_get_attachment_url($id); // todo can we abstract this?
		return $this;
	}

	/**
	 * Returns the URL for the Login page background image.
	 * @return string
	 */
	public function backgroundImageURL() {
		if ( ! $this->backgroundImage) {
			return $this->path . '/dist/images/' . $this->defaultBackground;
		}

		return $this->backgroundImage;
	}
}
