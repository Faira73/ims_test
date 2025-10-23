const modal = document.getElementById('popupModal');
        const btn = document.getElementById('openPopupBtn');
        const closeBtn = document.querySelector('.close');

        // Open modal
        btn.onclick = function() {
            modal.style.display = 'block';
        }

        // Close modal when X is clicked
        closeBtn.onclick = function() {
            modal.style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }