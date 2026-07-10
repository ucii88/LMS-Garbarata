

import Alpine from 'alpinejs';

window.Alpine = Alpine;

window.scrollToPartRow = function(no) {
	const row = document.getElementById("part-row-" + no);
	if (row) {
		row.scrollIntoView({ behavior: "smooth", block: "center" });
		
		// Remove highlight class from all rows first
		document.querySelectorAll('[id^="part-row-"]').forEach(r => {
			r.classList.remove("bg-blue-50", "text-blue-900", "font-semibold");
		});
		
		// Add highlight class
		row.classList.add("bg-blue-50", "text-blue-900", "font-semibold");
		
		// Remove highlight after 2 seconds
		setTimeout(() => {
			row.classList.remove("bg-blue-50", "text-blue-900", "font-semibold");
		}, 2000);
	}
};

window.scrollToRollerRow = function(no) {
	let tab = 1;
	if (no >= 7 && no <= 12) {
		tab = 2;
	} else if (no >= 13 && no <= 16) {
		tab = 3;
	}
	
	window.dispatchEvent(new CustomEvent("switch-detail-tab", { detail: { tab: tab } }));
	
	setTimeout(() => {
		const hotspot = document.getElementById("roller-hotspot-" + no);
		if (hotspot) {
			hotspot.classList.add("ring-8", "ring-blue-500/50", "bg-blue-600/40", "scale-125");
			setTimeout(() => {
				hotspot.classList.remove("ring-8", "ring-blue-500/50", "bg-blue-600/40", "scale-125");
			}, 2500);
		}
	}, 100);
	
	const row = document.getElementById("roller-row-" + no);
	if (row) {
		row.scrollIntoView({ behavior: "smooth", block: "center" });
		
		document.querySelectorAll('[id^="roller-row-"]').forEach(r => {
			r.classList.remove("bg-blue-50", "text-blue-900", "font-semibold");
		});
		
		row.classList.add("bg-blue-50", "text-blue-900", "font-semibold");
		
		setTimeout(() => {
			row.classList.remove("bg-blue-50", "text-blue-900", "font-semibold");
		}, 2000);
	}
};

window.scrollToCableRow = function(no) {
	const row = document.getElementById("cable-row-" + no);
	if (row) {
		row.scrollIntoView({ behavior: "smooth", block: "center" });
		
		document.querySelectorAll('[id^="cable-row-"]').forEach(r => {
			r.classList.remove("bg-blue-50", "text-blue-900", "font-semibold");
		});
		
		row.classList.add("bg-blue-50", "text-blue-900", "font-semibold");
		
		setTimeout(() => {
			row.classList.remove("bg-blue-50", "text-blue-900", "font-semibold");
		}, 2000);
	}
};

window.scrollToLiftRow = function(no) {
	const row = document.getElementById("lift-row-" + no);
	if (row) {
		row.scrollIntoView({ behavior: "smooth", block: "center" });
		
		document.querySelectorAll('[id^="lift-row-"]').forEach(r => {
			r.classList.remove("bg-blue-50", "text-blue-900", "font-semibold");
		});
		
		row.classList.add("bg-blue-50", "text-blue-900", "font-semibold");
		
		setTimeout(() => {
			row.classList.remove("bg-blue-50", "text-blue-900", "font-semibold");
		}, 2000);
	}
};

window.scrollToBogieRow = function(no) {
	const row = document.getElementById("bogie-row-" + no);
	if (row) {
		row.scrollIntoView({ behavior: "smooth", block: "center" });
		
		document.querySelectorAll('[id^="bogie-row-"]').forEach(r => {
			r.classList.remove("bg-blue-50", "text-blue-900", "font-semibold");
		});
		
		row.classList.add("bg-blue-50", "text-blue-900", "font-semibold");
		
		setTimeout(() => {
			row.classList.remove("bg-blue-50", "text-blue-900", "font-semibold");
		}, 2000);
	}
};

window.scrollToStairRow = function(no) {
	const row = document.getElementById("stair-row-" + no);
	if (row) {
		row.scrollIntoView({ behavior: "smooth", block: "center" });
		
		document.querySelectorAll('[id^="stair-row-"]').forEach(r => {
			r.classList.remove("bg-blue-50", "text-blue-900", "font-semibold");
		});
		
		row.classList.add("bg-blue-50", "text-blue-900", "font-semibold");
		
		setTimeout(() => {
			row.classList.remove("bg-blue-50", "text-blue-900", "font-semibold");
		}, 2000);
	}
};

window.scrollToRotationRow = function(no) {
	const row = document.getElementById("rotation-row-" + no);
	if (row) {
		row.scrollIntoView({ behavior: "smooth", block: "center" });
		
		document.querySelectorAll('[id^="rotation-row-"]').forEach(r => {
			r.classList.remove("bg-blue-50", "text-blue-900", "font-semibold");
		});
		
		row.classList.add("bg-blue-50", "text-blue-900", "font-semibold");
		
		setTimeout(() => {
			row.classList.remove("bg-blue-50", "text-blue-900", "font-semibold");
		}, 2000);
	}
};

window.scrollToCurtainRow = function(no) {
	const row = document.getElementById("curtain-row-" + no);
	if (row) {
		row.scrollIntoView({ behavior: "smooth", block: "center" });
		
		document.querySelectorAll('[id^="curtain-row-"]').forEach(r => {
			r.classList.remove("bg-blue-50", "text-blue-900", "font-semibold");
		});
		
		row.classList.add("bg-blue-50", "text-blue-900", "font-semibold");
		
		setTimeout(() => {
			row.classList.remove("bg-blue-50", "text-blue-900", "font-semibold");
		}, 2000);
	}
};

window.scrollToLevelerRow = function(no) {
	const row = document.getElementById("leveler-row-" + no);
	if (row) {
		row.scrollIntoView({ behavior: "smooth", block: "center" });
		
		document.querySelectorAll('[id^="leveler-row-"]').forEach(r => {
			r.classList.remove("bg-blue-50", "text-blue-900", "font-semibold");
		});
		
		row.classList.add("bg-blue-50", "text-blue-900", "font-semibold");
		
		setTimeout(() => {
			row.classList.remove("bg-blue-50", "text-blue-900", "font-semibold");
		}, 2000);
	}
};

window.scrollToClosureRow = function(no) {
	const row = document.getElementById("closure-row-" + no);
	if (row) {
		row.scrollIntoView({ behavior: "smooth", block: "center" });
		
		document.querySelectorAll('[id^="closure-row-"]').forEach(r => {
			r.classList.remove("bg-blue-50", "text-blue-900", "font-semibold");
		});
		
		row.classList.add("bg-blue-50", "text-blue-900", "font-semibold");
		
		setTimeout(() => {
			row.classList.remove("bg-blue-50", "text-blue-900", "font-semibold");
		}, 2000);
	}
};

window.scrollToSwingRow = function(no) {
	const row = document.getElementById("swing-row-" + no);
	if (row) {
		row.scrollIntoView({ behavior: "smooth", block: "center" });
		
		document.querySelectorAll('[id^="swing-row-"]').forEach(r => {
			r.classList.remove("bg-blue-50", "text-blue-900", "font-semibold");
		});
		
		row.classList.add("bg-blue-50", "text-blue-900", "font-semibold");
		
		setTimeout(() => {
			row.classList.remove("bg-blue-50", "text-blue-900", "font-semibold");
		}, 2000);
	}
};

window.scrollToWeatheringRow = function(no) {
	const row = document.getElementById("weathering-row-" + no);
	if (row) {
		row.scrollIntoView({ behavior: "smooth", block: "center" });
		
		document.querySelectorAll('[id^="weathering-row-"]').forEach(r => {
			r.classList.remove("bg-blue-50", "text-blue-900", "font-semibold");
		});
		
		row.classList.add("bg-blue-50", "text-blue-900", "font-semibold");
		
		setTimeout(() => {
			row.classList.remove("bg-blue-50", "text-blue-900", "font-semibold");
		}, 2000);
	}
};

window.scrollToEqualizerRow = function(no) {
	const row = document.getElementById("equalizer-row-" + no);
	if (row) {
		row.scrollIntoView({ behavior: "smooth", block: "center" });
		
		document.querySelectorAll('[id^="equalizer-row-"]').forEach(r => {
			r.classList.remove("bg-blue-50", "text-blue-900", "font-semibold");
		});
		
		row.classList.add("bg-blue-50", "text-blue-900", "font-semibold");
		
		setTimeout(() => {
			row.classList.remove("bg-blue-50", "text-blue-900", "font-semibold");
		}, 2000);
	}
};

function wrapTablesUnderHeading(parsedDocument, root, headingSelector, summaryTitle, titleToneClass = 'text-blue-600') {
	const headings = Array.from(root.querySelectorAll('h4'));
	const heading = headings.find((node) => node.textContent?.trim().includes(headingSelector));

	if (!heading) {
		return;
	}

	const tableDivs = [];
	let nextNode = heading.nextSibling;
	while (nextNode) {
		const currentNode = nextNode;
		nextNode = nextNode.nextSibling;

		if (currentNode.nodeType === Node.ELEMENT_NODE) {
			if (currentNode.tagName === 'H4') {
				break;
			}
			if (currentNode.classList.contains('overflow-x-auto')) {
				tableDivs.push(currentNode);
			}
		}
	}

	if (tableDivs.length === 0) {
		return;
	}

	const details = parsedDocument.createElement('details');
	details.className = 'group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm my-4';

	const summary = parsedDocument.createElement('summary');
	summary.className = 'flex cursor-pointer list-none items-start justify-between gap-4 bg-slate-50 px-4 py-4 transition hover:bg-slate-100';
	summary.innerHTML = `
		<div class="min-w-0">
			<div class="text-[10px] font-black uppercase tracking-[0.25em] ${titleToneClass}">${summaryTitle}</div>
			<p class="mt-1 text-xs leading-relaxed text-slate-600">Klik untuk melihat isi tabel dan detail inspeksi.</p>
		</div>
		<span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-white text-slate-500 shadow ring-1 ring-slate-200 transition group-open:rotate-180">
			<svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
				<path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
			</svg>
		</span>
	`;

	const contentWrapper = parsedDocument.createElement('div');
	contentWrapper.className = 'border-t border-slate-200 p-4 space-y-4';

	details.appendChild(summary);
	details.appendChild(contentWrapper);

	const firstTable = tableDivs[0];
	if (firstTable) {
		firstTable.before(details);
	}

	for (const node of tableDivs) {
		contentWrapper.appendChild(node);
	}
}

function wrapExpandableSections(parsedDocument, root, headingPrefix, summaryToneClass = 'text-blue-600') {
	const headings = Array.from(root.querySelectorAll('h4')).filter((heading) => heading.textContent?.trim().startsWith(headingPrefix));

	for (const heading of headings) {
		if (!heading.parentNode) {
			continue;
		}

		const details = parsedDocument.createElement('details');
		details.className = 'group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm my-5';

		const summary = parsedDocument.createElement('summary');
		summary.className = 'flex cursor-pointer list-none items-start justify-between gap-4 bg-slate-50 px-4 py-4 transition hover:bg-slate-100';
		summary.innerHTML = `
			<div class="min-w-0">
				<div class="text-[10px] font-black uppercase tracking-[0.25em] ${summaryToneClass}">${heading.textContent.trim()}</div>
				<p class="mt-1 text-xs leading-relaxed text-slate-600">Klik untuk melihat gambar, tabel, dan detail komponen.</p>
			</div>
			<span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-white text-slate-500 shadow ring-1 ring-slate-200 transition group-open:rotate-180">
				<svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
				</svg>
			</span>
		`;

		const contentWrapper = parsedDocument.createElement('div');
		contentWrapper.className = 'border-t border-slate-200 p-4 space-y-4';

		let currentNode = heading.nextSibling;
		while (currentNode) {
			const nextNode = currentNode.nextSibling;
			if (currentNode.nodeType === Node.ELEMENT_NODE && currentNode.tagName === 'H4') {
				break;
			}
			contentWrapper.appendChild(currentNode);
			currentNode = nextNode;
		}

		heading.parentNode.insertBefore(details, heading);
		details.appendChild(summary);
		details.appendChild(contentWrapper);
		heading.remove();
	}
}

