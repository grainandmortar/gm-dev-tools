/**
 * G&M Dev Tools - Tool Dock Manager
 *
 * Simple, clean container for dev tool buttons with collapse functionality
 */

(function() {
    'use strict';

    window.GMToolDock = {
        config: {
            dockId: 'gm-tool-dock',
            toggleId: 'gm-dock-toggle',
            storageKey: 'gm_tool_dock_collapsed'
        },

        dock: null,
        toggleBtn: null,
        toolsContainer: null,
        tools: [],
        isCollapsed: false,

        init: function() {
            if (this.dock) return;

            // Load saved state
            this.isCollapsed = localStorage.getItem(this.config.storageKey) === 'true';

            // Create the dock structure
            this.createDock();
        },

        createDock: function() {
            // Main dock container
            this.dock = document.createElement('div');
            this.dock.id = this.config.dockId;
            this.dock.className = 'gm-tool-dock';

            // Toggle button
            this.toggleBtn = document.createElement('button');
            this.toggleBtn.id = this.config.toggleId;
            this.toggleBtn.className = 'gm-dock-toggle';
            this.toggleBtn.innerHTML = '⚙️';
            this.toggleBtn.title = 'Toggle Dev Tools';
            this.toggleBtn.onclick = this.toggle.bind(this);

            // Tools container
            this.toolsContainer = document.createElement('div');
            this.toolsContainer.className = 'gm-tools-container';
            if (this.isCollapsed) {
                this.toolsContainer.style.display = 'none';
            }

            // Assemble dock - tools container first, toggle button last (stays at bottom)
            this.dock.appendChild(this.toolsContainer);
            this.dock.appendChild(this.toggleBtn);
            document.body.appendChild(this.dock);
        },

        registerTool: function(config) {
            if (!config.id || !config.element) return;

            // Store tool
            this.tools.push(config);

            // Sort by priority
            this.tools.sort((a, b) => (a.priority || 999) - (b.priority || 999));

            // Update display
            this.updateTools();
        },

        updateTools: function() {
            // Clear container
            this.toolsContainer.innerHTML = '';

            // Add tools in order
            this.tools.forEach(tool => {
                if (tool.element) {
                    // Reset element styles
                    tool.element.style.position = '';
                    tool.element.style.bottom = '';
                    tool.element.style.right = '';
                    tool.element.style.top = '';
                    tool.element.style.left = '';

                    // Add to container
                    this.toolsContainer.appendChild(tool.element);
                }
            });
        },

        toggle: function() {
            this.isCollapsed = !this.isCollapsed;

            if (this.isCollapsed) {
                this.toolsContainer.style.display = 'none';
                this.toggleBtn.classList.add('collapsed');
            } else {
                this.toolsContainer.style.display = 'flex';
                this.toggleBtn.classList.remove('collapsed');
            }

            // Save state
            localStorage.setItem(this.config.storageKey, this.isCollapsed);
        }
    };

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            GMToolDock.init();
        });
    } else {
        GMToolDock.init();
    }

})();