/**
 * Artisan Playground JavaScript
 */

// Theme management
class ThemeManager {
  constructor() {
    this.themeToggle = document.getElementById("themeToggle");
    this.themeIcon = document.getElementById("themeIcon");
    this.init();
  }

  init() {
    if (this.themeToggle) {
      this.themeToggle.addEventListener("click", () => this.toggleTheme());
    }
    this.loadTheme();
  }

  toggleTheme() {
    const html = document.documentElement;
    const currentTheme = html.getAttribute("data-bs-theme");
    const newTheme = currentTheme === "dark" ? "light" : "dark";

    this.setTheme(newTheme);
  }

  setTheme(theme) {
    document.documentElement.setAttribute("data-bs-theme", theme);
    localStorage.setItem("artisan_playground_theme", theme);

    if (this.themeIcon) {
      this.themeIcon.className =
        theme === "dark" ? "fas fa-sun" : "fas fa-moon";
    }
  }

  loadTheme() {
    const savedTheme = localStorage.getItem("artisan_playground_theme");
    if (savedTheme) {
      this.setTheme(savedTheme);
    }
  }
}

// Command execution utilities
class CommandExecutor {
  constructor() {
    this.bindEvents();
  }

  bindEvents() {
    const commandForm = document.getElementById("commandForm");
    if (commandForm) {
      commandForm.addEventListener("submit", (e) => {
        e.preventDefault();
        this.executeCommand();
      });
    }
  }

  async executeCommand() {
    const form = document.getElementById("commandForm");
    const formData = new FormData(form);
    const executeBtn = document.getElementById("executeBtn");
    const outputCard = document.getElementById("outputCard");
    const commandOutput = document.getElementById("commandOutput");
    const executionTime = document.getElementById("executionTime");

    // Show loading state
    this.setLoadingState(executeBtn, true);
    this.showOutput(outputCard, commandOutput, "Executing command...");

    try {
      const data = this.prepareCommandData(formData);
      const response = await this.sendCommandRequest(data);

      if (response.success) {
        this.showSuccessOutput(commandOutput, executionTime, response);
      } else {
        this.showErrorOutput(commandOutput, executionTime, response.message);
      }
    } catch (error) {
      this.showErrorOutput(commandOutput, executionTime, error.message);
    } finally {
      this.setLoadingState(executeBtn, false);
    }
  }

  prepareCommandData(formData) {
    const data = {
      command: formData.get("command"),
      arguments: {},
      options: {},
    };

    // Process arguments
    for (let [key, value] of formData.entries()) {
      if (key.startsWith("arguments[")) {
        const argName = key.replace("arguments[", "").replace("]", "");
        if (value) {
          data.arguments[argName] = value;
        }
      } else if (key.startsWith("options[")) {
        const optName = key.replace("options[", "").replace("]", "");
        if (key.endsWith("_value]")) {
          const actualOptName = optName.replace("_value", "");
          if (formData.get("options[" + actualOptName + "]")) {
            data.options[actualOptName] = value;
          }
        } else if (value === "1") {
          data.options[optName] = true;
        }
      }
    }

    return data;
  }

  async sendCommandRequest(data) {
    const response = await fetch("/artisan-playground/execute", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
      },
      body: JSON.stringify(data),
    });

    return await response.json();
  }

  setLoadingState(button, loading) {
    if (loading) {
      button.disabled = true;
      button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Executing...';
    } else {
      button.disabled = false;
      button.innerHTML = '<i class="fas fa-play"></i> Execute Command';
    }
  }

  showOutput(outputCard, commandOutput, message) {
    outputCard.style.display = "block";
    commandOutput.textContent = message;
  }

  showSuccessOutput(commandOutput, executionTime, response) {
    commandOutput.textContent = response.output;
    executionTime.textContent = response.execution_time + "s";
    commandOutput.style.color = "var(--bs-success)";
  }

  showErrorOutput(commandOutput, executionTime, message) {
    commandOutput.textContent = "Error: " + message;
    commandOutput.style.color = "var(--bs-danger)";
    executionTime.textContent = "Failed";
  }
}

// Utility functions
class Utils {
  static copyToClipboard(text) {
    return navigator.clipboard
      .writeText(text)
      .then(() => {
        this.showToast("Copied to clipboard!", "success");
      })
      .catch(() => {
        this.showToast("Failed to copy to clipboard", "error");
      });
  }

