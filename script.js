document.addEventListener('DOMContentLoaded', () => {

    const loader = document.querySelector('.loader');
    window.addEventListener('load', () => {
        setTimeout(() => {
            loader.classList.add('hidden');
        }, 800);
    });

    const header = document.querySelector('.header');
    const backToTop = document.querySelector('.back-to-top');

    window.addEventListener('scroll', () => {
        const scrollY = window.scrollY;

        if (scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }

        if (scrollY > 500) {
            backToTop.classList.add('visible');
        } else {
            backToTop.classList.remove('visible');
        }

        updateActiveNavLink();
    });

    const hamburger = document.querySelector('.hamburger');
    const navLinks = document.querySelector('.nav-links');
    const navItems = document.querySelectorAll('.nav-links a');

    hamburger.addEventListener('click', () => {
        hamburger.classList.toggle('active');
        navLinks.classList.toggle('active');
        document.body.style.overflow = navLinks.classList.contains('active') ? 'hidden' : '';
    });

    navItems.forEach(item => {
        item.addEventListener('click', () => {
            hamburger.classList.remove('active');
            navLinks.classList.remove('active');
            document.body.style.overflow = '';
        });
    });

    function updateActiveNavLink() {
        const sections = document.querySelectorAll('section[id]');
        const scrollPos = window.scrollY + 200;

        sections.forEach(section => {
            const top = section.offsetTop;
            const height = section.offsetHeight;
            const id = section.getAttribute('id');
            const link = document.querySelector(`.nav-links a[href="#${id}"]`);

            if (link) {
                if (scrollPos >= top && scrollPos < top + height) {
                    navItems.forEach(item => item.classList.remove('active'));
                    link.classList.add('active');
                }
            }
        });
    }

    const revealElements = document.querySelectorAll('.reveal');

    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });

    revealElements.forEach(el => revealObserver.observe(el));

    const skillBars = document.querySelectorAll('.skill-progress');

    const skillObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const width = entry.target.getAttribute('data-width');
                entry.target.style.width = width + '%';
            }
        });
    }, {
        threshold: 0.5
    });

    skillBars.forEach(bar => skillObserver.observe(bar));

    const counters = document.querySelectorAll('.counter');

    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = parseInt(entry.target.getAttribute('data-target'));
                const suffix = entry.target.getAttribute('data-suffix') || '';
                animateCounter(entry.target, target, suffix);
                counterObserver.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.5
    });

    counters.forEach(counter => counterObserver.observe(counter));

    function animateCounter(element, target, suffix) {
        let current = 0;
        const increment = target / 50;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current) + suffix;
        }, 30);
    }

    loadYouTubeVideos();

    async function loadYouTubeVideos() {
        const videosGrid = document.querySelector('.videos-grid');
        if (!videosGrid) return;

        const videos = [
            {
                id: 'DuUjOTPx2UI',
                title: 'الحقيقة الصادمة عن صناع المحتوى التقني!',
                thumbnail: 'https://img.youtube.com/vi/DuUjOTPx2UI/maxresdefault.jpg'
            },
            {
                id: 'OoBoWwrPfgk',
                title: 'ليش كثرة الأدوات بتخليك أضعف كمبرمج؟ رغم إنك تتعلم أكثر',
                thumbnail: 'https://img.youtube.com/vi/OoBoWwrPfgk/maxresdefault.jpg'
            },
            {
                id: 'QXqJOPOfsJ0',
                title: 'هل لسا في معنى لتعلم Frontend اليوم ولا انتهى زمنه؟',
                thumbnail: 'https://img.youtube.com/vi/QXqJOPOfsJ0/maxresdefault.jpg'
            },
            {
                id: 'ZDRKQcSjboM',
                title: 'مش كل واحد يكتب كود يعتبر مطور - الفرق الي يغيّر مستقبلك البرمجي',
                thumbnail: 'https://img.youtube.com/vi/ZDRKQcSjboM/maxresdefault.jpg'
            },
            {
                id: 'CjpcxfcH-TE',
                title: 'هل الأتمتة فعلاً تخلّي المبرمج أقوى؟ ولا نحن نفهمها غلط',
                thumbnail: 'https://img.youtube.com/vi/CjpcxfcH-TE/maxresdefault.jpg'
            },
            {
                id: '0IPORIyDik0',
                title: 'Moltbook: الحقيقة الكاملة عن منصة روبوتات الذكاء الاصطناعي',
                thumbnail: 'https://img.youtube.com/vi/0IPORIyDik0/maxresdefault.jpg'
            }
        ];

        videosGrid.innerHTML = '';

        videos.forEach((video, index) => {
            const card = document.createElement('div');
            card.className = `video-card reveal reveal-delay-${(index % 3) + 1}`;
            card.innerHTML = `
                <div class="video-thumbnail" data-video-id="${video.id}">
                    <img src="${video.thumbnail}" alt="${video.title}" 
                         onerror="this.src='https://via.placeholder.com/480x270/16161f/6c63ff?text=Video'">
                    <div class="video-play-btn" onclick="playVideo(this)">
                        <i class="fas fa-play"></i>
                    </div>
                </div>
                <div class="video-info">
                    <h3>${video.title}</h3>
                    <p><i class="fab fa-youtube"></i> كود التطور</p>
                </div>
            `;
            videosGrid.appendChild(card);
        });

        document.querySelectorAll('.video-card.reveal').forEach(el => {
            revealObserver.observe(el);
        });
    }

    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const message = document.getElementById('message').value.trim();

            if (!name || !email || !message) {
                showFormMessage('يرجى ملء جميع الحقول', 'error');
                return;
            }

            if (!isValidEmail(email)) {
                showFormMessage('يرجى إدخال بريد إلكتروني صحيح', 'error');
                return;
            }

            const submitBtn = contactForm.querySelector('.btn');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الإرسال...';
            submitBtn.disabled = true;

            setTimeout(() => {
                contactForm.reset();
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                showFormMessage('تم إرسال رسالتك بنجاح! سأتواصل معك قريباً.', 'success');
            }, 1500);
        });
    }

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function showFormMessage(msg, type) {
        const existing = document.querySelector('.form-message');
        if (existing) existing.remove();

        const msgEl = document.createElement('div');
        msgEl.className = `form-message ${type}`;
        msgEl.style.cssText = `
            padding: 12px 20px;
            border-radius: 8px;
            margin-top: 15px;
            font-size: 0.95rem;
            text-align: center;
            animation: fadeIn 0.3s ease;
            ${type === 'success' 
                ? 'background: rgba(74, 222, 128, 0.1); color: #4ade80; border: 1px solid rgba(74, 222, 128, 0.2);' 
                : 'background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2);'}
        `;
        msgEl.textContent = msg;
        contactForm.appendChild(msgEl);

        setTimeout(() => msgEl.remove(), 5000);
    }

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    if (backToTop) {
        backToTop.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    const serviceCards = document.querySelectorAll('.service-card');
    serviceCards.forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            const rotateX = (y - centerY) / 20;
            const rotateY = (centerX - x) / 20;
            card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-8px)`;
        });

        card.addEventListener('mouseleave', () => {
            card.style.transform = '';
        });
    });

});

function playVideo(btn) {
    const thumbnail = btn.closest('.video-thumbnail');
    const videoId = thumbnail.getAttribute('data-video-id');
    const iframe = document.createElement('iframe');
    iframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0`;
    iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
    iframe.allowFullscreen = true;
    thumbnail.innerHTML = '';
    thumbnail.appendChild(iframe);
}
