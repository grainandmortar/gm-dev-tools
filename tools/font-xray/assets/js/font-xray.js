// Typography Inspector Tool (Font X-Ray)
// Shows element tags and typography information on headings and paragraphs
// Cycles through: Off → Labels → Details → Off

document.addEventListener('DOMContentLoaded', function() {
    const STORAGE_KEY = 'typographyInspectorMode';

    // States: 'off', 'labels', 'details'
    let currentState = localStorage.getItem(STORAGE_KEY) || 'off';

    // Create toggle button
    const toggleButton = document.createElement('button');
    toggleButton.id = 'typographyToggle';
    toggleButton.style.cssText = 'background: #3782AA; color: white; padding: 8px 16px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); cursor: pointer; font-size: 14px; font-weight: 500; border: none; transition: all 0.3s ease; display: block;';
    toggleButton.innerHTML = '<span class="tool-emoji">🔍</span><span id="typographyToggleText">Typography: Off</span>';
    toggleButton.onmouseover = function() { this.style.transform = 'translateY(-2px)'; };
    toggleButton.onmouseout = function() { this.style.transform = 'translateY(0)'; };
    document.body.appendChild(toggleButton);

    // Register with Tool Dock if available
    if (window.GMToolDock) {
        window.GMToolDock.registerTool({
            id: 'font-xray',
            element: toggleButton,
            priority: 3 // Third position (above ACF module labels)
        });
    }

    // Function to convert RGB to HEX
    function rgbToHex(rgb) {
        const match = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
        if (match) {
            const hex = '#' +
                ('0' + parseInt(match[1], 10).toString(16)).slice(-2).toUpperCase() +
                ('0' + parseInt(match[2], 10).toString(16)).slice(-2).toUpperCase() +
                ('0' + parseInt(match[3], 10).toString(16)).slice(-2).toUpperCase();
            return hex;
        }
        return rgb;
    }

    // Function to get color display name (simplified for WP)
    function getColorName(color) {
        const hex = color.startsWith('rgb') ? rgbToHex(color) : color.toUpperCase();
        // Return just the hex for simplicity in WordPress context
        return hex;
    }

    // Function to create label for an element
    function createLabel(element) {
        const tagName = element.tagName;
        const computedStyle = window.getComputedStyle(element);
        const fontSize = computedStyle.fontSize;
        const lineHeight = computedStyle.lineHeight;
        const color = computedStyle.color;

        // Determine the display name for the element
        let displayName = tagName;

        // Check if element has heading classes
        const classList = element.className;
        if (classList && typeof classList === 'string') {
            if (classList.includes('h1') || classList.includes('heading-1')) displayName = 'H1';
            else if (classList.includes('h2') || classList.includes('heading-2')) displayName = 'H2';
            else if (classList.includes('h3') || classList.includes('heading-3')) displayName = 'H3';
            else if (classList.includes('h4') || classList.includes('heading-4')) displayName = 'H4';
            else if (classList.includes('h5') || classList.includes('heading-5')) displayName = 'H5';
            else if (classList.includes('h6') || classList.includes('heading-6')) displayName = 'H6';
        }

        // Calculate line height as percentage if it's in pixels
        let lineHeightDisplay = lineHeight;
        if (lineHeight !== 'normal' && lineHeight.includes('px') && fontSize.includes('px')) {
            const lhValue = parseFloat(lineHeight);
            const fsValue = parseFloat(fontSize);
            const percentage = Math.round((lhValue / fsValue) * 100);
            lineHeightDisplay = `${percentage}%`;
        }

        // Get color display
        const colorDisplay = getColorName(color);

        // Create wrapper div that will be positioned relative to the element
        const wrapper = document.createElement('div');
        wrapper.className = 'typography-label-wrapper';

        // Create label element
        const label = document.createElement('div');
        label.className = 'typography-label';
        label.dataset.tag = displayName.toLowerCase();

        // Set label content based on mode
        if (currentState === 'labels') {
            label.textContent = displayName;
        } else if (currentState === 'details') {
            label.textContent = `${displayName} • ${fontSize}/${lineHeightDisplay} • ${colorDisplay}`;
        }

        // Make element position relative if it's not already positioned
        const position = computedStyle.position;
        if (position === 'static') {
            element.style.position = 'relative';
            element.dataset.typographyOriginalPosition = 'static';
        }

        wrapper.appendChild(label);
        return wrapper;
    }

    // Function to update all labels
    function updateLabels() {
        // Remove existing labels and restore original positions
        document.querySelectorAll('.typography-label-wrapper').forEach(wrapper => wrapper.remove());
        document.querySelectorAll('[data-typography-original-position]').forEach(element => {
            if (element.dataset.typographyOriginalPosition === 'static') {
                element.style.position = '';
            }
            delete element.dataset.typographyOriginalPosition;
        });

        if (currentState === 'off') {
            return;
        }

        // First, prioritize actual heading tags
        const headingSelector = 'h1, h2, h3, h4, h5, h6';
        const headings = document.querySelectorAll(headingSelector);
        const labeledElements = new Set();

        // Label all headings first
        headings.forEach(element => {
            // Skip hidden elements
            const style = window.getComputedStyle(element);
            if (style.display === 'none' || style.visibility === 'hidden') {
                return;
            }

            // Skip if element has no text content
            if (!element.textContent.trim()) {
                return;
            }

            // Skip if already has a label
            if (element.querySelector('.typography-label-wrapper')) {
                return;
            }

            const labelWrapper = createLabel(element);
            element.appendChild(labelWrapper);
            labeledElements.add(element);
        });

        // Then label other text elements, but skip if they contain a heading
        const otherSelector = 'p, blockquote, .h1, .h2, .h3, .h4, .h5, .h6, label, legend, figcaption, dt, dd';
        const otherElements = document.querySelectorAll(otherSelector);

        otherElements.forEach(element => {
            // Skip if this element or its parent was already labeled
            if (labeledElements.has(element)) {
                return;
            }

            // Skip if this element contains a heading
            if (element.querySelector(headingSelector)) {
                return;
            }

            // Skip if this element is inside a heading
            if (element.closest(headingSelector)) {
                return;
            }

            // Skip hidden elements
            const style = window.getComputedStyle(element);
            if (style.display === 'none' || style.visibility === 'hidden') {
                return;
            }

            // Skip if element has no text content
            if (!element.textContent.trim()) {
                return;
            }

            // Skip if already has a label
            if (element.querySelector('.typography-label-wrapper')) {
                return;
            }

            const labelWrapper = createLabel(element);
            element.appendChild(labelWrapper);
            labeledElements.add(element);
        });
    }

    // Function to set typography mode
    function setTypographyMode(mode) {
        currentState = mode;

        // Update button appearance
        const toggleText = document.getElementById('typographyToggleText');

        switch(mode) {
            case 'labels':
                toggleButton.style.background = '#006937'; // Kelly Green
                toggleText.textContent = 'Typography: Labels';
                localStorage.setItem(STORAGE_KEY, 'labels');
                break;
            case 'details':
                toggleButton.style.background = '#1B5633'; // Forest Green
                toggleText.textContent = 'Typography: Details';
                localStorage.setItem(STORAGE_KEY, 'details');
                break;
            case 'off':
            default:
                toggleButton.style.background = '#3782AA'; // Water
                toggleText.textContent = 'Typography: Off';
                localStorage.removeItem(STORAGE_KEY);
                currentState = 'off';
                break;
        }

        updateLabels();
    }

    // Apply saved state on load
    setTypographyMode(currentState);

    // Cycle through states on button click
    toggleButton.addEventListener('click', function() {
        switch(currentState) {
            case 'off':
                setTypographyMode('labels');
                break;
            case 'labels':
                setTypographyMode('details');
                break;
            case 'details':
                setTypographyMode('off');
                break;
            default:
                setTypographyMode('off');
        }
    });

    // Keyboard shortcut: Ctrl/Cmd + Shift + T
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'T') {
            e.preventDefault();
            toggleButton.click();
        }
    });

    // Update labels on resize (in case responsive changes affect text)
    let resizeTimeout;
    window.addEventListener('resize', function() {
        if (currentState !== 'off') {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function() {
                updateLabels();
            }, 500);
        }
    });
});