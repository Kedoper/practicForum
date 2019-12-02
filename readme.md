## Описание API

<table>
            <thead>
            <tr>
                <td><span>Секция</span></td>
                <td><span>Методы</span></td>
                <td><span>Общедоступное</span></td>
            </tr>
            </thead>
            <tbody>
            <tr class="section">
                <td><span>threads</span></td>
                <td>
                    <table>
                        <thead>
                        <tr>
                            <td><span>Название</span></td>
                            <td><span>Параметры</span></td>
                            <td><span>Описание</span></td>
                            <td><span>Доступ</span></td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="method">
                            <td><span>gen</span></td>
                            <td><span>Нет</span></td>
                            <td><span>Генерирует случайные записи</span></td>
                            <td><span>По токену</span></td>
                        </tr>
                        <tr class="method">
                            <td><span>get</span></td>
                            <td>
                                <table>
                                    <thead>
                                    <tr>
                                        <td><span>Название</span></td>
                                        <td><span>Тип данных</span></td>
                                        <td><span>Описание</span></td>
                                        <td><span>Тип</span></td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><span>offset</span></td>
                                        <td><span>int</span></td>
                                        <td><span>Указывает, сколько
                                            нужно пропустить записей.
                                            По умолчанию равен 0</span>
                                        </td>
                                        <td><span>Опционально</span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td><span>Получение списка тем</span></td>
                            <td><span>Публичный</span></td>
                        </tr>
                        <tr class="method">
                            <td><span>getbyid</span></td>
                            <td>
                                <table>
                                    <thead>
                                    <tr>
                                        <td><span>Название</span></td>
                                        <td><span>Тип данных</span></td>
                                        <td><span>Описание</span></td>
                                        <td><span>Тип</span></td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><span>id</span></td>
                                        <td><span>int</span></td>
                                        <td><span>Уникальный идентификатор темы</span></td>
                                        <td><span>Обязательный</span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td><span>Получение темы по уникальному идентификатору</span></td>
                            <td><span>Публичный</span></td>
                        </tr>
                        <tr class="method">
                            <td><span>new</span></td>
                            <td>
                                <table>
                                    <thead>
                                    <tr>
                                        <td><span>Название</span></td>
                                        <td><span>Тип данных</span></td>
                                        <td><span>Описание</span></td>
                                        <td><span>Тип</span></td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><span>title</span></td>
                                        <td><span>string</span></td>
                                        <td><span>Название темы</span></td>
                                        <td><span>Обязательный</span></td>
                                    </tr>
                                    <tr>
                                        <td><span>category</span></td>
                                        <td><span>int</span></td>
                                        <td><span>Категория темы</span></td>
                                        <td><span>Обязательный</span></td>
                                    </tr>
                                    <tr>
                                        <td><span>content</span></td>
                                        <td><span>string</span></td>
                                        <td><span>Текст темы</span></td>
                                        <td><span>Обязательно</span></td>
                                    </tr>
                                    <tr>
                                        <td><span>tags</span></td>
                                        <td><span>array</span></td>
                                        <td><span>Теги темы</span></td>
                                        <td><span>Опционально</span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td><span>Создание темы</span></td>
                            <td><span>По токену</span></td>
                        </tr>
                        </tbody>
                    </table>
                </td>
                <td><span>Частично</span></td>
            </tr>
            <tr class="section">
                <td><span>comments</span></td>
                <td>
                    <table>
                        <thead>
                        <tr>
                            <td><span>Название</span></td>
                            <td><span>Параметры</span></td>
                            <td><span>Описание</span></td>
                            <td><span>Доступ</span></td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="method">
                            <td><span>get</span></td>
                            <td>
                                <table>
                                    <thead>
                                    <tr>
                                        <td><span>Название</span></td>
                                        <td><span>Тип данных</span></td>
                                        <td><span>Описание</span></td>
                                        <td><span>Тип</span></td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><span>offset</span></td>
                                        <td><span>int</span></td>
                                        <td><span>Указывает, сколько
                                            нужно пропустить записей.
                                            По умолчанию равен 0</span></td>
                                        <td><span>Опционально</span></td>
                                    </tr>
                                    <tr>
                                        <td><span>thread_id</span></td>
                                        <td><span>int</span></td>
                                        <td><span>Идентификатор темы</span></td>
                                        <td><span>Обязательный</span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td><span>Получение списка комментариев, которые
                            относятся к выбранной теме.</span>
                            </td>
                            <td><span>Публичный</span></td>
                        </tr>
                        <tr class="method">
                            <td><span>new</span></td>
                            <td>
                                <table>
                                    <thead>
                                    <tr>
                                        <td><span>Название</span></td>
                                        <td><span>Тип данных</span></td>
                                        <td><span>Описание</span></td>
                                        <td><span>Тип</span></td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><span>thread_id</span></td>
                                        <td><span>int</span></td>
                                        <td><span>Идентификатор темы</span></td>
                                        <td><span>Обязательный</span></td>
                                    </tr>
                                    <tr>
                                        <td><span>content</span></td>
                                        <td><span>string</span></td>
                                        <td><span>Текст комментария</span></td>
                                        <td><span>Обязательный</span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td><span>Создание нового комментария</span></td>
                            <td><span>По токену</span></td>
                        </tr>
                        </tbody>
                    </table>
                </td>
                <td><span>Частично</span></td>
            </tr>
            <tr class="section">
                <td><span>action</span></td>
                <td>
                    <table>
                        <thead>
                        <tr>
                            <td><span>Название</span></td>
                            <td><span>Параметры</span></td>
                            <td><span>Описание</span></td>
                            <td><span>Доступ</span></td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="method">
                            <td><span>thread</span></td>
                            <td>
                                <table>
                                    <thead>
                                    <tr>
                                        <td><span>Название</span></td>
                                        <td><span>Тип данных</span></td>
                                        <td><span>Описание</span></td>
                                        <td><span>Тип</span></td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><span>action</span></td>
                                        <td><span>string</span></td>
                                        <td><span>Тип действия, возможен один из вариантов:</span>
                                            <ul class="list">
                                                <li>like</li>
                                                <li>dislike</li>
                                                <li>fav</li>
                                                <li>report</li>
                                                <li>delete</li>
                                                <li>close</li>
                                                <li>edit</li>
                                            </ul>
                                        </td>
                                        <td><span>Обязательный</span></td>
                                    </tr>
                                    <tr>
                                        <td><span>thread_id</span></td>
                                        <td><span>int</span></td>
                                        <td><span>Идентификатор темы</span></td>
                                        <td><span>Обязательный</span></td>
                                    </tr>
                                    <tr>
                                        <td><span>reason</span></td>
                                        <td><span>string</span></td>
                                        <td><span>Причина жалобы/удаления/закрытия/редактирования</span></td>
                                        <td><span>Опционально, в зависимости от поля <b>action</b></span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td><span>Действия с темой</span></td>
                            <td><span>По токену</span></td>
                        </tr>
                        <tr class="method">
                            <td><span>comment</span></td>
                            <td>
                                <table>
                                    <thead>
                                    <tr>
                                        <td><span>Название</span></td>
                                        <td><span>Тип данных</span></td>
                                        <td><span>Описание</span></td>
                                        <td><span>Тип</span></td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><span>action</span></td>
                                        <td><span>string</span></td>
                                        <td><span>Тип действия, возможен один из вариантов:</span>
                                            <ul class="list">
                                                <li>like</li>
                                                <li>dislike</li>
                                                <li>fav</li>
                                                <li>report</li>
                                                <li>delete</li>
                                                <li>edit</li>
                                            </ul>
                                        </td>
                                        <td><span>Обязательный</span></td>
                                    </tr>
                                    <tr>
                                        <td><span>comment_id</span></td>
                                        <td><span>int</span></td>
                                        <td><span>Идентификатор комментария</span></td>
                                        <td><span>Обязательный</span></td>
                                    </tr>
                                    <tr>
                                        <td><span>reason</span></td>
                                        <td><span>string</span></td>
                                        <td><span>Причина жалобы\удаления</span></td>
                                        <td><span>Опционально, в зависимости от поля <b>action</b></span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td><span>Действия с комментарием</span></td>
                            <td><span>По токену</span></td>
                        </tr>
                        </tbody>
                    </table>
                </td>
                <td><span>Нет</span></td>
            </tr>
            </tbody>
        </table>
