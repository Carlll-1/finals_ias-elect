/* ============================================================
   FACE LOCK SYSTEM — Main JavaScript
   ============================================================ */

/* ── Navbar scroll effect ─────────────────────────────────── */
const navbar = document.querySelector('.navbar');
if (navbar) {
  window.addEventListener('scroll', () => {
    navbar.classList.toggle('scrolled', window.scrollY > 20);
  });
}

/* ── Mobile hamburger menu ────────────────────────────────── */
const hamburger = document.getElementById('hamburger');
const mobileMenu = document.getElementById('mobileMenu');
if (hamburger && mobileMenu) {
  hamburger.addEventListener('click', () => {
    mobileMenu.classList.toggle('open');
  });
  document.addEventListener('click', (e) => {
    if (!hamburger.contains(e.target) && !mobileMenu.contains(e.target)) {
      mobileMenu.classList.remove('open');
    }
  });
}

/* ── Dashboard sidebar toggle ─────────────────────────────── */
const sidebar = document.getElementById('sidebar');
const appMain = document.getElementById('appMain');
const sidebarToggle = document.getElementById('sidebarToggle');
const mobileSidebarToggle = document.getElementById('mobileSidebarToggle');
const sidebarOverlay = document.getElementById('sidebarOverlay');

if (sidebarToggle && sidebar) {
  sidebarToggle.addEventListener('click', () => {
    sidebar.classList.toggle('collapsed');
    if (appMain) appMain.classList.toggle('sidebar-collapsed');
  });
}

if (mobileSidebarToggle && sidebar) {
  mobileSidebarToggle.addEventListener('click', () => {
    sidebar.classList.add('mobile-open');
    if (sidebarOverlay) sidebarOverlay.classList.add('active');
  });
}
if (sidebarOverlay) {
  sidebarOverlay.addEventListener('click', () => {
    if (sidebar) sidebar.classList.remove('mobile-open');
    sidebarOverlay.classList.remove('active');
  });
}

/* ── Notification dropdown ────────────────────────────────── */
const notifBtn = document.getElementById('notifBtn');
const notifDropdown = document.getElementById('notifDropdown');
if (notifBtn && notifDropdown) {
  notifBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    notifDropdown.classList.toggle('open');
  });
  document.addEventListener('click', () => notifDropdown.classList.remove('open'));
}

/* ── Modal helpers ────────────────────────────────────────── */
function openModal(id) {
  const el = document.getElementById(id);
  if (el) el.classList.add('open');
}
function closeModal(id) {
  const el = document.getElementById(id);
  if (el) el.classList.remove('open');
}

document.querySelectorAll('[data-open-modal]').forEach(btn => {
  btn.addEventListener('click', () => openModal(btn.dataset.openModal));
});
document.querySelectorAll('[data-close-modal]').forEach(btn => {
  btn.addEventListener('click', () => closeModal(btn.dataset.closeModal));
});
document.querySelectorAll('.modal-overlay').forEach(overlay => {
  overlay.addEventListener('click', (e) => {
    if (e.target === overlay) overlay.classList.remove('open');
  });
});

/* ── Role tabs on login ───────────────────────────────────── */
const roleTabs = document.querySelectorAll('.role-tab');
if (roleTabs.length) {
  roleTabs.forEach(tab => {
    tab.addEventListener('click', () => {
      roleTabs.forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
      const role = tab.dataset.role;
      const adminForm = document.getElementById('adminForm');
      const userForm  = document.getElementById('userForm');
      if (adminForm) adminForm.style.display = role === 'admin' ? 'block' : 'none';
      if (userForm)  userForm.style.display  = role === 'user'  ? 'block' : 'none';
    });
  });
}

/* ── Permission toggles ───────────────────────────────────── */
document.querySelectorAll('.perm-toggle').forEach(toggle => {
  toggle.addEventListener('click', () => {
    toggle.classList.toggle('on');
    const on = toggle.classList.contains('on');
    toggle.setAttribute('aria-checked', on);
    showToast(on ? 'Permission granted' : 'Permission revoked', on ? 'success' : 'warning');
  });
});

