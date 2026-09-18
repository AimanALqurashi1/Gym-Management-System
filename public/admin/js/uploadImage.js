// uploadImage.js
function initImageUpload(containerId, previewId, inputId) {
    const container = document.getElementById(containerId);
    const preview = document.getElementById(previewId);
    const input = document.getElementById(inputId);
    
    if (!container || !preview || !input) return;
    
    // Click on container triggers file input
    container.addEventListener('click', function() {
        input.click();
    });
    
    // Handle file selection
    input.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                
                container.style.transform = 'scale(1.05)';
                setTimeout(() => {
                    container.style.transform = 'scale(1)';
                }, 200);
            }
            
            reader.readAsDataURL(this.files[0]);
        }
    });
    
    // Drag and drop support
    container.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.style.borderColor = '#2ecc71';
    });
    
    container.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.style.borderColor = '#e0e0e0';
    });
    
    container.addEventListener('drop', function(e) {
        e.preventDefault();
        this.style.borderColor = '#e0e0e0';
        
        if (e.dataTransfer.files.length) {
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


 








/* 
    document.addEventListener('DOMContentLoaded', function() {
    const avatarContainer = document.getElementById('avatarContainer');
    const avatarPreview = document.getElementById('avatar-preview');
    const fileInput = document.getElementById('avatar-upload');
    
    // Click on avatar container triggers file input
    avatarContainer.addEventListener('click', function() {
        fileInput.click();
    });
    
    // Handle file selection
    fileInput.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                // Update avatar preview with selected image
                avatarPreview.src = e.target.result;
                
                // Optional: Add a temporary success animation
                avatarContainer.style.transform = 'scale(1.05)';
                setTimeout(() => {
                    avatarContainer.style.transform = 'scale(1)';
                }, 200);
            }
            
            reader.readAsDataURL(this.files[0]);
        }
    });
    
    // Optional: Add drag and drop support directly on avatar
    avatarContainer.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.style.borderColor = '#2ecc71';
    });
    
    avatarContainer.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.style.borderColor = '#e0e0e0';
    });
    
    avatarContainer.addEventListener('drop', function(e) {
        e.preventDefault();
        this.style.borderColor = '#e0e0e0';
        
        if (e.dataTransfer.files.length) {
            fileInput.files = e.dataTransfer.files;
            
            // Trigger the change event manually
            const event = new Event('change');
            fileInput.dispatchEvent(event);
        }
    });
});

 */