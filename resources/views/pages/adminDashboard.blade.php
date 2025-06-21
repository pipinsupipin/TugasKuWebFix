@php
    use App\Models\User;
    use App\Models\Tugas;
    use App\Models\KategoriTugas;
    use App\Models\Feedback;
    use Carbon\Carbon;

    // Temporary: Skip auth check for testing
    // if (!auth()->check() || !auth()->user()->is_admin) {
    //     abort(403, 'Unauthorized access');
    // }

    // Get statistics
    $totalUsers = User::count();
    $totalTugas = Tugas::count();
    $totalCategories = KategoriTugas::count();
    $totalFeedback = Feedback::count();

    $completedTasks = Tugas::where('is_completed', true)->count();
    $pendingTasks = Tugas::where('is_completed', false)->count();

    $avgRating = round(Feedback::avg('rating') ?: 0, 1);
    $satisfiedFeedbacks = Feedback::where('rating', '>=', 4)->count();
    $satisfactionRate = $totalFeedback > 0 ? round(($satisfiedFeedbacks / $totalFeedback) * 100) : 0;

    // Recent activities
    $recentUsers = User::latest()->limit(5)->get();
    $recentTasks = Tugas::with('user')->latest()->limit(5)->get();
    $recentFeedback = Feedback::latest()->limit(5)->get();

    // Top users by completed tasks
    $topUsers = User::withCount([
        'tugas as completed_tasks' => function ($query) {
            $query->where('is_completed', true);
        }
    ])
        ->withCount('tugas as total_tasks')
        ->orderBy('completed_tasks', 'desc')
        ->limit(5)
        ->get();

    // Feedback by category
    $feedbackByCategory = Feedback::selectRaw('kategori, COUNT(*) as count')
        ->groupBy('kategori')
        ->get();

    // Tasks by completion status
    $tasksByStatus = [
        'completed' => $completedTasks,
        'pending' => $pendingTasks
    ];

    // New registrations this month
    $newUsersThisMonth = User::where('created_at', '>=', Carbon::now()->startOfMonth())->count();
    $newTasksThisMonth = Tugas::where('created_at', '>=', Carbon::now()->startOfMonth())->count();
    $newFeedbackThisMonth = Feedback::where('created_at', '>=', Carbon::now()->startOfMonth())->count();
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TugasKu Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .stat-card:hover {
            transform: translateY(-2px);
        }

        .chart-container {
            position: relative;
            height: 300px;
        }

        .gradient-bg {
            background-color:black ;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Header -->
    <header class="gradient-bg shadow-lg">
        <div class="max-w-7xl mx-auto px-6 py-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-white">
                        <span class="text-yellow-300">Tugas</span><span class="text-blue-200">•</span><span
                            class="text-yellow-300">Ku</span>
                    </h1>
                    <p class="text-blue-100 mt-1">Admin Dashboard - Control Panel</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-blue-100 text-sm">Welcome back,</p>
                        <p class="text-white font-semibold">Admin User</p>
                    </div>
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <i data-lucide="user" class="w-5 h-5 text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-6 py-8">

        <!-- Quick Stats -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800">📊 Dashboard Overview</h2>
                <div class="text-sm text-gray-500">
                    Last updated: {{ now()->format('d M Y, H:i') }}
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <!-- Total Users -->
                <div
                    class="stat-card bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Total Pengguna</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($totalUsers) }}</p>
                            <p class="text-sm text-blue-600 mt-2">
                                <i data-lucide="trending-up" class="w-4 h-4 inline mr-1"></i>
                                +{{ $newUsersThisMonth }} bulan ini
                            </p>
                        </div>
                        <div class="bg-blue-100 p-4 rounded-full">
                            <i data-lucide="users" class="w-8 h-8 text-blue-600"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Tasks -->
                <div
                    class="stat-card bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Total Tugas</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($totalTugas) }}</p>
                            <p class="text-sm mt-2">
                                <span class="text-green-600 font-medium">{{ $completedTasks }} selesai</span> •
                                <span class="text-yellow-600 font-medium">{{ $pendingTasks }} pending</span>
                            </p>
                        </div>
                        <div class="bg-green-100 p-4 rounded-full">
                            <i data-lucide="clipboard-check" class="w-8 h-8 text-green-600"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Categories -->
                <div
                    class="stat-card bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border-l-4 border-purple-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Kategori Tugas</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($totalCategories) }}</p>
                            <p class="text-sm text-purple-600 mt-2">
                                <i data-lucide="folder" class="w-4 h-4 inline mr-1"></i>
                                Active categories
                            </p>
                        </div>
                        <div class="bg-purple-100 p-4 rounded-full">
                            <i data-lucide="layers" class="w-8 h-8 text-purple-600"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Feedback -->
                <div
                    class="stat-card bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border-l-4 border-yellow-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Total Feedback</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($totalFeedback) }}</p>
                            <p class="text-sm mt-2">
                                <span class="text-yellow-600 font-medium">⭐ {{ $avgRating }}/5</span> •
                                <span class="text-green-600 font-medium">{{ $satisfactionRate }}% puas</span>
                            </p>
                        </div>
                        <div class="bg-yellow-100 p-4 rounded-full">
                            <i data-lucide="message-square" class="w-8 h-8 text-yellow-600"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">

            <!-- Feedback Distribution Chart -->
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-800">📝 Feedback by Category</h3>
                    <div class="text-sm text-gray-500">Distribution</div>
                </div>
                <div class="chart-container">
                    <canvas id="feedbackChart"></canvas>
                </div>
            </div>

            <!-- Task Status Chart -->
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-800">✅ Task Completion Rate</h3>
                    <div class="text-sm text-gray-500">
                        {{ $totalTugas > 0 ? round(($completedTasks / $totalTugas) * 100, 1) : 0 }}% completed
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="tasksChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Data Tables -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">

            <!-- Top Performing Users -->
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-800">🏆 Top Performers</h3>
                    <span class="text-sm text-gray-500">By completed tasks</span>
                </div>
                <div class="space-y-4">
                    @forelse($topUsers as $index => $user)
                        @php
                            $completionRate = $user->total_tasks > 0 ? round(($user->completed_tasks / $user->total_tasks) * 100, 1) : 0;
                            $badgeColor = $index === 0 ? 'bg-yellow-100 text-yellow-800' : ($index === 1 ? 'bg-gray-100 text-gray-800' : 'bg-orange-100 text-orange-800');
                        @endphp
                        <div
                            class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <span
                                        class="inline-flex items-center justify-center w-8 h-8 {{ $badgeColor }} rounded-full font-bold text-sm">
                                        {{ $index + 1 }}
                                    </span>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-lg text-green-600">{{ $user->completed_tasks }}</p>
                                <p class="text-sm text-gray-500">{{ $completionRate }}% completion rate</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            <i data-lucide="users" class="w-12 h-12 mx-auto mb-3 text-gray-300"></i>
                            <p>Belum ada user dengan tugas completed</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Feedback -->
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-800">💬 Recent Feedback</h3>
                    <span class="text-sm text-gray-500">Latest reviews</span>
                </div>
                <div class="space-y-4">
                    @forelse($recentFeedback as $feedback)
                                    <div class="p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                        <div class="flex items-center justify-between mb-3">
                                            <p class="font-semibold text-gray-900">{{ $feedback->nama_lengkap }}</p>
                                            <div class="flex items-center space-x-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <span
                                                        class="text-{{ $i <= $feedback->rating ? 'yellow' : 'gray' }}-400 text-sm">⭐</span>
                                                @endfor
                                            </div>
                                        </div>
                                        <p class="text-sm text-gray-700 mb-2">{{ Str::limit($feedback->judul, 60) }}</p>
                                        <div class="flex items-center justify-between">
                                            <span
                                                class="text-xs px-2 py-1 rounded-full 
                                                    {{ $feedback->kategori == 'layanan' ? 'bg-blue-100 text-blue-800' :
                        ($feedback->kategori == 'aplikasi' ? 'bg-green-100 text-green-800' :
                            ($feedback->kategori == 'website' ? 'bg-purple-100 text-purple-800' :
                                ($feedback->kategori == 'produk' ? 'bg-orange-100 text-orange-800' : 'bg-gray-100 text-gray-800'))) }}">
                                                {{ ucfirst($feedback->kategori) }}
                                            </span>
                                            <span class="text-xs text-gray-500">{{ $feedback->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            <i data-lucide="message-circle" class="w-12 h-12 mx-auto mb-3 text-gray-300"></i>
                            <p>Belum ada feedback</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Activity Timeline -->
        <div class="bg-white rounded-xl p-6 shadow-lg">
            <h3 class="text-lg font-bold text-gray-800 mb-6">🕒 Recent Activities</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <!-- New Users -->
                <div>
                    <h4 class="font-semibold text-gray-700 mb-4 flex items-center">
                        <i data-lucide="user-plus" class="w-4 h-4 mr-2 text-blue-600"></i>
                        New Users
                    </h4>
                    <div class="space-y-3">
                        @forelse($recentUsers as $user)
                            <div class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-50">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span
                                        class="text-blue-600 font-bold text-xs">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm">No recent users</p>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Tasks -->
                <div>
                    <h4 class="font-semibold text-gray-700 mb-4 flex items-center">
                        <i data-lucide="clipboard" class="w-4 h-4 mr-2 text-green-600"></i>
                        Recent Tasks
                    </h4>
                    <div class="space-y-3">
                        @forelse($recentTasks as $task)
                            <div class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-50">
                                <div
                                    class="w-8 h-8 bg-{{ $task->is_completed ? 'green' : 'yellow' }}-100 rounded-full flex items-center justify-center">
                                    <i data-lucide="{{ $task->is_completed ? 'check' : 'clock' }}"
                                        class="w-4 h-4 text-{{ $task->is_completed ? 'green' : 'yellow' }}-600"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ Str::limit($task->judul, 25) }}
                                    </p>
                                    <p class="text-xs text-gray-500">{{ $task->user->name ?? 'Unknown' }} •
                                        {{ $task->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm">No recent tasks</p>
                        @endforelse
                    </div>
                </div>

                <!-- Latest Feedback -->
                <div>
                    <h4 class="font-semibold text-gray-700 mb-4 flex items-center">
                        <i data-lucide="message-square" class="w-4 h-4 mr-2 text-purple-600"></i>
                        Latest Feedback
                    </h4>
                    <div class="space-y-3">
                        @forelse($recentFeedback->take(3) as $feedback)
                            <div class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-50">
                                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                    <span class="text-purple-600 font-bold text-xs">{{ $feedback->rating }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        {{ Str::limit($feedback->judul, 25) }}</p>
                                    <p class="text-xs text-gray-500">{{ $feedback->nama_lengkap }} •
                                        {{ $feedback->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm">No recent feedback</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Feedback by Category Chart
        const feedbackCtx = document.getElementById('feedbackChart').getContext('2d');
        new Chart(feedbackCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($feedbackByCategory->pluck('kategori')->map(function ($k) {
    return ucfirst($k); })) !!},
                datasets: [{
                    data: {!! json_encode($feedbackByCategory->pluck('count')) !!},
                    backgroundColor: [
                        '#3B82F6', '#10B981', '#8B5CF6', '#F59E0B', '#EF4444'
                    ],
                    borderWidth: 3,
                    borderColor: '#ffffff',
                    hoverBorderWidth: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });

        // Tasks Status Chart
        const tasksCtx = document.getElementById('tasksChart').getContext('2d');
        new Chart(tasksCtx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'Pending'],
                datasets: [{
                    data: [{{ $completedTasks }}, {{ $pendingTasks }}],
                    backgroundColor: ['#10B981', '#F59E0B'],
                    borderWidth: 3,
                    borderColor: '#ffffff',
                    hoverBorderWidth: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>