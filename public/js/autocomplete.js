$( function() {
    $.widget( "custom.catcomplete", $.ui.autocomplete, {
      _create: function() {
        this._super();
        this.widget().menu( "option", "items", "> :not(.ui-autocomplete-category)" );
      },
      _renderMenu: function( ul, items ) {
        var that = this,
          currentCategory = "";
        $.each( items, function( index, item ) {
          var li;
          if ( item.category != currentCategory ) {
            if(item.category != 'Nothing')
              ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
            currentCategory = item.category;
          }
          li = that._renderItemData( ul, item );
          if ( item.category ) {
            li.attr( "aria-label", item.category + " : " + item.label );
          }
        });
      }
    });
    $( "#search-bar" ).catcomplete({
      source: urlSearch,
      minLength: 1,
      select: function(event, ui) {
        $('#search-bar').val(ui.item.value);
        console.log(ui);
        if(ui.item.category == 'Users') {
          window.location.replace('/profile/' + ui.item.id);  
        } else if(ui.item.category == 'Tournaments') {
          window.location.replace('/tournament_page/' + ui.item.id);  
        }
      }
  });
  } );