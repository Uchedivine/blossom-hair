<div id="toast-container"
     style="position:fixed;bottom:24px;right:24px;z-index:9999;display:flex;flex-direction:column;gap:10px;max-width:340px;width:calc(100vw - 48px);"
     aria-live="polite"
     aria-atomic="false">
</div>

<style>
.blossom-toast {
    background: rgba(17, 5, 8, 0.88);
    backdrop-filter: blur(28px);
    -webkit-backdrop-filter: blur(28px);
    border-radius: 16px;
    padding: 14px 16px;
    display: flex;
    align-items: flex-start;
    gap: 12px;
    animation: toastIn 0.35s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
    box-shadow: 0 20px 60px rgba(0,0,0,0.4), 0 0 0 1px rgba(255,255,255,0.08);
    cursor: default;
    position: relative;
    overflow: hidden;
}
.blossom-toast::before {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 3px;
    border-radius: 16px 0 0 16px;
}
.blossom-toast.toast-success::before { background: rgba(74,222,128,0.8); }
.blossom-toast.toast-error::before   { background: rgba(239,68,68,0.8); }
.blossom-toast.toast-warning::before { background: rgba(245,158,11,0.8); }
.blossom-toast.toast-info::before    { background: rgba(96,165,250,0.8); }

.blossom-toast.toast-exit {
    animation: toastOut 0.28s ease-in forwards;
}

@keyframes toastIn {
    from { opacity: 0; transform: translateY(16px) scale(0.95); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
}
@keyframes toastOut {
    from { opacity: 1; transform: translateY(0) scale(1); }
    to   { opacity: 0; transform: translateY(8px) scale(0.97); }
}

.toast-icon {
    width: 32px; height: 32px; flex-shrink: 0;
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
}
.toast-success .toast-icon { background: rgba(74,222,128,0.15); }
.toast-error   .toast-icon { background: rgba(239,68,68,0.15); }
.toast-warning .toast-icon { background: rgba(245,158,11,0.15); }
.toast-info    .toast-icon { background: rgba(96,165,250,0.15); }

.toast-title {
    font-size: 13px; font-weight: 500;
    color: rgba(255,255,255,0.9);
    line-height: 1.3; margin: 0 0 2px;
}
.toast-message {
    font-size: 12px; color: rgba(255,255,255,0.45);
    margin: 0; line-height: 1.5;
}
.toast-action {
    font-size: 12px; font-weight: 500; color: #fda4af;
    background: none; border: none; cursor: pointer; padding: 0;
    text-decoration: underline; transition: opacity 0.2s;
}
.toast-action:hover { opacity: 0.7; }
.toast-close {
    background: none; border: none; cursor: pointer;
    color: rgba(255,255,255,0.2); padding: 0; margin-left: auto;
    flex-shrink: 0; transition: color 0.2s;
}
.toast-close:hover { color: rgba(255,255,255,0.6); }
</style>

<script>
function showToast({ type = 'info', title, message, actions = [], duration = 4500 }) {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const icons = {
        success: `<svg width="16" height="16" style="color:rgba(74,222,128,0.9);" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>`,
        error:   `<svg width="16" height="16" style="color:rgba(239,68,68,0.9);" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>`,
        warning: `<svg width="16" height="16" style="color:rgba(245,158,11,0.9);" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>`,
        info:    `<svg width="16" height="16" style="color:rgba(96,165,250,0.9);" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>`,
    };

    const toast = document.createElement('div');
    toast.className = `blossom-toast toast-${type}`;
    toast.setAttribute('role', 'alert');

    let actionsHtml = '';
    if (actions.length > 0) {
        actionsHtml = `<div style="margin-top:6px;display:flex;gap:10px;">`;
        actions.forEach((action, idx) => {
            actionsHtml += `<button class="toast-action" data-action-idx="${idx}">${action.label}</button>`;
        });
        actionsHtml += `</div>`;
    }

    toast.innerHTML = `
        <div class="toast-icon">${icons[type] || icons.info}</div>
        <div style="flex:1;min-width:0;">
            ${title ? `<p class="toast-title">${title}</p>` : ''}
            ${message ? `<p class="toast-message">${message}</p>` : ''}
            ${actionsHtml}
        </div>
        <button class="toast-close" aria-label="Close notification">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    `;

    toast.querySelectorAll('[data-action-idx]').forEach(btn => {
        btn.addEventListener('click', () => {
            const idx = parseInt(btn.dataset.actionIdx);
            if (actions[idx]?.callback) actions[idx].callback();
            removeToast(toast);
        });
    });

    toast.querySelector('.toast-close').addEventListener('click', () => removeToast(toast));

    container.appendChild(toast);

    const timer = setTimeout(() => removeToast(toast), duration);
    toast._timer = timer;

    toast.addEventListener('mouseenter', () => clearTimeout(toast._timer));
    toast.addEventListener('mouseleave', () => {
        toast._timer = setTimeout(() => removeToast(toast), 2000);
    });

    return toast;
}

function removeToast(toast) {
    clearTimeout(toast._timer);
    toast.classList.add('toast-exit');
    toast.addEventListener('animationend', () => toast.remove(), { once: true });
}
</script>