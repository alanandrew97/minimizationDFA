$(function(){
  // console.log('Pagina cargada');

  $('#entriesNumber').change(function(){
    if ( $('tbody tr', '#tt').length > 0 ){
      $('tbody *', '#tt').hide(300, function(){
        this.remove();
      });
    }
    if($('.th', '#tt').length > 0){
      $('.th', '#tt').hide(500, function(){
        this.remove();
      }); 
      for (let i = 0; i < $('#entriesNumber').val(); i++) {
        $('thead tr', '#tt').append('<th class="th" style="display:none;"><input class="entrie" name="entries[]" type="text"></th>');
        $('.th', '#tt').show(1000);
      }
      let p = 100 / $('#entriesNumber').val();
      $('.th', '#tt').css('width', p+'%');
    } else {
      for (let i = 0; i < $('#entriesNumber').val(); i++) {
        $('thead tr', '#tt').append('<th class="th" style="display:none;"><input class="entrie" name="entries[]" type="text"></th>');
        $('.th', '#tt').show(500);
      }
      let p = 100 / $('#entriesNumber').val();
      $('.th', '#tt').css('width', p + '%');
    }

  });

  $('#statesNumber').change(function(){
    if ($('tbody tr', '#tt').length > 0) {
      $('tbody tr', '#tt').hide(300, function () {
        this.remove();
      });
      for (let i = 0; i < $('#statesNumber').val(); i++) {
        let row = '<tr style="display:none;">';
        row += '<td>q'+i+'</td>';
        row += '<td><input class="initial" type="checkbox" name="states[' + i + '][initial]"></td>';
        row += '<td><input class="final" type="checkbox" name="states[' + i + '][final]"></td>';
        for (let j = 0; j < $('#entriesNumber').val(); j++){
          row += '<td><input class="state" name="states['+i+'][]" type="text"></td>';
        }
        row += '</tr>';
        $('tbody', '#tt').append(row);
        $('tbody tr', '#tt').show(1200);
      }
    } else {
      for (let i = 0; i < $('#statesNumber').val(); i++) {
        let row = '<tr style="display:none;">';
        row += '<td>q' + i + '</td>';
        row += '<td><input class="initial" type="checkbox" name="states[' + i + '][initial]"></td>';
        row += '<td><input class="final" type="checkbox" name="states['+i+'][final]"></td>';
        for (let j = 0; j < $('#entriesNumber').val(); j++) {
          row += '<td><input class="state" name="states[' + i + '][]" type="text"></td>';
        }
        row += '</tr>';
        $('tbody', '#tt').append(row);
        $('tbody tr', '#tt').show(500);
      }
      // let p = 100 / $('#entriesNumber').val();
    }
  });

  $("#form").submit(function (e) {
    e.preventDefault();
    var serializedData = $(this).serialize();
    // console.log(serializedData);
    $.ajax({
      url: 'minimize.php',
      success: function (msg) {
        $('#answer').show(500);
        var response = JSON.parse(msg);
        console.log(response);

        cargarTabla('#ttAnswer', response[0], response[1]);
      },
      error: function () {
        console.log("No se ha podido obtener la información");
      },
      type: "post",
      data: serializedData,
    });
  });

  function cargarTabla(idTable, entries, states) {
    console.log($(idTable));
    //Limpiar tabla
    $('tbody tr', idTable).remove();
    $('.th', idTable).remove();
    

    for (let i = 0; i < entries.length; i++) {
      $('thead tr', idTable).append('<th class="th"><input class="entrie" name="entries[]" value="'+entries[i]+'" type="text"></th>');
    }

    for (let i = 0; i < states.length; i++) {
      let row = '<tr>';
      row += '<td>q' + i + '</td>';
      row += '<td><input class="initial" type="checkbox" name="states[' + i + '][initial]" '+(states[i]['initial']?"checked":"")+'></td>';
      row += '<td><input class="final" type="checkbox" name="states[' + i + '][final]" ' + (states[i]['final'] ? "checked" : "") +'></td>';
      for (let j = 0; j < entries.length; j++) {
        row += '<td><input class="state" name="states[' + i + '][]" value="' + states[i]['transitions'][j]+'" type="text"></td>';
      }
      row += '</tr>';
      $('tbody', idTable).append(row);
    }
  }

});