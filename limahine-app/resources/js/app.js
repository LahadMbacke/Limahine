import './bootstrap';
import { initApp, Modal, Toast, FormHandler } from './components';

// Initialiser l'application
initApp();

// Exposer les classes globalement pour utilisation dans les templates Blade
window.Modal = Modal;
window.Toast = Toast;
window.FormHandler = FormHandler;
