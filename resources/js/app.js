

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.store('ui', {
	sidebarCollapsed: window.localStorage.getItem('sidebar-collapsed') === '1',
	toggleSidebar() {
		this.sidebarCollapsed = !this.sidebarCollapsed;
		window.localStorage.setItem('sidebar-collapsed', this.sidebarCollapsed ? '1' : '0');
	},
});

Alpine.start();
