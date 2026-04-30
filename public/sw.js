self.addEventListener('push', function (e) {
    let data = { title: '💪 MyGymCoach', body: 'حان وقت التمرين!', icon: '/images/logo-icon.svg', url: '/home' };
    try { data = Object.assign(data, e.data.json()); } catch (_) {}

    e.waitUntil(
        self.registration.showNotification(data.title, {
            body: data.body,
            icon: data.icon,
            badge: '/images/logo-icon.svg',
            dir: 'rtl',
            lang: 'ar',
            vibrate: [200, 100, 200],
            data: { url: data.url },
        })
    );
});

self.addEventListener('notificationclick', function (e) {
    e.notification.close();
    e.waitUntil(clients.openWindow(e.notification.data.url || '/home'));
});
