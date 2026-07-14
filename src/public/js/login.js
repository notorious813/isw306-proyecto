'use strict';

const loginView = document.querySelector('#login-view');
const dashboardView = document.querySelector('#dashboard-view');
const loginForm = document.querySelector('#login-form');
const formMessage = document.querySelector('#form-message');
const submitButton = document.querySelector('#submit-button');
const logoutButton = document.querySelector('#logout-button');
const passwordInput = document.querySelector('#password');
const togglePassword = document.querySelector('#toggle-password');

function showDashboard(user) {
  if (user) window.location.replace('/');
}

function showLogin() {
  dashboardView.hidden = true;
  loginView.hidden = false;
  loginForm.reset();
  formMessage.textContent = '';
}

async function request(url, options = {}) {
  const response = await fetch(url, {
    headers: { 'Content-Type': 'application/json', ...options.headers },
    ...options
  });

  if (!response.ok) {
    const data = await response.json().catch(() => ({}));
    throw new Error(data.message || 'Ocurrió un error. Inténtalo nuevamente.');
  }

  return response.status === 204 ? null : response.json();
}

loginForm.addEventListener('submit', async (event) => {
  event.preventDefault();
  formMessage.textContent = '';
  if (!loginForm.reportValidity()) return;

  submitButton.disabled = true;
  submitButton.textContent = 'Ingresando…';

  try {
    const data = await request('/api/login', {
      method: 'POST',
      body: JSON.stringify({ email: loginForm.email.value, password: loginForm.password.value })
    });
    showDashboard(data.user);
  } catch (error) {
    formMessage.textContent = error.message;
  } finally {
    submitButton.disabled = false;
    submitButton.textContent = 'Entrar';
  }
});

logoutButton.addEventListener('click', async () => {
  logoutButton.disabled = true;
  try {
    await request('/api/logout', { method: 'POST' });
    showLogin();
  } catch (error) {
    alert(error.message);
  } finally {
    logoutButton.disabled = false;
  }
});

togglePassword.addEventListener('click', () => {
  const isHidden = passwordInput.type === 'password';
  passwordInput.type = isHidden ? 'text' : 'password';
  togglePassword.textContent = isHidden ? 'Ocultar' : 'Ver';
});

request('/api/session').then(({ user }) => showDashboard(user)).catch(() => showLogin());