/* ── Door toggle ──────────────────────────────────────────── */
const doorToggle = document.getElementById('doorToggle');
const doorStatus = document.getElementById('doorStatus');
const doorIcon   = document.getElementById('doorIcon');
if (doorToggle) {
  let isLocked = true;
  doorToggle.addEventListener('click', () => {
    isLocked = !isLocked;
    if (doorStatus) doorStatus.textContent = isLocked ? 'Locked' : 'Unlocked';
    if (doorIcon)   doorIcon.textContent   = isLocked ? '🔒' : '🔓';
    doorToggle.textContent = isLocked ? 'Unlock Door' : 'Lock Door';
    showToast(isLocked ? 'Door locked successfully' : 'Door unlocked successfully', isLocked ? 'warning' : 'success');
  });
}

/* ── User table search ────────────────────────────────────── */
const searchInput = document.getElementById('tableSearch');
if (searchInput) {
  searchInput.addEventListener('input', () => {
    const q = searchInput.value.toLowerCase();
    document.querySelectorAll('.data-table tbody tr').forEach(row => {
      row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
  });
}

/* ── Delete row ───────────────────────────────────────────── */
document.querySelectorAll('.delete-row').forEach(btn => {
  btn.addEventListener('click', () => {
    if (confirm('Delete this user? This cannot be undone.')) {
      btn.closest('tr').remove();
      showToast('User deleted', 'danger');
    }
  });
});

/* ── Add user form ────────────────────────────────────────── */
const addUserForm = document.getElementById('addUserForm');
if (addUserForm) {
  addUserForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const name  = document.getElementById('newName').value.trim();
    const email = document.getElementById('newEmail').value.trim();
    const role  = document.getElementById('newRole').value;
    const dept  = document.getElementById('newDept').value.trim();
    if (!name || !email) return showToast('Please fill all required fields', 'danger');

    const tbody = document.querySelector('#usersTable tbody');
    if (tbody) {
      const initials = name.split(' ').map(n=>n[0]).join('').toUpperCase().slice(0,2);
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>
          <div class="user-cell">
            <div class="mini-avatar">${initials}</div>
            <div class="user-cell-info">
              <div class="name">${escapeHtml(name)}</div>
              <div class="email">${escapeHtml(email)}</div>
            </div>
          </div>
        </td>
        <td><span class="badge badge-pink">${escapeHtml(role)}</span></td>
        <td>${escapeHtml(dept || '—')}</td>
        <td><span class="badge badge-success badge-dot">Active</span></td>
        <td>${new Date().toLocaleDateString('en-US',{month:'short',day:'numeric',year:'numeric'})}</td>
        <td>—</td>
        <td>
          <div class="action-btns">
            <button class="btn btn-ghost btn-sm" title="Edit">✏️</button>
            <button class="btn btn-sm" style="background:#FFE0E0;color:#C62828;" title="Delete" onclick="this.closest('tr').remove();showToast('User deleted','danger')">🗑️</button>
          </div>
        </td>`;
      tbody.prepend(tr);
    }
    closeModal('addUserModal');
    addUserForm.reset();
    showToast(`${name} added successfully`, 'success');
  });
}

/* ── Toast notifications ──────────────────────────────────── */
function showToast(message, type = 'success') {
  let container = document.getElementById('toastContainer');
  if (!container) {
    container = document.createElement('div');
    container.id = 'toastContainer';
    container.style.cssText = 'position:fixed;bottom:24px;right:24px;z-index:9999;display:flex;flex-direction:column;gap:8px;';
    document.body.appendChild(container);
  }
  const colors = {
    success: { bg:'#E8F5E9', border:'#A5D6A7', color:'#1B5E20', icon:'✅' },
    danger:  { bg:'#FFEBEE', border:'#EF9A9A', color:'#B71C1C', icon:'❌' },
    warning: { bg:'#FFF8E1', border:'#FFE082', color:'#E65100', icon:'⚠️' },
    info:    { bg:'#E3F2FD', border:'#90CAF9', color:'#0D47A1', icon:'ℹ️' },
  };
  const c = colors[type] || colors.success;
  const toast = document.createElement('div');
  toast.style.cssText = `
    background:${c.bg};border:1px solid ${c.border};color:${c.color};
    padding:12px 18px;border-radius:10px;
    display:flex;align-items:center;gap:8px;
    font-size:0.875rem;font-weight:600;
    box-shadow:0 4px 16px rgba(0,0,0,0.12);
    animation:slideIn .25s ease;
    min-width:220px;max-width:320px;
  `;
  toast.innerHTML = `<span>${c.icon}</span><span>${message}</span>`;
  const style = document.createElement('style');
  style.textContent = '@keyframes slideIn{from{opacity:0;transform:translateX(20px)}to{opacity:1;transform:translateX(0)}}';
  document.head.appendChild(style);
  container.appendChild(toast);
  setTimeout(() => {
    toast.style.transition = 'opacity .3s,transform .3s';
    toast.style.opacity = '0';
    toast.style.transform = 'translateX(20px)';
    setTimeout(() => toast.remove(), 300);
  }, 3000);
}
window.showToast = showToast;

/* ── Counter animation ────────────────────────────────────── */
function animateCounters() {
  document.querySelectorAll('[data-count]').forEach(el => {
    const target = parseInt(el.dataset.count, 10);
    let current = 0;
    const step = Math.ceil(target / 60);
    const timer = setInterval(() => {
      current = Math.min(current + step, target);
      el.textContent = current.toLocaleString() + (el.dataset.suffix || '');
      if (current >= target) clearInterval(timer);
    }, 20);
  });
}

/* ── IntersectionObserver for counters & fade-in ─────────── */
const observerOptions = { threshold: 0.15 };
const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('visible');
      if (entry.target.querySelector('[data-count]')) animateCounters();
      observer.unobserve(entry.target);
    }
  });
}, observerOptions);

document.querySelectorAll('.observe').forEach(el => observer.observe(el));

/* ── Smooth active nav highlight ──────────────────────────── */
const currentPath = window.location.pathname.split('/').pop();
document.querySelectorAll('.nav-item').forEach(item => {
  const href = item.getAttribute('href');
  if (href && (href === currentPath || href.endsWith(currentPath))) {
    item.classList.add('active');
  }
});

/* ── Face ID upload simulation ───────────────────────────── */
const faceRegBox = document.getElementById('faceRegBox');
if (faceRegBox) {
  faceRegBox.addEventListener('click', () => {
    showToast('Face ID captured successfully!', 'success');
    faceRegBox.innerHTML = `
      <div class="face-reg-icon">✅</div>
      <h4 style="color:var(--pink-dark)">Face ID Registered</h4>
      <p>Face recognition data saved securely</p>
      <button class="btn btn-outline btn-sm" style="margin-top:12px" onclick="resetFaceReg()">Re-register</button>
    `;
  });
}
function resetFaceReg() {
  const box = document.getElementById('faceRegBox');
  if (box) {
    box.innerHTML = `
      <div class="face-reg-icon">📷</div>
      <h4>Register Face ID</h4>
      <p>Click to capture or upload a face photo for recognition</p>
    `;
  }
}
window.resetFaceReg = resetFaceReg;

/* ── Helper: escape HTML ──────────────────────────────────── */
function escapeHtml(str) {
  return str.replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]));
}

/* ── Filter by status ─────────────────────────────────────── */
const statusFilter = document.getElementById('statusFilter');
if (statusFilter) {
  statusFilter.addEventListener('change', () => {
    const val = statusFilter.value.toLowerCase();
    document.querySelectorAll('.data-table tbody tr').forEach(row => {
      const status = row.querySelector('.badge')?.textContent.toLowerCase() || '';
      row.style.display = (!val || status.includes(val)) ? '' : 'none';
    });
  });
}

/* ── Confirm delete modals ────────────────────────────────── */
const confirmDeleteBtn = document.getElementById('confirmDelete');
if (confirmDeleteBtn) {
  confirmDeleteBtn.addEventListener('click', () => {
    closeModal('deleteModal');
    showToast('User removed successfully', 'danger');
  });
}
