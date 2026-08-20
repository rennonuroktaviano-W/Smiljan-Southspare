document.documentElement.classList.add('js');

const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
const finePointer = window.matchMedia('(pointer: fine)').matches;

// ---------------------------------------------------------------- loading screen
const loader = document.querySelector('.loader');
const loaderCounter = document.querySelector('.loader-counter');

if (loader) {
    let progress = 0;
    const target = 100;
    const duration = 1600;
    const startTime = performance.now();

    const animate = (now) => {
        const elapsed = now - startTime;
        progress = Math.min(target, Math.round((elapsed / duration) * target));
        if (loaderCounter) loaderCounter.textContent = String(progress).padStart(3, '0');
        if (progress < target) requestAnimationFrame(animate);
    };
    requestAnimationFrame(animate);

    const dismiss = () => {
        loader.classList.add('is-done');
        document.body.classList.remove('overflow-hidden');
    };

    window.addEventListener('load', () => {
        const remaining = duration - (performance.now() - startTime);
        setTimeout(dismiss, Math.max(remaining, 400));
    });

    setTimeout(dismiss, 3000);
    document.body.classList.add('overflow-hidden');
}

// ---------------------------------------------------------------- film grain
if (!reducedMotion) {
    const grain = document.createElement('div');
    grain.className = 'grain';
    grain.setAttribute('aria-hidden', 'true');
    document.body.appendChild(grain);
}

// ---------------------------------------------------------------- custom cursor
const cursor = document.querySelector('.cursor-dot');

if (cursor && finePointer && !reducedMotion) {
    let x = innerWidth / 2;
    let y = innerHeight / 2;
    let tx = x;
    let ty = y;

    addEventListener('pointermove', (e) => {
        tx = e.clientX;
        ty = e.clientY;
    }, { passive: true });

    const raf = () => {
        x += (tx - x) * 0.18;
        y += (ty - y) * 0.18;
        cursor.style.transform = `translate3d(${x}px, ${y}px, 0)`;
        requestAnimationFrame(raf);
    };
    raf();

    const interactive = 'a, button, [data-cursor]';

    document.addEventListener('pointerover', (e) => {
        if (e.target.closest(interactive)) cursor.classList.add('is-active');
    });
    document.addEventListener('pointerout', (e) => {
        if (e.target.closest(interactive)) cursor.classList.remove('is-active');
    });
}

// ---------------------------------------------------------------- nav on scroll
const nav = document.querySelector('[data-nav]');

if (nav) {
    const sync = () => nav.classList.toggle('is-scrolled', scrollY > 24);
    addEventListener('scroll', sync, { passive: true });
    sync();
}

// ---------------------------------------------------------------- mobile menu
const menuBtn = document.querySelector('[data-menu-btn]');
const menu = document.querySelector('[data-menu]');

if (menuBtn && menu) {
    const setOpen = (open) => {
        menu.classList.toggle('is-open', open);
        menu.setAttribute('aria-hidden', String(!open));
        menuBtn.setAttribute('aria-expanded', String(open));
        document.body.classList.toggle('overflow-hidden', open);

        if (open) {
            const firstLink = menu.querySelector('a');
            if (firstLink) setTimeout(() => firstLink.focus(), 300);
        }
    };

    menuBtn.addEventListener('click', () => setOpen(!menu.classList.contains('is-open')));
    menu.querySelectorAll('a').forEach((a) => a.addEventListener('click', () => setOpen(false)));
    addEventListener('keydown', (e) => {
        if (e.key === 'Escape') setOpen(false);
    });

    // focus trap
    menu.addEventListener('keydown', (e) => {
        if (e.key !== 'Tab' || !menu.classList.contains('is-open')) return;
        const focusable = menu.querySelectorAll('a, button, [tabindex]');
        const first = focusable[0];
        const last = focusable[focusable.length - 1];
        if (e.shiftKey && document.activeElement === first) {
            e.preventDefault();
            last.focus();
        } else if (!e.shiftKey && document.activeElement === last) {
            e.preventDefault();
            first.focus();
        }
    });
}

