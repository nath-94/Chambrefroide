<?php include 'includes/header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Chambre Froide - Musée</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e0e0e0;
        }

        .header h1 {
            color: #333;
            font-size: 2.5em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header p {
            color: #666;
            font-size: 1.1em;
        }

        .status-indicator {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-left: 10px;
            animation: pulse 2s infinite;
        }

        .status-online {
            background: #4CAF50;
        }

        .status-offline {
            background: #f44336;
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }

        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .metric-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-left: 5px solid #667eea;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .metric-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .metric-card.temperature {
            border-left-color: #e74c3c;
        }

        .metric-card.humidity {
            border-left-color: #3498db;
        }

        .metric-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .metric-icon {
            font-size: 2em;
            margin-right: 15px;
        }

        .metric-title {
            font-size: 1.2em;
            color: #333;
            font-weight: 600;
        }

        .metric-value {
            font-size: 3em;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .metric-unit {
            font-size: 0.8em;
            color: #666;
        }

        .metric-status {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: 500;
            margin-top: 10px;
        }

        .status-optimal {
            background: #d4edda;
            color: #155724;
        }

        .status-warning {
            background: #fff3cd;
            color: #856404;
        }

        .status-critical {
            background: #f8d7da;
            color: #721c24;
        }

        .chart-container {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .chart-title {
            font-size: 1.3em;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .chart-placeholder {
            height: 300px;
            background: linear-gradient(45deg, #f8f9fa, #e9ecef);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-size: 1.1em;
            border: 2px dashed #dee2e6;
        }

        .controls {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 25px;
            font-size: 1em;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .btn-primary {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: #f8f9fa;
            color: #333;
            border: 2px solid #dee2e6;
        }

        .btn-secondary:hover {
            background: #e9ecef;
        }

        .alerts {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .alerts-title {
            font-size: 1.3em;
            color: #333;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .alert-item {
            padding: 12px 20px;
            margin-bottom: 10px;
            border-radius: 10px;
            border-left: 4px solid;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .alert-warning {
            background: #fff8e1;
            border-left-color: #ffa000;
            color: #e65100;
        }

        .alert-info {
            background: #e3f2fd;
            border-left-color: #1976d2;
            color: #0d47a1;
        }

        .timestamp {
            font-size: 0.9em;
            color: #666;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            color: #666;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            
            .metrics-grid {
                grid-template-columns: 1fr;
            }
            
            .header h1 {
                font-size: 2em;
            }
            
            .metric-value {
                font-size: 2.5em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏛️ Monitoring Chambre Froide</h1>
            <p>Conservation des Œuvres d'Art - Musée National</p>
            <span id="connectionStatus">Connexion: <span class="status-indicator status-online"></span></span>
        </div>

        <div class="controls">
            <button class="btn btn-primary" onclick="refreshData()">🔄 Actualiser</button>
            <button class="btn btn-secondary" onclick="toggleAutoRefresh()">⏱️ Auto-refresh</button>
            <button class="btn btn-secondary" onclick="exportData()">📊 Exporter</button>
        </div>

        <div class="metrics-grid">
            <div class="metric-card temperature">
                <div class="metric-header">
                    <div class="metric-icon">🌡️</div>
                    <div class="metric-title">Température</div>
                </div>
                <div class="metric-value" id="temperature">18.5<span class="metric-unit">°C</span></div>
                <div class="metric-status status-optimal" id="tempStatus">Optimal</div>
            </div>

            <div class="metric-card humidity">
                <div class="metric-header">
                    <div class="metric-icon">💧</div>
                    <div class="metric-title">Humidité</div>
                </div>
                <div class="metric-value" id="humidity">45.2<span class="metric-unit">%</span></div>
                <div class="metric-status status-optimal" id="humidityStatus">Optimal</div>
            </div>
        </div>

        <div class="chart-container">
            <div class="chart-title">📈 Évolution sur 24h</div>
            <div class="chart-placeholder" id="chart">
                Graphique des données historiques
                <br><small>Intégration avec Chart.js ou bibliothèque similaire</small>
            </div>
        </div>

        <div class="alerts">
            <div class="alerts-title">🔔 Alertes et Notifications</div>
            <div id="alertsList">
                <div class="alert-item alert-info">
                    <span>Système de monitoring démarré</span>
                    <span class="timestamp">Il y a 2 minutes</span>
                </div>
                <div class="alert-item alert-warning">
                    <span>Humidité légèrement élevée détectée</span>
                    <span class="timestamp">Il y a 15 minutes</span>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>Dernière mise à jour: <span id="lastUpdate">--:--</span> | Capteur DHT11 | Système de Conservation Musée</p>
        </div>
    </div>

    <script>
        // Variables globales
        let autoRefreshInterval;
        let isAutoRefreshEnabled = false;

        // Simulation de données (à remplacer par les vraies données du capteur)
        const sensorData = {
            temperature: 18.5,
            humidity: 45.2,
            timestamp: new Date().toLocaleString('fr-FR')
        };

        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            initializeApp();
            updateDisplay();
        });

        function initializeApp() {
            console.log('Application de monitoring initialisée');
            
            // Charger les données initiales
            fetchSensorData();
            
            // Charger l'historique pour le graphique
            loadHistoryData(24);
            
            updateLastUpdateTime();
            
            // Démarrage de l'auto-refresh par défaut
            toggleAutoRefresh();
        }

        // Fonction pour mettre à jour le graphique (placeholder)
        function updateChart(historicalData) {
            // Ici vous pourriez intégrer Chart.js ou une autre bibliothèque
            console.log('Données pour le graphique:', historicalData);
            
            // Exemple d'intégration simple
            const chartElement = document.getElementById('chart');
            if (historicalData && historicalData.length > 0) {
                chartElement.innerHTML = `
                    <div style="text-align: center; padding: 50px;">
                        📊 ${historicalData.length} mesures sur les dernières 24h
                        <br><br>
                        <small>Température: ${Math.min(...historicalData.map(d => d.temperature))}°C - ${Math.max(...historicalData.map(d => d.temperature))}°C</small>
                        <br>
                        <small>Humidité: ${Math.min(...historicalData.map(d => d.humidity))}% - ${Math.max(...historicalData.map(d => d.humidity))}%</small>
                    </div>
                `;
            }
        }

        function updateDisplay() {
            // Mise à jour des valeurs affichées
            document.getElementById('temperature').innerHTML = 
                sensorData.temperature + '<span class="metric-unit">°C</span>';
            document.getElementById('humidity').innerHTML = 
                sensorData.humidity + '<span class="metric-unit">%</span>';

            // Mise à jour des statuts
            updateTemperatureStatus(sensorData.temperature);
            updateHumidityStatus(sensorData.humidity);
            
            updateLastUpdateTime();
        }

        function updateTemperatureStatus(temp) {
            const statusElement = document.getElementById('tempStatus');
            statusElement.className = 'metric-status';
            
            if (temp >= 16 && temp <= 20) {
                statusElement.classList.add('status-optimal');
                statusElement.textContent = 'Optimal';
            } else if ((temp >= 14 && temp < 16) || (temp > 20 && temp <= 22)) {
                statusElement.classList.add('status-warning');
                statusElement.textContent = 'Attention';
            } else {
                statusElement.classList.add('status-critical');
                statusElement.textContent = 'Critique';
            }
        }

        function updateHumidityStatus(humidity) {
            const statusElement = document.getElementById('humidityStatus');
            statusElement.className = 'metric-status';
            
            if (humidity >= 40 && humidity <= 50) {
                statusElement.classList.add('status-optimal');
                statusElement.textContent = 'Optimal';
            } else if ((humidity >= 35 && humidity < 40) || (humidity > 50 && humidity <= 55)) {
                statusElement.classList.add('status-warning');
                statusElement.textContent = 'Attention';
            } else {
                statusElement.classList.add('status-critical');
                statusElement.textContent = 'Critique';
            }
        }

        function refreshData() {
            console.log('Actualisation des données...');
            
            // Utiliser les vraies données au lieu de la simulation
            fetchSensorData();
            
            // Animation de chargement
            const tempElement = document.getElementById('temperature');
            const humidityElement = document.getElementById('humidity');
            
            tempElement.style.opacity = '0.5';
            humidityElement.style.opacity = '0.5';
            
            setTimeout(() => {
                tempElement.style.opacity = '1';
                humidityElement.style.opacity = '1';
            }, 500);
        }

        function toggleAutoRefresh() {
            if (isAutoRefreshEnabled) {
                clearInterval(autoRefreshInterval);
                isAutoRefreshEnabled = false;
                console.log('Auto-refresh désactivé');
            } else {
                autoRefreshInterval = setInterval(refreshData, 30000); // 30 secondes
                isAutoRefreshEnabled = true;
                console.log('Auto-refresh activé');
            }
            
            const btn = document.querySelector('.btn-secondary');
            btn.textContent = isAutoRefreshEnabled ? '⏸️ Pause Auto' : '⏱️ Auto-refresh';
        }

        function exportData() {
            console.log('Export des données...');
            
            // Export via l'API au lieu de données simulées
            const format = 'json'; // ou 'csv'
            const hours = 24;
            
            fetch(`api/sensor-data.php?action=export&format=${format}&hours=${hours}`)
                .then(response => {
                    if (format === 'csv') {
                        return response.text();
                    } else {
                        return response.json();
                    }
                })
                .then(data => {
                    if (format === 'csv') {
                        // Télécharger le CSV
                        const blob = new Blob([data], { type: 'text/csv' });
                        const url = URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = `donnees_capteur_${new Date().toISOString().split('T')[0]}.csv`;
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                        URL.revokeObjectURL(url);
                    } else {
                        // Télécharger le JSON
                        const jsonData = JSON.stringify(data, null, 2);
                        const blob = new Blob([jsonData], { type: 'application/json' });
                        const url = URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = `donnees_capteur_${new Date().toISOString().split('T')[0]}.json`;
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                        URL.revokeObjectURL(url);
                    }
                    
                    addAlert('Données exportées avec succès', 'info');
                })
                .catch(error => {
                    console.error('Erreur lors de l\'export:', error);
                    addAlert('Erreur lors de l\'export des données', 'warning');
                });
        }

        function addAlert(message, type) {
            const alertsList = document.getElementById('alertsList');
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert-item alert-${type}`;
            alertDiv.innerHTML = `
                <span>${message}</span>
                <span class="timestamp">À l'instant</span>
            `;
            
            alertsList.insertBefore(alertDiv, alertsList.firstChild);
            
            // Limiter à 5 alertes maximum
            if (alertsList.children.length > 5) {
                alertsList.removeChild(alertsList.lastChild);
            }
        }

        function updateLastUpdateTime() {
            document.getElementById('lastUpdate').textContent = 
                new Date().toLocaleTimeString('fr-FR');
        }

        // Fonction AJAX pour récupérer les vraies données du capteur
        function fetchSensorData() {
            fetch('api/sensor-data.php?action=latest')
                .then(response => response.json())
                .then(data => {
                    if (data.temperature && data.humidity) {
                        sensorData.temperature = data.temperature;
                        sensorData.humidity = data.humidity;
                        sensorData.timestamp = data.timestamp;
                        updateDisplay();
                        
                        // Gestion des alertes basées sur le statut
                        if (data.status === 'critical') {
                            addAlert('Conditions critiques détectées !', 'warning');
                        } else if (data.status === 'warning') {
                            addAlert('Conditions sous-optimales', 'info');
                        }
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de la récupération des données:', error);
                    addAlert('Erreur de connexion au capteur', 'warning');
                    
                    // Passer en mode offline
                    document.querySelector('.status-indicator').className = 'status-indicator status-offline';
                });
        }

        // Fonction pour sauvegarder des données (si vous voulez envoyer des données)
        function sendSensorData(temperature, humidity) {
            fetch('api/sensor-data.php?action=save', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    temperature: temperature,
                    humidity: humidity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Données sauvegardées:', data.message);
                    
                    // Afficher les alertes s'il y en a
                    if (data.alerts && data.alerts.length > 0) {
                        data.alerts.forEach(alert => {
                            addAlert(alert.message, alert.type);
                        });
                    }
                } else {
                    console.error('Erreur:', data.error);
                }
            })
            .catch(error => {
                console.error('Erreur lors de l\'envoi:', error);
            });
        }

        // Fonction pour récupérer l'historique
        function loadHistoryData(hours = 24) {
            fetch(`api/sensor-data.php?action=history&hours=${hours}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Données historiques:', data);
                    // Ici vous pourriez dessiner un graphique avec ces données
                    updateChart(data);
                })
                .catch(error => {
                    console.error('Erreur historique:', error);
                });
        }

        // Fonction pour récupérer les statistiques
        function loadStatistics() {
            fetch('api/sensor-data.php?action=stats&hours=24')
                .then(response => response.json())
                .then(stats => {
                    console.log('Statistiques:', stats);
                    // Afficher les stats dans l'interface si besoin
                })
                .catch(error => {
                    console.error('Erreur stats:', error);
                });
        }

        // Gestion des erreurs réseau
        window.addEventListener('online', function() {
            document.querySelector('.status-indicator').className = 'status-indicator status-online';
            addAlert('Connexion rétablie', 'info');
        });

        window.addEventListener('offline', function() {
            document.querySelector('.status-indicator').className = 'status-indicator status-offline';
            addAlert('Connexion perdue', 'warning');
        });
    </script>
</body>
</html>