## Changelog

##### 1.0.0
- Redesign
- Added %price% variable for WooCommerce sites
- Different Webhooks per post type
- Option to disable categories

##### 0.2.2 - Tags, tags and tags!
- Added requested %tags% and %hashtags% variables (#1)

##### 0.2.1 - Sorry about that!
- Added support to non utf8mb4 collations (when MySQL collation was not set to utf8mb4 the data was not saved) #fixed
- Added %category% %image% variables (when you want to use an image larger than the thumbnail)
- Use 'thumbnail' instead 'post-thumbnail' to get thumbnail image (WP's default)

##### 0.2.0 - CUSTOM TYYYYYYYPES
- Added support to custom post types
- You can select the "custom post types" that will work
- Added %type% variable
- You can choose not to send a specific post

##### 0.1.3 - It's so beautiful
- Clean design
- Help variables clickables
- Added help tooltips
- Auto rezise textarea
- Discordance has an icon (WordPress menu)
- Discordance also available on WordPress (https://wordpress.org/plugins/discordance/)

##### 0.1.2 - WordPress' best practices
- Remove PHP 7 short tags

### 0.1.1 - Improvements
- Prevents duplicate webhooks
- Improvement of the JSON formatter (added pretty button)
- Added README with relevant information
- Added new variables (%author%, %author_url% and %gravatar%)

## Installation

1. Download the Discordance plugin: https://wordpress.org/plugins/discordance/
2. Upload the `discordance` folder to the `/wp-content/plugins/` directory.
3. Activate the plugin through the "Plugins" menu in WordPress.
4. Navigate to Discordance in the WordPress admin to configure the plugin.