// ---------------------------------------------------------------- reveal on scroll
const reveals = document.querySelectorAll('[data-reveal]');

if ('IntersectionObserver' in window) {
    const io = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    io.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.12, rootMargin: '0px 0px -8% 0px' },
    );
    reveals.forEach((el) => io.observe(el));
} else {
    reveals.forEach((el) => el.classList.add('is-visible'));
}

// ---------------------------------------------------------------- hero parallax
const hero = document.querySelector('[data-hero]');

if (hero && !reducedMotion) {
    const wrap = hero.querySelector('[data-parallax]');
    const heroImg = hero.querySelector('[data-parallax] img');
    const title = hero.querySelector('h1');

    let mx = 0;
    let my = 0;
    let tx = 0;
    let ty = 0;
    let progress = 0;
    let heroVisible = true;

    hero.addEventListener('pointermove', (e) => {
        const r = hero.getBoundingClientRect();
        tx = ((e.clientX - r.left) / r.width - 0.5) * 2;
        ty = ((e.clientY - r.top) / r.height - 0.5) * 2;
    }, { passive: true });

    const heroIO = new IntersectionObserver(
        ([entry]) => { heroVisible = entry.isIntersecting; },
        { threshold: 0 }
    );
    heroIO.observe(hero);

    const sync = () => {
        const r = hero.getBoundingClientRect();
        progress = Math.min(1, Math.max(0, -r.top / r.height));
    };

    addEventListener('scroll', sync, { passive: true });
    sync();

    const tick = () => {
        if (heroVisible) {
            mx += (tx - mx) * 0.06;
            my += (ty - my) * 0.06;

            if (wrap) wrap.style.transform = `translate3d(${mx * 14}px, ${my * 12 - progress * 60}px, 0)`;
            if (heroImg) heroImg.style.transform = `scale(${1 + progress * 0.05})`;
            if (title) title.style.transform = `translateY(${progress * 70}px)`;
        }
        requestAnimationFrame(tick);
    };
    tick();

    if (document.querySelector('[data-coffee]')) {
        import('./coffee-cup.js')
            .then(({ initCoffeeHero }) => initCoffeeHero(hero, { getProgress: () => progress }))
            .catch(() => {});
    }
}

