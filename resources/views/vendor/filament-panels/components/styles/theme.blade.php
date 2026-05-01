<style>
    /* Blossom Hair Custom Theme */
    
    /* Custom Pink Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: transparent;
    }

    ::-webkit-scrollbar-thumb {
        background: rgb(236, 72, 153);
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: rgb(219, 39, 119);
    }

    .dark ::-webkit-scrollbar-thumb {
        background: rgb(244, 114, 182);
    }

    .dark ::-webkit-scrollbar-thumb:hover {
        background: rgb(249, 168, 212);
    }

    /* Mobile Optimizations */
    @media (max-width: 768px) {
        /* Better touch targets */
        .fi-ta-actions button,
        .fi-ta-actions a {
            min-height: 44px;
            min-width: 44px;
        }
        
        /* Improved table scrolling */
        .fi-ta-table {
            font-size: 0.875rem;
        }
        
        /* Better form spacing on mobile */
        .fi-fo-field-wrp {
            margin-bottom: 1rem;
        }
        
        /* Mobile navigation improvements */
        .fi-topbar {
            position: sticky;
            top: 0;
            z-index: 40;
            backdrop-filter: blur(8px);
        }
        
        .fi-sidebar-nav {
            padding-bottom: 5rem;
        }
        
        /* Improved mobile forms */
        .fi-fo-component-ctn {
            padding: 0.75rem;
        }
    }

    /* Tablet Optimizations */
    @media (min-width: 768px) and (max-width: 1024px) {
        .fi-sidebar {
            width: 16rem;
        }
    }

    /* Better focus states for accessibility */
    button:focus-visible,
    a:focus-visible,
    input:focus-visible,
    select:focus-visible,
    textarea:focus-visible {
        outline: 2px solid rgb(236, 72, 153);
        outline-offset: 2px;
    }

    /* Smooth transitions */
    .fi-sidebar,
    .fi-topbar,
    .fi-main {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Print styles */
    @media print {
        .fi-sidebar,
        .fi-topbar,
        .fi-ta-actions {
            display: none !important;
        }
        
        .fi-main {
            margin: 0 !important;
            padding: 0 !important;
        }
    }

    /* Loading states */
    .fi-ta-table-loading {
        opacity: 0.6;
        pointer-events: none;
    }

    /* Improved sidebar branding */
    .fi-sidebar-header {
        padding: 1.5rem 1rem;
    }

    /* Better mobile sidebar */
    @media (max-width: 1024px) {
        .fi-sidebar-close-overlay {
            backdrop-filter: blur(4px);
        }
    }
</style>
