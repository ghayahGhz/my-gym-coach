// MyGymCoach — Main JS Entry
// Sets up CSRF for all fetch requests globally
const csrfToken = document.querySelector('meta[name=csrf-token]')?.content;
if (csrfToken) {
    const origFetch = window.fetch;
    window.fetch = (url, opts = {}) => {
        opts.headers = { 'X-CSRF-TOKEN': csrfToken, ...opts.headers };
        return origFetch(url, opts);
    };
}
