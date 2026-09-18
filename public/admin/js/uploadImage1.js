// uploadImage.js - Updated for dashboard integration

function initImageUpload(containerId, previewId, inputId) {
    const container = document.getElementById(containerId);
    const preview = document.getElementById(previewId);
    const input = document.getElementById(inputId);
    
    if (!container || !preview || !input) return;
    
    // Remove any existing classes
    container.classList.remove('drag-over', 'upload-success', 'upload-error', 'uploading');
    
    // Click on container triggers file input
    container.addEventListener('click', function() {
        input.click();
    });
    
    // Handle file selection
    input.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            
            // Validate file type
            if (!file.type.match('image.*')) {
                container.classList.add('upload-error');
                setTimeout(() => container.classList.remove('upload-error'), 1000);
                return;
            }
            
            // Validate file size (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                container.classList.add('upload-error');
                setTimeout(() => container.classList.remove('upload-error'), 1000);
                alert('File size should be less than 2MB');
                return;
            }
            
            // Show uploading state
            container.classList.add('uploading');
            
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                
                // Remove uploading state and show success
                container.classList.remove('uploading');
                container.classList.add('upload-success');
                
                // Animate
                container.style.transform = 'scale(1.05)';
                setTimeout(() => {
                    container.style.transform = 'scale(1)';
                    container.classList.remove('upload-success');
                }, 500);
            }
            
            reader.onerror = function() {
                container.classList.remove('uploading');
                container.classList.add('upload-error');
                setTimeout(() => container.classList.remove('upload-error'), 1000);
            }
            
            reader.readAsDataURL(file);
        }
    });
    
    // Drag and drop support
    container.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('drag-over');
    });
    
    container.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('drag-over');
    });
    
    container.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('drag-over');
        
        if (e.dataTransfer.files.length) {
            const file = e.dataTransfer.files[0];
            
            // Validate file type
            if (!file.type.match('image.*')) {
                container.classList.add('upload-error');
                setTimeout(() => container.classList.remove('upload-error'), 1000);
                return;
            }
            
            input.files = e.dataTransfer.files;
            const event = new Event('change', { bubbles: true });
            input.dispatchEvent(event);
        }
    });
}

// Function to initialize image upload for dynamically loaded content
function initDynamicImageUpload(containerId, previewId, inputId) {
    // Try immediately
    initImageUpload(containerId, previewId, inputId);
    
    // Also try after a short delay (for dynamically loaded content)
    setTimeout(() => {
        initImageUpload(containerId, previewId, inputId);
    }, 500);
}

// Auto-initialize for existing elements on page load
document.addEventListener('DOMContentLoaded', function() {
    initImageUpload('avatarContainer', 'avatar-preview', 'avatar-upload');
});