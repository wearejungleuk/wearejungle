export const fadeInOnScroll = () => {
	const selectorsToObserve = ['.js-fade-up', '.js-fade-in'];

	if (useFadeInEffects()) {
		const observer = new IntersectionObserver((entries) => {
			entries.forEach((entry) => {
				if (entry.isIntersecting) {
					// Add class to elements when they enter the viewport
					entry.target.classList.add('is-intersecting');
				}
			});
		});

		selectorsToObserve.forEach((selector) => {
			const selectors = document.querySelectorAll(selector);
			selectors.forEach((selector) => observer.observe(selector));
		});
	} else {
		// If intersection observer not supported, just show everything on page load
		selectorsToObserve.forEach((selector) => {
			const selectors = document.querySelectorAll(selector);
			selectors.forEach((selector) => selector.classList.add('is-intersecting'));
		});
	}
};

const useFadeInEffects = () => !!window.IntersectionObserver;

fadeInOnScroll();