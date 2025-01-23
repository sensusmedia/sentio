
# Sentio Addons Setup Guide

This guide provides step-by-step instructions to set up a WordPress development environment using WPE Local, clone the [Sentio repository](https://github.com/sensusmedia/sentio), and configure it to work specifically on the Sentio Addons plugin.

---

## Prerequisites

Before you begin, ensure you have the following installed on your system:

1. **Node.js** (for certain development tools)
2. **Git** (for version control)
3. **WPE Local** ([Download LocalWP here](https://localwp.com/))
4. A **GitHub account** with access to the [Sentio repository](https://github.com/sensusmedia/sentio)

---

## Step 1: Clone the Repository

The **Sentio Addons** plugin is located in the `app/public/wp-content/plugins/Sentio Addons` directory of the Sentio repository. To set up your local development environment, follow these steps:

1. Open a terminal and navigate to your project workspace:
   ```bash
   cd ~/projects/
   ```
2. Clone the Sentio repository:
   ```bash
   git clone https://github.com/sensusmedia/sentio.git
   cd sentio
   ```

---

## Step 2: Set Up a New Site in WPE Local

1. Open WPE Local and click **"Create a New Site"**.
2. **Select the Cloned Repository Path**:
   - Use the path to the `sentio` folder (e.g., `~/projects/sentio`).
3. Configure settings:
   - Ensure the `app/public` directory contains WordPress core files.
   - Select the **Preferred Configuration** or customize PHP, MySQL, and web server settings as needed.
4. Complete the setup by creating admin credentials for the WordPress site.

---

## Step 3: Verify the Installation

1. Open the local WordPress directory (`~/projects/sentio/app/public/`) to ensure it contains:
   - `wp-admin/`, `wp-includes/`, `wp-content/`.
   - The custom plugin `Sentio Addons` under `wp-content/plugins/`.
2. Open the WordPress Admin Dashboard (`WP Admin`) to confirm the theme and plugin are active.

---

## Step 4: Develop Locally

1. **Work in the `Sentio Addons` Directory**:
   - Navigate to the plugin directory:
     ```bash
     cd app/public/wp-content/plugins/Sentio\ Addons
     ```
   - Make all changes within this directory. Files outside this directory are ignored by Git.

2. **Push Changes**:
   - Stage changes in the `Sentio Addons` directory:
     ```bash
     git add app/public/wp-content/plugins/Sentio\ Addons/
     ```
   - Commit your changes:
     ```bash
     git commit -m "Describe your changes"
     ```
   - Push your changes to the remote repository:
     ```bash
     git push
     ```

---

## Additional Notes

- **Local Site Path**: The local WordPress site path will typically be:
  ```
  ~/projects/sentio/app/public
  ```

---

Thank you for using this guide to set up your development environment for the Sentio Addons plugin! If you encounter any issues, submit an issue on the [repository's GitHub page](https://github.com/sensusmedia/sentio).
