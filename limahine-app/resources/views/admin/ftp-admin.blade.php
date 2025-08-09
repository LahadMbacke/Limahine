<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration FTP - Limahine</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto py-8 px-4">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-800 mb-8">Administration FTP - Gestion des Médias</h1>
            
            <!-- Statut de connexion -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">État de la connexion FTP</h2>
                <div id="connection-status" class="mb-4">
                    <div class="flex items-center">
                        <div id="status-indicator" class="w-3 h-3 rounded-full bg-gray-400 mr-3"></div>
                        <span id="status-text">Vérification en cours...</span>
                    </div>
                </div>
                <button id="test-connection" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition-colors">
                    Tester la connexion
                </button>
            </div>

            <!-- Informations FTP -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Informations du serveur FTP</h2>
                <div id="ftp-info">
                    <div class="text-gray-500">Chargement des informations...</div>
                </div>
                <button id="refresh-info" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded transition-colors mt-4">
                    Actualiser les informations
                </button>
            </div>

            <!-- Statut de migration -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Statut de la migration</h2>
                <div id="migration-status">
                    <div class="text-gray-500">Chargement du statut...</div>
                </div>
                <div id="progress-bar" class="w-full bg-gray-200 rounded-full h-4 mt-4 hidden">
                    <div id="progress-fill" class="bg-blue-500 h-4 rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>
                <button id="refresh-status" class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded transition-colors mt-4">
                    Actualiser le statut
                </button>
            </div>

            <!-- Migration -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Migration des médias</h2>
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                <strong>Attention :</strong> La migration va déplacer tous vos fichiers média vers le serveur FTP. 
                                Assurez-vous que la connexion FTP fonctionne correctement avant de continuer.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div id="migration-result" class="hidden mb-4"></div>
                
                <button id="start-migration" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    Démarrer la migration
                </button>
            </div>

            <!-- Log d'activité -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Log d'activité</h2>
                <div id="activity-log" class="bg-gray-50 p-4 rounded border max-h-64 overflow-y-auto">
                    <div class="text-gray-500 text-sm">Page chargée à {{ now()->format('d/m/Y H:i:s') }}</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Configuration
        const API_BASE = '/admin/ftp';
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Elements DOM
        const statusIndicator = document.getElementById('status-indicator');
        const statusText = document.getElementById('status-text');
        const testConnectionBtn = document.getElementById('test-connection');
        const ftpInfo = document.getElementById('ftp-info');
        const refreshInfoBtn = document.getElementById('refresh-info');
        const migrationStatus = document.getElementById('migration-status');
        const refreshStatusBtn = document.getElementById('refresh-status');
        const progressBar = document.getElementById('progress-bar');
        const progressFill = document.getElementById('progress-fill');
        const startMigrationBtn = document.getElementById('start-migration');
        const migrationResult = document.getElementById('migration-result');
        const activityLog = document.getElementById('activity-log');

        // Fonctions utilitaires
        function logActivity(message, type = 'info') {
            const timestamp = new Date().toLocaleString('fr-FR');
            const colors = {
                info: 'text-blue-600',
                success: 'text-green-600',
                error: 'text-red-600',
                warning: 'text-yellow-600'
            };
            
            const logEntry = document.createElement('div');
            logEntry.className = `text-sm ${colors[type] || colors.info} mb-1`;
            logEntry.innerHTML = `<span class="text-gray-500">[${timestamp}]</span> ${message}`;
            
            activityLog.appendChild(logEntry);
            activityLog.scrollTop = activityLog.scrollHeight;
        }

        function updateConnectionStatus(isConnected, message = '') {
            statusIndicator.className = `w-3 h-3 rounded-full mr-3 ${isConnected ? 'bg-green-500' : 'bg-red-500'}`;
            statusText.textContent = message || (isConnected ? 'Connexion FTP active' : 'Connexion FTP échouée');
        }

        // API calls
        async function apiCall(endpoint, options = {}) {
            try {
                const response = await fetch(`${API_BASE}${endpoint}`, {
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        ...options.headers
                    },
                    ...options
                });

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }

                return await response.json();
            } catch (error) {
                logActivity(`Erreur API: ${error.message}`, 'error');
                throw error;
            }
        }

        // Fonctions principales
        async function testConnection() {
            testConnectionBtn.disabled = true;
            testConnectionBtn.textContent = 'Test en cours...';
            logActivity('Test de connexion FTP en cours...');

            try {
                const result = await apiCall('/test-connection');
                updateConnectionStatus(result.success, result.message);
                logActivity(result.message, result.success ? 'success' : 'error');
            } catch (error) {
                updateConnectionStatus(false, 'Erreur lors du test');
                logActivity(`Erreur lors du test de connexion: ${error.message}`, 'error');
            } finally {
                testConnectionBtn.disabled = false;
                testConnectionBtn.textContent = 'Tester la connexion';
            }
        }

        async function loadFtpInfo() {
            ftpInfo.innerHTML = '<div class="text-gray-500">Chargement...</div>';
            
            try {
                const result = await apiCall('/info');
                
                if (result.success) {
                    const info = result.data;
                    ftpInfo.innerHTML = `
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <strong>Statut de connexion:</strong> 
                                <span class="${info.connection_ok ? 'text-green-600' : 'text-red-600'}">
                                    ${info.connection_ok ? '✅ Connecté' : '❌ Déconnecté'}
                                </span>
                            </div>
                            <div><strong>Nombre de fichiers:</strong> ${info.files_count || 0}</div>
                            <div><strong>Nombre de dossiers:</strong> ${info.directories_count || 0}</div>
                        </div>
                        ${info.error ? `<div class="text-red-600 mt-2">Erreur: ${info.error}</div>` : ''}
                    `;
                    logActivity('Informations FTP chargées', 'success');
                } else {
                    ftpInfo.innerHTML = '<div class="text-red-600">Erreur lors du chargement des informations</div>';
                }
            } catch (error) {
                ftpInfo.innerHTML = '<div class="text-red-600">Erreur de connexion</div>';
            }
        }

        async function loadMigrationStatus() {
            migrationStatus.innerHTML = '<div class="text-gray-500">Chargement...</div>';
            
            try {
                const result = await apiCall('/status');
                
                if (result.success) {
                    const data = result.data;
                    const progress = data.migration_progress || 0;
                    
                    migrationStatus.innerHTML = `
                        <div class="grid grid-cols-2 gap-4">
                            <div><strong>Total des médias:</strong> ${data.total_media}</div>
                            <div><strong>Sur FTP:</strong> ${data.ftp_media}</div>
                            <div><strong>Locaux:</strong> ${data.local_media}</div>
                            <div><strong>Publics:</strong> ${data.public_media}</div>
                        </div>
                        <div class="mt-2">
                            <strong>Progression:</strong> ${progress.toFixed(1)}%
                        </div>
                    `;
                    
                    progressBar.classList.remove('hidden');
                    progressFill.style.width = `${progress}%`;
                    
                    logActivity(`Statut de migration chargé: ${progress.toFixed(1)}% migré`, 'success');
                } else {
                    migrationStatus.innerHTML = '<div class="text-red-600">Erreur lors du chargement du statut</div>';
                }
            } catch (error) {
                migrationStatus.innerHTML = '<div class="text-red-600">Erreur de connexion</div>';
            }
        }

        async function startMigration() {
            if (!confirm('Êtes-vous sûr de vouloir démarrer la migration ? Cette opération peut prendre du temps.')) {
                return;
            }

            startMigrationBtn.disabled = true;
            startMigrationBtn.textContent = 'Migration en cours...';
            migrationResult.classList.add('hidden');
            logActivity('Démarrage de la migration...', 'warning');

            try {
                const result = await apiCall('/migrate', { method: 'POST' });
                
                if (result.success) {
                    const data = result.data;
                    migrationResult.innerHTML = `
                        <div class="bg-green-50 border border-green-200 rounded p-4">
                            <h3 class="font-semibold text-green-800">Migration terminée avec succès !</h3>
                            <div class="mt-2 text-sm text-green-700">
                                <div>✅ Fichiers migrés: ${data.success}</div>
                                <div>❌ Échecs: ${data.failed}</div>
                                ${data.errors && data.errors.length > 0 ? `
                                    <div class="mt-2">
                                        <strong>Erreurs:</strong>
                                        <ul class="list-disc list-inside">
                                            ${data.errors.map(err => `<li>${err.file_name}: ${err.error}</li>`).join('')}
                                        </ul>
                                    </div>
                                ` : ''}
                            </div>
                        </div>
                    `;
                    logActivity(`Migration terminée: ${data.success} réussis, ${data.failed} échecs`, 'success');
                } else {
                    migrationResult.innerHTML = `
                        <div class="bg-red-50 border border-red-200 rounded p-4">
                            <h3 class="font-semibold text-red-800">Erreur lors de la migration</h3>
                            <div class="mt-2 text-sm text-red-700">${result.message}</div>
                        </div>
                    `;
                    logActivity(`Erreur de migration: ${result.message}`, 'error');
                }
                
                migrationResult.classList.remove('hidden');
                loadMigrationStatus(); // Rafraîchir le statut
            } catch (error) {
                migrationResult.innerHTML = `
                    <div class="bg-red-50 border border-red-200 rounded p-4">
                        <h3 class="font-semibold text-red-800">Erreur de connexion</h3>
                        <div class="mt-2 text-sm text-red-700">${error.message}</div>
                    </div>
                `;
                migrationResult.classList.remove('hidden');
            } finally {
                startMigrationBtn.disabled = false;
                startMigrationBtn.textContent = 'Démarrer la migration';
            }
        }

        // Event listeners
        testConnectionBtn.addEventListener('click', testConnection);
        refreshInfoBtn.addEventListener('click', loadFtpInfo);
        refreshStatusBtn.addEventListener('click', loadMigrationStatus);
        startMigrationBtn.addEventListener('click', startMigration);

        // Chargement initial
        document.addEventListener('DOMContentLoaded', () => {
            logActivity('Interface d\'administration FTP chargée');
            testConnection();
            loadFtpInfo();
            loadMigrationStatus();
        });

        // Rafraîchissement automatique du statut toutes les 30 secondes
        setInterval(loadMigrationStatus, 30000);
    </script>
</body>
</html>