  static showToast(message, type = "info") {
    // Create toast element
    const toast = document.createElement("div");
    toast.className = `toast align-items-center text-white bg-${
      type === "success" ? "success" : type === "error" ? "danger" : "info"
    } border-0`;
    toast.setAttribute("role", "alert");
    toast.setAttribute("aria-live", "assertive");
    toast.setAttribute("aria-atomic", "true");

    toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        `;

    // Add to page
    const container =
      document.getElementById("toast-container") || this.createToastContainer();
    container.appendChild(toast);

    // Show toast
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();

    // Remove after hidden
    toast.addEventListener("hidden.bs.toast", () => {
      toast.remove();
    });
  }

  static createToastContainer() {
    const container = document.createElement("div");
    container.id = "toast-container";
    container.className = "toast-container position-fixed top-0 end-0 p-3";
    container.style.zIndex = "1055";
    document.body.appendChild(container);
    return container;
  }

  static debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
      const later = () => {
        clearTimeout(timeout);
        func(...args);
      };
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
    };
  }

  static formatBytes(bytes, decimals = 2) {
    if (bytes === 0) return "0 Bytes";
    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    const sizes = ["Bytes", "KB", "MB", "GB", "TB"];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + " " + sizes[i];
  }

  static formatDuration(seconds) {
    if (seconds < 1) return (seconds * 1000).toFixed(0) + "ms";
    if (seconds < 60) return seconds.toFixed(2) + "s";
    const minutes = Math.floor(seconds / 60);
    const remainingSeconds = seconds % 60;
    return `${minutes}m ${remainingSeconds.toFixed(0)}s`;
  }
}

// Search functionality
class CommandSearch {
  constructor() {
    this.searchInput = document.getElementById("commandSearch");
    this.commandItems = document.querySelectorAll(".command-item");
    this.searchClear = document.getElementById("searchClear");
    this.searchShortcut = document.getElementById("searchShortcut");
    this.init();
  }

  init() {
    if (this.searchInput) {
      this.searchInput.addEventListener("input", () => this.filterCommands());
      this.searchInput.addEventListener("keydown", (e) =>
        this.handleSearchShortcut(e)
      );

      if (this.searchClear) {
        this.searchClear.addEventListener("click", () => this.clearSearch());
      }

      this.updateShortcutDisplay();
      this.searchInput.focus();
    }
  }

  filterCommands() {
    const searchTerm = this.searchInput.value.toLowerCase();
    let visibleCount = 0;

    this.commandItems.forEach((item) => {
      const commandName = item.getAttribute("data-command");
      const description = item.getAttribute("data-description");

      if (
        commandName.includes(searchTerm) ||
        description.includes(searchTerm)
      ) {
        item.style.display = "block";
        visibleCount++;
      } else {
        item.style.display = "none";
      }
    });

    // Show/hide clear button and shortcut
    if (this.searchClear && this.searchShortcut) {
      if (searchTerm) {
        this.searchClear.style.display = "flex";
        this.searchShortcut.style.display = "none";
      } else {
        this.searchClear.style.display = "none";
        this.searchShortcut.style.display = "flex";
      }
    }

    // Update command counts
    this.updateCommandCounts();
  }

  clearSearch() {
    this.searchInput.value = "";
    this.searchInput.focus();
    this.filterCommands();
  }

  updateCommandCounts() {
    const sections = document.querySelectorAll(".command-section");

    sections.forEach((section) => {
      const commandGrid = section.querySelector(".command-grid");
      if (commandGrid) {
        const visibleCommands = commandGrid.querySelectorAll(
          '.command-item[style*="block"], .command-item:not([style*="none"])'
        );
        const countElement = section.querySelector(".command-count");
        if (countElement) {
          countElement.textContent = `${visibleCommands.length} commands`;
        }
      }
    });
  }

  handleSearchShortcut(e) {
    const isMac = navigator.platform.toUpperCase().indexOf("MAC") >= 0;
    const cmdOrCtrl = isMac ? e.metaKey : e.ctrlKey;

    if (cmdOrCtrl && e.key === "k") {
      e.preventDefault();
      this.searchInput.focus();
      this.searchInput.select();
    }
  }

  updateShortcutDisplay() {
    const isMac = navigator.platform.toUpperCase().indexOf("MAC") >= 0;
    const cmdKey = document.getElementById("cmdKey");

    if (cmdKey) {
      if (isMac) {
        cmdKey.textContent = "⌘";
        this.searchInput.placeholder =
          "Search commands by name or description... (⌘K)";
      } else {
        cmdKey.textContent = "Ctrl";
        this.searchInput.placeholder =
          "Search commands by name or description... (Ctrl+K)";
      }
    }
  }
}

// Initialize when DOM is loaded
document.addEventListener("DOMContentLoaded", function () {
  // Initialize theme manager
  new ThemeManager();

  // Initialize command executor if on command page
  if (document.getElementById("commandForm")) {
    new CommandExecutor();
  }

  // Initialize search if available
  if (document.getElementById("commandSearch")) {
    new CommandSearch();
  }

  // Global copy function
  window.copyOutput = function () {
    const output = document.getElementById("outputContent").textContent;
    Utils.copyToClipboard(output);
  };

  // Global show output function
  window.showOutput = function (output) {
    document.getElementById("outputContent").textContent = output;
    new bootstrap.Modal(document.getElementById("outputModal")).show();
  };

  // Global reset form function
  window.resetForm = function () {
    document.getElementById("commandForm").reset();
    document.getElementById("outputCard").style.display = "none";
  };

  // Global re-execute command function
  window.reExecuteCommand = function (commandName, arguments, options) {
    if (confirm("Do you want to re-execute this command?")) {
      const params = new URLSearchParams();
      params.append("command", commandName);
      if (arguments) {
        Object.keys(arguments).forEach((key) => {
          params.append(`arguments[${key}]`, arguments[key]);
        });
      }
      if (options) {
        Object.keys(options).forEach((key) => {
          params.append(`options[${key}]`, options[key]);
        });
      }
      window.location.href = `/artisan-playground?${params.toString()}`;
    }
  };

  // Global show details function
  window.showDetails = function (commandId) {
    fetch(`/artisan-playground/command-details/${commandId}`)
      .then((response) => response.json())
      .then((data) => {
        document.getElementById("detailsContent").innerHTML = data.html;
        new bootstrap.Modal(document.getElementById("detailsModal")).show();
      })
      .catch((error) => {
        console.error("Error loading command details:", error);
        Utils.showToast("Error loading command details", "error");
      });
  };

  // Initialize login page functionality
  if (document.getElementById("loginForm")) {
    initializeLoginPage();
  }

  // Initialize history page functionality
  if (document.getElementById("filterForm")) {
    initializeHistoryPage();
  }
});

// Login page functionality
function initializeLoginPage() {
  const togglePassword = document.getElementById("togglePassword");
  const passwordInput = document.getElementById("password");
  const passwordIcon = document.getElementById("passwordIcon");
  const loginForm = document.getElementById("loginForm");
  const loginBtn = document.getElementById("loginBtn");

  if (togglePassword && passwordInput && passwordIcon) {
    togglePassword.addEventListener("click", function() {
      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        passwordIcon.className = "fas fa-eye-slash";
      } else {
        passwordInput.type = "password";
        passwordIcon.className = "fas fa-eye";
      }
    });
  }

  if (loginForm && loginBtn) {
    loginForm.addEventListener("submit", function(e) {
      loginBtn.disabled = true;
      loginBtn.innerHTML = '<span class="spinner me-2"></span>Signing In...';
    });
  }

  // Focus on email field
  const emailField = document.getElementById("email");
  if (emailField) {
    emailField.focus();
  }
}

// History page functionality
function initializeHistoryPage() {
  const filterForm = document.getElementById("filterForm");
  const filterInputs = filterForm.querySelectorAll("input, select");
  const clearFiltersBtn = document.getElementById("clearFilters");

  // Auto-submit form when filters change
  filterInputs.forEach(input => {
    input.addEventListener("change", function() {
      filterForm.submit();
    });
  });

  // Clear filters button
  if (clearFiltersBtn) {
    clearFiltersBtn.addEventListener("click", function() {
      // Clear all form inputs
      filterInputs.forEach(input => {
        if (input.type === "text" || input.type === "select-one") {
          input.value = "";
        } else if (input.type === "checkbox") {
          input.checked = false;
        }
      });
      filterForm.submit();
    });
  }
}
