// Enable Bootstrap tooltips
$(document).ready(function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Confirm delete action
$(document).ready(function() {
    $('[data-delete-confirm]').on('click', function(e) {
        if (!confirm('Biztosan törölni szeretnéd ezt a hírt?')) {
            e.preventDefault();
        }
    });
});

// Image preview before upload
$(document).ready(function() {
    const imageInput = $('input[type="file"][accept*="image"]');
    if (imageInput.length > 0) {
        imageInput.on('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = $('<img>').attr({
                        src: e.target.result,
                        className: 'img-thumbnail mt-2',
                        style: 'max-height: 200px'
                    });
                    
                    const container = imageInput.parent();
                    const existingPreview = container.find('img');
                    if (existingPreview.length > 0) {
                        existingPreview.remove();
                    }
                    container.append(preview);
                };
                reader.readAsDataURL(file);
            }
        });
    }
}); 