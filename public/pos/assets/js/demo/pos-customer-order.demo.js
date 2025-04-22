document.querySelectorAll('.nav-link').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const filter = this.getAttribute('data-filter');
        document.querySelectorAll('.pos-product').forEach(card => {
            const type = card.closest('[data-type]')?.getAttribute('data-type');
            if (filter === 'all' || filter === type) {
                card.closest('.col-xxl-3').style.display = 'block';
            } else {
                card.closest('.col-xxl-3').style.display = 'none';
            }
        });
        document.querySelectorAll('.nav-link').forEach(nav => nav.classList.remove('active'));
        this.classList.add('active');
    });
});