Alpine.data('studyPage', (modules = []) => ({
		activeModuleId: modules[0] ? modules[0].id : null,
		modules,
		getActiveModule() {
			return this.modules.find((module) => module.id === this.activeModuleId) || { title: '', content: '', image_path: null };
		},
		renderModuleContent(content) {
			if (!content) {
				return '';
			}

			if (!content.includes('TROUBLE') && !content.includes('4.6.3 Inspeksi Bulanan') && !content.includes('4.6.4 Inspeksi Quartal') && !content.includes('5.1.1. Rotunda Assembly')) {
				return content;
			}

			const parser = new DOMParser();
			const parsedDocument = parser.parseFromString(`<div id="root">${content}</div>`, 'text/html');
			const root = parsedDocument.getElementById('root');

			if (!root) {
				return content;
			}

			if (content.includes('4.6.3 Inspeksi Bulanan')) {
				wrapTablesUnderHeading(parsedDocument, root, '4.6.3 Inspeksi Bulanan', 'Tabel Inspeksi Bulanan', 'text-blue-600');
			}

			if (content.includes('4.6.4 Inspeksi Quartal')) {
				wrapTablesUnderHeading(parsedDocument, root, '4.6.4 Inspeksi Quartal', 'Tabel Inspeksi Quartal', 'text-blue-600');
			}

			if (content.includes('5.1.1. Rotunda Assembly')) {
				wrapExpandableSections(parsedDocument, root, '5.1.', 'text-blue-600');
			}

			const troubleHeadings = Array.from(root.querySelectorAll('h5')).filter((heading) => heading.textContent?.trim().toUpperCase().includes('TROUBLE'));

			const processedBlocks = new Set();

			troubleHeadings.forEach((heading) => {
				const block = heading.closest('div.rounded-xl.border.border-red-200.bg-white.p-4.shadow-sm.mt-6, div.rounded-xl.border.border-red-200.bg-white.p-4.shadow-sm');

				if (!block || processedBlocks.has(block)) {
					return;
				}

				processedBlocks.add(block);

				const header = block.firstElementChild;
				const title = heading.textContent ? heading.textContent.trim() : 'TROUBLE';
				const description = header?.querySelector('p')?.textContent?.trim() || '';

				const details = parsedDocument.createElement('details');
				details.className = 'group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm';

				const summary = parsedDocument.createElement('summary');
				summary.className = 'flex cursor-pointer list-none items-start justify-between gap-4 bg-slate-50 px-4 py-4 transition hover:bg-slate-100';
				summary.innerHTML = `
					<div class="min-w-0">
						<div class="text-xs font-bold text-slate-800 leading-snug">
							<span class="text-rose-600 font-black uppercase tracking-wider mr-1.5">${title}</span>
							${description ? `: ${description}` : ''}
						</div>
						<p class="mt-1 text-[11px] leading-relaxed text-slate-500 font-medium">Klik untuk melihat isi tabel secara detail</p>
					</div>
					<span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-white text-slate-500 shadow ring-1 ring-slate-200 transition group-open:rotate-180">
						<svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
						</svg>
					</span>
				`;

				const contentWrapper = parsedDocument.createElement('div');
				contentWrapper.className = 'border-t border-slate-200 p-4 space-y-4';

				while (block.children.length > 1) {
					contentWrapper.appendChild(block.children[1]);
				}

				details.appendChild(summary);
				details.appendChild(contentWrapper);
				block.replaceWith(details);
			});

			return root.innerHTML;
		},
		nextModule() {
			const index = this.modules.findIndex((module) => module.id === this.activeModuleId);
			if (index !== -1 && index < this.modules.length - 1) {
				this.activeModuleId = this.modules[index + 1].id;
			}
		},
		prevModule() {
			const index = this.modules.findIndex((module) => module.id === this.activeModuleId);
			if (index > 0) {
				this.activeModuleId = this.modules[index - 1].id;
			}
		},
		isFirst() {
			return this.modules.findIndex((module) => module.id === this.activeModuleId) === 0;
		},
		isLast() {
			return this.modules.findIndex((module) => module.id === this.activeModuleId) === this.modules.length - 1;
		},
	}));

Alpine.store('ui', {
	sidebarCollapsed: window.localStorage.getItem('sidebar-collapsed') === '1',
	toggleSidebar() {
		this.sidebarCollapsed = !this.sidebarCollapsed;
		window.localStorage.setItem('sidebar-collapsed', this.sidebarCollapsed ? '1' : '0');
	},
});

Alpine.start();
