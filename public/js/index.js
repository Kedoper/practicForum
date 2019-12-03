document.querySelectorAll('.new-thread')
    .forEach(newThreadButton =>
        newThreadButton.addEventListener('click',
            () => location.href = '/thread/new')
    );

