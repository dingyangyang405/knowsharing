$('.linke-select').select2({
    ajax: {
        url: $('.linke-select').data('url'),
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
                results: data.topics
            };
        }
    },
    templateResult: formatState,
    templateSelection: template,
    minimumInputLength: 1,
    escapeMarkup: function (markup) {
        return markup;
    },
});

function formatState(state) {
    if (!state.id) {
        return state.name;
    }
    var $state = $(
        '<span>' + state.name + '</span>'
    );
    return $state;
};

function template(data) {
    return data.name;
}

$(".linke-select").select2("data", $(".linke-select").select2('data')[0]['id']);
$('body').on('keyup','.select2-search__field',function() {
    $(".linke-select option ").val($(".select2-search__field").val());
    $(".select2-selection__rendered").html($(".select2-search__field").val());
});