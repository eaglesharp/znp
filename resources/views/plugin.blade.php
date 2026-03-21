

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <style>
    .ui-autocomplete .highlight {
      font-weight: bold;
      color: blue;
    }
  </style>
  <script>
  $(function() {
  function split(val) {
    return val.split(/,\s*/);
  }

  function extractLast(term) {
    return split(term).pop();
  }

  $("#tags")
    .on("keydown", function(event) {
      if (event.keyCode === $.ui.keyCode.TAB && $(this).autocomplete("instance").menu.active) {
        event.preventDefault();
      }
    })
    .autocomplete({
      minLength: 0,
      source: function(request, response) {
        $.ajax({
          url: "{{ url('autocomplete/skillsposition') }}",
          dataType: "json",
          data: {
            query: extractLast(request.term)
          },
          success: function(data) {
            response($.map(data, function(item) {
              return {
                label: item,
                value: item
              };
            }));
          }
        });
      },
      focus: function() {
        return false;
      },
      select: function(event, ui) {
        var terms = split(this.value);
        terms.pop();
        terms.push(ui.item.value);
        terms.push("");
        this.value = terms.join(", ");
        return false;
      },
      open: function(event, ui) {
        var term = extractLast(this.value);
        var autocomplete = $(this).data("ui-autocomplete");
        autocomplete.menu.element.find("li").each(function() {
          var item = $(this).data("ui-autocomplete-item");
          var highlightedItem = item.label.replace(new RegExp($.ui.autocomplete.escapeRegex(term), "gi"), '<span class="highlight">$&</span>');
          $(this).html(highlightedItem);
        });
      }
    });
});

  </script>


</head>
<body>
 
  <div class="ui-widget">
    <form method="post" action="{{ url("check") }}">
      @csrf
    <label for="tags">History & Examination: </label>
    <input id="tags" size="50" name="tags">
    <input type="submit" value="Submit">
    </form>
  
  </div>
</body>
</html>
