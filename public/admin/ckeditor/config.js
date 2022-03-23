/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
    config.extraPlugins = 'youtube';
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	  config.format_tags = 'p;h1;h2;h3;div';
      config.allowedContent = true;
      config.fillEmptyBlocks = false;
      config.basicEntities = false;
      config.filebrowserImageBrowseUrl = '/kcfinder/browse.php?type=images&dir=images/public';
};