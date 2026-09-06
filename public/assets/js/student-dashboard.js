/**
 * Student Dashboard Core Scripts
 * Handles tab switching, URL hash routing, theme switching, and custom calendar rendering.
 */

function switchTab(sectionName) {
    // 1. Remove active state from all sections and sidebar buttons
    document.querySelectorAll('.tab-section').forEach(el => {
        el.classList.remove('active-section');
        el.style.display = 'none'; // Fallback to ensure hidden
    });
    document.querySelectorAll('.acad-sidebar .nav-item-custom, .nav-item-custom').forEach(el => {
        el.classList.remove('active');
    });

    // 2. Activate target section and navbar item
    const targetSection = document.getElementById('section-' + sectionName);
    if (targetSection) {
        targetSection.classList.add('active-section');
        targetSection.style.display = 'block';
    }

    const targetBtn = document.getElementById('btn-nav-' + sectionName);
    if (targetBtn) {
        targetBtn.classList.add('active');
    }

    // 3. Update URL Hash for state persistence
    if (window.location.hash !== '#' + sectionName) {
        history.pushState(null, null, '#' + sectionName);
    }

    // 4. Trigger FullCalendar re-render if switching to attendance tab
    if (sectionName === 'attendances' && window.studentCalendar) {
        setTimeout(() => {
            window.studentCalendar.render();
            window.studentCalendar.updateSize();
        }, 120);
    }

    // 5. Smooth scroll to top
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

document.addEventListener('DOMContentLoaded', function () {
    // --- Theme Switcher Logic ---
    const themeToggleBtn = document.getElementById('themeToggleBtn');
    const themeIcon = document.getElementById('themeIcon');
    const htmlElement = document.documentElement;

    const savedTheme = localStorage.getItem('student_portal_theme') || 'light';
    setTheme(savedTheme);

    if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', function () {
            const currentTheme = htmlElement.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            setTheme(newTheme);
        });
    }

    function setTheme(theme) {
        htmlElement.setAttribute('data-bs-theme', theme);
        localStorage.setItem('student_portal_theme', theme);
        if (themeIcon) {
            if (theme === 'dark') {
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
            } else {
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
            }
        }
    }

    // --- Tab Routing & Hash Handling ---
    const handleHashChange = () => {
        const hash = window.location.hash.replace('#', '');
        if (hash && document.getElementById('section-' + hash)) {
            switchTab(hash);
        } else {
            // Default fallback tab if no hash or invalid hash
            switchTab('dashboard');
        }
    };

    // Initial evaluation on load
    handleHashChange();

    // Re-evaluate on URL hash updates
    window.addEventListener('hashchange', handleHashChange);

    // --- Calendar Implementation ---
    let currentDate = new Date();
    const monthYearLabel = document.getElementById('calendar-month-year');
    const daysContainer = document.getElementById('calendar-days-container');
    const prevBtn = document.getElementById('prev-month-btn');
    const nextBtn = document.getElementById('next-month-btn');

    function renderCalendar() {
        if (!daysContainer || !monthYearLabel) return;

        daysContainer.innerHTML = '';

        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();
        const today = new Date();

        const firstDayIndex = new Date(year, month, 1).getDay();
        const totalDays = new Date(year, month + 1, 0).getDate();

        const monthNames = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];

        monthYearLabel.textContent = `${monthNames[month]} ${year}`;

        // Empty padding slots before month start
        for (let i = 0; i < firstDayIndex; i++) {
            const emptyDiv = document.createElement('div');
            emptyDiv.innerHTML = `<div class="schedule-day-box opacity-0"></div>`;
            daysContainer.appendChild(emptyDiv);
        }

        // Render month days
        for (let day = 1; day <= totalDays; day++) {
            const dayWrapper = document.createElement('div');
            const dayBox = document.createElement('div');
            dayBox.className = 'schedule-day-box text-dark fw-medium';
            dayBox.textContent = day;

            if (
                day === today.getDate() &&
                month === today.getMonth() &&
                year === today.getFullYear()
            ) {
                dayBox.classList.add('is-today');
            }

            dayWrapper.appendChild(dayBox);
            daysContainer.appendChild(dayWrapper);
        }
    }

    if (prevBtn && nextBtn) {
        prevBtn.addEventListener('click', function () {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        });

        nextBtn.addEventListener('click', function () {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        });

        renderCalendar();
    }
});