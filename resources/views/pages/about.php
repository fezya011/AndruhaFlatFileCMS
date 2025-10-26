<?php
// Специальный шаблон для страницы "Обо мне"
?>
<div class="about-page">
    <div class="profile-card fade-in-up">
        <div class="profile-header">
            <h1><?= htmlspecialchars($content['meta']['title'] ?? 'Обо мне') ?></h1>
            <div class="profile-tagline">Начинающий веб-разработчик и IT-энтузиаст</div>
        </div>

        <!-- Основной контент из MarkDown -->
        <?php if (!empty($content['content'])): ?>
        <div class="content-section main-content">
            <div class="about-content">
                <?= $content['content'] ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Блок с навыками -->
        <div class="content-section">
            <h2><i class="fas fa-code"></i> Технические навыки</h2>
            <div class="skills-grid">
                <div class="skill-category">
                    <div class="skill-header">
                        <i class="fab fa-js-square"></i>
                        <h3>Frontend</h3>
                    </div>
                    <div class="skill-items">
                        <div class="skill-item">
                            <span class="skill-name">HTML/CSS</span>
                            <div class="skill-bar">
                                <div class="skill-progress" data-level="85"></div>
                            </div>
                            <span class="skill-percent">85%</span>
                        </div>
                        <div class="skill-item">
                            <span class="skill-name">JavaScript</span>
                            <div class="skill-bar">
                                <div class="skill-progress" data-level="70"></div>
                            </div>
                            <span class="skill-percent">70%</span>
                        </div>
                        <div class="skill-item">
                            <span class="skill-name">React (изучаю)</span>
                            <div class="skill-bar">
                                <div class="skill-progress" data-level="40"></div>
                            </div>
                            <span class="skill-percent">40%</span>
                        </div>
                    </div>
                </div>

                <div class="skill-category">
                    <div class="skill-header">
                        <i class="fas fa-server"></i>
                        <h3>Backend</h3>
                    </div>
                    <div class="skill-items">
                        <div class="skill-item">
                            <span class="skill-name">PHP</span>
                            <div class="skill-bar">
                                <div class="skill-progress" data-level="75"></div>
                            </div>
                            <span class="skill-percent">75%</span>
                        </div>
                        <div class="skill-item">
                            <span class="skill-name">MySQL</span>
                            <div class="skill-bar">
                                <div class="skill-progress" data-level="65"></div>
                            </div>
                            <span class="skill-percent">65%</span>
                        </div>
                        <div class="skill-item">
                            <span class="skill-name">Node.js (изучаю)</span>
                            <div class="skill-bar">
                                <div class="skill-progress" data-level="35"></div>
                            </div>
                            <span class="skill-percent">35%</span>
                        </div>
                    </div>
                </div>

                <div class="skill-category">
                    <div class="skill-header">
                        <i class="fas fa-tools"></i>
                        <h3>Инструменты</h3>
                    </div>
                    <div class="skill-items">
                        <div class="skill-item">
                            <span class="skill-name">Git</span>
                            <div class="skill-bar">
                                <div class="skill-progress" data-level="80"></div>
                            </div>
                            <span class="skill-percent">80%</span>
                        </div>
                        <div class="skill-item">
                            <span class="skill-name">VS Code</span>
                            <div class="skill-bar">
                                <div class="skill-progress" data-level="90"></div>
                            </div>
                            <span class="skill-percent">90%</span>
                        </div>
                        <div class="skill-item">
                            <span class="skill-name">Figma</span>
                            <div class="skill-bar">
                                <div class="skill-progress" data-level="60"></div>
                            </div>
                            <span class="skill-percent">60%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Блок с образованием -->
        <div class="content-section">
            <h2><i class="fas fa-graduation-cap"></i> Образование и опыт</h2>
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-date">2022 - настоящее время</div>
                    <div class="timeline-content">
                        <h3>Самостоятельное изучение программирования</h3>
                        <p>Активно изучаю веб-разработку через онлайн-курсы, документацию и практические проекты</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-date">2023</div>
                    <div class="timeline-content">
                        <h3>Первые коммерческие проекты</h3>
                        <p>Разработка сайтов и веб-приложений для небольших компаний и стартапов</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-date">2024</div>
                    <div class="timeline-content">
                        <h3>Разработка собственной CMS</h3>
                        <p>Создание flat-file CMS на PHP для небольших сайтов и блогов</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Блок с целями -->
        <div class="content-section">
            <h2><i class="fas fa-bullseye"></i> Цели и планы</h2>
            <div class="goals-grid">
                <div class="goal-card">
                    <div class="goal-icon">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <h3>Стать профессиональным разработчиком</h3>
                    <p>Развивать навыки full-stack разработки и работать над интересными проектами</p>
                </div>
                <div class="goal-card">
                    <div class="goal-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Присоединиться к IT-сообществу</h3>
                    <p>Участвовать в open-source проектах и сотрудничать с другими разработчиками</p>
                </div>
                <div class="goal-card">
                    <div class="goal-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3>Поступить в университет</h3>
                    <p>Получить высшее образование в сфере IT и компьютерных наук</p>
                </div>
            </div>
        </div>

        <!-- Призыв к действию -->
        <div class="content-section text-center">
            <h2><i class="fas fa-handshake"></i> Готов к сотрудничеству!</h2>
            <p class="cta-text">Ищу интересные проекты и возможности для роста. Давайте создадим что-то amazing вместе!</p>
            <div class="cta-actions">
                <a href="/contact" class="btn btn-primary btn-large">
                    <i class="fas fa-paper-plane"></i> Связаться со мной
                </a>
                <a href="/articles" class="btn btn-secondary btn-large">
                    <i class="fas fa-newspaper"></i> Читать мои статьи
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.about-page {
    padding: 2rem 0;
}

