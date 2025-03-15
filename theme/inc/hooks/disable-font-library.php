<?php

namespace BopTail\Hooks;

/**
 * Disables the font library UI by modifying the editor settings.
 *
 * On most client builds we don't actually want to rely on administrators adding random custom fonts. Because doing so
 * can have very strong negative side effects on both the visual appearance of a site but even more importantly the
 * performance of a site. Therefore, the best practice is to already define the correct fonts in the themes
 * theme.json file.
 *
 * @param array $editor_settings The current settings for the editor.
 *
 * @return array The modified editor settings with the font library UI disabled.
 */
function disable_font_library_ui( $editor_settings ) {
	$editor_settings['fontLibraryEnabled'] = false;

	return $editor_settings;
}

add_filter( 'block_editor_settings_all', 'disable_font_library_ui' );
