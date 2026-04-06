<meta name="color-scheme" content="light dark">
<script>
    window.tailwind = window.tailwind || {};
    tailwind.config = {
        darkMode: 'class',
        theme: {
            extend: {}
        }
    };
</script>
<script>
    (function () {
        var storageKey = 'color-theme';
        var root = document.documentElement;
        var storedTheme = localStorage.getItem(storageKey);
        var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        var isDark = storedTheme ? storedTheme === 'dark' : prefersDark;

        root.classList.toggle('dark', isDark);
        root.style.colorScheme = isDark ? 'dark' : 'light';
    })();
</script>
