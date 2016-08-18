$(".tags-select").select2({

  tags: true,
  
  maximumSelectionLength: 4,

  ajax: {
    url: $('.tags-select').data('url'),
    type: 'POST',
    dataType: 'json',
    processResults: function (data) {
      return {
        results: data.tags
      };
    }
  }
});