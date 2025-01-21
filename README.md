
# Step 1: Setting Up the Local Environment for WordPress Plugin Development

This guide explains how to set up your local development environment using WP Engine Local App, GitHub, and WordPress. By the end of this step, you will have a functional WordPress installation and the `sentio` plugin repository ready for development.

---

## Prerequisites

Before you start, ensure you have the following installed and configured:

### Tools Required
1. **WP Engine Local App**: Download and install from [WP Engine Local](https://wpengine.com/local/).
2. **Git**: Install Git on your machine. Visit [Git Downloads](https://git-scm.com/downloads) for installation instructions.
3. **GitHub Account**: Ensure you have access to the [sentio repository](https://github.com/sensusmedia/sentio/tree/develop).
4. **Code Editor**: (Optional) Install a code editor like [Visual Studio Code](https://code.visualstudio.com/).

---

## Step-by-Step Instructions

### 1. Download and Install WP Engine Local App
1. Visit the [WP Engine Local](https://wpengine.com/local/) website.
2. Download the app for your operating system (Windows, macOS, or Linux).
3. Install the app by following the on-screen instructions.

---

### 2. Set Up a Local WordPress Site
1. Open the WP Engine Local App.
2. Click on **Create a New Site** or **+ Add Site**.
3. Configure the new site:
   - **Site Name**: Use `sentio-dev` or a name of your choice.
   - **Environment**: Use the default settings (Preferred Environment).
   - **Database**: Allow the app to configure the database automatically.
4. Finish the setup and start the local site.
5. Note the **Local Site URL** (e.g., `http://sentio-dev.local`).

---

### 3. Clone the GitHub Repository
1. Open a terminal or Git Bash.
2. Navigate to the `wp-content/plugins/` directory of your local WordPress site:
   ```bash
   cd /path/to/local/site/wp-content/plugins/
   ```
   Replace `/path/to/local/site/` with the directory path of your local site.
3. Clone the `sentio` GitHub repository:
   ```bash
   git clone https://github.com/sensusmedia/sentio.git
   ```
4. Navigate into the cloned repository:
   ```bash
   cd sentio
   ```
5. Verify the repository is set up:
   - Run `git status` to confirm the repository is properly initialized.

---

### 4. Configure `.gitignore`
To ensure only the plugin files are tracked in the repository, set up a `.gitignore` file:
1. Open the `sentio` directory in your preferred code editor.
2. Create or edit the `.gitignore` file in the root of the repository:
   ```bash
   touch .gitignore
   ```
3. Add the following content to `.gitignore`:
   ```gitignore
   /*
   !/sentio/
   ```
4. Save the file.

---

### 5. Activate the Plugin in WordPress
1. Open your browser and go to the WordPress admin dashboard for your local site:
   ```
   http://sentio-dev.local/wp-admin
   ```
2. Log in using the admin credentials created during setup.
3. Navigate to **Plugins > Installed Plugins**.
4. Locate the `sentio` plugin and click **Activate**.

---

### 6. Test the Setup
1. Verify the plugin appears and functions correctly on your local site.
2. Make a small test change in the plugin files (e.g., update a comment in a PHP file) and confirm the changes appear on the site.

---

# Step 2: Pushing Plugin Changes to Git

To ensure an efficient workflow, every commit will be made on a new branch. Once the changes are reviewed and approved, the new branch will be merged into the `develop` branch, triggering an automated deployment via DeployHQ.

---

### Workflow for Pushing Changes

#### 1. Create a New Branch for Your Changes
1. Open the terminal and navigate to the `sentio` plugin directory:
   ```bash
   cd /path/to/local/site/wp-content/plugins/sentio
   ```
2. Create and switch to a new branch. Use a meaningful branch name that reflects the changes you are making:
   ```bash
   git checkout -b feature/your-branch-name
   ```

#### 2. Make Your Changes
1. Edit the plugin files as needed.
2. Test your changes thoroughly in the local WordPress site.

#### 3. Stage and Commit Changes
1. Stage the changes you made:
   ```bash
   git add .
   ```
2. Commit the changes with a descriptive message:
   ```bash
   git commit -m "Describe the changes you made"
   ```

#### 4. Push the Branch to GitHub
1. Push the branch to the remote repository:
   ```bash
   git push origin feature/your-branch-name
   ```

#### 5. Create a Pull Request
1. Go to the [sentio repository on GitHub](https://github.com/sensusmedia/sentio/tree/develop).
2. Create a new Pull Request (PR) from your branch into the `develop` branch.
3. Add a title and description for your PR and assign it to a reviewer.

#### 6. Merge and Deploy
1. Once the PR is reviewed and approved, merge it into the `develop` branch.
2. The `develop` branch will automatically trigger a deployment to the WP Engine development site via DeployHQ.

---

### Best Practices
- Use clear, descriptive commit messages.
- Keep branch names consistent with their purpose (e.g., `feature/add-new-widget` or `fix/resolve-bug-123`).
- Frequently sync your branch with the latest changes from the `develop` branch to avoid conflicts:
  ```bash
  git pull origin develop
  ```

---

### Troubleshooting
1. **Branch Name Conflicts**:
   - Ensure your branch name is unique by following the naming convention.
2. **Merge Conflicts**:
   - Resolve conflicts locally and test before pushing the resolved changes.

---

### Next Steps
After successfully merging and deploying your changes, start a new branch for the next set of tasks or features.

---
