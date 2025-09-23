/**
 * ACF Module Labels JavaScript
 * Handles toggle functionality and label creation
 */

document.addEventListener('DOMContentLoaded', function() {
    const toggleButton = document.getElementById('acfModuleLabelsToggle');
    const toggleText = document.getElementById('acfModuleLabelsToggleText');

    if (!toggleButton) return;

    // Get configuration from PHP (with defaults as fallback)
    const config = window.gmModuleLabelsConfig || {
        selector: '[data-acf-module]',
        attribute: 'acf-module',
        formatPrefix: '',
        classSelectors: [],
        formatFunction: null
    };

    // Register with Tool Dock if available
    if (window.GMToolDock) {
        window.GMToolDock.registerTool({
            id: 'acf-module-labels',
            element: toggleButton,
            priority: 2 // Second position (above outline toggle)
        });
    }

    const STORAGE_KEY = 'gmAcfModuleLabelsActive';
    
    // Get saved state from localStorage
    let isActive = localStorage.getItem(STORAGE_KEY) === 'true';
    
    // Initialize labels on load
    initializeLabels();
    
    // Apply initial state
    updateState();
    
    // Toggle button click handler
    toggleButton.addEventListener('click', function() {
        isActive = !isActive;
        updateState();
        localStorage.setItem(STORAGE_KEY, isActive);
    });
    
    /**
     * Initialize labels for all modules
     */
    function initializeLabels() {
        // Find all modules using configured selector
        let modules = Array.from(document.querySelectorAll(config.selector));

        // Also check for class-based selectors if configured
        if (config.classSelectors && config.classSelectors.length > 0) {
            config.classSelectors.forEach(classSelector => {
                const classModules = document.querySelectorAll(classSelector);
                classModules.forEach(module => {
                    if (!modules.includes(module)) {
                        modules.push(module);
                    }
                });
            });
        }

        modules.forEach(module => {
            // Skip if label already exists
            if (module.querySelector('.gm-acf-module-label')) {
                return;
            }

            // Get module name from data attribute using configured attribute name
            let moduleName;
            if (config.attribute) {
                // Convert attribute name to camelCase for dataset access
                const datasetKey = config.attribute.replace(/-([a-z])/g, (g) => g[1].toUpperCase());
                moduleName = module.dataset[datasetKey];
            }

            if (!moduleName) return;
            
            // Create label element
            const label = document.createElement('div');
            label.className = 'gm-acf-module-label';
            
            // Format the module name for display
            const formattedName = formatModuleName(moduleName);
            label.textContent = formattedName;
            
            // Add label to module
            module.appendChild(label);
            
            // Ensure module has relative positioning for absolute label
            if (window.getComputedStyle(module).position === 'static') {
                module.style.position = 'relative';
            }
        });
    }
    
    /**
     * Format module name for display
     */
    function formatModuleName(name) {
        // Remove configured prefix if present
        if (config.formatPrefix && name.startsWith(config.formatPrefix)) {
            name = name.substring(config.formatPrefix.length);
        }

        // Use custom format function if provided
        if (config.formatFunction && typeof window[config.formatFunction] === 'function') {
            return window[config.formatFunction](name);
        }

        // Default formatting: Convert underscores to spaces and capitalize
        return name
            .replace(/_/g, ' ')
            .replace(/\b\w/g, char => char.toUpperCase());
    }
    
    /**
     * Update the state of labels and button
     */
    function updateState() {
        const body = document.body;
        
        if (isActive) {
            body.classList.add('gm-acf-labels-active');
            toggleButton.classList.add('active');
            toggleText.textContent = 'Hide Labels';
        } else {
            body.classList.remove('gm-acf-labels-active');
            toggleButton.classList.remove('active');
            toggleText.textContent = 'Module Labels';
        }
    }
    
    /**
     * Re-initialize labels when DOM changes (for dynamic content)
     */
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                // Check if any new nodes contain modules
                mutation.addedNodes.forEach(node => {
                    if (node.nodeType === 1) { // Element node
                        // Check if node itself matches the selector
                        if (node.matches && node.matches(config.selector)) {
                            initializeLabels();
                        } else if (node.querySelectorAll) {
                            // Check if node contains elements matching the selector
                            const modules = node.querySelectorAll(config.selector);
                            if (modules.length > 0) {
                                initializeLabels();
                            }
                        }
                    }
                });
            }
        });
    });
    
    // Start observing the document for changes
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
    
    /**
     * Keyboard shortcut (Ctrl/Cmd + Shift + M)
     */
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'M') {
            e.preventDefault();
            toggleButton.click();
        }
    });
});