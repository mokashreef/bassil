<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$dataFile = '../data.json';
$data = json_decode(file_get_contents($dataFile), true);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لوحة التحكم | BASSEL</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap');
        body { font-family: 'Tajawal', sans-serif; background-color: #0f172a; color: #f8fafc; }
        .glass-panel { background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.1); }
        .input-field { background: #0f172a; border: 1px solid #334155; color: white; border-radius: 0.5rem; padding: 0.75rem; width: 100%; transition: all 0.3s; }
        .input-field:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3); }
        label { display: block; margin-bottom: 0.5rem; font-weight: 500; color: #94a3b8; font-size: 0.9rem; }
        .tab-btn { padding: 1rem 1.5rem; color: #94a3b8; border-bottom: 2px solid transparent; transition: all 0.3s; }
        .tab-btn:hover { color: white; }
        .tab-btn.active { color: #3b82f6; border-bottom-color: #3b82f6; }
        .tab-content { display: none; }
        .tab-content.active { display: block; animation: fadeIn 0.4s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="glass-panel sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center font-bold text-xl">B</div>
                    <span class="font-bold text-xl tracking-wider">لوحة تحكم الموقع</span>
                </div>
                <div class="flex gap-4">
                    <a href="../" target="_blank" class="text-slate-300 hover:text-white px-3 py-2 rounded-md flex items-center gap-2 transition">
                        <i class="fa fa-external-link"></i> عرض الموقع
                    </a>
                    <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-medium transition shadow-lg shadow-red-500/30 flex items-center gap-2">
                        <i class="fa fa-sign-out"></i> خروج
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
        
        <form id="cmsForm" action="save.php" method="POST">
            <!-- Tabs -->
            <div class="flex border-b border-slate-700 mb-8 overflow-x-auto hide-scrollbar">
                <button type="button" class="tab-btn active font-bold" data-tab="general"><i class="fa fa-cog mr-2"></i> إعدادات عامة</button>
                <button type="button" class="tab-btn font-bold" data-tab="hero"><i class="fa fa-home mr-2"></i> القسم الرئيسي (Hero)</button>
                <button type="button" class="tab-btn font-bold" data-tab="about"><i class="fa fa-user mr-2"></i> من أنا</button>
                <button type="button" class="tab-btn font-bold" data-tab="contact"><i class="fa fa-envelope mr-2"></i> التواصل</button>
                <button type="button" class="tab-btn font-bold" data-tab="portfolio"><i class="fa fa-images mr-2"></i> الأعمال (Portfolio)</button>
                <button type="button" class="tab-btn font-bold" data-tab="services"><i class="fa fa-crown mr-2"></i> الخدمات</button>
            </div>

            <div class="glass-panel rounded-2xl p-6 sm:p-10 shadow-2xl">
                <!-- Tab: General -->
                <div id="general" class="tab-content active">
                    <h2 class="text-2xl font-bold text-white mb-6 border-b border-slate-700 pb-3">إعدادات عامة (SEO)</h2>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label>عنوان الموقع (Site Title)</label>
                            <input type="text" name="site_title" class="input-field" value="<?= htmlspecialchars($data['site_title']) ?>">
                        </div>
                        <div>
                            <label>وصف الموقع (Meta Description)</label>
                            <textarea name="meta_desc" class="input-field h-24"><?= htmlspecialchars($data['meta_desc']) ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Tab: Hero -->
                <div id="hero" class="tab-content">
                    <h2 class="text-2xl font-bold text-white mb-6 border-b border-slate-700 pb-3">القسم الرئيسي (Hero Section)</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label>الشارة (Badge)</label>
                            <input type="text" name="hero_badge" class="input-field" value="<?= htmlspecialchars($data['hero_badge']) ?>">
                        </div>
                        <div>
                            <label>الاسم</label>
                            <input type="text" name="hero_name" class="input-field" value="<?= htmlspecialchars($data['hero_name']) ?>">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-6 mb-6">
                        <div>
                            <label>اللقب (Title)</label>
                            <input type="text" name="hero_title" class="input-field" value="<?= htmlspecialchars($data['hero_title']) ?>">
                        </div>
                        <div>
                            <label>الوصف القصير</label>
                            <textarea name="hero_desc" class="input-field h-24"><?= htmlspecialchars($data['hero_desc']) ?></textarea>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-blue-400 mb-4 mt-8">الإحصائيات</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-slate-800/50 p-4 rounded-xl border border-slate-700">
                            <label>الرقم الأول</label>
                            <input type="text" name="hero_stats_1" class="input-field mb-3" value="<?= htmlspecialchars($data['hero_stats_1']) ?>">
                            <label>النص الأول</label>
                            <input type="text" name="hero_stats_1_label" class="input-field" value="<?= htmlspecialchars($data['hero_stats_1_label']) ?>">
                        </div>
                        <div class="bg-slate-800/50 p-4 rounded-xl border border-slate-700">
                            <label>الرقم الثاني</label>
                            <input type="text" name="hero_stats_2" class="input-field mb-3" value="<?= htmlspecialchars($data['hero_stats_2']) ?>">
                            <label>النص الثاني</label>
                            <input type="text" name="hero_stats_2_label" class="input-field" value="<?= htmlspecialchars($data['hero_stats_2_label']) ?>">
                        </div>
                        <div class="bg-slate-800/50 p-4 rounded-xl border border-slate-700">
                            <label>الرقم الثالث</label>
                            <input type="text" name="hero_stats_3" class="input-field mb-3" value="<?= htmlspecialchars($data['hero_stats_3']) ?>">
                            <label>النص الثالث</label>
                            <input type="text" name="hero_stats_3_label" class="input-field" value="<?= htmlspecialchars($data['hero_stats_3_label']) ?>">
                        </div>
                    </div>
                </div>

                <!-- Tab: About -->
                <div id="about" class="tab-content">
                    <h2 class="text-2xl font-bold text-white mb-6 border-b border-slate-700 pb-3">قسم من أنا</h2>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label>رابط الصورة الشخصية</label>
                            <input type="text" name="about_image" class="input-field" value="<?= htmlspecialchars($data['about_image']) ?>">
                        </div>
                        <div>
                            <label>العنوان</label>
                            <input type="text" name="about_title" class="input-field" value="<?= htmlspecialchars($data['about_title']) ?>">
                        </div>
                        <div>
                            <label>الفقرة الأولى</label>
                            <textarea name="about_desc_1" class="input-field h-24"><?= htmlspecialchars($data['about_desc_1']) ?></textarea>
                        </div>
                        <div>
                            <label>الفقرة الثانية</label>
                            <textarea name="about_desc_2" class="input-field h-24"><?= htmlspecialchars($data['about_desc_2']) ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Tab: Contact -->
                <div id="contact" class="tab-content">
                    <h2 class="text-2xl font-bold text-white mb-6 border-b border-slate-700 pb-3">معلومات التواصل</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label>البريد الإلكتروني</label>
                            <input type="text" name="contact_email" class="input-field" value="<?= htmlspecialchars($data['contact_email']) ?>">
                        </div>
                        <div>
                            <label>رقم الواتساب</label>
                            <input type="text" name="contact_whatsapp" class="input-field" value="<?= htmlspecialchars($data['contact_whatsapp']) ?>">
                        </div>
                        <div>
                            <label>الموقع (العنوان)</label>
                            <input type="text" name="contact_location" class="input-field" value="<?= htmlspecialchars($data['contact_location']) ?>">
                        </div>
                        <div>
                            <label>رابط إنستغرام</label>
                            <input type="text" name="social_instagram" class="input-field" value="<?= htmlspecialchars($data['social_instagram']) ?>">
                        </div>
                        <div class="md:col-span-2">
                            <label>رابط بيهانس</label>
                            <input type="text" name="social_behance" class="input-field" value="<?= htmlspecialchars($data['social_behance']) ?>">
                        </div>
                    </div>
                </div>

                <!-- Tab: Portfolio -->
                <div id="portfolio" class="tab-content">
                    <h2 class="text-2xl font-bold text-white mb-6 border-b border-slate-700 pb-3">معرض الأعمال (صور)</h2>
                    <p class="text-sm text-slate-400 mb-4">أضف روابط الصور الخاصة بأعمالك (مسار الصورة أو رابط خارجي).</p>
                    <div id="portfolio-container" class="space-y-4">
                        <?php foreach($data['portfolio_images'] as $img): ?>
                        <div class="flex gap-2">
                            <input type="text" name="portfolio_images[]" class="input-field flex-grow" value="<?= htmlspecialchars($img) ?>">
                            <button type="button" class="bg-red-500/20 text-red-400 hover:bg-red-500 hover:text-white px-4 rounded-lg transition" onclick="this.parentElement.remove()"><i class="fa fa-trash"></i></button>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" id="add-portfolio" class="mt-4 bg-slate-700 hover:bg-slate-600 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                        <i class="fa fa-plus"></i> إضافة صورة جديدة
                    </button>
                </div>

                <!-- Tab: Services -->
                <div id="services" class="tab-content">
                    <h2 class="text-2xl font-bold text-white mb-6 border-b border-slate-700 pb-3">الخدمات</h2>
                    <div id="services-container" class="space-y-6">
                        <?php foreach($data['services'] as $index => $svc): ?>
                        <div class="bg-slate-800/50 p-6 rounded-xl border border-slate-700 relative">
                            <button type="button" class="absolute top-4 left-4 text-red-400 hover:text-red-500 text-xl" onclick="this.parentElement.remove()"><i class="fa fa-times"></i></button>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label>العنوان</label>
                                    <input type="text" name="services[<?= $index ?>][title]" class="input-field" value="<?= htmlspecialchars($svc['title']) ?>">
                                </div>
                                <div>
                                    <label>كلاس الأيقونة (مثال: fas fa-crown)</label>
                                    <input type="text" name="services[<?= $index ?>][icon]" class="input-field" value="<?= htmlspecialchars($svc['icon']) ?>">
                                </div>
                                <div class="md:col-span-2">
                                    <label>الوصف</label>
                                    <textarea name="services[<?= $index ?>][desc]" class="input-field h-20"><?= htmlspecialchars($svc['desc']) ?></textarea>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" id="add-service" class="mt-6 bg-slate-700 hover:bg-slate-600 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                        <i class="fa fa-plus"></i> إضافة خدمة جديدة
                    </button>
                </div>

            </div>

            <!-- Save Action -->
            <div class="fixed bottom-0 left-0 w-full glass-panel border-t border-slate-700 p-4 z-50 flex justify-center">
                <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-10 py-3 rounded-full font-bold text-lg shadow-[0_0_20px_rgba(37,99,235,0.4)] transition transform hover:scale-105 flex items-center gap-3">
                    <i class="fa fa-save"></i> حفظ جميع التعديلات
                </button>
            </div>
        </form>
    </main>

    <!-- Spacer for bottom bar -->
    <div class="h-24"></div>

    <script>
        // Tab switching
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                
                btn.classList.add('active');
                document.getElementById(btn.dataset.tab).classList.add('active');
            });
        });

        // Add Portfolio Image
        document.getElementById('add-portfolio').addEventListener('click', () => {
            const container = document.getElementById('portfolio-container');
            const div = document.createElement('div');
            div.className = 'flex gap-2';
            div.innerHTML = `
                <input type="text" name="portfolio_images[]" class="input-field flex-grow" placeholder="رابط أو مسار الصورة">
                <button type="button" class="bg-red-500/20 text-red-400 hover:bg-red-500 hover:text-white px-4 rounded-lg transition" onclick="this.parentElement.remove()"><i class="fa fa-trash"></i></button>
            `;
            container.appendChild(div);
        });

        // Add Service
        let serviceCount = document.querySelectorAll('#services-container > div').length;
        document.getElementById('add-service').addEventListener('click', () => {
            const container = document.getElementById('services-container');
            const div = document.createElement('div');
            div.className = 'bg-slate-800/50 p-6 rounded-xl border border-slate-700 relative';
            div.innerHTML = `
                <button type="button" class="absolute top-4 left-4 text-red-400 hover:text-red-500 text-xl" onclick="this.parentElement.remove()"><i class="fa fa-times"></i></button>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label>العنوان</label>
                        <input type="text" name="services[${serviceCount}][title]" class="input-field" placeholder="عنوان الخدمة">
                    </div>
                    <div>
                        <label>كلاس الأيقونة</label>
                        <input type="text" name="services[${serviceCount}][icon]" class="input-field" placeholder="مثال: fas fa-star">
                    </div>
                    <div class="md:col-span-2">
                        <label>الوصف</label>
                        <textarea name="services[${serviceCount}][desc]" class="input-field h-20" placeholder="وصف الخدمة"></textarea>
                    </div>
                </div>
            `;
            container.appendChild(div);
            serviceCount++;
        });
    </script>
</body>
</html>
