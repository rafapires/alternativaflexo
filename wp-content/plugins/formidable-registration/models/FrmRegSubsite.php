<?php

/**
 * Class FrmRegSubsite
 *
 * @since 2.0
 */
class FrmRegSubsite{

	/**
	 * Current site domain
	 *
	 * @since 2.0
	 * @var string
	 */
	private $current_site_domain = '';

	/**
	 * Current site path
	 *
	 * @since 2.0
	 * @var string
	 */
	private $current_site_path = '';

	/**
	 * Keep track of whether the current site is a subdomain or subdirectory install
	 *
	 * @since 2.0
	 * @var bool
	 */
	private $is_subdomain_install = false;

	/**
	 * Subsite title
	 *
	 * @since 2.0
	 * @var string
	 */
	private $title = '';

	/**
	 * Subsite domain
	 *
	 * @since 2.0
	 * @var string
	 */
	private $domain = '';

	/**
	 * Subsite subdomain or subdirectory
	 *
	 * @since 2.0
	 * @var string
	 */
	private $subdomain = '';

	/**
	 * Subsite path (part of URL that comes after domain)
	 *
	 * @since 2.0
	 * @var string
	 */
	private $path = '';

	/**
	 * User object
	 *
	 * @since 2.0
	 * @var null|FrmRegUser
	 */
	private $user = null;

	/**
	 * Entry object
	 *
	 * @since 2.0
	 * @var null|object
	 */
	private $entry = null;

	/**
	 * FrmRegSubsite constructor
	 *
	 * @since 2.0
	 * @param FrmRegUser $user
	 * @param $settings
	 * @param object $entry
	 */
	public function __construct( $user, $settings, $entry ) {
		$this->user = $user;
		$this->entry = $entry;

		$this->init_current_site_properties();
		$this->init_is_subdomain_install();

		$this->init_title( $settings );
		$this->init_subdomain( $settings );
		$this->init_path( $settings );
		$this->init_domain( $settings );

		$this->make_full_path_unique( $this->subdomain, 0 );
	}

	/**
	 * Set the current site properties
	 *
	 * @since 2.0
	 */
	private function init_current_site_properties() {
		$current_site = get_current_site();
		$this->current_site_path = $current_site->path;
		$this->current_site_domain = $current_site->domain;
	}

	/**
	 * Determine if the site is a subdomain install
	 *
	 * @since 2.0
	 */
	private function init_is_subdomain_install() {
		$this->is_subdomain_install = is_subdomain_install();
	}

	/**
	 * Set the title property for the subsite object
	 *
	 * @since 2.0
	 * @param array $settings
	 */
	private function init_title( $settings ) {
		if ( ! isset( $settings['subsite_title'] ) ) {
			return;
		}

		if ( $settings['subsite_title'] === 'username' ) {
			// Blog title should match username
			$this->title = $this->user->get_username();

		} else if ( is_numeric( $settings['subsite_title'] ) ) {
			// Blog title is set as a specific field
			$this->set_property_from_field_value( 'title', $settings['subsite_title'] );
		}
	}

	/**
	 * Set the subdomain for a new site
	 *
	 * @since 2.0
	 *
	 * @param array $settings
	 */
	private function init_subdomain( $settings ) {
		if ( $settings['subsite_domain'] === 'blog_title' ) {
			// Domain/subdirectory should match blog title
			$this->subdomain = $this->title;

		} else if ( $settings['subsite_domain'] === 'username' ) {
			// Domain/subdirectory should match username
			$this->subdomain = $this->user->get_username();

		} else if ( is_numeric( $settings['subsite_domain'] ) ) {
			// Domain/subdirectory is set as a specific field
			$opt = $settings['subsite_domain'];
			if ( FrmRegEntryHelper::is_field_selected_and_value_saved( $this->entry, $opt ) ) {
				$this->subdomain = $this->entry->metas[ $opt ];
			}
		}

		$this->subdomain = sanitize_title( $this->subdomain );
	}

	/**
	 * Set the path property for the new subsite
	 *
	 * @since 2.0
	 * @param array $settings
	 */
	private function init_path( $settings ) {
		if ( ! isset( $settings['subsite_domain'] ) || ! $this->subdomain ) {
			return;
		}

		if ( $this->is_subdomain_install ) {
			// If subsite.localhost.com format
			$this->path = $this->current_site_path;
		} else {
			// If localhost.com/subsite format
			$this->path  = $this->current_site_path . $this->subdomain . '/';
		}
	}

	/**
	 * Set the domain property for the new subsite
	 *
	 * @since 2.0
	 * @param array $settings
	 */
	private function init_domain( $settings ) {
		if ( ! isset( $settings['subsite_domain'] ) || ! $this->subdomain ) {
			return;
		}

		if ( $this->is_subdomain_install ) {
			// If subsite.localhost.com format
			$this->domain = $this->subdomain . '.' . preg_replace( '|^www\.|', '', $this->current_site_domain );
		} else {
			// If localhost.com/subsite format
			$this->domain = $this->current_site_domain;
		}
	}

	/**
	 * Create a subsite
	 *
	 * @since 2.0
	 *
	 * @return int|WP_Error
	 */
	public function create() {
		$new_blog_id = 0;

		$user_id = $this->user->get_user_id();

		if ( $user_id && $this->domain && $this->path && $this->title ) {
			$new_blog_id = wpmu_create_blog( $this->domain, $this->path, $this->title, $user_id );

			$args = array(
				'user_id' => $user_id,
				'domain'  => $this->domain,
				'path'    => $this->path,
				'entry'   => $this->entry,
			);
			do_action( 'frmreg_after_create_subsite', $new_blog_id, $args );
		}

		return $new_blog_id;
	}

	/**
	 * Make the full path for the new subsite unique
	 *
	 * @since 2.0
	 *
	 * @param string $original_subdomain
	 * @param int $count
	 */
	private function make_full_path_unique( $original_subdomain, $count ) {
		if ( domain_exists( $this->domain, $this->path ) ) {
			$count++;

			$this->subdomain = $original_subdomain . (string) $count;

			if ( $this->is_subdomain_install ) {
				$this->domain = $this->subdomain . '.' . preg_replace( '|^www\.|', '', $this->current_site_domain );
			} else {
				$this->path = $this->current_site_path . $this->subdomain . '/';
			}

			$this->make_full_path_unique( $original_subdomain, $count );
		}
	}

	/**
	 * Set a property from a posted field value
	 *
	 * @since 2.0
	 * @param string $property
	 * @param string $opt
	 */
	private function set_property_from_field_value( $property, $opt ) {
		if ( FrmRegEntryHelper::is_field_selected_and_value_saved( $this->entry, $opt ) ) {
			$this->$property = $this->entry->metas[ $opt ];
		}
	}
}