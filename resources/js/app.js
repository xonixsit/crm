import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Ensure Alpine starts after Livewire is ready
document.addEventListener('livewire:init', () => {
    if (window.Livewire) {
        Alpine.start();
    } else {
        console.error('Livewire is not defined. Alpine.js entanglement may not work.');
    }
});


