let editor;
try {
    document.getElementById('addCommentBtn').addEventListener('click', addNewComment);
    hljs.configure({
        languages: ['php', 'javascript', 'ruby', 'python']
    });
    editor = new Quill('#newComment', {
        theme: "snow",
        placeholder: 'Время что-то написать...',
        modules: {
            syntax: true,
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
                ['blockquote', 'code-block'],

                [{'header': 1}, {'header': 2}],               // custom button values
                [{'list': 'ordered'}, {'list': 'bullet'}],
                [{'script': 'sub'}, {'script': 'super'}],      // superscript/subscript
                [{'indent': '-1'}, {'indent': '+1'}, {'align': []}],          // outdent/indent
                [{'direction': 'rtl'}],                         // text direction

                [{'size': ['small', false, 'large', 'huge']}],  // custom dropdown
                [{'header': [1, 2, 3, 4, 5, 6, false]}],

                [{'color': []}, {'background': []}],          // dropdown with defaults from theme
                [{'font': []}],


                ['formula'],
                ['image', 'video'],

                ['clean']
            ],
            // history: {
            //     delay: 1000,
            //     maxStack: 5000,
            //     userOnly: true
            // }
        }
    });
} catch (e) {
}

loadComments().then(value => renderComments(value));

function showPageModal() {
    let modal = document.getElementById('pageModal');
    document.querySelector('body').classList.add('modal-open');
    modal.classList.remove('hidden');
    modal.classList.add('shown');
}

function hidePageModal() {
    let modal = document.getElementById('pageModal');
    document.querySelector('body').classList.remove('modal-open');
    modal.classList.remove('shown');
    modal.classList.add('hidden');
}

function addNewComment() {
    if (editor.getLength() > 10) {
        let comment = editor.container.children[0].innerHTML,
            thread_id = document.querySelector('[data-thread]');

        let xr = new XMLHttpRequest(),
            body = JSON.stringify({
                thread: thread_id.dataset.thread,
                comment: comment
            });
        xr.open('POST', '/api/comments.new');
        xr.send(body);
        editor.deleteText(0, editor.getLength());
        xr.onreadystatechange = function () {
            if (xr.readyState === 4 && xr.status === 200) {
                let response = JSON.parse(xr.response);
                loadComments().then(value => renderComments(value));
            }
        };
    } else {
        alert("Комментарий должен содержать минимум 10 символов!")
    }
}

function loadComments() {
    return new Promise(resolve => {
        let xr = new XMLHttpRequest(),
            thread_id = document.querySelector('[data-thread]'),
            body = JSON.stringify({
                thread: thread_id.dataset.thread,
            });
        xr.open('POST', '/api/comments.get');
        xr.send(body);
        xr.onreadystatechange = function () {
            if (xr.readyState === 4 && xr.status === 200) {
                resolve(JSON.parse(xr.response));
            }
        }

    })
}

function renderComments(comments) {
    let commentsListWrapper = document.getElementById('threadCommentsList'),
        commentsList = [];
    comments.map(comments => {
        let userAvatar = `<div class="user-avatar">${comments.author[0].toUpperCase()}</div>`;
        if (comments.avatar) {
            userAvatar = ` <div class="user-avatar" style="background: none"><img class="uAvatar" src="${comments.avatar}" alt="${comments.author} avatar" width="40"
                             height="40"></div>`;
        }
        let newComment = `
     <li class="comments-list__item">
                <div class="comment">
                    <div class="comment-col">
                            ${userAvatar}
                        
                    </div>
                    <div class="comment-col">
                        <div class="comment-header">
                            <div class="comment-header__username">
                                <span>${comments.author}</span>
                            </div>
                            <div class="comment-header__date">
                                <span>${comments.datetime}</span>
                            </div>
                        </div>
                        <div class="comment-body">
                            ${comments.content}
                        </div>
                        <div class="comment-footer">
                            <ul class="action-list">
                                <li class="action-list__item">
                                    <i class="fas fa-thumbs-up"></i>
                                    <span class="action-list__item-counter">${comments.like}</span>
                                </li>
                                <li class="action-list__item">
                                    <i class="fas fa-thumbs-down"></i>
                                    <span class="action-list__item-counter">${comments.dislike}</span>
                                </li>
                                <li class="action-list__item">
                                    <i class="fas fa-heart"></i>
                                    <span class="action-list__item-counter">${comments.fav}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
    `;
        commentsList.push(newComment);
    });
    commentsListWrapper.innerHTML = commentsList.join('');
    document.querySelectorAll('img').forEach(value => {
        if (!value.classList.contains('uAvatar')) {
            value.classList.add("spotlight");
        }
        // value.title = "Нажмите для просмотра";
    })
}



