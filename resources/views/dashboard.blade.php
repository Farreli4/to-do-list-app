<?php
// Simulasi data - dalam aplikasi nyata, data ini dari database
$tasks = [
    ['id' => 1, 'title' => 'Meeting dengan klien', 'category' => 'pekerjaan', 'completed' => false],
    ['id' => 2, 'title' => 'Beli groceries', 'category' => 'belanja', 'completed' => false],
    ['id' => 3, 'title' => 'Workout pagi', 'category' => 'pribadi', 'completed' => true],
    ['id' => 4, 'title' => 'Review kode', 'category' => 'pekerjaan', 'completed' => true],
    ['id' => 5, 'title' => 'Bayar tagihan listrik', 'category' => 'pribadi', 'completed' => false],
];

// Filter berdasarkan kategori jika ada parameter
$currentCategory = isset($_GET['category']) ? $_GET['category'] : 'all';
if ($currentCategory != 'all') {
    $tasks = array_filter($tasks, function($task) use ($currentCategory) {
        return $task['category'] == $currentCategory;
    });
}

// Hitung statistik
$totalTasks = count($tasks);
$completedTasks = count(array_filter($tasks, function($task) { return $task['completed']; }));
$pendingTasks = $totalTasks - $completedTasks;
$completedPercentage = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;
$pendingPercentage = $totalTasks > 0 ? ($pendingTasks / $totalTasks) * 100 : 0;

// Filter tugas berdasarkan status
$activeTasks = array_filter($tasks, function($task) { return !$task['completed']; });
$completedTasksList = array_filter($tasks, function($task) { return $task['completed']; });

