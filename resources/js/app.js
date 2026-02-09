import './bootstrap';
import Alpine from 'alpinejs';
import { tourSteps } from './tour-steps';

window.Alpine = Alpine;
Alpine.start();

// User Onboarding Tour
document.addEventListener('DOMContentLoaded', () => {
    // Only run if userTourData is provided by the layout
    if (window.userTourData) {
        const { hasSeenTour, userRole, tourCompleteUrl, csrfToken } = window.userTourData;

        // Only run if user hasn't seen the tour and we have steps for their role
        if (!hasSeenTour && tourSteps[userRole]) {
            // Check if driver.js is available (loaded via CDN or bundle)
            const driver = window.driver && window.driver.js ? window.driver.js.driver : null;

            if (driver) {
                const tour = driver({
                    showProgress: true,
                    steps: tourSteps[userRole],
                    onDestroyed: () => {
                        // Mark tour as complete via AJAX
                        fetch(tourCompleteUrl, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Content-Type': 'application/json'
                            }
                        }).then(() => {
                            window.userTourData.hasSeenTour = true;
                        }).catch(err => console.error('Gagal menyimpan status tour:', err));
                    }
                });

                tour.drive();
            }
        }
    }
});
