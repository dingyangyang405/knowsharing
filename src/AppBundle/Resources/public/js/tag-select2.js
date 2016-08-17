$('.tag-select').select2({
    ajax: {
        url: $('.tag-select').data('url'),
        delay: 250,
        type: 'POST',
        dataType: 'json',
        data: function (params) {
            var query = {
                name: params.term,
            }
            return query;
        },

        processResults: function (data) {
            return {
                results: data.tags
            };
        }
    },
    templateResult: tagFormatState,
    templateSelection: tagTemplate,
    minimumInputLength: 1,
    escapeMarkup: function (markup) {
        return markup;
    },
});


function tagFormatState(state) {
    if (!state.id) {
        return state.name;
    }
    var $state = $(
        '<span>' + state.name + '</span>'
    );
    return $state;
};

function tagTemplate(data) {
    return data.name;
}
