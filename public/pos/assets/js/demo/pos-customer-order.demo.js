// document.querySelectorAll('.nav-link').forEach(btn => {
//     btn.addEventListener('click', function(e) {
//         e.preventDefault();
//         const filter = this.getAttribute('data-filter');
//         document.querySelectorAll('.pos-product').forEach(card => {
//             const type = card.closest('[data-type]')?.getAttribute('data-type');
//             if (filter === 'all' || filter === type) {
//                 card.closest('.col-xxl-3').style.display = 'block';
//             } else {
//                 card.closest('.col-xxl-3').style.display = 'none';
//             }
//         });
//         document.querySelectorAll('.nav-link').forEach(nav => nav.classList.remove('active'));
//         this.classList.add('active');
//     });
// });

document.querySelectorAll('.pos-menu .nav-link').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();

        const filter = this.getAttribute('data-filter');

        document.querySelectorAll('.product-item').forEach(item => {
            const type = item.getAttribute('data-type');
            if (filter === 'all' || filter === type) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });

        // Manage active class on nav links
        document.querySelectorAll('.pos-menu .nav-link').forEach(nav => nav.classList.remove('active'));
        this.classList.add('active');
    });
});

