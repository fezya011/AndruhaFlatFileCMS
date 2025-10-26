<?php
// Специальный шаблон для страницы контактов
?>
<div class="contacts-page">
    <div class="profile-card fade-in-up">
        <div class="profile-header">
            <h1><?= htmlspecialchars($content['meta']['title'] ?? 'Контакты') ?></h1>
            <div class="profile-tagline">Свяжитесь со мной для сотрудничества и обсуждения проектов</div>
        </div>

        <div class="content-section">
            <h2><i class="fas fa-envelope"></i> Мои контакты</h2>
            
            <div class="contact-links">
                <a href="mailto:agodovanskij@inbox.ru" class="contact-link">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="contact-info">
                        <span class="contact-label">Email</span>
                        <span class="contact-value">agodovanskij@inbox.ru</span>
                    </div>
                    <div class="contact-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
                
                <a href="tel:+79143496419" class="contact-link">
                    <div class="contact-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="contact-info">
                        <span class="contact-label">Телефон</span>
                        <span class="contact-value">+7 (914) 349-64-19</span>
                    </div>
                    <div class="contact-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
                
                <div class="contact-link">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="contact-info">
                        <span class="contact-label">Адрес</span>
                        <span class="contact-value">г. Владивосток, Россия</span>
                    </div>
                    <div class="contact-arrow">
                        <i class="fas fa-map"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-section">
            <h2><i class="fas fa-clock"></i> Время для связи</h2>
            <div class="schedule-grid">
                <div class="schedule-item">
                    <div class="schedule-day">Понедельник - Пятница</div>
                    <div class="schedule-time">9:00 - 18:00</div>
                </div>
                <div class="schedule-item">
                    <div class="schedule-day">Суббота</div>
                    <div class="schedule-time">10:00 - 16:00</div>
                </div>
                <div class="schedule-item">
                    <div class="schedule-day">Воскресенье</div>
                    <div class="schedule-time">Выходной</div>
                </div>
            </div>
            <div class="schedule-note">
                <i class="fas fa-info-circle"></i> В другое время отвечаю при первой возможности
            </div>
        </div>

        <div class="content-section">
            <h2><i class="fas fa-share-alt"></i> Социальные сети</h2>
            <div class="social-grid">
                <a href="https://m.vk.com/veinsarempty" class="social-card vk" target="_blank">
                    <div class="social-icon">
                        <i class="fab fa-vk"></i>
                    </div>
                    <div class="social-info">
                        <span class="social-name">VK</span>
                        <span class="social-desc">Основное общение</span>
                    </div>
                    <div class="social-arrow">
                        <i class="fas fa-external-link-alt"></i>
                    </div>
                </a>
                
                <a href="https://t.me/pennoenjoyer" class="social-card telegram" target="_blank">
                    <div class="social-icon">
                        <i class="fab fa-telegram"></i>
                    </div>
                    <div class="social-info">
                        <span class="social-name">Telegram</span>
                        <span class="social-desc">Быстрые сообщения</span>
                    </div>
                    <div class="social-arrow">
                        <i class="fas fa-external-link-alt"></i>
                    </div>
                </a>
                
                <a href="https://github.com/fezya011" class="social-card github" target="_blank">
                    <div class="social-icon">
                        <i class="fab fa-github"></i>
                    </div>
                    <div class="social-info">
                        <span class="social-name">GitHub</span>
                        <span class="social-desc">Мои проекты</span>
                    </div>
                    <div class="social-arrow">
                        <i class="fas fa-external-link-alt"></i>
                    </div>
                </a>
            </div>
        </div>

        <div class="content-section text-center">
            <h2><i class="fas fa-comments"></i> Начнем общение?</h2>
            <p class="contact-invite">Не стесняйтесь обращаться по любым вопросам! Отвечаю быстро и всегда открыт к новым знакомствам и интересным проектам.</p>
            
            <div class="contact-actions">
                <a href="mailto:agodovanskij@inbox.ru" class="btn btn-primary btn-large">
                    <i class="fas fa-paper-plane"></i> Написать письмо
                </a>
                <a href="https://t.me/pennoenjoyer" class="btn btn-secondary btn-large" target="_blank">
                    <i class="fab fa-telegram"></i> Написать в Telegram
                </a>
            </div>
        </div>

        <!-- Дополнительный контент из MarkDown -->
        <?php if (!empty($content['content']) && trim(strip_tags($content['content'])) !== ''): ?>
        <div class="content-section additional-content">
            <h2><i class="fas fa-ellipsis-h"></i> Дополнительная информация</h2>
            <div class="markdown-content">
                <?= $content['content'] ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
.contacts-page {
    padding: 2rem 0;
}

/* Стили для контактных ссылок */
.contact-links {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-top: 2rem;
}

.contact-link {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    padding: 2rem;
    background: var(--gradient-card);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    text-decoration: none;
    color: var(--light-1);
    transition: all var(--transition-normal);
    position: relative;
    overflow: hidden;
}

.contact-link::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(99, 102, 241, 0.1), transparent);
    transition: left 0.6s;
}

.contact-link:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg), var(--shadow-glow);
    border-color: var(--primary);
}

.contact-link:hover::before {
    left: 100%;
}

.contact-icon {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--gradient-primary);
    border-radius: 50%;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.contact-info {
    flex: 1;
}

