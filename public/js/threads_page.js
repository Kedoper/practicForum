document.getElementById('addCommentBtn').addEventListener('click', addNewComment);


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
        let comment = editor.container.children[0].innerHTML;

        let xr = new XMLHttpRequest(),
            body = JSON.stringify({
                thread: this.dataset.thread,
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
            thread_id = document.getElementById('addCommentBtn'),
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
        let newComment = `
     <li class="comments-list__item">
                <div class="comment">
                    <div class="comment-col">
                        <div class="user-avatar">
                            F
                        </div>
                    </div>
                    <div class="comment-col">
                        <div class="comment-header">
                            <div class="comment-header__username">
                                <span>Ferlom189</span>
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
        value.classList.add("spotlight");
        // value.title = "Нажмите для просмотра";
    })
}


hljs.configure({
    languages: ['php', 'javascript', 'ruby', 'python']
});
let editor = new Quill('#newComment', {
    theme: "snow",
    placeholder: 'Время что-то написать...',
    modules: {
        syntax: true,
        toolbar: [
            ['formula'],
            ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
            ['blockquote', 'code-block'],

            [{'header': 1}, {'header': 2}],               // custom button values
            [{'list': 'ordered'}, {'list': 'bullet'}],
            [{'script': 'sub'}, {'script': 'super'}],      // superscript/subscript
            [{'indent': '-1'}, {'indent': '+1'}],          // outdent/indent
            [{'direction': 'rtl'}],                         // text direction

            [{'size': ['small', false, 'large', 'huge']}],  // custom dropdown
            [{'header': [1, 2, 3, 4, 5, 6, false]}],

            [{'color': []}, {'background': []}],          // dropdown with defaults from theme
            [{'font': []}],
            [{'align': []}],

            ['image', 'video'],

            ['clean']
        ],
    }
});