/**
 * ACF Module Labels JavaScript
 * Simple: finds [data-module] elements and adds a label at the top
 */

document.addEventListener('DOMContentLoaded', function() {
    const toggleButton = document.getElementById('acfModuleLabelsToggle');
    const toggleText = document.getElementById('acfModuleLabelsToggleText');

    if (!toggleButton) return;

    // Register with Tool Dock if available
    if (window.GMToolDock) {
        window.GMToolDock.registerTool({
            id: 'acf-module-labels',
            element: toggleButton,
            priority: 2
        });
    }

    const STORAGE_KEY = 'gmAcfModuleLabelsActive';
    let isActive = localStorage.getItem(STORAGE_KEY) === 'true';
    let labelsCreated = false;

    // Apply initial state
    updateState();

    // Toggle button click handler
    toggleButton.addEventListener('click', function() {
        isActive = !isActive;
        updateState();
        localStorage.setItem(STORAGE_KEY, isActive);
    });

    /**
     * Format module name for display
     */
    function formatModuleName(name) {
        // Remove common prefixes
        name = name.replace(/^page_module_/, '');
        name = name.replace(/^page_modules_/, '');
        name = name.replace(/^hero_module_/, '');
        name = name.replace(/^cta_module_/, '');
        name = name.replace(/^news_module_/, '');
        name = name.replace(/^media_module_/, '');
        name = name.replace(/^contact_module_/, '');

        // Convert underscores to spaces and capitalize
        return name
            .replace(/_/g, ' ')
            .replace(/\b\w/g, char => char.toUpperCase());
    }

    /**
     * Create labels for all modules
     */
    function createLabels() {
        if (labelsCreated) return;

        const modules = document.querySelectorAll('[data-module]');

        modules.forEach((module, index) => {
            const moduleName = module.getAttribute('data-module');
            if (!moduleName) return;

            // Create label
            const label = document.createElement('div');
            label.className = 'gm-module-label';
            label.innerHTML = `<span class="gm-module-label-num">${index + 1}</span> ${formatModuleName(moduleName)}`;

            // Insert at start of module
            module.insertBefore(label, module.firstChild);
        });

        labelsCreated = true;
    }

    /**
     * Update the state
     */
    function updateState() {
        const body = document.body;

        if (isActive) {
            createLabels();
            body.classList.add('gm-acf-labels-active');
            toggleButton.classList.add('active');
            toggleText.textContent = 'Hide Labels';
        } else {
            body.classList.remove('gm-acf-labels-active');
            toggleButton.classList.remove('active');
            toggleText.textContent = 'Module Labels';
        }
    }

    // Keyboard shortcut (Ctrl/Cmd + Shift + M)
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'M') {
            e.preventDefault();
            toggleButton.click();
        }
    });
});
