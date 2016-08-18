// $(".tags-select").select2({
//   tags: true,
//   tokenSeparators: [",", " "],
//   createSearchChoice: function(term, data) {
//     if ($(data).filter(function() {
//       return this.text.localeCompare(term) === 0;
//     }).length === 0) {
//       return {
//         id: term,
//         text: term
//       };
//     }
//   },
//   multiple: true,
//   ajax: {
//     url: $('.tags-select').data('url'),
//     dataType: "json",
//     type: 'POST',
//     data: function(term, page) {
//       return {
//         q: term
//       };
//     },
//     processResults: function(data) {
//       return {
//         results: data
//       };
//     }
//   }
// });
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