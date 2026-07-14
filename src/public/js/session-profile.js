'use strict';

(function initSessionProfile() {
  const profile = document.getElementById('admin-profile');
  const logoutButton = document.getElementById('header-logout');

  if (!profile || !logoutButton) return;

  fetch('/api/session')
    .then((response) => {
      if (!response.ok) throw new Error('No active session');
      return response.json();
    })
    .then(() => {
      profile.hidden = false;
    })
    .catch(() => {
      profile.hidden = true;
    });

  logoutButton.addEventListener('click', async () => {
    logoutButton.disabled = true;

    try {
      await fetch('/api/logout', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' }
      });
      window.location.href = '/login.html';
    } catch (error) {
      logoutButton.disabled = false;
      alert('No se pudo cerrar la sesión. Inténtalo nuevamente.');
    }
  });
})();
