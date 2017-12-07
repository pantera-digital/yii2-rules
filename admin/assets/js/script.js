const rulesActionModal = $('#rules-actions-modal');
const initAce = function () {
    var textarea = $('#rulesactions-php_code');
    var editor = ace.edit("editor");
    editor.setTheme("ace/theme/dracula");
    editor.getSession().setMode({path: "ace/mode/php", inline: true});

    editor.getSession().on("change", function () {
        textarea.val(editor.getSession().getValue());
    });

    editor.getSession().setValue(textarea.val());
};

//Когда модалка загузится инициализируем редактор
rulesActionModal.on('loaded.modal.bs', function () {
    initAce();
});

//Очистка модалки после закрытия
rulesActionModal.on('hidden.bs.modal', function (e) {
    $(e.target).removeData('bs.modal');
    $(this).find('.modal-content').html('');
});

//Удаление rules action с грида
$(document).on('click', '.delete-action', function () {
    if (confirm('Are you sure?')) {
        $.ajax({
            url: $(this).attr('href'),
            type: 'post',
            success: function () {
                $.pjax.reload('#rules-actions-pjax-container');
            }
        });
    }
    return false;
});

//Добавление rules action в конце закрытие модалки и перезагрузка контейнера
$(document).on('submit', '#rules-actions-form', function () {
    var form = $(this);
    $.post(form.attr('action'), form.serialize(), function () {
        $('#rules-actions-modal').modal('hide');
        $.pjax.reload('#rules-actions-pjax-container');
    });
    return false;
});