.contact-label {
    display: block;
    font-size: 0.9rem;
    color: var(--light-3);
    margin-bottom: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
}

.contact-value {
    display: block;
    font-weight: 700;
    font-size: 1.3rem;
    color: var(--light-1);
}

.contact-arrow {
    color: var(--primary);
    font-size: 1.2rem;
    opacity: 0.7;
    transition: all var(--transition-normal);
}

.contact-link:hover .contact-arrow {
    transform: translateX(5px);
    opacity: 1;
}

/* Стили для расписания */
.schedule-grid {
    display: grid;
    gap: 1rem;
    margin-top: 1.5rem;
}

.schedule-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: all var(--transition-normal);
}

.schedule-item:hover {
    background: rgba(255, 255, 255, 0.08);
    transform: translateX(5px);
}

.schedule-day {
    font-weight: 600;
    color: var(--light-1);
}

.schedule-time {
    color: var(--primary);
    font-weight: 600;
    background: rgba(99, 102, 241, 0.1);
    padding: 0.5rem 1rem;
    border-radius: 8px;
    border: 1px solid rgba(99, 102, 241, 0.3);
}

.schedule-note {
    margin-top: 1rem;
    padding: 1rem;
    background: rgba(16, 185, 129, 0.1);
    border: 1px solid rgba(16, 185, 129, 0.3);
    border-radius: 8px;
    color: var(--success);
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Стили для социальных сетей */
.social-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-top: 1.5rem;
}

.social-card {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    padding: 2rem;
    background: var(--gradient-card);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    text-decoration: none;
    color: var(--light-1);
    transition: all var(--transition-normal);
    position: relative;
    overflow: hidden;
}

.social-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
    transition: left 0.6s;
}

.social-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-lg), var(--shadow-glow);
}

.social-card:hover::before {
    left: 100%;
}

.social-card.vk:hover {
    border-color: #4a76a8;
}

.social-card.telegram:hover {
    border-color: #0088cc;
}

.social-card.github:hover {
    border-color: #6e5494;
}

.social-icon {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.social-card.vk .social-icon {
    background: #4a76a8;
}

.social-card.telegram .social-icon {
    background: #0088cc;
}

.social-card.github .social-icon {
    background: #6e5494;
}

.social-info {
    flex: 1;
}

.social-name {
    display: block;
    font-weight: 700;
    font-size: 1.2rem;
    margin-bottom: 0.3rem;
}

.social-desc {
    display: block;
    color: var(--light-3);
    font-size: 0.9rem;
}

.social-arrow {
    color: var(--light-3);
    font-size: 1.1rem;
    transition: all var(--transition-normal);
}

.social-card:hover .social-arrow {
    color: var(--primary);
    transform: translateX(3px);
}

/* Стили для призыва к действию */
.contact-invite {
    font-size: 1.1rem;
    color: var(--light-2);
    line-height: 1.7;
    margin-bottom: 2rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.contact-actions {
    display: flex;
    gap: 1.5rem;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 2rem;
}

.btn-large {
    padding: 1.2rem 2.5rem;
    font-size: 1.1rem;
}

/* Дополнительный контент */
.additional-content {
    border-top: 2px solid rgba(255, 255, 255, 0.1);
    margin-top: 3rem;
    padding-top: 2rem;
}

.markdown-content {
    color: var(--light-2);
    line-height: 1.7;
}

.markdown-content h3 {
    color: var(--light-1);
    margin: 1.5rem 0 1rem 0;
    font-size: 1.3rem;
}

.markdown-content p {
    margin-bottom: 1rem;
}

/* Адаптивность */
@media (max-width: 768px) {
    .contacts-page {
        padding: 1rem 0;
    }
    
    .contact-link {
        padding: 1.5rem;
        gap: 1rem;
    }
    
    .contact-icon {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
    }
    
    .contact-value {
        font-size: 1.1rem;
    }
    
    .social-grid {
        grid-template-columns: 1fr;
    }
    
    .social-card {
        padding: 1.5rem;
        gap: 1rem;
    }
    
    .schedule-item {
        flex-direction: column;
        gap: 0.5rem;
        text-align: center;
    }
    
    .contact-actions {
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
    .contact-link {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .contact-arrow {
        display: none;
    }
    
    .social-card {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .social-arrow {
        display: none;
    }
}
</style>

<script>
// Анимация появления элементов
document.addEventListener('DOMContentLoaded', function() {
    const elements = document.querySelectorAll('.contact-link, .social-card, .schedule-item');
    
    elements.forEach((element, index) => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            element.style.transition = 'all 0.6s ease';
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }, index * 100);
    });
});

// Копирование email при клике
document.querySelector('.contact-link[href^="mailto:"]').addEventListener('click', function(e) {
    const email = 'agodovanskij@inbox.ru';
    navigator.clipboard.writeText(email).then(() => {
        // Временное уведомление
        const originalHtml = this.innerHTML;
        this.innerHTML = '<div class="contact-icon"><i class="fas fa-check"></i></div><div class="contact-info"><span class="contact-label">Email скопирован!</span><span class="contact-value">' + email + '</span></div>';
        
        setTimeout(() => {
            this.innerHTML = originalHtml;
        }, 2000);
    });
});
</script>