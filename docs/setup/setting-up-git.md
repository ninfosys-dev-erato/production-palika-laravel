# Git Setup Guide for Digital Epalika Laravel Project

This guide will help you set up Git for the Digital Epalika Laravel project, including credential management to avoid repeated authentication.

## Table of Contents
1. [Prerequisites](#prerequisites)
2. [Initial Git Setup](#initial-git-setup)
3. [Repository Setup](#repository-setup)
4. [Credential Management](#credential-management)
5. [Branch Strategy](#branch-strategy)
6. [Workflow Best Practices](#workflow-best-practices)
7. [Troubleshooting](#troubleshooting)

## Prerequisites

Before starting, ensure you have:
- Git installed on your system
- Access to the project repository (GitHub, GitLab, etc.)
- SSH key pair (recommended) or Personal Access Token

### Installing Git

**Ubuntu/Debian:**
```bash
sudo apt update
sudo apt install git
```

**macOS:**
```bash
# Using Homebrew
brew install git

# Or download from https://git-scm.com/download/mac
```

**Windows:**
Download from https://git-scm.com/download/win

## Initial Git Setup

### 1. Configure Git User Information

Set your name and email globally:
```bash
git config --global user.name "Your Full Name"
git config --global user.email "your.email@example.com"
```

### 2. Set Default Branch Name
```bash
git config --global init.defaultBranch main
```

### 3. Configure Line Ending Handling

**For Windows:**
```bash
git config --global core.autocrlf true
```

**For macOS/Linux:**
```bash
git config --global core.autocrlf input
```

## Repository Setup

### 1. Clone the Repository

If you're starting fresh:
```bash
git clone <repository-url>
cd digital-epalika-laravel
```

### 2. Initialize Git (if not already initialized)

If you have the project locally without Git:
```bash
cd digital-epalika-laravel
git init
git remote add origin <repository-url>
```

### 3. Verify Remote Configuration
```bash
git remote -v
```

## Credential Management

### Option 1: SSH Key Authentication (Recommended)

#### 1. Generate SSH Key
```bash
ssh-keygen -t ed25519 -C "your.email@example.com"
# Press Enter to accept default file location
# Enter a passphrase (recommended) or press Enter for no passphrase
```

#### 2. Add SSH Key to SSH Agent
```bash
# Start the SSH agent
eval "$(ssh-agent -s)"

# Add your SSH key to the agent
ssh-add ~/.ssh/id_ed25519
```

#### 3. Add SSH Key to Your Git Provider

**For GitHub:**
1. Copy your public key:
   ```bash
   cat ~/.ssh/id_ed25519.pub
   ```
2. Go to GitHub → Settings → SSH and GPG keys
3. Click "New SSH key"
4. Paste your public key and save

**For GitLab:**
1. Copy your public key (same command as above)
2. Go to GitLab → Preferences → SSH Keys
3. Paste your public key and save

#### 4. Test SSH Connection
```bash
# For GitHub
ssh -T git@github.com

# For GitLab
ssh -T git@gitlab.com
```

### Option 2: Personal Access Token (Alternative)

#### 1. Generate Personal Access Token

**GitHub:**
1. Go to Settings → Developer settings → Personal access tokens → Tokens (classic)
2. Generate new token
3. Select scopes: `repo`, `workflow`
4. Copy the token immediately (you won't see it again)

**GitLab:**
1. Go to User Settings → Access Tokens
2. Create token with `read_repository` and `write_repository` scopes
3. Copy the token

#### 2. Configure Git Credential Manager

**For macOS:**
```bash
git config --global credential.helper osxkeychain
```

**For Windows:**
```bash
git config --global credential.helper manager-core
```

**For Linux:**
```bash
git config --global credential.helper store
```

#### 3. Store Credentials
When you first push/pull, Git will prompt for credentials:
- Username: your Git username
- Password: use your Personal Access Token (not your account password)

### Option 3: Git Credential Manager (Cross-platform)

Install Git Credential Manager for secure credential storage:

**macOS:**
```bash
brew install git-credential-manager
```

**Windows:**
Download from https://github.com/GitCredentialManager/git-credential-manager/releases

**Linux:**
```bash
# Ubuntu/Debian
sudo apt install git-credential-manager

# Or download from releases
```

## Branch Strategy

### 1. Main Branch Protection
- `main` branch should be protected
- Require pull request reviews
- Require status checks to pass

### 2. Branch Naming Convention
```
feature/feature-name
bugfix/bug-description
hotfix/urgent-fix
release/version-number
```

### 3. Create Feature Branch
```bash
git checkout main
git pull origin main
git checkout -b feature/your-feature-name
```

## Workflow Best Practices

### 1. Daily Workflow
```bash
# Start of day
git checkout main
git pull origin main

# Create feature branch
git checkout -b feature/your-feature

# Make changes and commit
git add .
git commit -m "feat: add new feature description"

# Push to remote
git push -u origin feature/your-feature
```

### 2. Commit Message Convention
Use conventional commits:
```
feat: add new feature
fix: bug fix
docs: documentation changes
style: formatting changes
refactor: code refactoring
test: adding tests
chore: maintenance tasks
```

### 3. Before Pushing
```bash
# Check status
git status

# Review changes
git diff

# Run tests (if available)
php artisan test

# Check for sensitive data
git diff --cached | grep -i "password\|secret\|key\|token"
```

### 4. Pull Request Process
1. Push your feature branch
2. Create pull request on Git provider
3. Request code review
4. Address review comments
5. Merge after approval

## Project-Specific Setup

### 1. Laravel Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Install dependencies
composer install
npm install

# Run migrations
php artisan migrate
```

### 2. Pre-commit Hooks (Optional)
Create `.git/hooks/pre-commit`:
```bash
#!/bin/bash
# Run PHP CS Fixer
./vendor/bin/php-cs-fixer fix --dry-run --diff

# Run tests
php artisan test

# Check for sensitive data
if git diff --cached | grep -i "password\|secret\|key\|token"; then
    echo "Warning: Potential sensitive data detected!"
    exit 1
fi
```

Make it executable:
```bash
chmod +x .git/hooks/pre-commit
```

## Troubleshooting

### Common Issues

#### 1. Authentication Failed
```bash
# Check SSH connection
ssh -T git@github.com

# Verify remote URL
git remote -v

# If using HTTPS, update to SSH
git remote set-url origin git@github.com:username/repository.git
```

#### 2. Permission Denied
```bash
# Check SSH key permissions
chmod 600 ~/.ssh/id_ed25519
chmod 644 ~/.ssh/id_ed25519.pub
```

#### 3. Large File Issues
```bash
# Check for large files
find . -size +50M

# Add to .gitignore if needed
echo "large-file.zip" >> .gitignore
```

#### 4. Merge Conflicts
```bash
# Abort merge
git merge --abort

# Or resolve conflicts manually
git status
# Edit conflicted files
git add .
git commit
```

### Useful Git Aliases
Add these to your `~/.gitconfig`:
```ini
[alias]
    st = status
    co = checkout
    br = branch
    ci = commit
    unstage = reset HEAD --
    last = log -1 HEAD
    visual = !gitk
    lg = log --oneline --graph --decorate
    amend = commit --amend --no-edit
```

## Security Best Practices

1. **Never commit sensitive data:**
   - API keys
   - Database passwords
   - Private keys
   - Environment variables

2. **Use environment files:**
   - Keep `.env` in `.gitignore`
   - Use `.env.example` for documentation

3. **Regular security updates:**
   - Update dependencies regularly
   - Review access permissions
   - Rotate SSH keys periodically

## Additional Resources

- [Git Documentation](https://git-scm.com/doc)
- [GitHub Guides](https://guides.github.com/)
- [Conventional Commits](https://www.conventionalcommits.org/)
- [Laravel Best Practices](https://laravel.com/docs/best-practices)

---

**Note:** This guide assumes you have appropriate permissions to the repository. Contact your project administrator if you need access or have questions about the setup process.
