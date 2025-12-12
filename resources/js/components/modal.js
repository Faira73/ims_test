document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('[data-modal-target]');
    
    buttons.forEach(button => {
        button.addEventListener('click', () => {
            const targetId = button.getAttribute('data-modal-target');
            const modal = document.getElementById(targetId);
            if(modal) modal.style.display = 'block';
        });
    });

    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) modal.style.display = 'none';
        });
    });
});
