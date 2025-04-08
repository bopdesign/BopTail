import { CountUp } from '../../../assets/library/countUp/countUp.min.js';

const handleStatsAnimation = () => {
	const statsBlock = document.querySelectorAll('.block-stats');
	statsBlock.forEach(row => {
		const stats = row.querySelectorAll('.stat');
		stats.forEach(statEl => {
			const countUp = new CountUp(statEl, statEl.dataset.stat, {
				enableScrollSpy: true,
				scrollSpyDelay: 250,
				scrollSpyOnce: true,
				duration: 2,
			});
		});
	});
};

// Add event listener
window.addEventListener('load', handleStatsAnimation);
