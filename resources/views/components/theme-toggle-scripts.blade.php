<script>
    (function () {
        var storageKey = 'color-theme';
        var root = document.documentElement;
        var toggleButton = document.getElementById('theme-toggle');
        var darkIcon = document.getElementById('theme-toggle-dark-icon');
        var lightIcon = document.getElementById('theme-toggle-light-icon');
        var mediaQuery = window.matchMedia ? window.matchMedia('(prefers-color-scheme: dark)') : null;

        function resolveTheme() {
            var storedTheme = localStorage.getItem(storageKey);

            if (storedTheme === 'light' || storedTheme === 'dark') {
                return storedTheme;
            }

            return mediaQuery && mediaQuery.matches ? 'dark' : 'light';
        }

        function applyTheme(theme) {
            var isDark = theme === 'dark';

            root.classList.toggle('dark', isDark);
            root.style.colorScheme = isDark ? 'dark' : 'light';

            if (darkIcon) {
                darkIcon.classList.toggle('hidden', isDark);
            }

            if (lightIcon) {
                lightIcon.classList.toggle('hidden', !isDark);
            }

            if (toggleButton) {
                toggleButton.setAttribute('aria-pressed', isDark ? 'true' : 'false');
                toggleButton.setAttribute('data-theme', theme);
            }
        }

        function persistTheme(theme) {
            localStorage.setItem(storageKey, theme);
            applyTheme(theme);
        }

        applyTheme(resolveTheme());

        if (!toggleButton) {
            return;
        }

        toggleButton.addEventListener('click', function () {
            persistTheme(root.classList.contains('dark') ? 'light' : 'dark');
        });

        if (!mediaQuery) {
            return;
        }

        var syncWithSystemTheme = function (event) {
            if (localStorage.getItem(storageKey)) {
                return;
            }

            applyTheme(event.matches ? 'dark' : 'light');
        };

        if (typeof mediaQuery.addEventListener === 'function') {
            mediaQuery.addEventListener('change', syncWithSystemTheme);
        } else if (typeof mediaQuery.addListener === 'function') {
            mediaQuery.addListener(syncWithSystemTheme);
        }
    })();
</script>
