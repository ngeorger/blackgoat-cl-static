<?php
/**
 * Content section closing tag template.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
			</div>

			<?php
			/**
			 * Hook: cakecious/frontend/after_primary_and_sidebar
			 */
			do_action( 'cakecious/frontend/after_primary_and_sidebar' );
			?>

		</div>
	</div>
</div>