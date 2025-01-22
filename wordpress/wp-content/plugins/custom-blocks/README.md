# Custom Blocks Plugin for WordPress

## Description

The **Custom Blocks** plugin is a WordPress plugin designed to add custom Gutenberg blocks to your WordPress site. It allows you to extend the functionality of the block editor by creating and managing custom blocks tailored to your needs.

This plugin is located in the `wp-content/plugins/custom-blocks` directory of the [sandbox_wordpress](https://github.com/iwolfisberg/sandbox_wordpress) project.

## Features

- Create and manage custom Gutenberg blocks.
- Fully compatible with the WordPress block editor.
- Customizable and extensible codebase.

## Requirements

- WordPress version 5.8 or higher.
- PHP version 7.4 or higher.
- Node.js and npm (for block development and building).

## Installation

### 1. Clone the Repository

Clone the repository to your local machine:

```bash
git clone https://github.com/iwolfisberg/sandbox_wordpress.git
```

### 2. Navigate to the Plugin Directory

Navigate to the plugin directory:

```bash
cd sandbox_wordpress/wp-content/plugins/custom-blocks
```

### 3. Install Dependencies

If your plugin uses Node.js for building blocks, install the dependencies:

```bash
npm install
```

### 4. Build the Plugin

Build the JavaScript and CSS assets:

```bash
npm run build
```

For development, you can use:

```bash
npm run start
```

### 5. Activate the Plugin

1. Log in to your WordPress admin dashboard.
2. Go to **Plugins > Installed Plugins**.
3. Locate the **Custom Blocks** plugin in the list and click **Activate**.

## Usage

### Adding a Custom Block in editor

1. Open the WordPress block editor (e.g., when editing a post or page).
2. Click the "+" button to add a block.
3. Search for the custom block(s) you added through this plugin.
4. Insert the block and customize it as needed.

### Modifying Existing Blocks

- Make changes to the block source files in the `src` directory.
- Rebuild the assets using `npm run build`.

## Development

### File Structure

- `src/`: Contains the source files for your custom blocks (JavaScript, CSS, etc.).
- `build/`: Contains the compiled files ready for use in WordPress.
- `custom-blocks.php`: Main entry point for the plugin.

### Adding a New Block

1. Create a new directory under `src/blocks` for your block.
2. Define your block configuration and code.
3. Register the block in the plugin's `custom-blocks.js` file (in the `$blocks_path` variable).
4. Build the assets with `npm run build`.
