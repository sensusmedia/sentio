
# Sentio Addons Plugin Workflow

This guide explains how to set up the development environment and work specifically on the **Sentio Addons** plugin, which is located within the larger Sentio repository. Developers are restricted to working only on this plugin directory.

---

## **Step 1: Setting Up the Local Environment**

### Prerequisites
Before you begin, ensure the following tools are installed and configured:

1. **WP Engine Local App**: [Download here](https://wpengine.com/local/).
2. **Git**: [Install Git](https://git-scm.com/downloads) for version control.
3. **GitHub Account**: Ensure you have access to the [Sentio repository](https://github.com/sensusmedia/sentio/tree/develop).
4. **Code Editor**: (Optional) Use a tool like [Visual Studio Code](https://code.visualstudio.com/).

---

### **1. Clone the Sentio Repository**
The **Sentio Addons** plugin is located in the `app/public/wp-content/plugins/Sentio Addons` directory of the Sentio repository. Follow these steps:

1. Clone the entire repository:
   ```bash
   git clone https://github.com/sensusmedia/sentio.git
   cd sentio
   ```

2. Navigate to the Sentio Addons plugin directory:
   ```bash
   cd app/public/wp-content/plugins/Sentio\ Addons
   ```

3. Ensure you only work within this directory. Any changes made outside this directory will not be tracked or committed due to the `.gitignore` configuration.

---

## **Step 2: Working on the Sentio Addons Plugin**

### 1. Create a Feature Branch
To begin working on a new feature or bug fix, create a new branch:
```bash
git checkout -b feature/<feature-name>
```

### 2. Make Changes
- Edit the plugin files only within the `Sentio Addons` directory.
- Test your changes locally in your WordPress environment.

### 3. Stage and Commit Changes
- Stage only changes made to the `Sentio Addons` plugin directory:
  ```bash
  git add app/public/wp-content/plugins/Sentio\ Addons/
  git commit -m "Describe your changes"
  ```

### 4. Push the Branch
Push your branch to the remote repository:
```bash
git push origin feature/<feature-name>
```

---

## **Step 3: Deployment Workflow**

- Once your changes are reviewed and approved, merge your feature branch into the `develop` branch.
- The deployment pipeline (e.g., DeployHQ) will automatically deploy changes from the `develop` branch to the staging environment.
- Only files in the `Sentio Addons` directory will be deployed due to the `.gitignore` configuration.

---

## **.gitignore Configuration**

The repository uses the following `.gitignore` to ensure only the `Sentio Addons` directory is tracked:

```gitignore
/*
!/app/
!/app/public/
!/app/public/wp-content/
!/app/public/wp-content/plugins/
!/app/public/wp-content/plugins/Sentio Addons/
!/app/public/wp-content/plugins/Sentio Addons/**/*
```

---

## **Best Practices**

1. Always create feature branches for new work.
2. Commit meaningful and specific changes.
3. Test thoroughly before creating a pull request.
4. Keep your `develop` branch up-to-date:
   ```bash
   git pull origin develop
   ```

---

This workflow ensures you are working exclusively on the **Sentio Addons** plugin and simplifies the development and deployment process. Let me know if you need further adjustments or clarifications!
