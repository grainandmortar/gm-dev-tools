/**
 * Outline Toggle Tool JavaScript
 * G&M Dev Tools
 *
 * Cycles through: Off → Normal (divs only) → Enhanced (everything) → Off
 */

(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        const toggleButton = document.getElementById('outlineToggle');
        const toggleText = document.getElementById('outlineToggleText');

        if (!toggleButton || !toggleText) {
            return;
        }

        // Register with Tool Dock if available
        if (window.GMToolDock) {
            window.GMToolDock.registerTool({
                id: 'outline-toggle',
                element: toggleButton,
                priority: 1 // Bottom position (first tool)
            });
        }

        const STORAGE_KEY = 'gm_outline_mode';
        
        // States: 'off', 'normal', 'enhanced'
        let currentState = localStorage.getItem(STORAGE_KEY) || 'off';
        
        // Function to set outline mode
        function setOutlineMode(mode) {
            // Remove all outline classes
            document.body.classList.remove('outline-mode', 'outline-mode-enhanced');
            
            // Remove all bg classes and reset to default
            toggleButton.classList.remove('bg-black', 'bg-red', 'bg-gray80');
            
            switch(mode) {
                case 'normal':
                    document.body.classList.add('outline-mode');
                    toggleButton.classList.add('bg-red');
                    toggleText.textContent = 'Outline: Divs';
                    localStorage.setItem(STORAGE_KEY, 'normal');
                    break;
                    
                case 'enhanced':
                    document.body.classList.add('outline-mode-enhanced');
                    toggleButton.classList.add('bg-gray80');
                    toggleText.textContent = 'Outline: All';
                    localStorage.setItem(STORAGE_KEY, 'enhanced');
                    break;
                    
                case 'off':
                default:
                    toggleButton.classList.add('bg-black');
                    toggleText.textContent = 'Outline Mode';
                    localStorage.removeItem(STORAGE_KEY);
                    currentState = 'off';
                    return;
            }
            currentState = mode;
        }
        
        // Apply saved state on load
        setOutlineMode(currentState);
        
        // Cycle through states on button click
        toggleButton.addEventListener('click', function() {
            switch(currentState) {
                case 'off':
                    setOutlineMode('normal');
                    break;
                case 'normal':
                    setOutlineMode('enhanced');
                    break;
                case 'enhanced':
                    setOutlineMode('off');
                    break;
                default:
                    setOutlineMode('off');
            }
        });
        
        // Keyboard shortcut: Ctrl/Cmd + Shift + O
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'O') {
                e.preventDefault();
                toggleButton.click();
            }
        });
    });
})();