document.querySelectorAll('[data-thread_id]')
    .forEach(value => value.addEventListener('click', openThread));

function openThread() {
    location.href = "/thread/" + this.dataset.thread_id;
}