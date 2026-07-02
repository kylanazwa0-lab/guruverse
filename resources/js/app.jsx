import React from 'react';
import { createRoot } from 'react-dom/client';
import { MagneticDock, DockIconHome, DockIconSearch, DockIconFolder, DockIconSettings } from '@/components/ui/magnetic-dock';
import '@/resources/css/app.css';

const dockItems = [
    {
        id: 'home',
        label: 'Beranda',
        icon: <DockIconHome />,
        onClick: () => window.location.href = '/',
        isActive: true,
    },
    {
        id: 'courses',
        label: 'Kelas',
        icon: <DockIconFolder />,
        onClick: () => window.location.href = '/guru-belajar',
    },
    {
        id: 'search',
        label: 'Cari',
        icon: <DockIconSearch />,
        onClick: () => console.log('Search clicked'),
    },
    {
        id: 'settings',
        label: 'Pengaturan',
        icon: <DockIconSettings />,
        onClick: () => window.location.href = '/admin',
    }
];

function App() {
    return (
        <div className="fixed bottom-6 left-1/2 -translate-x-1/2 z-50">
            <MagneticDock items={dockItems} iconSize={48} maxScale={1.3} />
        </div>
    );
}

const rootElement = document.getElementById('magnetic-dock-root');
if (rootElement) {
    const root = createRoot(rootElement);
    root.render(<App />);
}
