document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        // const headerHeight = document.querySelector('#header').offsetHeight;
        const headerHeight = 0;
        const additionalOffset = 0; // Adjust if necessary
        const targetId = this.getAttribute('href').substring(1);
        const targetElement = document.getElementById(targetId);

        if (targetElement) {
            const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset;
            const offsetPosition = targetPosition - headerHeight - additionalOffset;

            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
        }
    });
});

// Page load scroll adjustment with delay
window.addEventListener('load', function () {
    if (window.location.hash) {
        setTimeout(() => {
            const headerHeight = document.querySelector('#header').offsetHeight;
            const additionalOffset = 10; // Adjust if necessary
            const targetId = window.location.hash.substring(1);
            const targetElement = document.getElementById(targetId);

            if (targetElement) {
                const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset;
                const offsetPosition = targetPosition - headerHeight - additionalOffset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        }, 600); // Delay in milliseconds
    }
});
