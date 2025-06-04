<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo Dashboard - Terinspirasi Any.do</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            color: #333;
        }
        
        .container {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar styling */
        .sidebar {
            width: 250px;
            background-color: #ffffff;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            display: flex;
            flex-direction: column;
        }
        
        .logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 30px;
            color: #2979ff;
            display: flex;
            align-items: center;
        }
        
        .logo-icon {
            margin-right: 10px;
            font-size: 28px;
        }
        
        .menu-item {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .menu-item:hover {
            background-color: #f0f0f0;
        }
        
        .menu-item.active {
            background-color: #e3f2fd;
            color: #2979ff;
            font-weight: 500;
        }
        
        .menu-icon {
            margin-right: 12px;
            font-size: 20px;
            width: 24px;
            text-align: center;
        }
        
        .new-list-btn {
            margin-top: auto;
            background-color: #2979ff;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .new-list-btn:hover {
            background-color: #2069e0;
        }
        
        /* Main content area */
        .main-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .page-title {
            font-size: 24px;
            font-weight: 600;
        }
        
        .search-bar {
            display: flex;
            background: white;
            border-radius: 8px;
            padding: 10px 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            width: 700px;
        }
        
        .search-bar input {
            border: none;
            outline: none;
            width: 100%;
            margin-left: 8px;
        }
        
        .user-menu {
            display: flex;
            align-items: center;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e3f2fd;
            color: #2979ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-left: 15px;
            cursor: pointer;
        }
        
        /* Task list styling */
        .task-section {
            margin-bottom: 40px;
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #555;
        }
        
        .task-count {
            background-color: #e3f2fd;
            color: #2979ff;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }
        
        .task-list {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        
        .task-item {
            display: flex;
            align-items: center;
            padding: 16px 20px;
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.2s;
        }
        
        .task-item:last-child {
            border-bottom: none;
        }
        
        .task-item:hover {
            background-color: #fafafa;
        }
        
        .task-checkbox {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid #ddd;
            margin-right: 15px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .task-checkbox.done {
            background-color: #4caf50;
            border-color: #4caf50;
            color: white;
        }
        
        .task-content {
            flex: 1;
        }
        
        .task-title {
            margin-bottom: 4px;
            font-weight: 500;
        }
        
        .task-title.done {
            text-decoration: line-through;
            color: #999;
        }
        
        .task-details {
            display: flex;
            align-items: center;
            font-size: 14px;
            color: #888;
        }
        
        .task-date {
            display: flex;
            align-items: center;
            margin-right: 15px;
        }
        
        .task-category {
            display: flex;
            align-items: center;
        }
        
        .category-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 5px;
        }
        
        .priority-indicator {
            width: 4px;
            height: 40px;
            border-radius: 2px;
            margin-right: 15px;
        }
        
        .priority-high {
            background-color: #f44336;
        }
        
        .priority-medium {
            background-color: #ff9800;
        }
        
        .priority-low {
            background-color: #4caf50;
        }
        
        .category-work {
            background-color: #5e35b1;
        }
        
        .category-personal {
            background-color: #00897b;
        }
        
        .category-shopping {
            background-color: #ec407a;
        }
        
        .add-task {
            display: flex;
            align-items: center;
            padding: 16px 20px;
            cursor: pointer;
            color: #888;
            font-weight: 500;
        }
        
        .add-task:hover {
            background-color: #f5f5f5;
        }
        
        .add-icon {
            font-size: 20px;
            margin-right: 10px;
            color: #2979ff;
        }
        
        /* Stat cards */
        .stats-row {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            flex: 1;
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
        }
        
        .stat-value {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #888;
            font-size: 14px;
        }
        
        .stat-progress {
            margin-top: 15px;
            height: 6px;
            background-color: #f0f0f0;
            border-radius: 3px;
            overflow: hidden;
        }
        
        .progress-bar {
            height: 100%;
            border-radius: 3px;
        }
        
        .progress-blue {
            background-color: #2979ff;
        }
        
        .progress-green {
            background-color: #4caf50;
        }
        
        .progress-orange {
            background-color: #ff9800;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
                padding: 15px;
            }
            
            .main-content {
                padding: 15px;
            }
            
            .search-bar {
                width: 100%;
                max-width: 300px;
            }
            
            .stats-row {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">
                <span class="logo-icon">✓</span>
                <span>TodoList</span>
            </div>
            
            <div class="menu-item active">
                <span class="menu-icon">📋</span>
                <span>Semua Tugas</span>
            </div>
            
            <div class="menu-item">
                <span class="menu-icon">📅</span>
                <span>Hari Ini</span>
            </div>
            
            <div class="menu-item">
                <span class="menu-icon">⭐</span>
                <span>Penting</span>
            </div>
            
            <div class="menu-item">
                <span class="menu-icon">📁</span>
                <span>Pekerjaan</span>
            </div>
            
            <div class="menu-item">
                <span class="menu-icon">🏠</span>
                <span>Pribadi</span>
            </div>
            
            <div class="menu-item">
                <span class="menu-icon">🛒</span>
                <span>Belanja</span>
            </div>
            
            <button class="new-list-btn">
                <span>+ Daftar Baru</span>
            </button>
        </div>
        
        <!-- Main content -->
        <div class="main-content">
            <div class="header">
                <h1 class="page-title">Dashboard</h1>
                
                <div class="search-bar">
                    <span>🔍</span>
                    <input type="text" placeholder="Cari tugas...">
                </div>
                
                <div class="user-menu">
                    <div class="user-avatar">U</div>
                </div>
            </div>
            
            <!-- Stats row -->
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-value">12</div>
                    <div class="stat-label">Total Tugas</div>
                    <div class="stat-progress">
                        <div class="progress-bar progress-blue" style="width: 100%;"></div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-value">7</div>
                    <div class="stat-label">Tugas Selesai</div>
                    <div class="stat-progress">
                        <div class="progress-bar progress-green" style="width: 60%;"></div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-value">5</div>
                    <div class="stat-label">Tugas Tersisa</div>
                    <div class="stat-progress">
                        <div class="progress-bar progress-orange" style="width: 40%;"></div>
                    </div>
                </div>
            </div>
            
            <!-- Today's Tasks -->
            <div class="task-section">
                <div class="section-header">
                    <h2 class="section-title">Tugas Hari Ini</h2>
                    <span class="task-count">3</span>
                </div>
                
                <div class="task-list">
                    <div class="task-item">
                        <div class="priority-indicator priority-high"></div>
                        <div class="task-checkbox"></div>
                        <div class="task-content">
                            <div class="task-title">Pertemuan tim pukul 10:00</div>
                            <div class="task-details">
                                <div class="task-date">🕙 10:00 - 11:30</div>
                                <div class="task-category">
                                    <div class="category-indicator category-work"></div>
                                    <span>Pekerjaan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="task-item">
                        <div class="priority-indicator priority-medium"></div>
                        <div class="task-checkbox"></div>
                        <div class="task-content">
                            <div class="task-title">Selesaikan laporan bulanan</div>
                            <div class="task-details">
                                <div class="task-date">🕔 16:00</div>
                                <div class="task-category">
                                    <div class="category-indicator category-work"></div>
                                    <span>Pekerjaan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="task-item">
                        <div class="priority-indicator priority-low"></div>
                        <div class="task-checkbox"></div>
                        <div class="task-content">
                            <div class="task-title">Belanja bahan makanan</div>
                            <div class="task-details">
                                <div class="task-date">🕕 17:30</div>
                                <div class="task-category">
                                    <div class="category-indicator category-shopping"></div>
                                    <span>Belanja</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="add-task">
                        <span class="add-icon">+</span>
                        <span>Tambah tugas baru</span>
                    </div>
                </div>
            </div>
            
            <!-- Upcoming Tasks -->
            <div class="task-section">
                <div class="section-header">
                    <h2 class="section-title">Tugas Mendatang</h2>
                    <span class="task-count">2</span>
                </div>
                
                <div class="task-list">
                    <div class="task-item">
                        <div class="priority-indicator priority-medium"></div>
                        <div class="task-checkbox"></div>
                        <div class="task-content">
                            <div class="task-title">Presentasi proyek baru</div>
                            <div class="task-details">
                                <div class="task-date">📅 Besok</div>
                                <div class="task-category">
                                    <div class="category-indicator category-work"></div>
                                    <span>Pekerjaan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="task-item">
                        <div class="priority-indicator priority-low"></div>
                        <div class="task-checkbox"></div>
                        <div class="task-content">
                            <div class="task-title">Kunjungan dokter gigi</div>
                            <div class="task-details">
                                <div class="task-date">📅 25 Mei 2025</div>
                                <div class="task-category">
                                    <div class="category-indicator category-personal"></div>
                                    <span>Pribadi</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="add-task">
                        <span class="add-icon">+</span>
                        <span>Tambah tugas baru</span>
                    </div>
                </div>
            </div>
            
            <!-- Completed Tasks -->
            <div class="task-section">
                <div class="section-header">
                    <h2 class="section-title">Tugas Selesai</h2>
                    <span class="task-count">7</span>
                </div>
                
                <div class="task-list">
                    <div class="task-item">
                        <div class="priority-indicator priority-medium"></div>
                        <div class="task-checkbox done">✓</div>
                        <div class="task-content">
                            <div class="task-title done">Membayar tagihan listrik</div>
                            <div class="task-details">
                                <div class="task-date">📅 Kemarin</div>
                                <div class="task-category">
                                    <div class="category-indicator category-personal"></div>
                                    <span>Pribadi</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="task-item">
                        <div class="priority-indicator priority-high"></div>
                        <div class="task-checkbox done">✓</div>
                        <div class="task-content">
                            <div class="task-title done">Kirim proposal ke klien</div>
                            <div class="task-details">
                                <div class="task-date">📅 20 Mei 2025</div>
                                <div class="task-category">
                                    <div class="category-indicator category-work"></div>
                                    <span>Pekerjaan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="task-item">
                        <div class="priority-indicator priority-low"></div>
                        <div class="task-checkbox done">✓</div>
                        <div class="task-content">
                            <div class="task-title done">Membeli hadiah ulang tahun</div>
                            <div class="task-details">
                                <div class="task-date">📅 19 Mei 2025</div>
                                <div class="task-category">
                                    <div class="category-indicator category-shopping"></div>
                                    <span>Belanja</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="add-task">
                        <span class="add-icon">+</span>
                        <span>Tambah tugas baru</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Sederhana toggle checkbox
        document.querySelectorAll('.task-checkbox').forEach(checkbox => {
            checkbox.addEventListener('click', function() {
                this.classList.toggle('done');
                this.parentElement.querySelector('.task-title').classList.toggle('done');
                if (this.classList.contains('done')) {
                    this.innerHTML = '✓';
                } else {
                    this.innerHTML = '';
                }
            });
        });
    </script>
</body>
</html>