.main-content {
    text-align: center;
}

.about-content {
    color: var(--light-2);
    line-height: 1.8;
    font-size: 1.1rem;
    max-width: 800px;
    margin: 0 auto;
}

.about-content h2 {
    color: var(--light-1);
    margin: 2rem 0 1rem 0;
    font-size: 1.8rem;
}

.about-content h3 {
    color: var(--light-1);
    margin: 1.5rem 0 0.8rem 0;
    font-size: 1.4rem;
}

/* Стили для навыков */
.skills-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

.skill-category {
    background: var(--gradient-card);
    padding: 2rem;
    border-radius: 16px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: all var(--transition-normal);
}

.skill-category:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.skill-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid rgba(255, 255, 255, 0.1);
}

.skill-header i {
    font-size: 2rem;
    background: var(--gradient-primary);
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.skill-header h3 {
    color: var(--light-1);
    margin: 0;
    font-size: 1.3rem;
}

.skill-items {
    display: flex;
    flex-direction: column;
    gap: 1.2rem;
}

.skill-item {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.skill-name {
    flex: 1;
    color: var(--light-2);
    font-weight: 500;
    min-width: 120px;
}

.skill-bar {
    flex: 2;
    height: 8px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 4px;
    overflow: hidden;
    position: relative;
}

.skill-progress {
    height: 100%;
    background: var(--gradient-primary);
    border-radius: 4px;
    width: 0;
    transition: width 1.5s ease-in-out;
    position: relative;
}

.skill-progress::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

.skill-percent {
    color: var(--primary);
    font-weight: 600;
    min-width: 40px;
    text-align: right;
}

/* Стили для таймлайна */
.timeline {
    position: relative;
    margin-top: 2rem;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 30px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: var(--gradient-primary);
}

.timeline-item {
    display: flex;
    margin-bottom: 3rem;
    position: relative;
}

.timeline-date {
    width: 120px;
    padding-right: 2rem;
    text-align: right;
    color: var(--primary);
    font-weight: 600;
    font-size: 0.9rem;
}

.timeline-content {
    flex: 1;
    background: var(--gradient-card);
    padding: 1.5rem;
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    margin-left: 2rem;
    position: relative;
    transition: all var(--transition-normal);
}

.timeline-content:hover {
    transform: translateX(10px);
    box-shadow: var(--shadow-lg);
}

.timeline-content::before {
    content: '';
    position: absolute;
    left: -10px;
    top: 20px;
    width: 20px;
    height: 20px;
    background: var(--gradient-primary);
    border-radius: 50%;
    border: 4px solid var(--dark-2);
}

.timeline-content h3 {
    color: var(--light-1);
    margin-bottom: 0.5rem;
    font-size: 1.2rem;
}

.timeline-content p {
    color: var(--light-3);
    margin: 0;
    line-height: 1.6;
}

/* Стили для целей */
.goals-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

.goal-card {
    background: var(--gradient-card);
    padding: 2.5rem 2rem;
    border-radius: 16px;
    text-align: center;
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: all var(--transition-normal);
    position: relative;
    overflow: hidden;
}

.goal-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-primary);
}

.goal-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-lg), var(--shadow-glow);
}

.goal-icon {
    width: 70px;
    height: 70px;
    margin: 0 auto 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--gradient-primary);
    border-radius: 50%;
    font-size: 1.8rem;
}

.goal-card h3 {
    color: var(--light-1);
    margin-bottom: 1rem;
    font-size: 1.2rem;
}

.goal-card p {
    color: var(--light-3);
    line-height: 1.6;
    margin: 0;
}

/* Призыв к действию */
.cta-text {
    font-size: 1.1rem;
    color: var(--light-2);
    line-height: 1.7;
    margin-bottom: 2rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.cta-actions {
    display: flex;
    gap: 1.5rem;
    justify-content: center;
    flex-wrap: wrap;
}

/* Адаптивность */
@media (max-width: 768px) {
    .about-page {
        padding: 1rem 0;
    }
    
    .skills-grid {
        grid-template-columns: 1fr;
    }
    
    .skill-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .skill-bar {
        width: 100%;
    }
    
    .timeline::before {
        left: 20px;
    }
    
    .timeline-date {
        width: 80px;
        padding-right: 1rem;
    }
    
    .timeline-content {
        margin-left: 1.5rem;
    }
    
    .goals-grid {
        grid-template-columns: 1fr;
    }
    
    .cta-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .btn-large {
        width: 100%;
        max-width: 300px;
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .skill-category {
        padding: 1.5rem;
    }
    
    .goal-card {
        padding: 2rem 1.5rem;
    }
    
    .timeline-item {
        flex-direction: column;
    }
    
    .timeline-date {
        width: 100%;
        text-align: left;
        padding-right: 0;
        margin-bottom: 0.5rem;
    }
}
</style>

<script>
// Анимация прогресс-баров
document.addEventListener('DOMContentLoaded', function() {
    const progressBars = document.querySelectorAll('.skill-progress');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const progressBar = entry.target;
                const level = progressBar.getAttribute('data-level');
                progressBar.style.width = level + '%';
            }
        });
    }, { threshold: 0.5 });
    
    progressBars.forEach(bar => observer.observe(bar));
    
    // Анимация появления элементов
    const animateElements = document.querySelectorAll('.skill-category, .timeline-item, .goal-card');
    
    animateElements.forEach((element, index) => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(30px)';
        
        setTimeout(() => {
            element.style.transition = 'all 0.6s ease';
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>