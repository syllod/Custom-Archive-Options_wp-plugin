# Custom Archive Options Plugin for WordPress

This plugin allows you to customize the titles, introductory texts, and images for the archives of Custom Post Types and blog pages in WordPress.

I often find myself wanting to create custom headers for different types of pages and posts. Unfortunately, depending on the theme used, it can be quite challenging to modify information for the blog page and the archives of Custom Post Types. Additionally, I wanted the ability to input customized information for these pages (titles, introductory text, and images). With shortcodes, this plugin allows for the freedom to create headers using hooks, making it a versatile solution for varying themes.

## Features

- Dynamic custom fields creation for each Custom Post Type and blog page.
- Customize the title, introductory text, and featured image for archive pages.
- Excludes certain Custom Post Types that don't have archive pages.
- Utilizes shortcodes to display customized elements on archive pages.

## Installation

1. Download or clone this repository to your local system.
2. If downloaded as a zip, extract the folder.
3. Copy the `custom-archive-options` folder to the `/wp-content/plugins/` directory of your WordPress installation.
4. Go to the WordPress dashboard, navigate to the 'Plugins' menu and activate the 'Custom Archive Options' plugin.

## Usage

1. After activating the plugin, go to the WordPress dashboard.
2. You will find a menu item named 'Paramètres des Archives'. Click on it.
3. For each Custom Post Type and the blog, you will see options to input a custom title, an introductory text, and a featured image URL.
4. Save the changes.

You can now use the following shortcodes in your theme files or post/pages content:

- `[custom_archive_title]` to display the custom title.
- `[custom_archive_intro]` to display the custom introductory text.
- `[custom_archive_image]` to display url of the the custom image.

## Contribution

Contributions are always welcome. Please create a pull request with your changes or improvements.

## License

This plugin is released under the [GPL-2.0+ License](https://www.gnu.org/licenses/gpl-2.0.html).
