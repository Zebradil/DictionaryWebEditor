"use strict";

(function ($) {

    $(document).ready(function () {
        initFormFactory($('#comments-container'), $('#add-comment-link'));
        initFormFactory($('#meanings-container'), $('#add-meaning-link'));
        initFormFactory($('#links-container'), $('#add-link-link'));

        $('body').on('click', '.delete-form-child-link', function (e) {
            e.preventDefault();
            var $panelHeading = $(this).parent();
            $panelHeading.add($panelHeading.next()).remove();
        });

    });

    function initFormFactory($container, $link) {
        $container.data('index', $container.children().length);
        $link.on('click', function (e) {
            e.preventDefault();
            addForm($container);
        });
    }

    function addForm($container) {
        var index = $container.data('index');
        var $newForm = $($container.data('prototype').replace(/__name__/g, index));
        $newForm.appendTo($container).find('select').select2();
        $container.data('index', index + 1);
    }

})(jQuery);