// Get current page
$currentPage = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// Tentukan judul halaman
function getPageTitle($page, $category) {
    switch($page) {
        case 'pekerjaan': return 'Pekerjaan';
        case 'pribadi': return 'Pribadi';
        case 'belanja': return 'Belanja';
        default: 
            if ($category != 'all') {
                return ucfirst($category);
            }
            return 'Dashboard';
    }
}
?>
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
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }

        .container {
            display: flex;
            height: 100vh;
            max-width: 1400px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            margin: 10px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(255, 255, 255, 0.2);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 40px;
            padding: 10px;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
        }

        .logo span:last-child {
            font-size: 24px;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 20px;
            margin-bottom: 8px;
            text-decoration: none;
            color: #666;
            border-radius: 15px;
            transition: all 0.3s ease;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .menu-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.8), transparent);
            transition: left 0.5s ease;
        }

        .menu-item:hover::before {
            left: 100%;
        }

        .menu-item:hover {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            transform: translateX(5px);
        }

        .menu-item.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .menu-item.active:hover {
            transform: translateX(0);
        }

        .menu-icon {
            font-size: 20px;
            width: 24px;
            text-align: center;
        }

        .new-list-btn {
            margin-top: auto;
            padding: 15px 20px;
            background: linear-gradient(135deg, #ff6b6b, #ee5a24);
            border: none;
            border-radius: 15px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(255, 107, 107, 0.3);
        }

        .new-list-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(255, 107, 107, 0.4);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 30px 40px;
            background: rgba(255, 255, 255, 0.05);
            overflow-y: auto;
        }

        /* Header */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 40px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .page-title {
            font-size: 36px;
            font-weight: 700;
            color: white;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .search-bar {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 25px;
            padding: 12px 20px;
            gap: 10px;
            min-width: 300px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .search-bar:focus-within {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .search-bar input {
            border: none;
            outline: none;
            background: transparent;
            flex: 1;
            font-size: 16px;
            color: #333;
        }

        .search-bar input::placeholder {
            color: #999;
        }

        .user-menu {
            display: flex;
            align-items: center;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #4ecdc4, #44a08d);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(78, 205, 196, 0.3);
        }

        .user-avatar:hover {
            transform: scale(1.1);
        }

        /* Stats Row */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .stat-value {
            font-size: 42px;
            font-weight: 700;
            color: #333;
            margin-bottom: 8px;
        }

        .stat-label {
            color: #666;
            font-weight: 500;
            margin-bottom: 15px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-progress {
            height: 8px;
            background: #f0f0f0;
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            border-radius: 10px;
            transition: width 0.8s ease;
        }

        .progress-blue {
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .progress-green {
            background: linear-gradient(90deg, #4ecdc4, #44a08d);
        }

        .progress-orange {
            background: linear-gradient(90deg, #ff9a56, #ff6b6b);
        }

        /* Task Sections */
        .task-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .task-section:hover {
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.15);
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f5f5f5;
        }

        .section-title {
            font-size: 24px;
            font-weight: 600;
            color: #333;
        }

        .task-count {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            min-width: 40px;
            text-align: center;
        }

        .task-list {
            min-height: 100px;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-icon {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.7;
        }

        .empty-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #666;
        }

        .empty-description {
            font-size: 16px;
            line-height: 1.5;
            max-width: 400px;
            margin: 0 auto;
        }

        /* Task Items */
        .task-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 20px;
            margin-bottom: 15px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .task-item:hover {
            transform: translateX(5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .task-checkbox {
            width: 20px;
            height: 20px;
            border: 2px solid #ddd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .task-checkbox.completed {
            background: linear-gradient(135deg, #4ecdc4, #44a08d);
            border-color: #4ecdc4;
            color: white;
        }

        .task-text {
            flex: 1;
            font-size: 16px;
            color: #333;
        }

        .task-text.completed {
            text-decoration: line-through;
            color: #999;
        }

        .task-category {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 500;
            text-transform: capitalize;
        }

        /* Navigation Button */
        .nav-button {
            background: linear-gradient(135deg, #4ecdc4, #44a08d);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }

        .nav-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(78, 205, 196, 0.3);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                margin: 5px;
                border-radius: 15px;
                flex-direction: column;
                height: auto;
                min-height: 100vh;
            }
            
            .sidebar {
                width: 100%;
                padding: 20px;
                order: 2;
            }
            
            .main-content {
                padding: 20px;
                order: 1;
            }
            
            .header {
                flex-direction: column;
                align-items: stretch;
                gap: 15px;
            }
            
            .search-bar {
                min-width: auto;
            }
            
            .stats-row {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .page-title {
                font-size: 28px;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .stat-card {
                padding: 20px;
            }
            
            .stat-value {
                font-size: 32px;
            }
            
            .task-section {
                padding: 20px;
            }
            
            .section-title {
                font-size: 20px;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .task-section,
        .stat-card {
            animation: fadeIn 0.6s ease forwards;
        }

        .stat-card:nth-child(2) {
            animation-delay: 0.1s;
        }

        .stat-card:nth-child(3) {
            animation-delay: 0.2s;
        }

        /* Scrollbar Styling */
        .main-content::-webkit-scrollbar {
            width: 6px;
        }

        .main-content::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        .main-content::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }

        .main-content::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
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
            
            <a href="index.php" class="menu-item <?php echo ($currentPage == 'dashboard' && $currentCategory == 'all') ? 'active' : ''; ?>">
                <span class="menu-icon">📋</span>
                <span>Semua Tugas</span>
            </a>
            
            <a href="index.php?page=pekerjaan&category=pekerjaan" class="menu-item <?php echo ($currentPage == 'pekerjaan' || $currentCategory == 'pekerjaan') ? 'active' : ''; ?>">
                <span class="menu-icon">📁</span>
                <span>Pekerjaan</span>
            </a>
            
            <!-- Link ke halaman pribadi yang terpisah -->
            <a href="index.php?page=pekerjaan&category=pekerjaan" class="menu-item <?php echo $currentPage == 'pribadi' ? 'active' : ''; ?>">
                <span class="menu-icon">🏠</span>
                <span>Pribadi</span>
            </a>
            
            <a href="index.php?page=belanja&category=belanja" class="menu-item <?php echo ($currentPage == 'belanja' || $currentCategory == 'belanja') ? 'active' : ''; ?>">
                <span class="menu-icon">🛒</span>
                <span>Belanja</span>
            </a>
            
            <button class="new-list-btn">
                <span>+ Daftar Baru</span>
            </button>
        </div>
        
        <!-- Main content -->
        <div class="main-content">
            <div class="header">
                <h1 class="page-title">
                    <?php echo getPageTitle($currentPage, $currentCategory); ?>
                </h1>
                
                <div class="search-bar">
                    <span>🔍</span>
                    <input type="text" placeholder="Cari tugas..." id="searchInput">
                </div>
                
                <div class="user-menu">
                    <div class="user-avatar">U</div>
                </div>
            </div>
            
            <!-- Stats row -->
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-value"><?php echo $totalTasks; ?></div>
                    <div class="stat-label">Total Tugas</div>
                    <div class="stat-progress">
                        <div class="progress-bar progress-blue" style="width: 100%;"></div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-value"><?php echo $completedTasks; ?></div>
                    <div class="stat-label">Tugas Selesai</div>
                    <div class="stat-progress">
                        <div class="progress-bar progress-green" style="width: <?php echo $completedPercentage; ?>%;"></div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-value"><?php echo $pendingTasks; ?></div>
                    <div class="stat-label">Tugas Tersisa</div>
                    <div class="stat-progress">
                        <div class="progress-bar progress-orange" style="width: <?php echo $pendingPercentage; ?>%;"></div>
                    </div>
                </div>
            </div>
            
            <!-- Active Tasks -->
            <div class="task-section">
                <div class="section-header">
                    <h2 class="section-title">Tugas Aktif</h2>
                    <span class="task-count"><?php echo count($activeTasks); ?></span>
                </div>
                
                <div class="task-list">
                    <?php if (empty($activeTasks)): ?>
                        <div class="empty-state">
                            <div class="empty-icon">📝</div>
                            <div class="empty-title">Belum ada tugas aktif</div>
                            <div class="empty-description">Mulai dengan menambahkan tugas baru di kategori yang Anda inginkan</div>
                        </div>
                    <?php else: ?>
                        <?php foreach ($activeTasks as $task): ?>
                            <div class="task-item">
                                <div class="task-checkbox"></div>
                                <div class="task-text"><?php echo htmlspecialchars($task['title']); ?></div>
                                <span class="task-category"><?php echo htmlspecialchars($task['category']); ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                
                <!-- Jika sedang melihat kategori pribadi, tampilkan tombol ke halaman detail -->
                <?php if ($currentCategory == 'pribadi'): ?>
                    <a href="task_personal.php" class="nav-button">
                        📋 Lihat Detail Aktivitas Pribadi
                    </a>
                <?php endif; ?>
            </div>
            
            <!-- Completed Tasks -->
            <div class="task-section">
                <div class="section-header">
                    <h2 class="section-title">Tugas Selesai</h2>
                    <span class="task-count"><?php echo count($completedTasksList); ?></span>
                </div>
                
                <div class="task-list">
                    <?php if (empty($completedTasksList)): ?>
                        <div class="empty-state">
                            <div class="empty-icon">✅</div>
                            <div class="empty-title">Belum ada tugas yang selesai</div>
                            <div class="empty-description">Tugas yang sudah diselesaikan akan muncul di sini</div>
                        </div>
                    <?php else: ?>
                        <?php foreach ($completedTasksList as $task): ?>
                            <div class="task-item">
                                <div class="task-checkbox completed">✓</div>
                                <div class="task-text completed"><?php echo htmlspecialchars($task['title']); ?></div>
                                <span class="task-category"><?php echo htmlspecialchars($task['category']); ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const taskItems = document.querySelectorAll('.task-item');
            
            taskItems.forEach(function(item) {
                const taskText = item.querySelector('.task-text').textContent.toLowerCase();
                if (taskText.includes(searchTerm)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        // Task checkbox functionality
        document.querySelectorAll('.task-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('click', function() {
                const taskItem = this.closest('.task-item');
                const isCompleted = this.classList.contains('completed');
                
                if (isCompleted) {
                    this.classList.remove('completed');
                    this.innerHTML = '';
                    taskItem.querySelector('.task-text').classList.remove('completed');
                } else {
                    this.classList.add('completed');
                    this.innerHTML = '✓';
                    taskItem.querySelector('.task-text').classList.add('completed');
                }
            });
        });
    </script>
</body>
</html>