// ---------------------------------------------------------------- 3D tilt on images
if (finePointer && !reducedMotion) {
    document.querySelectorAll('[data-tilt]').forEach((el) => {
        const frame = el.querySelector('.img-frame');
        if (!frame) return;

        el.addEventListener('pointermove', (e) => {
            const r = el.getBoundingClientRect();
            const x = (e.clientX - r.left) / r.width;
            const y = (e.clientY - r.top) / r.height;
            const rotateX = (y - 0.5) * -8;
            const rotateY = (x - 0.5) * 8;
            frame.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.02)`;
        });

        el.addEventListener('pointerleave', () => {
            frame.style.transform = '';
        });
    });
}

// ---------------------------------------------------------------- magnetic links
if (finePointer && !reducedMotion) {
    document.querySelectorAll('[data-magnetic]').forEach((el) => {
        el.addEventListener('pointermove', (e) => {
            const r = el.getBoundingClientRect();
            const dx = (e.clientX - (r.left + r.width / 2)) * 0.25;
            const dy = (e.clientY - (r.top + r.height / 2)) * 0.25;
            el.style.transition = 'none';
            el.style.transform = `translate(${dx}px, ${dy}px)`;
        });

        el.addEventListener('pointerleave', () => {
            el.style.transition = 'transform 0.5s cubic-bezier(0.22, 1, 0.36, 1)';
            el.style.transform = '';
        });
    });
}

// ---------------------------------------------------------------- opening status
const statusBox = document.querySelector('[data-status]');
const statusText = document.querySelector('[data-status-text]');

if (statusBox && statusText) {
    const open = statusBox.dataset.open || '08:00';
    const close = statusBox.dataset.close || '22:00';
    const dot = statusBox.querySelector('.status-dot');
    const labelOpen = statusBox.dataset.labelOpen || 'SEDANG BUKA';
    const labelClosed = statusBox.dataset.labelClosed || 'TUTUP · BUKA 08:00';

    const fmt = new Intl.DateTimeFormat('id-ID', {
        timeZone: 'Asia/Jakarta',
        hour: '2-digit',
        minute: '2-digit',
        hour12: false,
    });

    const toMin = (t) => {
        const [h, m] = t.split(':').map(Number);
        return h * 60 + m;
    };

    const openMin = toMin(open);
    const closeMin = toMin(close);

    const update = () => {
        const parts = fmt.formatToParts(new Date());
        const map = {};
        parts.forEach((p) => {
            map[p.type] = p.value;
        });
        const hour = map.hour === '24' ? '00' : map.hour;
        const now = toMin(`${hour}:${map.minute}`);

        const isOpen = now >= openMin && now < closeMin;
        statusText.textContent = isOpen ? labelOpen : labelClosed;
        if (dot) dot.classList.toggle('is-open', isOpen);
    };

    update();
    setInterval(update, 60000);
}

// ---------------------------------------------------------------- back to top
const backToTop = document.querySelector('.back-to-top');

if (backToTop) {
    const toggleBackToTop = () => {
        backToTop.classList.toggle('is-visible', scrollY > 600);
    };
    addEventListener('scroll', toggleBackToTop, { passive: true });
    toggleBackToTop();

    backToTop.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}

// ---------------------------------------------------------------- cookie consent
const cookieConsent = document.getElementById('cookie-consent');

if (cookieConsent) {
    const setConsent = (value) => {
        const secure = location.protocol === 'https:' ? '; Secure' : '';
        document.cookie = `cookie_consent=${value}; path=/; max-age=31536000; SameSite=Lax${secure}`;
        cookieConsent.classList.remove('is-visible');
        setTimeout(() => cookieConsent.remove(), 400);
    };

    const hasConsent = document.cookie
        .split(';')
        .some((c) => c.trim().startsWith('cookie_consent='));

    if (!hasConsent) {
        cookieConsent.hidden = false;
        requestAnimationFrame(() => cookieConsent.classList.add('is-visible'));
    }

    cookieConsent
        .querySelector('[data-cookie-accept]')
        ?.addEventListener('click', () => setConsent('accepted'));
    cookieConsent
        .querySelector('[data-cookie-decline]')
        ?.addEventListener('click', () => setConsent('rejected'));
}

// ---------------------------------------------------------------- admin flash dismiss
document.querySelectorAll('.flash-msg').forEach((el) => {
    const dismiss = () => {
        el.classList.add('is-dismiss');
        setTimeout(() => el.remove(), 300);
    };

    const closeBtn = el.querySelector('[data-flash-close]');
    if (closeBtn) closeBtn.addEventListener('click', dismiss);

    setTimeout(dismiss, 5000);
});

// ---------------------------------------------------------------- admin sidebar toggle
const sidebarToggle = document.querySelector('[data-sidebar-toggle]');
const sidebar = document.querySelector('.admin-sidebar');

if (sidebarToggle && sidebar) {
    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('is-open');
    });

    document.addEventListener('click', (e) => {
        if (sidebar.classList.contains('is-open') && !sidebar.contains(e.target) && e.target !== sidebarToggle) {
            sidebar.classList.remove('is-open');
        }
    });
}

// ---------------------------------------------------------------- data-confirm forms
document.querySelectorAll('[data-confirm]').forEach((el) => {
    el.addEventListener('submit', (e) => {
        if (!confirm(el.dataset.confirm)) e.preventDefault();
    });
});

// ---------------------------------------------------------------- image upload preview
document.querySelectorAll('[data-upload]').forEach((wrap) => {
    const input = wrap.querySelector('input[type="file"]');
    const preview = wrap.querySelector('[data-upload-preview]');
    if (!input || !preview) return;

    input.addEventListener('change', () => {
        const file = input.files[0];
        if (!file) { preview.innerHTML = ''; return; }
        const url = URL.createObjectURL(file);
        preview.innerHTML = '<img src="' + url + '" alt="Preview" class="max-h-48 rounded border border-ink/10">';
    });
});
