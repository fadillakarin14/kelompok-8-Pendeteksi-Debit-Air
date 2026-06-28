(function () {
  const root = document.documentElement;
  const toggleBtn = document.getElementById('themeToggle');
  const themeIcon = document.getElementById('themeIcon');
  const themeLabel = document.getElementById('themeLabel');

  const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
  let currentTheme = window.__currentTheme || (prefersDark ? 'dark' : 'light');

  function applyTheme(theme) {
    if (theme === 'dark') {
      root.setAttribute('data-theme', 'dark');
      if (themeIcon) themeIcon.textContent = '☀';
      if (themeLabel) themeLabel.textContent = 'Light';
    } else {
      root.removeAttribute('data-theme');
      if (themeIcon) themeIcon.textContent = '🌙';
      if (themeLabel) themeLabel.textContent = 'Dark';
    }
    window.__currentTheme = theme;
    currentTheme = theme;
  }

  applyTheme(currentTheme);

  if (toggleBtn) {
    toggleBtn.addEventListener('click', function () {
      applyTheme(currentTheme === 'dark' ? 'light' : 'dark');
    });
  }
})();
